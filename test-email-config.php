<?php

/**
 * Script de test pour vérifier la configuration SMTP
 * Usage: php test-email-config.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

echo "==============================================\n";
echo "  Test de Configuration Email - Helpora\n";
echo "==============================================\n\n";

// Afficher la configuration actuelle
echo "📧 Configuration SMTP actuelle:\n";
echo "--------------------------------\n";
echo "MAIL_MAILER: " . env('MAIL_MAILER', 'non défini') . "\n";
echo "MAIL_HOST: " . env('MAIL_HOST', 'non défini') . "\n";
echo "MAIL_PORT: " . env('MAIL_PORT', 'non défini') . "\n";
echo "MAIL_USERNAME: " . env('MAIL_USERNAME', 'non défini') . "\n";
echo "MAIL_PASSWORD: " . (env('MAIL_PASSWORD') ? '***défini***' : 'non défini') . "\n";
echo "MAIL_ENCRYPTION: " . env('MAIL_ENCRYPTION', 'non défini') . "\n";
echo "MAIL_FROM_ADDRESS: " . env('MAIL_FROM_ADDRESS', 'non défini') . "\n";
echo "MAIL_FROM_NAME: " . env('MAIL_FROM_NAME', 'non défini') . "\n\n";

// Demander l'email de destination
echo "Entrez votre adresse email pour le test (ou appuyez sur Entrée pour annuler): ";
$handle = fopen("php://stdin", "r");
$email = trim(fgets($handle));
fclose($handle);

if (empty($email)) {
    echo "\n❌ Test annulé.\n";
    exit(0);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "\n❌ Adresse email invalide.\n";
    exit(1);
}

echo "\n🚀 Envoi de l'email de test à: $email\n";
echo "Veuillez patienter...\n\n";

try {
    Mail::send('emails.feedback.client-reminder', [
        'user' => (object)[
            'prenom' => 'Test',
            'email' => $email
        ],
        'demande' => (object)[
            'dateSouhaitee' => now()->format('d/m/Y'),
            'idDemande' => 999
        ],
        'rappel_number' => 1,
        'userType' => 'client',
        'feedback_url' => url('/feedback/999')
    ], function ($message) use ($email) {
        $message->to($email)
                ->subject('Test Email - Système de Feedback Helpora');
    });

    echo "✅ Email envoyé avec succès!\n\n";
    echo "Vérifiez votre boîte de réception (et le dossier spam).\n";
    
    if (env('MAIL_MAILER') === 'log') {
        echo "\n⚠️  ATTENTION: Vous utilisez le driver 'log'.\n";
        echo "Les emails sont enregistrés dans storage/logs/laravel.log\n";
        echo "Pour envoyer de vrais emails, configurez SMTP dans le fichier .env\n";
    }
    
    if (env('MAIL_MAILER') === 'smtp' && env('MAIL_HOST') === 'sandbox.smtp.mailtrap.io') {
        echo "\n📬 Vous utilisez Mailtrap.\n";
        echo "Consultez votre inbox sur https://mailtrap.io\n";
    }

    exit(0);

} catch (\Exception $e) {
    echo "❌ Erreur lors de l'envoi de l'email:\n";
    echo "Message: " . $e->getMessage() . "\n\n";
    
    echo "💡 Solutions possibles:\n";
    echo "1. Vérifiez vos identifiants SMTP dans le fichier .env\n";
    echo "2. Assurez-vous que votre pare-feu autorise les connexions SMTP\n";
    echo "3. Si vous utilisez Gmail, créez un mot de passe d'application\n";
    echo "4. Essayez avec Mailtrap pour les tests: https://mailtrap.io\n";
    echo "5. Consultez les logs: storage/logs/laravel.log\n\n";
    
    echo "Détails de l'erreur:\n";
    echo $e->getTraceAsString() . "\n";
    
    exit(1);
}
