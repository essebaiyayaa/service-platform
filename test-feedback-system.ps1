# Script PowerShell pour tester le système de feedback
# Usage: .\test-feedback-system.ps1

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Test du Système de Feedback - Helpora" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

$projectPath = "c:\Users\douae\OneDrive\Bureau\helpora\service-platform-1"
Set-Location $projectPath

# Fonction pour afficher un titre de section
function Show-Section {
    param([string]$title)
    Write-Host ""
    Write-Host "--- $title ---" -ForegroundColor Yellow
    Write-Host ""
}

# 1. Vérifier la configuration email
Show-Section "1. Configuration Email"
php artisan config:show mail | Select-String "mailer", "host", "port", "username", "from"

# 2. Vérifier les migrations
Show-Section "2. Statut des Migrations"
php artisan migrate:status | Select-String "feedback"

# 3. Exécuter la commande de debug
Show-Section "3. Debug du Système"
php artisan feedback:debug

# 4. Proposer de tester l'envoi
Write-Host ""
$test = Read-Host "Voulez-vous tester l'envoi d'emails maintenant? (o/n)"
if ($test -eq "o" -or $test -eq "O") {
    Show-Section "4. Test d'Envoi d'Emails"
    php test-email-config.php
}

# 5. Proposer d'envoyer les rappels
Write-Host ""
$rappels = Read-Host "Voulez-vous envoyer les rappels de feedback maintenant? (o/n)"
if ($rappels -eq "o" -or $rappels -eq "O") {
    Show-Section "5. Envoi des Rappels"
    php artisan feedback:send-reminders
}

# 6. Afficher les logs récents
Write-Host ""
$logs = Read-Host "Voulez-vous voir les logs récents? (o/n)"
if ($logs -eq "o" -or $logs -eq "O") {
    Show-Section "6. Logs Récents"
    if (Test-Path "storage\logs\feedback-reminders.log") {
        Get-Content "storage\logs\feedback-reminders.log" -Tail 20
    } else {
        Write-Host "Aucun log de rappel trouvé." -ForegroundColor Yellow
    }
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "  Test Terminé!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""
Write-Host "Pour plus d'informations, consultez:" -ForegroundColor Cyan
Write-Host "  - README_FEEDBACK.md" -ForegroundColor White
Write-Host "  - QUICKSTART_FEEDBACK.md" -ForegroundColor White
Write-Host "  - CONFIGURATION_EMAIL.md" -ForegroundColor White
Write-Host ""
