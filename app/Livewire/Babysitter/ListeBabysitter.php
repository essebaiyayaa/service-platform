<?php

namespace App\Livewire\Babysitter;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Babysitting\Babysitter;
use App\Models\Babysitting\Superpouvoir;
use Illuminate\Support\Facades\DB;

class ListeBabysitter extends Component
{
    use WithPagination;

    public $search = '';
    public $priceMin = 30;
    public $priceMax = 150;
    public $ville = '';
    public $experience = null;
    public $non_fumeur = false;
    public $permis_conduire = false;
    public $selectedServices = [];
    public $babysittersWithLocation = [];
    public $showMap = false;

    protected $queryString = ['search', 'priceMin', 'priceMax', 'ville', 'experience'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPriceMin()
    {
        $this->resetPage();
    }

    public function updatingPriceMax()
    {
        $this->resetPage();
    }

    public function updatingVille()
    {
        $this->resetPage();
    }

    public function updatingNonFumeur()
    {
        $this->resetPage();
    }

    public function updatingPermisConduire()
    {
        $this->resetPage();
    }

    public function updatingSelectedServices()
    {
        $this->resetPage();
    }

    public function toggleService($serviceId)
    {
        if (in_array($serviceId, $this->selectedServices)) {
            $this->selectedServices = array_filter($this->selectedServices, fn($id) => $id !== $serviceId);
        } else {
            $this->selectedServices[] = $serviceId;
        }
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->priceMin = 30;
        $this->priceMax = 150;
        $this->ville = '';
        $this->experience = null;
        $this->non_fumeur = false;
        $this->permis_conduire = false;
        $this->selectedServices = [];
        $this->resetPage();
    }

    public function render()
    {
        $query = Babysitter::with([
            'intervenant.utilisateur.localisations',
            'intervenant.disponibilites',
            'superpouvoirs'
        ]);

        // Filtre par prix
        if ($this->priceMin && $this->priceMin > 0) {
            $query->where('prixHeure', '>=', $this->priceMin);
        }
        if ($this->priceMax && $this->priceMax > 0) {
            $query->where('prixHeure', '<=', $this->priceMax);
        }

        // Filtre par ville
        if ($this->ville) {
            $query->whereHas('intervenant.utilisateur.localisations', function ($q) {
                $q->where('ville', 'LIKE', "%{$this->ville}%");
            });
        }

        // Filtre par expérience
        if ($this->experience) {
            $query->where('expAnnee', '>=', $this->experience);
        }

        // Filtre par caractéristiques
        if ($this->non_fumeur) {
            $query->where('estFumeur', false);
        }

        if ($this->permis_conduire) {
            $query->where('permisConduite', true);
        }

        // Filtre par services (superpouvoirs)
        if (!empty($this->selectedServices)) {
            $query->whereHas('superpouvoirs', function ($q) {
                $q->whereIn('superpouvoirs.idSuperpouvoir', $this->selectedServices);
            }, '=', count($this->selectedServices));
        }

    // Filtre par recherche (nom/prénom/quartier/ville)
        if ($this->search) {
            $query->where(function($subQuery) {
                $subQuery->whereHas('intervenant.utilisateur', function ($q) {
                    $q->where('nom', 'LIKE', "%{$this->search}%")
                      ->orWhere('prenom', 'LIKE', "%{$this->search}%");
                })->orWhereHas('intervenant.utilisateur.localisations', function ($q) {
                    $q->where('adresse', 'LIKE', "%{$this->search}%")
                      ->orWhere('ville', 'LIKE', "%{$this->search}%");
                });
            });
        }

        $babysitters = $query->paginate(15);

        // Récupérer les babysitters avec localisation pour la carte
        $locationData = DB::table('babysitters')
            ->join('intervenants', 'babysitters.idBabysitter', '=', 'intervenants.IdIntervenant')
            ->join('utilisateurs', 'intervenants.IdIntervenant', '=', 'utilisateurs.idUser')
            ->leftJoin('localisations', 'utilisateurs.idUser', '=', 'localisations.idUser')
            ->where('intervenants.statut', 'VALIDE')
            ->select(
                'babysitters.idBabysitter',
                'utilisateurs.prenom',
                'utilisateurs.nom',
                'localisations.latitude',
                'localisations.longitude',
                'localisations.ville',
                'babysitters.prixHeure',
                'utilisateurs.photo',
                'utilisateurs.note'
            )
            ->get();

        // Debug: Vérifier combien de babysitters sont trouvés
        \Log::info('Total babysitters trouvés: ' . $locationData->count());
        
        $this->babysittersWithLocation = $locationData->filter(function($babysitter) {
            return $babysitter->latitude && $babysitter->longitude;
        });

        // Debug: Vérifier combien ont des coordonnées
        \Log::info('Babysitters avec coordonnées: ' . $this->babysittersWithLocation->count());

        // Récupérer tous les services pour le filtre
        $allServices = Superpouvoir::all();

        // Villes disponibles
        $villes = ['Casablanca', 'Rabat', 'Marrakech', 'Tanger', 'Fes', 'Agadir'];

        // Compter le nombre total de babysitters disponibles
        $totalBabysitters = Babysitter::count();
        // Préparer les données réelles pour la carte avec coordonnées par défaut
$defaultCoords = [
    'Casablanca' => [33.5731, -7.5898],
    'Rabat' => [34.0209, -6.8416],
    'Marrakech' => [31.6295, -7.9811],
    'Tanger' => [35.7595, -5.8340],
    'Fes' => [33.9716, -4.9975],
    'Agadir' => [30.4278, -9.5981],
    'default' => [33.5731, -7.5898]
];

// Limiter à 50 babysitters maximum pour la carte pour éviter la surcharge
$limitedLocationData = $locationData->take(50);

$babysittersMap = $limitedLocationData->map(function($babysitter) use ($defaultCoords) {
    $coords = $defaultCoords[$babysitter->ville] ?? $defaultCoords['default'];
    
    return [
        'idBabysitter' => $babysitter->idBabysitter,
        'prenom' => $babysitter->prenom,
        'nom' => $babysitter->nom,
        'photo' => $babysitter->photo,
        'note' => (float) ($babysitter->note ?? 0),
        'ville' => $babysitter->ville,
        'latitude' => !empty($babysitter->latitude) ? (float) $babysitter->latitude : $coords[0],
        'longitude' => !empty($babysitter->longitude) ? (float) $babysitter->longitude : $coords[1],
        'prixHeure' => (float) $babysitter->prixHeure
    ];
})->toArray();

        return view('livewire.babysitter.liste-babysitter', [
            'babysitters' => $babysitters,
            'allServices' => $allServices,
            'villes' => $villes,
            'totalBabysitters' => $totalBabysitters,
            'babysittersWithLocation' => $this->babysittersWithLocation,
            'babysittersMap' => $babysittersMap,
        ]);
    }
    public function toggleMap()
{
    $this->showMap = !$this->showMap;
}
}
