USE Biblioteca;

-- Insertar datos en la tabla Autores
INSERT INTO Autores (nombre) VALUES
('J.R.R. Tolkien'),
('Gabriel García Márquez'),
('J.K. Rowling'),
('Isaac Asimov'),
('George Orwell'),
('Stephen King'),
('Agatha Christie'),
('Jane Austen'),
('Mark Twain'),
('Edgar Allan Poe'),
('Ray Bradbury'),
('Harper Lee'),
('Carlos Ruiz Zafón'),
('Frank Herbert'),
('Bram Stoker'),
('Arthur Conan Doyle'),
('Victor Hugo'),
('Mary Shelley'),
('H.P. Lovecraft'),
('Leo Tolstói');

-- Insertar datos en la tabla Categorias
INSERT INTO Categorias (nombre) VALUES
('Fantasía'),
('Realismo Mágico'),
('Juvenil'),
('Ciencia Ficción'),
('Terror'),
('Misterio'),
('Romance'),
('Clásicos'),
('Aventura'),
('Historia');

-- Insertar datos en la tabla Editoriales
INSERT INTO Editoriales (nombre) VALUES
('Minotauro'),
('Sudamericana'),
('Salamandra'),
('Planeta'),
('Penguin Random House');

-- Insertar datos en la tabla Usuarios
-- Contraseña: admin123 (encriptada)
-- Contraseña: usuario123 (encriptada)
INSERT INTO Usuarios (nombre, correo, telefono, direccion, password, tipo_usuario) 
VALUES 
('Administrador', 'admin@biblioteca.com', '555-0000', 'Biblioteca Central', '$2y$10$FnE0ytvLf5JvY1pX1uPOyGH78Qf0btYkywXBhsdf8grI3Txgm2C6e', 'admin'), 
('Usuario Normal', 'usuario@biblioteca.com', '555-1111', 'Calle Secundaria 456', '$2y$10$FnE0ytvLf5JvY1pX1uPOyGH78Qf0btYkywXBhsdf8grI3Txgm2C6e', 'usuario');

-- Insertar datos en la tabla Libros
INSERT INTO Libros (titulo, id_autor, id_categoria, id_editorial, isbn, año_publicacion) VALUES
('El señor de los anillos', 1, 1, 1, '978-84-450-7750-3', 1954),
('Cien años de soledad', 2, 2, 2, '978-84-376-0494-7', 1967),
('Harry Potter y la piedra filosofal', 3, 3, 3, '978-84-7888-495-3', 1997),
('1984', 5, 4, 4, '978-84-233-3131-2', 1949),
('El resplandor', 6, 5, 5, '978-84-9872-173-2', 1977),
('Fahrenheit 451', 11, 4, 4, '978-84-376-0495-6', 1953),
('Matar a un ruiseñor', 12, 8, 3, '978-84-376-0495-2', 1960),
('La sombra del viento', 13, 9, 1, '978-84-226-7803-5', 2001),
('Dune', 14, 4, 4, '978-84-376-0495-8', 1965),
('Drácula', 15, 5, 5, '978-84-206-1946-8', 1897),
('Sherlock Holmes: Estudio en escarlata', 16, 6, 4, '978-84-376-0495-4', 1887),
('Los miserables', 17, 8, 3, '978-84-376-0495-5', 1862),
('Frankenstein', 18, 5, 5, '978-84-376-0495-7', 1818),
('El llamado de Cthulhu', 19, 5, 5, '978-84-376-0495-10', 1928),
('Guerra y paz', 20, 8, 3, '978-84-376-0496-1', 1869);

-- Insertar datos en la tabla Prestamos
INSERT INTO Prestamos (id_usuario, fecha_prestamo, fecha_devolucion, estado) 
VALUES
(1, '2025-02-01', '2025-02-15', 'Prestado'),
(2, '2025-01-15', '2025-01-30', 'Devuelto');
