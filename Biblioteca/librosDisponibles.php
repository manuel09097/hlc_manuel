<?php
session_start();
include('conexion.php');

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); // Si no está logueado, redirigir al login
    exit();
}

// Consultar los libros disponibles
$query = "
    SELECT L.id_libro, L.titulo, A.nombre AS autor, C.nombre AS categoria, E.nombre AS editorial
    FROM libros L
    JOIN autores A ON L.id_autor = A.id_autor
    JOIN categorias C ON L.id_categoria = C.id_categoria
    JOIN editoriales E ON L.id_editorial = E.id_editorial
    LEFT JOIN ejemplares X ON L.id_libro = X.id_libro
    LEFT JOIN prestamos P ON X.id_ejemplar = P.id_ejemplar AND P.estado = 'Prestado'
    WHERE P.id_prestamo IS NULL
";

$result = mysqli_query($conexion, $query);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros Disponibles</title>
    <!-- Vincular Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-primary text-white text-center py-3">
        <h1>Libros Disponibles</h1>
        <nav>
            <ul class="nav justify-content-center">
                <li class="nav-item"><a class="nav-link text-white" href="usuario.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="alquilarLibro.php">Alquilar Libro</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>
    
    <main class="container mt-5">
        <section>
            <h2 class="mb-4">Libros que puedes alquilar</h2>
            
            <?php if (mysqli_num_rows($result) > 0): ?>
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Categoría</th>
                            <th>Editorial</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                                <td><?php echo htmlspecialchars($row['autor']); ?></td>
                                <td><?php echo htmlspecialchars($row['categoria']); ?></td>
                                <td><?php echo htmlspecialchars($row['editorial']); ?></td>
                                <td><a href="alquilarLibro.php?id_libro=<?php echo $row['id_libro']; ?>" class="btn btn-primary">Alquilar</a></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-warning" role="alert">
                    No hay libros disponibles para alquilar en este momento.
                </div>
            <?php endif; ?>
        </section>
    </main>
    
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2025 Biblioteca</p>
    </footer>

    <!-- Vincular JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
mysqli_free_result($result);
mysqli_close($conexion);
?>
