import socket
import json
import platform
import psutil
import time

def obtener_metricas():
    # Obtener información de la RAM
    ram = psutil.virtual_memory()
    # Obtener información del disco raíz ('/' en Linux/Mac, 'C:\\' en Windows)
    ruta_disco = 'C:\\' if platform.system() == 'Windows' else '/'
    disco = psutil.disk_usage(ruta_disco)

    # Construir un diccionario con los datos del sistema
    metricas = {
        "sistema": platform.system(),
        "nodo": platform.node(),
        "version": platform.release(),
        "cpu_percent": psutil.cpu_percent(interval=1), # Intervalo de 1s para medir bien la CPU
        "ram_total": round(ram.total / (1024**3), 2),
        "ram_usada": round(ram.used / (1024**3), 2),
        "ram_percent": ram.percent,
        "disco_total": round(disco.total / (1024**3), 2),
        "disco_usado": round(disco.used / (1024**3), 2),
        "disco_percent": disco.percent
    }
    return metricas

def enviar_metricas(host_servidor='127.0.0.1', puerto=5000):
    metricas = obtener_metricas()
    
    try:
        # Crear socket y conectar al servidor
        cliente = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        cliente.connect((host_servidor, puerto))
        
        # Enviar los datos convertidos a JSON y codificados en bytes
        cliente.sendall(json.dumps(metricas).encode('utf-8'))
        cliente.close()
        print(f"[+] Métricas enviadas a {host_servidor}:{puerto}")
        
    except ConnectionRefusedError:
        print("[-] No se pudo conectar al servidor. Asegúrate de que esté en ejecución.")

if __name__ == "__main__":
    print("[*] Iniciando el Agente de Monitoreo...")
    # Bucle infinito para enviar datos cada 5 segundos
    try:
        while True:
            enviar_metricas()
            time.sleep(5)
    except KeyboardInterrupt:
        print("\n[*] Agente detenido.")