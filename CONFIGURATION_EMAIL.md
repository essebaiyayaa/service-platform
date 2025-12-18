# Configuration des Emails de Feedback

## 📧 Vue d'ensemble

Le système d'envoi automatique de feedback fonctionne selon les règles suivantes :

### Règles d'envoi
1. **Premier email (J+1)** : Envoyé le jour après l'intervention au client ET à l'intervenant
2. **Deuxième email (J+6)** : Envoyé le 6ème jour après l'intervention au client ET à l'intervenant
3. **Arrêt conditionnel** : Si l'un des deux (client OU intervenant) remplit le feedback, on arrête l'envoi des emails pour cette personne uniquement

---

## ⚙️ Configuration SMTP

### Option 1 : Gmail (Recommandé pour le développement)

1. **Créer un mot de passe d'application Gmail** :
   - Aller sur https://myaccount.google.com/security
   - Activer la validation en 2 étapes si ce n'est pas déjà fait
   - Aller dans "Mots de passe des applications"
   - Créer un nouveau mot de passe pour "Mail"

2. **Modifier le fichier `.env`** :
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre-email@gmail.com
MAIL_PASSWORD=votre-mot-de-passe-application
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=votre-email@gmail.com
MAIL_FROM_NAME="Helpora"
```

### Option 2 : Mailtrap (Recommandé pour les tests)

1. **Créer un compte sur Mailtrap** : https://mailtrap.io
2. **Récupérer les identifiants SMTP**
3. **Modifier le fichier `.env`** :
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=votre-username-mailtrap
MAIL_PASSWORD=votre-password-mailtrap
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@helpora.com
MAIL_FROM_NAME="Helpora"
```

### Option 3 : Autre service SMTP

Vous pouvez utiliser n'importe quel service SMTP (SendGrid, Mailgun, Amazon SES, etc.)
Consultez la documentation de votre fournisseur pour les paramètres SMTP.

---

## 🚀 Activation du système

### 1. Vérifier la configuration

```bash
php artisan config:clear
php artisan config:cache
```

### 2. Tester l'envoi d'emails

Créez un fichier de test `test-email.php` à la racine :

```php
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Mail;

Mail::raw('Test email depuis Helpora', function ($message) {
    $message->to('votre-email@example.com')
            ->subject('Test Email Helpora');
});

echo "Email envoyé avec succès!\n";
```

Exécutez :
```bash
php test-email.php
```

### 3. Configurer le Scheduler Laravel

Le système utilise le scheduler Laravel pour envoyer les emails automatiquement chaque jour à 10h.

#### Sur Windows (Développement)

Créez un fichier `run-scheduler.bat` :
```batch
@echo off
cd /d "c:\Users\douae\OneDrive\Bureau\helpora\service-platform-1"
php artisan schedule:work
```

Exécutez ce fichier en arrière-plan ou utilisez le Planificateur de tâches Windows.

#### Sur Linux/Production

Ajoutez cette ligne au crontab :
```bash
* * * * * cd /chemin/vers/votre/projet && php artisan schedule:run >> /dev/null 2>&1
```

### 4. Tester manuellement l'envoi de rappels

```bash
php artisan feedback:send-reminders
```

Cette commande va :
- Chercher toutes les interventions terminées avec statut "validée"
- Vérifier si des feedbacks ont déjà été soumis
- Envoyer les emails de rappel appropriés (J+1 ou J+6)
- Arrêter l'envoi si un feedback a été soumis

---

## 🔍 Vérification et Debugging

### Consulter les logs

Les logs sont enregistrés dans :
- `storage/logs/laravel.log` - Logs généraux
- `storage/logs/feedback-reminders.log` - Logs spécifiques aux rappels

### Vérifier la table feedback_rappels

```sql
SELECT * FROM feedback_rappels ORDER BY created_at DESC;
```

Cette table contient :
- `idDemande` : ID de la demande d'intervention
- `type_destinataire` : 'client' ou 'intervenant'
- `rappel_number` : 1 (premier rappel) ou 2 (deuxième rappel)
- `date_envoi` : Date d'envoi du rappel
- `feedback_fourni` : true si le feedback a été soumis

### Commande de debug

Une commande de debug est disponible :
```bash
php artisan feedback:debug
```

---

## 📊 Structure de la base de données

### Table `feedback_rappels`
Stocke l'historique des rappels envoyés et leur statut.

### Table `feedbacks`
Stocke les feedbacks soumis par les clients et intervenants.

### Table `demandes_intervention`
Contient les interventions. Le système surveille celles avec :
- `statut = 'validée'`
- `idIntervenant` non null
- Date/heure de fin passée

---

## ❓ FAQ

**Q: Les emails ne sont pas envoyés, que faire ?**
R: 
1. Vérifiez votre configuration SMTP dans `.env`
2. Exécutez `php artisan config:clear`
3. Consultez les logs dans `storage/logs/laravel.log`
4. Testez avec Mailtrap pour voir si le problème vient de votre serveur SMTP

**Q: Comment arrêter les rappels pour une intervention spécifique ?**
R: Marquez manuellement les rappels comme terminés :
```sql
UPDATE feedback_rappels 
SET feedback_fourni = true 
WHERE idDemande = [ID_DEMANDE];
```

**Q: Comment changer l'heure d'envoi des rappels ?**
R: Modifiez le fichier `app/Console/Kernel.php` ligne 18 :
```php
->at('10:00')  // Changez l'heure ici
```

**Q: Comment personnaliser les templates d'emails ?**
R: Les templates se trouvent dans :
- `resources/views/emails/feedback/client-reminder.blade.php`
- `resources/views/emails/feedback/intervenant-reminder.blade.php`

---

## 🎯 Prochaines étapes

1. ✅ Configurer votre service SMTP
2. ✅ Tester l'envoi manuel avec `php artisan feedback:send-reminders`
3. ✅ Configurer le scheduler (cron ou Planificateur Windows)
4. ✅ Surveiller les logs pendant les premiers jours
5. ✅ Ajuster les templates d'emails si nécessaire

---

**Support** : Pour toute question, consultez la documentation Laravel sur les emails : https://laravel.com/docs/mail
