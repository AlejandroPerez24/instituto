-- 1️ CREAR BASE DE DATOS
CREATE DATABASE IF NOT EXISTS registro_contactos;

-- Usar la base de datos recién creada
USE registro_contactos;

-- 2 CREAR TABLA 'contacto'
CREATE TABLE contacto (
    Codcontacto INT AUTO_INCREMENT PRIMARY KEY,
    Nombcontacto VARCHAR(50) NOT NULL,
    Apecontacto VARCHAR(50) NOT NULL,
    Direccion VARCHAR(100) NOT NULL,
    Telefono VARCHAR(15) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    FNac DATE NOT NULL,
    EstadoCivil VARCHAR(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
