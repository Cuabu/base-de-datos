import socket
import json

def iniciar_servidor(host='0.0.0.0', puerto=5000):
    # Crear un socket TCP/IP
    servidor = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    
    # Permitir reusar la dirección si el puerto se queda "enganchado"
    servidor.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
    
    servidor.bind((host, puerto))
    servidor.listen(5)
    print(f"[*] Servidor de monitoreo escuchando en {host}:{puerto}...")

    try:
        while True:
            conexion, direccion = servidor.accept()
            datos = conexion.recv(4096)
            
            if datos:
                try:
                    # Decodificar el JSON recibido
                    metricas = json.loads(datos.decode('utf-8'))
                    
                    print(f"\n[+] Reporte recibido desde: {direccion[0]}")
                    print("-" * 40)
                    print(f"🖥️  Sistema: {metricas.get('sistema')} {metricas.get('version')}")
                    print(f"🏷️  Nombre del Equipo: {metricas.get('nodo')}")
                    print(f"⚙️  Uso de CPU: {metricas.get('cpu_percent')}%")
                    print(f"🧠 Memoria RAM: {metricas.get('ram_usada')} GB / {metricas.get('ram_total')} GB ({metricas.get('ram_percent')}%)")
                    print(f"💾 Disco Principal: {metricas.get('disco_usado')} GB / {metricas.get('disco_total')} GB ({metricas.get('disco_percent')}%)")
                    print("-" * 40)
                    
                except json.JSONDecodeError:
                    print("[-] Error al decodificar los datos recibidos.")
            
            conexion.close()
    except KeyboardInterrupt:
        print("\n[*] Servidor apagado.")
        servidor.close()

if __name__ == "__main__":
    iniciar_servidor()