# 🚀 Guide de Démarrage Rapide - Système de Feedback

## ⚡ Configuration en 5 Minutes

### Étape 1 : Configuration SMTP (2 min)

**Option A : Mailtrap (Recommandé pour les tests)**
1. Créez un compte sur https://mailtrap.io (gratuit)
2. Copiez vos identifiants SMTP
3. Modifiez votre fichier `.env` :
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

**Option B : Gmail (Pour la production)**
1. Activez la validation en 2 étapes sur Gmail
2. Créez un mot de passe d'application : https://myaccount.google.com/apppasswords
3. Modifiez votre fichier `.env` :
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre-email@gmail.com
MAIL_PASSWORD=votre-mot-de-passe-application-16-caracteres
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=votre-email@gmail.com
MAIL_FROM_NAME="Helpora"
```

4. Effacez le cache :
```bash
php artisan config:clear
```

---

### Étape 2 : Tester la Configuration (1 min)

```bash
php test-email-config.php
```

Entrez votre email et vérifiez que vous recevez l'email de test.

---

### Étape 3 : Vérifier le Système (1 min)

```bash
php artisan feedback:debug
```

Cette commande affiche :
- ✅ Configuration email
- ✅ Demandes d'intervention
- ✅ Feedbacks existants
- ✅ Rappels envoyés
- ✅ Prochains rappels

---

### Étape 4 : Tester l'Envoi (1 min)

```bash
php artisan feedback:send-reminders
```

Vérifiez les logs :
```bash
tail -f storage/logs/feedback-reminders.log
```

---

### Étape 5 : Activer le Scheduler (30 sec)

**Windows :**
Double-cliquez sur `run-scheduler.bat`

**Linux :**
```bash
crontab -e
```
Ajoutez :
```bash
* * * * * cd /chemin/vers/helpora && php artisan schedule:run >> /dev/null 2>&1
```

---

## ✅ C'est Tout !

Le système est maintenant actif et enverra automatiquement :
- 📧 Premier rappel : J+1 après l'intervention
- 📧 Deuxième rappel : J+6 après l'intervention
- 🛑 Arrêt automatique si feedback soumis

---

## 📋 Checklist de Vérification

- [ ] Configuration SMTP dans `.env`
- [ ] Test email réussi (`php test-email-config.php`)
- [ ] Commande de debug exécutée (`php artisan feedback:debug`)
- [ ] Scheduler activé (`run-scheduler.bat` ou crontab)
- [ ] Logs vérifiés (`storage/logs/feedback-reminders.log`)

---

## 🆘 Problèmes Courants

### "Connection refused" lors du test email
➡️ Vérifiez vos identifiants SMTP dans `.env`
➡️ Exécutez `php artisan config:clear`

### Aucun rappel envoyé
➡️ Vérifiez qu'il y a des interventions avec statut 'validée'
➡️ Vérifiez que l'intervention est terminée (date/heure passée)
➡️ Exécutez `php artisan feedback:debug` pour voir les détails

### Le scheduler ne fonctionne pas
➡️ Windows : Vérifiez que `run-scheduler.bat` est en cours d'exécution
➡️ Linux : Vérifiez le crontab avec `crontab -l`

---

## 📚 Documentation Complète

Pour plus de détails, consultez :
- `README_FEEDBACK.md` - Documentation complète
- `CONFIGURATION_EMAIL.md` - Guide de configuration détaillé
- `.env.smtp.exemple` - Exemples de configuration

---

**Besoin d'aide ?**
Exécutez `php artisan feedback:debug` pour diagnostiquer les problèmes.
