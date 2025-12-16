<?php

namespace App\Livewire\Tutoring;

// On importe la classe PARTAGÉE fournie par l'autre groupe
use App\Livewire\Shared\GestionDisponibilites; 
use Illuminate\Support\Facades\Auth;

// On utilise "extends GestionDisponibilites" pour hériter de toute leur logique
// (save, delete, variables $disponibilites, $viewMode...)
class DisponibilitesPage extends GestionDisponibilites
{
    public $prenom;
    public $photo;

    public function mount()
    {
        // On appelle le mount du parent pour charger les données partagées
        parent::mount(); 

        // On ajoute nos données spécifiques pour la Sidebar
        $user = Auth::user();
        $this->prenom = $user->prenom;
        $this->photo = $user->photo;
    }

    public function logout() {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }

    public function render()
    {
        // On force l'utilisation de TA vue
        return view('livewire.tutoring.disponibilites');
    }
}
