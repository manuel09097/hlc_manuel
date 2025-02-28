-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS Biblioteca;
USE Biblioteca;

-- Tabla de Autores
CREATE TABLE IF NOT EXISTS Autores (
    id_autor INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL
);

-- Tabla de Categorías
CREATE TABLE IF NOT EXISTS Categorias (
    id_categoria INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL
);

-- Tabla de Editoriales
CREATE TABLE IF NOT EXISTS Editoriales (
    id_editorial INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL
);

-- Tabla de Libros
CREATE TABLE IF NOT EXISTS Libros (
    id_libro INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    id_autor INT,
    id_categoria INT,
    id_editorial INT,
    isbn VARCHAR(20) UNIQUE NOT NULL,
    año_publicacion INT,
    FOREIGN KEY (id_autor) REFERENCES Autores(id_autor),
    FOREIGN KEY (id_categoria) REFERENCES Categorias(id_categoria),
    FOREIGN KEY (id_editorial) REFERENCES Editoriales(id_editorial)
);

-- Tabla de Usuarios (incluye la columna password encriptada y tipo de usuario)
CREATE TABLE IF NOT EXISTS Usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    telefono VARCHAR(15),
    direccion TEXT,
    password VARCHAR(255) NOT NULL,
    tipo_usuario ENUM('admin', 'usuario') NOT NULL
);

-- Tabla de Préstamos
CREATE TABLE IF NOT EXISTS Prestamos (
    id_prestamo INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    fecha_prestamo DATE,
    fecha_devolucion DATE,
    estado VARCHAR(50),
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);
