import socket
import json
import mysql.connector
from mysql.connector import Error

# Configuración de la base de datos
DB_CONFIG = {
    'host': 'localhost',
    'user': 'root',       # Cambia por tu usuario
    'password': '',       # Cambia por tu contraseña
    'database': 'gestion_personas'  # Cambia por el nombre de tu base de datos
}

def guardar_en_db(metricas):
    try:
        conexion = mysql.connector.connect(**DB_CONFIG)
        if conexion.is_connected():
            cursor = conexion.cursor()
            
            consulta = """
                INSERT INTO dispositivos (
                    hostname, usuario, sistema, version, arquitectura, ip, cpu, 
                    ram_total, ram_usada, ram_porcentaje, disco_total, disco_libre, disco_porcentaje
                ) VALUES (
                    %(hostname)s, %(usuario)s, %(sistema)s, %(version)s, %(arquitectura)s, %(ip)s, %(cpu)s,
                    %(ram_total)s, %(ram_usada)s, %(ram_porcentaje)s, %(disco_total)s, %(disco_libre)s, %(disco_porcentaje)s
                )
            """
            
            cursor.execute(consulta, metricas)
            conexion.commit()
            print(f"[+] Datos guardados en DB para el host: {metricas.get('hostname')}")
            
    except Error as e:
        print(f"[-] Error al conectar o insertar en MySQL: {e}")
    finally:
        if 'conexion' in locals() and conexion.is_connected():
            cursor.close()
            conexion.close()

def iniciar_servidor(host='0.0.0.0', puerto=5000):
    servidor = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
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
                    metricas = json.loads(datos.decode('utf-8'))
                    print(f"\n[*] Recibido reporte de {direccion[0]}")
                    
                    # Guardar en la base de datos
                    guardar_en_db(metricas)
                    
                except json.JSONDecodeError:
                    print("[-] Error al decodificar los datos recibidos.")
            
            conexion.close()
    except KeyboardInterrupt:
        print("\n[*] Servidor apagado.")
        servidor.close()

if __name__ == "__main__":
    iniciar_servidor()