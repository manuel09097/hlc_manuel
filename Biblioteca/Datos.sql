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

-- Insertar datos en la tabla Categorías
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

-- Insertar datos en la tabla Libros
INSERT INTO Libros (titulo, id_autor, id_categoria, id_editorial, isbn, año_publicacion) VALUES
('El señor de los anillos', 1, 1, 1, '978-84-450-7750-3', 1954),
('Cien años de soledad', 2, 2, 2, '978-84-376-0494-7', 1967),
('Harry Potter y la piedra filosofal', 3, 3, 3, '978-84-7888-495-3', 1997),
('1984', 5, 4, 4, '978-84-233-3131-1', 1949),
('El resplandor', 6, 5, 5, '978-84-9872-173-1', 1977),
('Fahrenheit 451', 11, 4, 4, '978-84-376-0495-5', 1953),
('Matar a un ruiseñor', 12, 8, 3, '978-84-376-0495-1', 1960),
('La sombra del viento', 13, 9, 1, '978-84-226-7803-4', 2001),
('Dune', 14, 4, 4, '978-84-376-0495-7', 1965),
('Drácula', 15, 5, 5, '978-84-206-1946-7', 1897),
('Sherlock Holmes: Estudio en escarlata', 16, 6, 4, '978-84-376-0495-3', 1887),
('Los miserables', 17, 8, 3, '978-84-376-0495-4', 1862),
('Frankenstein', 18, 5, 5, '978-84-376-0495-6', 1818),
('El llamado de Cthulhu', 19, 5, 5, '978-84-376-0495-9', 1928),
('Guerra y paz', 20, 8, 3, '978-84-376-0496-0', 1869),
('Don Quijote de la Mancha', 20, 8, 3, '978-84-376-0496-1', 1605),
('Crimen y castigo', 20, 8, 3, '978-84-376-0496-2', 1866),
('La divina comedia', 20, 8, 3, '978-84-376-0496-3', 1320),
('El retrato de Dorian Gray', 20, 8, 3, '978-84-376-0496-4', 1890),
('El principito', 20, 8, 3, '978-84-376-0496-5', 1943),
('Orgullo y prejuicio', 20, 7, 3, '978-84-376-0496-6', 1813),
('Anna Karenina', 20, 7, 3, '978-84-376-0496-7', 1877),
('Moby Dick', 20, 8, 3, '978-84-376-0496-8', 1851),
('Ulises', 20, 8, 3, '978-84-376-0496-9', 1922),
('Rebelión en la granja', 5, 4, 4, '978-84-376-0495-9', 1945);

-- Insertar datos en la tabla Usuarios
INSERT INTO Usuarios (nombre, correo, telefono, direccion) VALUES
('Juan Pérez', 'juanperez@gmail.com', '555-1234', 'Calle Falsa 123'),
('María López', 'marialopez@yahoo.com', '555-5678', 'Av. Siempre Viva 742'),
('Carlos Sánchez', 'carloss@hotmail.com', '555-4321', 'Calle de los Sueños 456');

-- Insertar datos en la tabla Préstamos
INSERT INTO Prestamos (id_usuario, id_ejemplar, id_empleado, fecha_prestamo, fecha_devolucion, estado) VALUES
(1, 1, 1, '2025-02-01', '2025-02-15', 'Prestado'),
(2, 2, 2, '2025-01-15', '2025-01-30', 'Devuelto'),
(3, 3, 1, '2025-02-05', '2025-02-20', 'Prestado');
