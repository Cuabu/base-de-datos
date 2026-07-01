CREATE DATABASE IF NOT EXISTS gestion_personas
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE gestion_personas;

CREATE TABLE personas (

    id INT AUTO_INCREMENT PRIMARY KEY,

    -- Información personal
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    tipo_documento VARCHAR(30),
    numero_documento VARCHAR(50),
    fecha_nacimiento DATE,
    genero VARCHAR(20),
    nacionalidad VARCHAR(100),

    -- Contacto
    telefono VARCHAR(30),
    telefono_secundario VARCHAR(30),
    correo VARCHAR(150),
    direccion TEXT,
    ciudad VARCHAR(100),
    departamento VARCHAR(100),
    pais VARCHAR(100),
    codigo_postal VARCHAR(20),

    -- Residencia
    lugar_residencia VARCHAR(200),

    -- Trabajo
    empresa VARCHAR(150),
    cargo VARCHAR(100),
    direccion_trabajo TEXT,
    telefono_trabajo VARCHAR(30),

    -- Dispositivos
    marca_celular VARCHAR(100),
    modelo_celular VARCHAR(100),
    imei VARCHAR(50),

    marca_computadora VARCHAR(100),
    modelo_computadora VARCHAR(100),
    numero_serie_pc VARCHAR(100),

    -- Redes sociales
    facebook VARCHAR(255),
    instagram VARCHAR(255),
    tiktok VARCHAR(255),
    x VARCHAR(255),
    youtube VARCHAR(255),
    linkedin VARCHAR(255),
    github VARCHAR(255),
    telegram VARCHAR(255),
    whatsapp VARCHAR(30),

    -- Fotografías y documentos
    foto_perfil VARCHAR(255),
    foto_documento_frontal VARCHAR(255),
    foto_documento_trasera VARCHAR(255),

    -- Información adicional
    estado_civil VARCHAR(50),
    profesion VARCHAR(100),
    nivel_estudios VARCHAR(100),
    observaciones TEXT,

    -- Auditoría
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP);
ALTER TABLE personas ADD placa_carro VARCHAR(20);
ALTER TABLE personas ADD modelo_carro VARCHAR(100);
