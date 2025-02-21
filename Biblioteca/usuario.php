<?php
session_start();
include('conexion.php'); // Incluir la conexión a la base de datos

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); // Si no está logueado, redirigir al login
    exit();
}

// Obtener todos los libros que NO estén prestados (sin préstamos activos)
$query = "
    SELECT L.id_libro, L.titulo, A.nombre AS autor, C.nombre AS categoria, E.nombre AS editorial, P.id_prestamo
    FROM libros L
    JOIN autores A ON L.id_autor = A.id_autor
    JOIN categorias C ON L.id_categoria = C.id_categoria
    LEFT JOIN editoriales E ON L.id_editorial = E.id_editorial
    LEFT JOIN ejemplares X ON L.id_libro = X.id_libro
    LEFT JOIN prestamos P ON X.id_ejemplar = P.id_ejemplar AND P.estado = 'Prestado' 
    WHERE P.id_prestamo IS NULL"; // Asegura que los libros no tengan préstamos activos

$resultado = mysqli_query($conexion, $query);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros disponibles</title>
    <!-- Cargar Bootstrap desde CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 900px;
        }
        h3 {
            color: #007bff;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .table thead {
            background-color: #007bff;
            color: white;
        }
        .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-primary:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }
        .btn-info:hover {
            background-color: #138496;
            border-color: #117a8b;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h3 class="text-center">Libros disponibles para alquilar</h3>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>Categoría</th>
                <th>Editorial</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
                <td><?php echo $row['titulo']; ?></td>
                <td><?php echo $row['autor']; ?></td>
                <td><?php echo $row['categoria']; ?></td>
                <td><?php echo $row['editorial']; ?></td>
                <td>
                    <?php if ($row['id_prestamo'] === NULL) { ?>
                        <a href="alquilarLibro.php?id_libro=<?php echo $row['id_libro']; ?>" class="btn btn-primary">Alquilar</a>
                    <?php } else { ?>
                        <a href="devolverLibro.php?id_prestamo=<?php echo $row['id_prestamo']; ?>" class="btn btn-danger">Devolver</a>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="logout.php" class="btn btn-info">Cerrar sesión</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
