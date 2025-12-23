<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmationActionProf extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $statut = $this->data['statut'] === 'validée' ? 'acceptée' : 'refusée';
        $matiere = $this->data['matiere'] ?? 'Soutien scolaire';
        
        $subject = $statut === 'acceptée' 
            ? "Vous avez accepté une nouvelle mission" 
            : "Demande refusée";
        
        return $this->subject($subject)
                    ->view('emails.confirmation_prof');
    }
}