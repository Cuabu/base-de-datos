CREATE TABLE dispositivos (

    id INT AUTO_INCREMENT PRIMARY KEY,

    hostname VARCHAR(100),

    usuario VARCHAR(100),

    sistema VARCHAR(100),

    version VARCHAR(100),

    arquitectura VARCHAR(50),

    ip VARCHAR(50),

    cpu DECIMAL(5,2),

    ram_total INT,

    ram_usada INT,

    ram_porcentaje DECIMAL(5,2),

    disco_total DECIMAL(10,2),

    disco_libre DECIMAL(10,2),

    disco_porcentaje DECIMAL(5,2),

    ultima_conexion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP

);