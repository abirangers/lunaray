@echo off
echo ========================================
echo Starting Ngrok Tunnel for Lunaray
echo ========================================
echo.

REM Start Laravel development server in background
echo Starting Laravel server on port 8000...
start /B php artisan serve --host=127.0.0.1 --port=8000

REM Wait for Laravel to start
timeout /t 3 /nobreak >nul

REM Start ngrok tunnel
echo Starting ngrok tunnel...
echo.
echo ========================================
echo Your app will be accessible via ngrok URL
echo Copy the HTTPS URL and share it!
echo ========================================
echo.

REM Use full path to ngrok
C:\Users\USER\Downloads\ngrok-v3-stable-windows-amd64\ngrok.exe http 8000 --log=stdout

REM If ngrok exits, stop Laravel server
echo.
echo Stopping Laravel server...
taskkill /F /IM php.exe /T >nul 2>&1
echo Done!
pause

