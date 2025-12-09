<?php

namespace App\Livewire\Babysitter;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\Babysitting\Babysitter;
use Illuminate\Support\Facades\Hash;


class BabysitterRegistration extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $totalSteps = 5;

    // Étape 1
    public $prenom, $nom, $email, $date_naissance;
    public $mot_de_passe, $mot_de_passe_confirmation;
    public $je_fume = false, $jai_enfants = false;
    public $permis_conduire = false, $jai_voiture = false;

    // Étape 2
    public $telephone, $adresse, $photo_profil;

    // Étape 3
    public $prix_horaire, $annees_experience, $niveau_etudes;
    public $description, $experience_detaillee;
    public $langues = [];
    public $categories_enfants = [];

    // Étape 4
    public $certifications = [];
    public $superpowers = [];
    public $disponibilites = [];

    // Étape 5
    public $radiographie_thorax, $coproculture_selles;
    public $certificat_aptitude, $casier_judiciaire;

    public function mount()
    {
        $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
        foreach ($jours as $jour) {
            $this->disponibilites[$jour] = [];
        }
    }

    public function rules()
    {
        $rules = [];

        if ($this->currentStep == 1) {
            $rules = [
                'prenom' => 'required|string|max:255',
                'nom' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'date_naissance' => 'required|date|before:today',
                'mot_de_passe' => 'required|min:8|confirmed',
            ];
        }

        if ($this->currentStep == 2) {
            $rules = [
                'telephone' => 'required|string|max:20',
                'adresse' => 'required|string|max:500',
            ];
        }

        if ($this->currentStep == 3) {
            $rules = [
                'prix_horaire' => 'required|numeric|min:0',
                'annees_experience' => 'required|string',
                'niveau_etudes' => 'required|string|max:500',
                'description' => 'required|string|max:1000',
                'experience_detaillee' => 'required|string|max:2000',
                'langues' => 'required|array|min:1',
            ];
        }

        if ($this->currentStep == 5) {
            $rules = [
                'casier_judiciaire' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'prenom.required' => 'Le prénom est obligatoire',
            'nom.required' => 'Le nom est obligatoire',
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'L\'email doit être valide',
            'email.unique' => 'Cet email est déjà utilisé',
            'date_naissance.required' => 'La date de naissance est obligatoire',
            'mot_de_passe.required' => 'Le mot de passe est obligatoire',
            'mot_de_passe.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'mot_de_passe.confirmed' => 'Les mots de passe ne correspondent pas',
            'telephone.required' => 'Le téléphone est obligatoire',
            'adresse.required' => 'L\'adresse est obligatoire',
            'prix_horaire.required' => 'Le prix horaire est obligatoire',
            'annees_experience.required' => 'Les années d\'expérience sont obligatoires',
            'niveau_etudes.required' => 'Le niveau d\'études est obligatoire',
            'description.required' => 'La description est obligatoire',
            'experience_detaillee.required' => 'L\'expérience détaillée est obligatoire',
            'langues.required' => 'Sélectionnez au moins une langue',
            'casier_judiciaire.required' => 'Le casier judiciaire est obligatoire',
        ];
    }

    public function suivant()
    {
        $this->validate();
        
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function precedent()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function ajouterDisponibilite($jour)
    {
        $this->disponibilites[$jour][] = ['debut' => '', 'fin' => ''];
    }

    public function supprimerDisponibilite($jour, $index)
    {
        unset($this->disponibilites[$jour][$index]);
        $this->disponibilites[$jour] = array_values($this->disponibilites[$jour]);
    }

    public function finaliser()
    {
        $this->validate();

        try {
            // Créer l'utilisateur
            $user = User::create([
                'name' => $this->prenom . ' ' . $this->nom,
                'email' => $this->email,
                'password' => Hash::make($this->mot_de_passe),
                'role' => 'babysitter',
            ]);

            // Upload de la photo de profil
            $photoPath = $this->photo_profil ? 
                $this->photo_profil->store('babysitters/photos', 'public') : null;

            // Upload des documents
            $documents = [];
            if ($this->radiographie_thorax) {
                $documents['radiographie_thorax'] = $this->radiographie_thorax->store('babysitters/documents', 'public');
            }
            if ($this->coproculture_selles) {
                $documents['coproculture_selles'] = $this->coproculture_selles->store('babysitters/documents', 'public');
            }
            if ($this->certificat_aptitude) {
                $documents['certificat_aptitude'] = $this->certificat_aptitude->store('babysitters/documents', 'public');
            }
            if ($this->casier_judiciaire) {
                $documents['casier_judiciaire'] = $this->casier_judiciaire->store('babysitters/documents', 'public');
            }

            // Créer le profil babysitter
            Babysitter::create([
                'user_id' => $user->id,
                'prenom' => $this->prenom,
                'nom' => $this->nom,
                'date_naissance' => $this->date_naissance,
                'telephone' => $this->telephone,
                'adresse' => $this->adresse,
                'photo_profil' => $photoPath,
                'je_fume' => $this->je_fume,
                'jai_enfants' => $this->jai_enfants,
                'permis_conduire' => $this->permis_conduire,
                'jai_voiture' => $this->jai_voiture,
                'prix_horaire' => $this->prix_horaire,
                'annees_experience' => $this->annees_experience,
                'niveau_etudes' => $this->niveau_etudes,
                'description' => $this->description,
                'experience_detaillee' => $this->experience_detaillee,
                'langues' => $this->langues,
                'categories_enfants' => $this->categories_enfants,
                'certifications' => $this->certifications,
                'superpowers' => $this->superpowers,
                'disponibilites' => $this->disponibilites,
                'documents' => $documents,
                'statut' => 'en_attente',
            ]);

            
        } catch (\Exception $e) {
            session()->flash('error', 'Une erreur est survenue lors de l\'inscription: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.babysitter.babysitter-registration');
        
    }
}