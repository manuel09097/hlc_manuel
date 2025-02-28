-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS Biblioteca;
USE Biblioteca;

-- Tabla de Autores
CREATE TABLE Autores (
    id_autor INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL
);

-- Tabla de Categorías
CREATE TABLE Categorias (
    id_categoria INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL
);

-- Tabla de Editoriales
CREATE TABLE Editoriales (
    id_editorial INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL
);

-- Tabla de Libros
CREATE TABLE Libros (
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

-- Tabla de Ejemplares
CREATE TABLE Ejemplares (
    id_ejemplar INT PRIMARY KEY AUTO_INCREMENT,
    id_libro INT,
    estado VARCHAR(50) NOT NULL DEFAULT 'Disponible',
    FOREIGN KEY (id_libro) REFERENCES Libros(id_libro)
);

-- Tabla de Usuarios
CREATE TABLE Usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    telefono VARCHAR(15),
    direccion TEXT
);

-- Tabla de Empleados
CREATE TABLE Empleados (
    id_empleado INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    telefono VARCHAR(15)
);

-- Tabla de Préstamos
CREATE TABLE Prestamos (
    id_prestamo INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    id_ejemplar INT,
    id_empleado INT,
    fecha_prestamo DATE NOT NULL,
    fecha_devolucion DATE,
    estado VARCHAR(50) NOT NULL DEFAULT 'En préstamo',
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario),
    FOREIGN KEY (id_ejemplar) REFERENCES Ejemplares(id_ejemplar),
    FOREIGN KEY (id_empleado) REFERENCES Empleados(id_empleado)
);
