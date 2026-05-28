-- Create database
CREATE DATABASE IF NOT EXISTS diccionariodb;
USE diccionariodb;

-- Users table for authentication
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Objetos table for the data dictionary
CREATE TABLE IF NOT EXISTS objetos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    tipo VARCHAR(100) NOT NULL,
    descripcion TEXT,
    base_datos VARCHAR(255),
    usuario_creador INT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_creador) REFERENCES users(id) ON DELETE SET NULL
);

-- Insert a default user (password is '123456')
INSERT INTO users (name, email, password) VALUES ('Admin', 'admin@example.com', '$2y$10$0N3205WhRuKNH8I2XVMCn.uAVRwsu6mj0En1cKyozc3Ni2BZfiCJ2');
