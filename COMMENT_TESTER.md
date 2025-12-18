# 🧪 COMMENT TESTER LE SYSTÈME DE FEEDBACK

## ✅ TEST RAPIDE (3 étapes simples)

### 📝 ÉTAPE 1 : Configurer l'email (1 minute)

**Option la plus simple - Mailtrap (GRATUIT)** :

1. Allez sur **https://mailtrap.io** 
2. Créez un compte gratuit
3. Dans votre inbox, cliquez sur "Show Credentials"
4. Copiez les informations

5. **Ouvrez votre fichier `.env`** et modifiez ces lignes :

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=collez-votre-username-ici
MAIL_PASSWORD=collez-votre-password-ici
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@helpora.com
MAIL_FROM_NAME="Helpora"
```

6. **Exécutez cette commande** :
```bash
php artisan config:clear
```

---

### 📧 ÉTAPE 2 : Tester l'envoi d'email (30 secondes)

**Exécutez cette commande** :
```bash
php test-email-config.php
```

- Le script vous demande votre email
- Tapez n'importe quel email (ex: test@example.com)
- Appuyez sur Entrée

**Résultat attendu** :
- ✅ "Email envoyé avec succès!"
- Allez sur Mailtrap.io → vous verrez l'email dans votre inbox

---

### 🔍 ÉTAPE 3 : Vérifier le système (30 secondes)

**Exécutez cette commande** :
```bash
php artisan feedback:debug
```

**Ce que vous verrez** :
- ✅ Configuration email
- ✅ Nombre de demandes d'intervention
- ✅ Nombre de feedbacks
- ✅ Rappels envoyés
- ✅ Prochains rappels à envoyer

---

## 🎯 TEST COMPLET (Si vous voulez tester l'envoi de rappels)

### Option A : Tester avec des données existantes

**Exécutez** :
```bash
php artisan feedback:send-reminders
```

**Ce qui se passe** :
- Le système cherche les interventions terminées
- Envoie les rappels aux clients/intervenants
- Vous verrez les emails dans Mailtrap

---

### Option B : Créer une intervention de test

1. **Dans votre base de données**, créez une intervention avec :
   - `statut = 'validée'`
   - `dateSouhaitee` = hier
   - `heureFin` = une heure passée
   - `idClient` et `idIntervenant` renseignés

2. **Exécutez** :
```bash
php artisan feedback:send-reminders
```

3. **Vérifiez Mailtrap** → Vous devriez voir 2 emails (client + intervenant)

---

## 📊 VÉRIFIER LES RÉSULTATS

### Voir les logs :
```bash
type storage\logs\feedback-reminders.log
```

### Voir les rappels dans la base de données :
```sql
SELECT * FROM feedback_rappels ORDER BY created_at DESC;
```

---

## ❓ PROBLÈMES COURANTS

### "Connection refused"
➡️ Vérifiez vos identifiants Mailtrap dans `.env`
➡️ Exécutez `php artisan config:clear`

### "Aucun rappel à envoyer"
➡️ Normal si vous n'avez pas d'intervention terminée
➡️ Créez une intervention de test (voir Option B ci-dessus)

### L'email n'arrive pas
➡️ Si vous utilisez Mailtrap, l'email est dans votre inbox Mailtrap (pas dans votre vraie boîte mail)
➡️ C'est normal ! Mailtrap capture les emails pour les tests

---

## 🚀 ACTIVER EN PRODUCTION

Une fois les tests OK, pour activer en production :

1. **Configurez Gmail ou un autre service SMTP** (voir `.env.smtp.exemple`)

2. **Lancez le scheduler** :
   - Windows : Double-cliquez sur `run-scheduler.bat`
   - Linux : Ajoutez au crontab (voir README_FEEDBACK.md)

3. **C'est tout !** Les emails seront envoyés automatiquement chaque jour à 10h

---

## 📞 BESOIN D'AIDE ?

Exécutez simplement :
```bash
php artisan feedback:debug
```

Cette commande vous montre exactement l'état du système.

---

**Temps total de test : 2-3 minutes** ⏱️
