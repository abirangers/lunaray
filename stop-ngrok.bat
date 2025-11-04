@echo off
echo ========================================
echo Stopping Ngrok and Laravel Server
echo ========================================
echo.

echo Stopping ngrok...
taskkill /F /IM ngrok.exe /T >nul 2>&1

echo Stopping Laravel server...
taskkill /F /IM php.exe /T >nul 2>&1

echo.
echo All services stopped!
echo ========================================
pause

