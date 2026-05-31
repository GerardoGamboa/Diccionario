-- Create database
CREATE DATABASE IF NOT EXISTS diccionariodb;
USE diccionariodb;

-- Users table for authentication
CREATE TABLE IF NOT EXISTS dic_usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 1. Servidores
CREATE TABLE IF NOT EXISTS dic_servidores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    ip VARCHAR(100),
    puerto INT,
    motor VARCHAR(100),
    descripcion TEXT,
    usuario_creador INT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_creador) REFERENCES dic_usuarios(id) ON DELETE SET NULL
);

-- 2. Bases de Datos (Linked to Servidor)
CREATE TABLE IF NOT EXISTS dic_bases_datos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    servidor_id INT NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    usuario_creador INT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (servidor_id) REFERENCES dic_servidores(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_creador) REFERENCES dic_usuarios(id) ON DELETE SET NULL
);

-- 3. Tablas (Linked to Base de Datos)
CREATE TABLE IF NOT EXISTS dic_tablas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    base_datos_id INT NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    usuario_creador INT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (base_datos_id) REFERENCES dic_bases_datos(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_creador) REFERENCES dic_usuarios(id) ON DELETE SET NULL
);

-- 4. Columnas (Linked to Tabla)
CREATE TABLE IF NOT EXISTS dic_columnas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tabla_id INT NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    tipo_dato VARCHAR(100),
    longitud VARCHAR(50),
    permite_nulo BOOLEAN DEFAULT TRUE,
    es_llave BOOLEAN DEFAULT FALSE,
    descripcion TEXT,
    usuario_creador INT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tabla_id) REFERENCES dic_tablas(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_creador) REFERENCES dic_usuarios(id) ON DELETE SET NULL
);

-- 5. Vistas (Linked to Base de Datos)
CREATE TABLE IF NOT EXISTS dic_vistas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    base_datos_id INT NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    codigo TEXT,
    descripcion TEXT,
    usuario_creador INT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (base_datos_id) REFERENCES dic_bases_datos(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_creador) REFERENCES dic_usuarios(id) ON DELETE SET NULL
);

-- 6. Procedimientos (Linked to Base de Datos)
CREATE TABLE IF NOT EXISTS dic_procedimientos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    base_datos_id INT NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    codigo TEXT,
    descripcion TEXT,
    usuario_creador INT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (base_datos_id) REFERENCES dic_bases_datos(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_creador) REFERENCES dic_usuarios(id) ON DELETE SET NULL
);

-- 7. Funciones (Linked to Base de Datos)
CREATE TABLE IF NOT EXISTS dic_funciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    base_datos_id INT NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    codigo TEXT,
    descripcion TEXT,
    usuario_creador INT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (base_datos_id) REFERENCES dic_bases_datos(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_creador) REFERENCES dic_usuarios(id) ON DELETE SET NULL
);

-- 8. Disparadores (Linked to Tabla)
CREATE TABLE IF NOT EXISTS dic_disparadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tabla_id INT NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    evento VARCHAR(100),
    codigo TEXT,
    descripcion TEXT,
    usuario_creador INT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tabla_id) REFERENCES dic_tablas(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_creador) REFERENCES dic_usuarios(id) ON DELETE SET NULL
);

-- Versioning table
CREATE TABLE IF NOT EXISTS dic_versiones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    objeto_id INT NOT NULL,
    tipo_objeto ENUM('procedimiento', 'funcion', 'disparador', 'vista') NOT NULL,
    consecutivo INT NOT NULL,
    codigo TEXT,
    descripcion TEXT,
    usuario_creador INT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_creador) REFERENCES dic_usuarios(id) ON DELETE SET NULL
);

-- Insert a default user (password is '123456')
INSERT INTO dic_usuarios (name, email, password) VALUES ('Admin', 'admin@example.com', '$2y$10$0N3205WhRuKNH8I2XVMCn.uAVRwsu6mj0En1cKyozc3Ni2BZfiCJ2');
