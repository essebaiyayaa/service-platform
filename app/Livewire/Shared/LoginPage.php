<?php

namespace App\Livewire\Shared;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LoginPage extends Component
{
    public $email = '';
    public $password = '';
    // public $remember = false;
    public $showPassword = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    protected $messages = [
        'email.required' => 'L\'email est requis',
        'email.email' => 'L\'email doit être valide',
        'password.required' => 'Le mot de passe est requis',
        'password.min' => 'Le mot de passe doit contenir au moins 6 caractères',
    ];

    public function togglePasswordVisibility()
    {
        $this->showPassword = !$this->showPassword;
    }

    // public function fillBabysitterCredentials()
    // {
    //     $this->email = 'babysitter@helpora.com';
    //     $this->password = 'baby123';
    //     $this->remember = false;
    // }

    // public function fillClientCredentials()
    // {
    //     $this->email = 'client@helpora.com';
    //     $this->password = 'client123';
    //     $this->remember = false;
    // }

    public function login()
    {
        $this->validate();

<<<<<<< HEAD
        // Test credentials pour babysitter
        if ($this->email === 'babysitter@helpora.com' && $this->password === 'baby123') {
            session()->flash('success', 'Connexion réussie en tant que babysitter !');
            return redirect()->route('babysitter.dashboard');
        }

        // Test credentials pour client
        if ($this->email === 'client@helpora.com' && $this->password === 'client123') {
            session()->flash('success', 'Connexion réussie en tant que client !');
            return redirect()->route('home');
        }

     
=======
        // Tenter l'authentification
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();

            $user = Auth::user();

            // Vérifier le statut
            if ($user->statut !== 'actif') {
                Auth::logout();
                $this->addError('email', 'Votre compte est suspendu.');
                return;
            }

            // Rediriger selon le rôle
            if ($user->role === 'intervenant') {
                session()->flash('success', 'Bienvenue ' . $user->prenom . ' !');
                return redirect()->route('babysitter.dashboard');
            }

            if ($user->role === 'client') {
                session()->flash('success', 'Bienvenue ' . $user->prenom . ' !');
                return redirect('/');
            }

            return redirect('/');
        }

>>>>>>> a1bdcd3ba03f7cc5600329f39c9d5e2ad26eb5de
        $this->addError('email', 'Email ou mot de passe incorrect.');
    }

    public function navigateToRegister()
    {
        return redirect('/inscriptionClient');
    }

    // public function navigateToForgotPassword()
    // {
    //     return redirect()->route('password.request');
    // }

    public function navigateToHome()
    {
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.shared.login-page');
    }
}