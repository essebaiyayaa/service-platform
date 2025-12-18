@echo off
REM ============================================
REM Script pour exécuter le scheduler Laravel
REM ============================================

echo.
echo ========================================
echo   Helpora - Scheduler Laravel
echo ========================================
echo.

cd /d "c:\Users\douae\OneDrive\Bureau\helpora\service-platform-1"

echo Demarrage du scheduler...
echo Le scheduler va verifier les taches toutes les minutes.
echo.
echo IMPORTANT: Gardez cette fenetre ouverte pour que
echo les emails de feedback soient envoyes automatiquement.
echo.
echo Pour arreter, appuyez sur Ctrl+C
echo.
echo ----------------------------------------
echo.

php artisan schedule:work
