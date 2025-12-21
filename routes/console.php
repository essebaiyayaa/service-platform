<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Planification de la tâche d'annulation automatique des réservations babysitter (toutes les heures)
// Assurez-vous que le cron est configuré sur le serveur (php artisan schedule:run)
\Illuminate\Support\Facades\Schedule::command('babysitter:cancel-expired-bookings')->hourly();
