# 📧 Système d'Envoi Automatique de Feedback - Helpora

## ✅ Installation Terminée !

Le système d'envoi automatique d'emails de feedback a été configuré avec succès.

---

## 📝 Résumé du Système

### Règles d'Envoi

1. **Premier email (J+1)** : Envoyé le jour après l'intervention
   - Destinataires : Client ET Intervenant
   
2. **Deuxième email (J+6)** : Envoyé le 6ème jour après l'intervention
   - Destinataires : Client ET Intervenant (seulement ceux qui n'ont pas encore répondu)
   
3. **Arrêt automatique** : 
   - Si le client soumet son feedback → Arrêt des emails pour le client uniquement
   - Si l'intervenant soumet son feedback → Arrêt des emails pour l'intervenant uniquement

---

## 🗂️ Fichiers Créés/Modifiés

### Fichiers Modifiés
- ✅ `app/Jobs/SendFeedbackReminderJob.php` - Logique d'envoi des rappels (corrigé)
- ✅ `app/Console/Commands/DebugFeedback.php` - Commande de debug améliorée
- ✅ `database/migrations/2025_12_18_163000_create_feedback_rappels_table.php` - Migration corrigée

### Fichiers Créés
- ✅ `CONFIGURATION_EMAIL.md` - Guide complet de configuration
- ✅ `.env.smtp.exemple` - Exemples de configuration SMTP
- ✅ `test-email-config.php` - Script de test de configuration email
- ✅ `run-scheduler.bat` - Script Windows pour lancer le scheduler
- ✅ `README_FEEDBACK.md` - Ce fichier

### Fichiers Existants (Déjà Configurés)
- ✅ `app/Console/Commands/SendFeedbackReminders.php` - Commande artisan
- ✅ `app/Console/Kernel.php` - Scheduler configuré (10h chaque jour)
- ✅ `app/Models/Shared/FeedbackRappel.php` - Modèle de rappels
- ✅ `app/Models/Shared/Feedback.php` - Modèle de feedbacks
- ✅ `resources/views/emails/feedback/client-reminder.blade.php` - Template email client
- ✅ `resources/views/emails/feedback/intervenant-reminder.blade.php` - Template email intervenant

---

## 🚀 Prochaines Étapes

### 1. Configurer SMTP (OBLIGATOIRE)

Actuellement, le système est en mode `log` (les emails sont enregistrés dans les logs).

**Pour envoyer de vrais emails :**

1. Ouvrez le fichier `.env.smtp.exemple`
2. Choisissez une configuration (Gmail, Mailtrap, SendGrid, etc.)
3. Copiez la configuration dans votre fichier `.env`
4. Exécutez :
   ```bash
   php artisan config:clear
   php artisan config:cache
   ```

**Recommandations :**
- **Pour les tests** : Utilisez Mailtrap (https://mailtrap.io) - Gratuit
- **Pour la production** : Utilisez Gmail avec mot de passe d'application ou SendGrid

### 2. Tester la Configuration Email

```bash
php test-email-config.php
```

Ce script vous demandera votre email et enverra un email de test.

### 3. Vérifier le Système

```bash
php artisan feedback:debug
```

Cette commande affiche :
- ✅ Configuration email actuelle
- ✅ Demandes d'intervention terminées
- ✅ Feedbacks déjà soumis
- ✅ Rappels envoyés
- ✅ Prochains rappels à envoyer

### 4. Tester l'Envoi Manuel

```bash
php artisan feedback:send-reminders
```

Cette commande :
- Cherche toutes les interventions terminées (statut = 'validée')
- Vérifie si des feedbacks ont été soumis
- Envoie les rappels appropriés (J+1 ou J+6)
- Arrête l'envoi si un feedback a été soumis

### 5. Activer le Scheduler (Production)

#### Sur Windows (Développement)

Double-cliquez sur `run-scheduler.bat` ou exécutez :
```bash
run-scheduler.bat
```

Gardez cette fenêtre ouverte. Le scheduler vérifiera les tâches toutes les minutes.

#### Sur Linux/Production

Ajoutez au crontab :
```bash
crontab -e
```

Puis ajoutez :
```bash
* * * * * cd /chemin/vers/helpora && php artisan schedule:run >> /dev/null 2>&1
```

---

## 🔍 Commandes Utiles

### Debug et Vérification
```bash
# Afficher l'état complet du système
php artisan feedback:debug

# Vérifier la configuration email
php test-email-config.php

# Voir les migrations
php artisan migrate:status
```

### Envoi Manuel
```bash
# Envoyer les rappels manuellement
php artisan feedback:send-reminders

# Voir les logs
tail -f storage/logs/laravel.log
tail -f storage/logs/feedback-reminders.log
```

### Configuration
```bash
# Effacer le cache de configuration
php artisan config:clear

# Mettre en cache la configuration
php artisan config:cache

# Voir la configuration mail
php artisan config:show mail
```

---

## 📊 Structure de la Base de Données

### Table `feedback_rappels`
Stocke l'historique des rappels envoyés.

| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint | ID unique |
| idDemande | bigint | ID de la demande d'intervention |
| idClient | bigint | ID du client |
| idIntervenant | bigint | ID de l'intervenant |
| type_destinataire | enum | 'client' ou 'intervenant' |
| rappel_number | int | 1 (premier rappel) ou 2 (deuxième rappel) |
| date_envoi | timestamp | Date d'envoi du rappel |
| prochain_rappel | timestamp | Date du prochain rappel (nullable) |
| feedback_fourni | boolean | true si le feedback a été soumis |

### Table `feedbacks`
Stocke les feedbacks soumis par les clients et intervenants.

| Colonne | Type | Description |
|---------|------|-------------|
| idFeedBack | bigint | ID unique |
| idAuteur | bigint | ID de l'auteur du feedback |
| idCible | bigint | ID de la personne évaluée |
| typeAuteur | enum | 'client' ou 'intervenant' |
| idDemande | bigint | ID de la demande d'intervention |
| commentaire | text | Commentaire |
| credibilite | int | Note 0-5 |
| sympathie | int | Note 0-5 |
| ponctualite | int | Note 0-5 |
| proprete | int | Note 0-5 |
| qualiteTravail | int | Note 0-5 |

---

## 🔧 Dépannage

### Les emails ne sont pas envoyés

1. **Vérifiez la configuration SMTP** :
   ```bash
   php artisan config:show mail
   ```

2. **Testez l'envoi** :
   ```bash
   php test-email-config.php
   ```

3. **Consultez les logs** :
   ```bash
   tail -f storage/logs/laravel.log
   ```

4. **Vérifiez que le scheduler tourne** :
   - Windows : Le fichier `run-scheduler.bat` doit être en cours d'exécution
   - Linux : Vérifiez le crontab avec `crontab -l`

### Aucun rappel n'est envoyé

1. **Vérifiez qu'il y a des interventions terminées** :
   ```bash
   php artisan feedback:debug
   ```

2. **Vérifiez le statut des demandes** :
   - Le statut doit être exactement 'validée' (avec accent)
   - L'intervention doit avoir un intervenant assigné
   - La date/heure de fin doit être passée

3. **Exécutez manuellement** :
   ```bash
   php artisan feedback:send-reminders
   ```

### Erreur de migration

Si la migration échoue, c'est probablement parce que la table existe déjà.
Vérifiez avec :
```bash
php artisan tinker --execute="echo DB::select('SHOW TABLES LIKE \'feedback_rappels\'') ? 'Table existe' : 'Table n\'existe pas';"
```

---

## 📞 Support

Pour toute question :
1. Consultez `CONFIGURATION_EMAIL.md` pour plus de détails
2. Exécutez `php artisan feedback:debug` pour diagnostiquer
3. Consultez les logs dans `storage/logs/`

---

## ✨ Fonctionnalités Implémentées

- ✅ Envoi automatique J+1 après intervention
- ✅ Envoi automatique J+6 après intervention
- ✅ Arrêt automatique si feedback soumis
- ✅ Gestion séparée client/intervenant
- ✅ Templates d'emails personnalisés
- ✅ Système de logs complet
- ✅ Commande de debug détaillée
- ✅ Script de test de configuration
- ✅ Support multi-fournisseurs SMTP
- ✅ Scheduler Laravel configuré

---

**Système développé pour Helpora** 🚀
Date de mise en place : 18 Décembre 2025
