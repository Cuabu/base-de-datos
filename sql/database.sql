-- ===========================================
-- CREAR BASE DE DATOS
-- ===========================================

CREATE DATABASE IF NOT EXISTS sistema_login
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE sistema_login;

-- ===========================================
-- CREAR TABLA USUARIOS
-- ===========================================

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ===========================================
-- INSERTAR USUARIO ADMINISTRADOR
-- ===========================================

-- Usuario: admin
-- Contraseña: Admin123*

INSERT INTO usuarios (nombre, usuario, password)
VALUES (
    'Carlos Alberto Cuabu',
    'admin',
    '$2y$10$EjemploDeHashGeneradoConPasswordHashxxxxxxxxxxxxxxxxxxxxxxxx'
);

-- ===========================================
-- VERIFICAR LOS DATOS
-- ===========================================

SELECT * FROM usuarios;