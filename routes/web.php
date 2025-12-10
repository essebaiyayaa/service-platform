<?php

use App\Livewire\Shared\LandingPage;
use App\Livewire\Shared\ServicesPage;
use App\Livewire\Shared\ContactPage;
use App\Livewire\Shared\LoginPage;
use App\Livewire\Shared\Register;
use App\Livewire\Shared\RegisterClientPage;
use App\Livewire\Shared\RegisterIntervenantPage;
use App\Livewire\Shared\ListeBabysitter;
use App\Livewire\Shared\BabysitterProfilePage;
use App\Livewire\Shared\BabysitterBooking;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingPage::class);
Route::get('/services', ServicesPage::class);
Route::get('/contact', ContactPage::class);
Route::get('/connexion', LoginPage::class);
Route::get('/inscription', Register::class);
Route::get('/inscriptionIntervenant', RegisterIntervenantPage::class);
Route::get('/inscriptionClient', RegisterClientPage::class);
Route::get('/liste-babysitter', ListeBabysitter::class);
Route::get('/babysitter-profile/{id}', BabysitterProfilePage::class);
Route::get('/babysitter-booking/{id}', BabysitterBooking::class);


