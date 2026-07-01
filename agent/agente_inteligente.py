import socket
import json
import platform
import psutil
import time
import getpass

# Configuración
HOST_SERVIDOR = '127.0.0.1' # IP de la máquina donde corre el servidor Python
PUERTO_SERVIDOR = 5000
INTERVALO_NORMAL = 1800     # 30 minutos en segundos (30 * 60)
INTERVALO_REVISION = 5      # Revisa el hardware internamente cada 5 segundos
UMBRAL_ALERTA = 80.0        # Porcentaje a partir del cual se envía alerta

def obtener_metricas():
    ram = psutil.virtual_memory()
    ruta_disco = 'C:\\' if platform.system() == 'Windows' else '/'
    disco = psutil.disk_usage(ruta_disco)

    metricas = {
        "hostname": platform.node(),
        "usuario": getpass.getuser(),
        "sistema": platform.system(),
        "version": platform.release(),
        "arquitectura": platform.machine(),
        "ip": socket.gethostbyname(socket.gethostname()),
        "cpu": round(psutil.cpu_percent(interval=1), 2),
        "ram_total": int(ram.total / (1024**2)),       # Guardado en MB para ser INT
        "ram_usada": int(ram.used / (1024**2)),        # Guardado en MB para ser INT
        "ram_porcentaje": round(ram.percent, 2),
        "disco_total": round(disco.total / (1024**3), 2), # Guardado en GB
        "disco_libre": round(disco.free / (1024**3), 2),  # Guardado en GB
        "disco_porcentaje": round(disco.percent, 2)
    }
    return metricas

def enviar_metricas(metricas, motivo="Rutina"):
    try:
        cliente = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        cliente.connect((HOST_SERVIDOR, PUERTO_SERVIDOR))
        cliente.sendall(json.dumps(metricas).encode('utf-8'))
        cliente.close()
        print(f"[+] [{motivo}] Métricas enviadas al servidor.")
    except ConnectionRefusedError:
        print("[-] Error: El servidor no está respondiendo.")

if __name__ == "__main__":
    print(f"[*] Agente iniciado. Reporte cada {INTERVALO_NORMAL//60} min o si el hardware supera el {UMBRAL_ALERTA}%.")
    
    ultimo_envio = 0 # Inicializar en 0 para que envíe el primer reporte inmediatamente
    
    try:
        while True:
            metricas = obtener_metricas()
            tiempo_actual = time.time()
            
            # Evaluar si algún componente supera el 80%
            alerta_hardware = (
                metricas["cpu"] >= UMBRAL_ALERTA or 
                metricas["ram_porcentaje"] >= UMBRAL_ALERTA or 
                metricas["disco_porcentaje"] >= UMBRAL_ALERTA
            )
            
            # Evaluar si ya pasaron los 30 minutos
            tiempo_cumplido = (tiempo_actual - ultimo_envio) >= INTERVALO_NORMAL
            
            if alerta_hardware:
                enviar_metricas(metricas, motivo="ALERTA > 80%")
                ultimo_envio = time.time()
                # Pausar por 60 segundos después de una alerta para evitar saturar la red/DB si el uso se queda en 81%
                time.sleep(60)
                
            elif tiempo_cumplido:
                enviar_metricas(metricas, motivo="Rutina 30 min")
                ultimo_envio = time.time()
                
            else:
                # Si todo está normal, esperar 5 segundos y volver a revisar
                time.sleep(INTERVALO_REVISION)
                
    except KeyboardInterrupt:
        print("\n[*] Agente detenido manualmente.")