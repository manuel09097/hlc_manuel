<?php
// Incluir el archivo de conexión
include('conexion.php');

// Verificar si se ha recibido un ID para eliminar
if (isset($_GET['id'])) {
    $id_libro = $_GET['id'];
    
    // Preparar la consulta SQL para eliminar
    $query = "DELETE FROM Libros WHERE id_libro = $id_libro";
    
    if (mysqli_query($conexion, $query)) {
        echo "<div class='alert alert-success'>Libro eliminado correctamente.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error al eliminar el libro: " . mysqli_error($conexion) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Eliminar Libro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2 class="mb-4">Eliminar Libro</h2>
    <form method="GET" action="" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label class="form-label">ID del Libro a Eliminar:</label>
            <input type="number" name="id" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-danger">Eliminar</button>
    </form>
</body>
</html>
