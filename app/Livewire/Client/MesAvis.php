<?php

namespace App\Livewire\Client;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MesAvis extends Component
{
    use WithPagination, WithFileUploads;

    // Filtres
    public $searchTerm = '';
    public $filterService = '';
    public $filterNote = '';

    // Modal Avis
    public $selectedAvis = null;
    public $showAvisModal = false;

    // Modal Réclamation
    public $showReclamationModal = false;
    public $selectedFeedbackId = null;
    public $sujet = '';
    public $description = '';
    public $priorite = 'moyenne';
    public $preuves = [];

    // User
    public $user;

    // Règles de validation pour la réclamation
    protected $rules = [
        'sujet' => 'required|min:5|max:255',
        'description' => 'required|min:10',
        'priorite' => 'required|in:faible,moyenne,urgente',
        'preuves.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240'
    ];

    protected $messages = [
        'sujet.required' => 'Le sujet est obligatoire',
        'sujet.min' => 'Le sujet doit contenir au moins 5 caractères',
        'sujet.max' => 'Le sujet ne peut pas dépasser 255 caractères',
        'description.required' => 'La description est obligatoire',
        'description.min' => 'La description doit contenir au moins 10 caractères',
        'priorite.required' => 'Veuillez sélectionner une priorité',
        'priorite.in' => 'La priorité doit être faible, moyenne ou urgente',
        'preuves.*.mimes' => 'Les fichiers doivent être des images (jpg, jpeg, png) ou des PDF',
        'preuves.*.max' => 'Chaque fichier ne doit pas dépasser 10 MB'
    ];

    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à cette page.');
        }

        if (Auth::user()->role !== 'client') {
            return redirect('/')->with('error', 'Cette page est réservée aux clients uniquement.');
        }

        $this->loadUser();
    }

    private function loadUser()
    {
        $authUser = Auth::user();
        $authId = $authUser ? ($authUser->idUser ?? $authUser->id) : null;

        if ($authId) {
            $this->user = DB::table('utilisateurs')
                ->where('idUser', $authId)
                ->first();
        }

        if (!$this->user) {
            abort(403, 'Accès non autorisé');
        }
    }

    // Reset pagination quand on filtre
    public function updatedSearchTerm() 
    { 
        $this->resetPage(); 
    }
    
    public function updatedFilterService() 
    { 
        $this->resetPage(); 
    }
    
    public function updatedFilterNote() 
    { 
        $this->resetPage(); 
    }

    // Modal Avis
    public function openAvisModal($id)
    {
        Log::info("Opening avis modal for ID: {$id}");
        
        $this->selectedAvis = DB::table('feedbacks')
            ->join('utilisateurs', 'feedbacks.idAuteur', '=', 'utilisateurs.idUser')
            ->leftJoin('demandes_intervention', 'feedbacks.idDemande', '=', 'demandes_intervention.idDemande')
            ->leftJoin('services', 'demandes_intervention.idService', '=', 'services.idService')
            ->select(
                'feedbacks.*',
                'utilisateurs.prenom as auteur_prenom',
                'utilisateurs.nom as auteur_nom',
                'services.nomService as nom_service',
                DB::raw('ROUND((feedbacks.credibilite + feedbacks.sympathie + feedbacks.ponctualite + feedbacks.proprete + feedbacks.qualiteTravail) / 5, 1) as note_moyenne')
            )
            ->where('feedbacks.idFeedBack', $id)
            ->first();

        if ($this->selectedAvis) {
            $this->selectedAvis->has_reclamation = DB::table('reclamantions')
                ->where('idFeedback', $id)
                ->where('idAuteur', $this->user->idUser)
                ->exists();
            
            $this->showAvisModal = true;
            Log::info("Avis modal opened successfully");
        } else {
            Log::error("Avis not found for ID: {$id}");
        }
    }

    public function closeAvisModal()
    {
        $this->showAvisModal = false;
        $this->selectedAvis = null;
    }

    // Modal Réclamation
    public function openReclamationModal($feedbackId)
    {
        Log::info("Opening reclamation modal for feedback ID: {$feedbackId}");
        
        $this->selectedFeedbackId = $feedbackId;
        $this->reset(['sujet', 'description', 'preuves']);
        $this->priorite = 'moyenne';
        $this->resetValidation();
        $this->showReclamationModal = true;
    }

    public function openReclamationModalFromDetails()
    {
        if ($this->selectedAvis) {
            $this->selectedFeedbackId = $this->selectedAvis->idFeedBack;
            $this->showAvisModal = false;
            $this->reset(['sujet', 'description', 'preuves']);
            $this->priorite = 'moyenne';
            $this->resetValidation();
            $this->showReclamationModal = true;
        }
    }

    public function closeReclamationModal()
    {
        $this->showReclamationModal = false;
        $this->selectedFeedbackId = null;
        $this->reset(['sujet', 'description', 'priorite', 'preuves']);
        $this->resetValidation();
    }

    // Créer réclamation
    public function createReclamation()
    {
        Log::info('=== DEBUT CREATION RECLAMATION ===');
        Log::info('Feedback ID: ' . $this->selectedFeedbackId);
        Log::info('Sujet: ' . $this->sujet);
        Log::info('Description: ' . $this->description);
        Log::info('Priorité: ' . $this->priorite);
        
        // Validation
        $this->validate();
        
        Log::info('Validation passed');

        try {
            // Récupérer le feedback
            $feedback = DB::table('feedbacks')
                ->where('idFeedBack', $this->selectedFeedbackId)
                ->first();

            if (!$feedback) {
                Log::error('Feedback not found: ' . $this->selectedFeedbackId);
                session()->flash('error', 'Avis introuvable.');
                return;
            }

            Log::info('Feedback found - idAuteur: ' . $feedback->idAuteur);

            // Vérifier si réclamation existe déjà
            $existingReclamation = DB::table('reclamantions')
                ->where('idFeedback', $this->selectedFeedbackId)
                ->where('idAuteur', $this->user->idUser)
                ->exists();

            if ($existingReclamation) {
                Log::warning('Reclamation already exists');
                session()->flash('error', 'Une réclamation existe déjà pour cet avis.');
                $this->closeReclamationModal();
                return;
            }

            // Gérer l'upload des preuves
            $preuvesPath = null;
            if (!empty($this->preuves)) {
                Log::info('Processing ' . count($this->preuves) . ' files');
                $paths = [];
                foreach ($this->preuves as $file) {
                    $path = $file->store('reclamations/preuves', 'public');
                    $paths[] = $path;
                    Log::info('File stored: ' . $path);
                }
                $preuvesPath = json_encode($paths);
            }

            // Préparer les données
            $data = [
                'idCible' => $feedback->idAuteur,
                'idAuteur' => $this->user->idUser,
                'idFeedback' => $this->selectedFeedbackId,
                'statut' => 'en_attente',
                'preuves' => $preuvesPath,
                'sujet' => $this->sujet,
                'description' => $this->description,
                'priorite' => $this->priorite,
                'dateCreation' => now()
            ];

            Log::info('Data to insert: ' . json_encode($data));

            // Créer la réclamation
            $inserted = DB::table('reclamantions')->insert($data);

            if ($inserted) {
                Log::info('Reclamation created successfully');
                session()->flash('success', 'Réclamation envoyée avec succès !');
                $this->closeReclamationModal();
                
                // Rafraîchir la page
                $this->dispatch('reclamation-created');
            } else {
                Log::error('Failed to insert reclamation');
                session()->flash('error', 'Échec de la création de la réclamation.');
            }

        } catch (\Exception $e) {
            Log::error('=== ERREUR CREATION RECLAMATION ===');
            Log::error('Message: ' . $e->getMessage());
            Log::error('File: ' . $e->getFile());
            Log::error('Line: ' . $e->getLine());
            Log::error('Trace: ' . $e->getTraceAsString());
            
            session()->flash('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
        
        Log::info('=== FIN CREATION RECLAMATION ===');
    }

    public function removePreuve($index)
    {
        if (isset($this->preuves[$index])) {
            unset($this->preuves[$index]);
            $this->preuves = array_values($this->preuves);
            Log::info("Removed preuve at index: {$index}");
        }
    }

    // Calcul des statistiques
    private function getStats()
    {
        $allAvis = $this->getBaseQuery()->get();

        return [
            'total_avis' => $allAvis->count(),
            'avis_positifs' => $allAvis->where('note_moyenne', '>=', 4)->count(),
            'avis_negatifs' => $allAvis->where('note_moyenne', '<', 3)->count(),
        ];
    }

    private function getBaseQuery()
    {
        $query = DB::table('feedbacks')
            ->join('utilisateurs', 'feedbacks.idAuteur', '=', 'utilisateurs.idUser')
            ->leftJoin('demandes_intervention', 'feedbacks.idDemande', '=', 'demandes_intervention.idDemande')
            ->leftJoin('services', 'demandes_intervention.idService', '=', 'services.idService')
            ->select(
                'feedbacks.*',
                'utilisateurs.prenom as auteur_prenom',
                'utilisateurs.nom as auteur_nom',
                'services.nomService as nom_service',
                DB::raw('ROUND((feedbacks.credibilite + feedbacks.sympathie + feedbacks.ponctualite + feedbacks.proprete + feedbacks.qualiteTravail) / 5, 1) as note_moyenne')
            )
            ->where('feedbacks.idCible', $this->user->idUser)
            ->where('feedbacks.typeAuteur', 'intervenant')
            ->where('feedbacks.estVisible', 1);

        // Filtre recherche
        if (!empty($this->searchTerm)) {
            $query->where(function($q) {
                $q->where('utilisateurs.prenom', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('utilisateurs.nom', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('feedbacks.commentaire', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('services.nomService', 'like', '%' . $this->searchTerm . '%');
            });
        }

        // Filtre service
        if (!empty($this->filterService)) {
            $query->where('services.nomService', $this->filterService);
        }

        // Filtre note
        if (!empty($this->filterNote)) {
            if ($this->filterNote === 'positive') {
                $query->havingRaw('note_moyenne >= 4');
            } elseif ($this->filterNote === 'negative') {
                $query->havingRaw('note_moyenne < 3');
            }
        }

        return $query;
    }

    public function render()
    {
        $query = $this->getBaseQuery();
        $avis = $query->orderBy('feedbacks.dateCreation', 'desc')->paginate(5);

        // Vérifier si chaque avis a déjà une réclamation
        foreach ($avis as $avis_item) {
            $avis_item->has_reclamation = DB::table('reclamantions')
                ->where('idFeedback', $avis_item->idFeedBack)
                ->where('idAuteur', $this->user->idUser)
                ->exists();
        }

        // Services disponibles pour le filtre
        $services = DB::table('feedbacks')
            ->join('demandes_intervention', 'feedbacks.idDemande', '=', 'demandes_intervention.idDemande')
            ->join('services', 'demandes_intervention.idService', '=', 'services.idService')
            ->where('feedbacks.idCible', $this->user->idUser)
            ->where('feedbacks.typeAuteur', 'intervenant')
            ->select('services.nomService')
            ->distinct()
            ->pluck('nomService');

        $stats = $this->getStats();

        return view('livewire.client.mes-avis', [
            'avis' => $avis,
            'stats' => $stats,
            'services' => $services
        ])->layout('layouts.app');
    }
}