@echo off
title Instalador de Librerias Python

echo ==========================================
echo      INSTALADOR DEL AGENTE BITWAVE
echo ==========================================
echo.

python --version
if %errorlevel% neq 0 (
    echo.
    echo Python no esta instalado.
    pause
    exit
)

echo.
echo Actualizando pip...
python -m pip install --upgrade pip

echo.
echo Instalando librerias...

pip install psutil
pip install websockets
pip install websocket-client
pip install requests
pip install aiohttp
pip install py-cpuinfo
pip install WMI
pip install pywin32

echo.
echo ==========================================
echo Instalacion finalizada correctamente.
echo ==========================================

pause