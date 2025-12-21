<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Babysitting\DemandeIntervention;
use App\Models\Shared\Feedback;
use App\Models\Shared\Utilisateur;
use App\Mail\FeedbackReminderMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendBabysitterFeedbackReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'babysitter:send-feedback-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoie des rappels quotidiens pour le feedback (Client et Babysitter) pendant 7 jours après l\'intervention.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Début de l\'envoi des rappels de feedback...');

        // 1. Définir la fenêtre de temps : interventions passées depuis moins de 7 jours
        // mais terminées (dateSouhaitee < maintenant)
        $sevenDaysAgo = Carbon::now()->subDays(7);
        $now = Carbon::now();

        // Récupérer toutes les demandes validées dans cette fenêtre
        $demandes = DemandeIntervention::where('statut', 'validée')
            ->where('dateSouhaitee', '<', $now)
            ->where('dateSouhaitee', '>=', $sevenDaysAgo)
            ->with(['client', 'intervenant.user']) // Charger les utilisateurs
            ->get();

        if ($demandes->isEmpty()) {
            $this->info('Aucune demande nécessitant un rappel trouvée.');
            return;
        }

        $countEmails = 0;

        foreach ($demandes as $demande) {
            $dateIntervention = $demande->dateSouhaitee->format('d/m/Y');
            
            // --- Traitement pour le CLIENT ---
            if ($demande->client) {
                // Vérifier si le client a déjà laissé un feedback pour cette demande
                $feedbackExists = Feedback::where('idDemande', $demande->idDemande)
                    ->where('idAuteur', $demande->idClient)
                    ->exists();

                if (!$feedbackExists) {
                    $this->sendReminderToClient($demande, $dateIntervention);
                    $countEmails++;
                }
            }

            // --- Traitement pour le BABYSITTER ---
            // Note: idIntervenant dans DemandeIntervention est déjà l'ID User du babysitter
            if ($demande->idIntervenant) {
                // Vérifier si le babysitter a déjà laissé un feedback
                $feedbackBabysitterExists = Feedback::where('idDemande', $demande->idDemande)
                    ->where('idAuteur', $demande->idIntervenant)
                    ->exists();

                if (!$feedbackBabysitterExists) {
                    $this->sendReminderToBabysitter($demande, $dateIntervention);
                    $countEmails++;
                }
            }
        }

        $this->info("Terminé. {$countEmails} e-mails de rappel envoyés.");
    }

    protected function sendReminderToClient($demande, $dateStr)
    {
        try {
            // URL pour que le client note le babysitter
            // Route: feedback.babysitter -> /feedback/babysitter/{idService}/{demandeId}/{auteurId}/{cibleId}/{typeAuteur?}
            $url = route('feedback.babysitter', [
                'idService' => $demande->idService,
                'demandeId' => $demande->idDemande,
                'auteurId' => $demande->idClient,
                'cibleId' => $demande->idIntervenant,
                'typeAuteur' => 'client'
            ]);

            // Récupérer le nom du babysitter
            $babysitterName = 'le babysitter';
            if ($demande->intervenant && $demande->intervenant->user) {
                $babysitterName = $demande->intervenant->user->prenom . ' ' . $demande->intervenant->user->nom;
            }

            Mail::to($demande->client->email)->send(new FeedbackReminderMail(
                $demande->client->prenom,
                $babysitterName,
                $dateStr,
                $url
            ));
            
            $this->info("Rappel envoyé au client ID {$demande->idClient} pour demande #{$demande->idDemande}");

        } catch (\Exception $e) {
            $this->error("Erreur envoi client demande #{$demande->idDemande}: " . $e->getMessage());
        }
    }

    protected function sendReminderToBabysitter($demande, $dateStr)
    {
        try {
            // URL pour que le babysitter note le client
            $url = route('feedback.babysitter', [
                'idService' => $demande->idService,
                'demandeId' => $demande->idDemande,
                'auteurId' => $demande->idIntervenant,
                'cibleId' => $demande->idClient,
                'typeAuteur' => 'intervenant'
            ]);

            $intervenantUser = Utilisateur::find($demande->idIntervenant);

            if ($intervenantUser && $intervenantUser->email) {
                $clientName = $demande->client ? ($demande->client->prenom . ' ' . $demande->client->nom) : 'le client';

                Mail::to($intervenantUser->email)->send(new FeedbackReminderMail(
                    $intervenantUser->prenom,
                    $clientName,
                    $dateStr,
                    $url
                ));

                $this->info("Rappel envoyé au babysitter ID {$demande->idIntervenant} pour demande #{$demande->idDemande}");
            }

        } catch (\Exception $e) {
            $this->error("Erreur envoi babysitter demande #{$demande->idDemande}: " . $e->getMessage());
        }
    }
}
