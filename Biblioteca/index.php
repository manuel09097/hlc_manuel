<?php
// Incluir el archivo de conexión
include('conexion.php');

// Obtener todos los libros de la base de datos
$query = "SELECT Libros.id_libro, Libros.titulo, Autores.nombre AS autor, Categorias.nombre AS categoria, Editoriales.nombre AS editorial
          FROM Libros
          JOIN Autores ON Libros.id_autor = Autores.id_autor
          JOIN Categorias ON Libros.id_categoria = Categorias.id_categoria
          JOIN Editoriales ON Libros.id_editorial = Editoriales.id_editorial";
$resultado = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Listado de Libros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2 class="mb-4">Listado de Libros</h2>
    <a href="introducirDatos.php" class="btn btn-success mb-3">Agregar Nuevo Libro</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Categoría</th>
                <th>Editorial</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($libro = mysqli_fetch_assoc($resultado)) { ?>
                <tr>
                    <td><?php echo $libro['id_libro']; ?></td>
                    <td><?php echo $libro['titulo']; ?></td>
                    <td><?php echo $libro['autor']; ?></td>
                    <td><?php echo $libro['categoria']; ?></td>
                    <td><?php echo $libro['editorial']; ?></td>
                    <td>
                        <a href="modificarDatos.php?id=<?php echo $libro['id_libro']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="eliminarDatos.php?id=<?php echo $libro['id_libro']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este libro?');">Eliminar</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
