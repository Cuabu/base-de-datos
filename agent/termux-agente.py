import asyncio
import json
import os
import platform
import socket
import time

import psutil
import websockets

# Cambia esta dirección por la IP o dominio de tu servidor
SERVIDOR = "ws://192.168.1.100:8765"

INTERVALO = 5  # segundos


def obtener_datos():
    memoria = psutil.virtual_memory()
    disco = psutil.disk_usage("/")

    return {
        "hostname": socket.gethostname(),
        "usuario": os.getenv("USER", "desconocido"),
        "sistema": platform.system(),
        "version": platform.release(),
        "arquitectura": platform.machine(),
        "cpu": psutil.cpu_percent(interval=1),
        "ram_total_mb": round(memoria.total / 1024 / 1024),
        "ram_usada_mb": round(memoria.used / 1024 / 1024),
        "ram_porcentaje": memoria.percent,
        "disco_total_gb": round(disco.total / 1024 / 1024 / 1024, 2),
        "disco_libre_gb": round(disco.free / 1024 / 1024 / 1024, 2),
        "disco_porcentaje": disco.percent,
        "timestamp": int(time.time())
    }


async def ejecutar():

    while True:

        try:

            print("Conectando al servidor...")

            async with websockets.connect(SERVIDOR) as ws:

                print("Conectado.")

                while True:

                    datos = obtener_datos()

                    await ws.send(json.dumps(datos))

                    print("Reporte enviado")

                    await asyncio.sleep(INTERVALO)

        except Exception as e:

            print("Servidor no disponible:", e)

            await asyncio.sleep(5)


if __name__ == "__main__":
    asyncio.run(ejecutar())