<?php

use App\Livewire\Shared\LandingPage;
use App\Livewire\Shared\ServicesPage;
use App\Livewire\Shared\ContactPage;
use App\Livewire\Shared\LoginPage;
use App\Livewire\Shared\Register;
use App\Livewire\Shared\RegisterClientPage;
use App\Livewire\Shared\RegisterIntervenantPage;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Babysitter\BabysitterRegistration;



Route::get('/', LandingPage::class);
Route::get('/services', ServicesPage::class);
Route::get('/contact', ContactPage::class);
Route::get('/connexion', LoginPage::class);
Route::get('/inscription', Register::class);
Route::get('/inscriptionIntervenant', RegisterIntervenantPage::class);
Route::get('/inscriptionClient', RegisterClientPage::class);
Route::post('/register-client', [RegisterController::class, 'store'])->name('register.store');
<<<<<<< HEAD
Route::get('/inscriptionBabysitter', BabysitterRegistration::class)->name('inscription.babysitter');
=======
Route::post('/connexion', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
>>>>>>> a1bdcd3ba03f7cc5600329f39c9d5e2ad26eb5de
