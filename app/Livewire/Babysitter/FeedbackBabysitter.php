<?php

namespace App\Livewire\Babysitter;

use Livewire\Component;
use App\Models\Shared\Feedback;
use App\Models\Shared\Utilisateur;
use App\Models\Shared\DemandesIntervention;
use Illuminate\Support\Facades\DB;

class FeedbackBabysitter extends Component
{
    // IDs
    public $demandeId;
    public $auteurId;
    public $cibleId;
    public $typeAuteur;

    // Informations de la demande
    public $demande;
    public $auteur;
    public $cible;

    // Étapes du formulaire
    public $currentStep = 1;
    public $totalSteps = 3;

    // Critères de notation (1-5 étoiles)
    public $ponctualite = 0;
    public $professionnalisme = 0;
    public $relationAvecEnfants = 0;
    public $communication = 0;
    public $proprete = 0;

    // Commentaire
    public $commentaire = '';

    // Récapitulatif
    public $showRecap = false;
    public $feedbackSubmitted = false;

    protected $rules = [
        'ponctualite' => 'required|integer|min:1|max:5',
        'professionnalisme' => 'required|integer|min:1|max:5',
        'relationAvecEnfants' => 'required|integer|min:1|max:5',
        'communication' => 'required|integer|min:1|max:5',
        'proprete' => 'required|integer|min:1|max:5',
        'commentaire' => 'nullable|string|max:1000',
    ];

    protected $messages = [
        'ponctualite.required' => 'Veuillez noter la ponctualité',
        'ponctualite.min' => 'La note doit être au minimum de 1 étoile',
        'ponctualite.max' => 'La note doit être au maximum de 5 étoiles',
        'professionnalisme.required' => 'Veuillez noter le professionnalisme',
        'relationAvecEnfants.required' => 'Veuillez noter la relation avec les enfants',
        'communication.required' => 'Veuillez noter la communication',
        'proprete.required' => 'Veuillez noter la propreté',
    ];

    public function mount($demandeId = null, $auteurId = null, $cibleId = null, $typeAuteur = 'client')
    {
        // Simuler des données pour le test
        if (!$demandeId) {
            $this->demandeId = 1; // ID valide qui existe dans la BD
            $this->auteurId = 1;
            $this->cibleId = 2;
        } else {
            $this->demandeId = $demandeId;
            $this->auteurId = $auteurId;
            $this->cibleId = $cibleId;
        }
        
        $this->typeAuteur = $typeAuteur;

        // Charger les données
        $this->loadData();
    }

    private function loadData()
    {
        // Charger la demande (simulée pour le test)
        $this->demande = (object)[
            'idDemande' => $this->demandeId,
            'dateSouhaitee' => now()->subDays(1),
            'heureDebut' => '14:00',
            'heureFin' => '18:00',
            'lieu' => 'Casablanca, Maarif',
        ];

        // Charger l'auteur (simulé)
        $this->auteur = (object)[
            'idUser' => $this->auteurId,
            'nom' => 'Alami',
            'prenom' => 'Sara',
            'photo' => null,
        ];

        // Charger la cible (simulé)
        $this->cible = (object)[
            'idUser' => $this->cibleId,
            'nom' => 'Benjelloun',
            'prenom' => 'Fatima',
            'photo' => null,
            'note' => 4.5,
        ];
    }

    public function setRating($criteria, $value)
    {
        $this->$criteria = $value;
    }

    public function nextStep()
    {
        // Validation selon l'étape
        if ($this->currentStep === 1) {
            $this->validate([
                'ponctualite' => 'required|integer|min:1|max:5',
                'professionnalisme' => 'required|integer|min:1|max:5',
                'relationAvecEnfants' => 'required|integer|min:1|max:5',
            ]);
        } elseif ($this->currentStep === 2) {
            $this->validate([
                'communication' => 'required|integer|min:1|max:5',
                'proprete' => 'required|integer|min:1|max:5',
            ]);
        }

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function showRecapitulatif()
    {
        $this->validate();
        $this->showRecap = true;
    }

    public function editFeedback()
    {
        $this->showRecap = false;
        $this->currentStep = 1;
    }

    public function submitFeedback()
    {
        // Debug simple
        \Log::info('SUBMIT FEEDBACK CALLED!!!');
        
        $this->validate();

        try {
            DB::beginTransaction();

            // Calculer la note moyenne
            $noteMoyenne = ($this->ponctualite + $this->professionnalisme + 
                           $this->relationAvecEnfants + $this->communication + 
                           $this->proprete) / 5;

            // Créer le feedback
            $feedback = Feedback::create([
                'idAuteur' => $this->auteurId,
                'idCible' => $this->cibleId,
                'typeAuteur' => $this->typeAuteur,
                'commentaire' => $this->commentaire,
                'credibilite' => $this->professionnalisme,
                'sympathie' => $this->relationAvecEnfants,
                'ponctualite' => $this->ponctualite,
                'proprete' => $this->proprete,
                'qualiteTravail' => $this->communication,
                'estVisible' => true,
                'dateCreation' => now(),
                'idDemande' => $this->demandeId,
            ]);

            // Mettre à jour la note de l'utilisateur cible
            $this->updateUserRating($this->cibleId, $noteMoyenne);

            DB::commit();

            $this->feedbackSubmitted = true;
            
            session()->flash('success', 'Votre évaluation a été soumise avec succès!');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Une erreur est survenue: ' . $e->getMessage());
            
            // Log l'erreur pour debug
            \Log::error('Feedback submission error: ' . $e->getMessage());
        }
    }

    private function updateUserRating($userId, $newRating)
    {
        // Récupérer tous les feedbacks pour cet utilisateur
        $feedbacks = Feedback::where('idCible', $userId)->get();
        
        $totalRatings = $feedbacks->count() + 1; // +1 pour le nouveau feedback
        
        // Calculer la nouvelle note moyenne
        $currentSum = $feedbacks->sum(function($feedback) {
            return ($feedback->credibilite + $feedback->sympathie + 
                    $feedback->ponctualite + $feedback->proprete + 
                    $feedback->qualiteTravail) / 5;
        });
        
        $newAverage = ($currentSum + $newRating) / $totalRatings;

        // Mettre à jour l'utilisateur
        Utilisateur::where('idUser', $userId)->update([
            'note' => round($newAverage, 1),
            'nbrAvis' => $totalRatings
        ]);
    }

    public function getAverageRating()
    {
        if ($this->ponctualite === 0) return 0;
        
        return round(($this->ponctualite + $this->professionnalisme + 
                     $this->relationAvecEnfants + $this->communication + 
                     $this->proprete) / 5, 1);
    }

    public $testDebug = '';

    public function updatedTestDebug($value)
    {
        \Log::info('Debug button clicked! Value: ' . $value);
    }

    public function render()
    {
        return view('livewire.babysitter.feedback-babysitter');
    }
}