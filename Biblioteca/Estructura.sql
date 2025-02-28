CREATE DATABASE biblioteca; 
USE Biblioteca;

-- Crear la tabla 'Autores' (para los autores de los libros)
CREATE TABLE IF NOT EXISTS `Autores` (
    `id_autor` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre_autor` VARCHAR(255) NOT NULL
);

-- Crear la tabla 'Categorias' (para las categorías de los libros)
CREATE TABLE IF NOT EXISTS `Categorias` (
    `id_categoria` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(255) NOT NULL
);

-- Crear la tabla 'Editoriales' (para las editoriales de los libros)
CREATE TABLE IF NOT EXISTS `Editoriales` (
    `id_editorial` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(255) NOT NULL
);

-- Crear la tabla 'Usuarios' (para los usuarios del sistema)
CREATE TABLE IF NOT EXISTS `Usuarios` (
    `id_usuario` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(255) NOT NULL,
    `correo` VARCHAR(255) NOT NULL,
    `telefono` VARCHAR(20) NOT NULL,
    `direccion` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `tipo_usuario` ENUM('admin', 'usuario') NOT NULL
);

-- Crear la tabla 'Libros' (para los libros disponibles)
CREATE TABLE IF NOT EXISTS `Libros` (
    `id_libro` INT AUTO_INCREMENT PRIMARY KEY,
    `titulo` VARCHAR(255) NOT NULL,
    `id_autor` INT NOT NULL,
    `id_categoria` INT NOT NULL,
    `id_editorial` INT NOT NULL,
    `isbn` VARCHAR(20) NOT NULL,
    `año_publicacion` INT NOT NULL,
    FOREIGN KEY (`id_autor`) REFERENCES `Autores`(`id_autor`),
    FOREIGN KEY (`id_categoria`) REFERENCES `Categorias`(`id_categoria`),
    FOREIGN KEY (`id_editorial`) REFERENCES `Editoriales`(`id_editorial`)
);

-- Crear la tabla 'Prestamos' (para registrar los préstamos de libros)
CREATE TABLE IF NOT EXISTS `Prestamos` (
    `id_prestamo` INT AUTO_INCREMENT PRIMARY KEY,
    `id_usuario` INT NOT NULL,
    `id_libro` INT NOT NULL,
    `fecha_prestamo` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `fecha_devolucion` DATETIME,
    `estado` ENUM('Prestado', 'Devuelto') DEFAULT 'Prestado',
    FOREIGN KEY (`id_usuario`) REFERENCES `Usuarios`(`id_usuario`),
    FOREIGN KEY (`id_libro`) REFERENCES `Libros`(`id_libro`)
);
