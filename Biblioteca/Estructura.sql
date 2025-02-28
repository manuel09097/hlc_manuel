CREATE DATABASE IF NOT EXISTS Biblioteca;

USE Biblioteca;

-- Crear tabla de Autores
CREATE TABLE IF NOT EXISTS Autores (
    id_autor INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL
);

-- Crear tabla de Categorias
CREATE TABLE IF NOT EXISTS Categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL
);

-- Crear tabla de Editoriales
CREATE TABLE IF NOT EXISTS Editoriales (
    id_editorial INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL
);

-- Crear tabla de Usuarios
CREATE TABLE IF NOT EXISTS Usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    correo VARCHAR(255) NOT NULL UNIQUE,
    telefono VARCHAR(20),
    direccion TEXT,
    password VARCHAR(255) NOT NULL,
    tipo_usuario ENUM('admin', 'usuario') NOT NULL
);

-- Crear tabla de Libros
CREATE TABLE IF NOT EXISTS Libros (
    id_libro INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    id_autor INT,
    id_categoria INT,
    id_editorial INT,
    isbn VARCHAR(20),
    año_publicacion INT,
    FOREIGN KEY (id_autor) REFERENCES Autores(id_autor),
    FOREIGN KEY (id_categoria) REFERENCES Categorias(id_categoria),
    FOREIGN KEY (id_editorial) REFERENCES Editoriales(id_editorial)
);

-- Crear tabla de Prestamos
CREATE TABLE IF NOT EXISTS Prestamos (
    id_prestamo INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    fecha_prestamo DATE,
    fecha_devolucion DATE,
    estado ENUM('Prestado', 'Devuelto') NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);
