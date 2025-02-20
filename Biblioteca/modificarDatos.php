<?php
// Incluir el archivo de conexión
include('conexion.php');

// Verificar si se ha recibido un ID para editar
if (isset($_GET['id'])) {
    $id_libro = $_GET['id'];
    $query = "SELECT * FROM Libros WHERE id_libro = $id_libro";
    $resultado = mysqli_query($conexion, $query);
    $libro = mysqli_fetch_assoc($resultado);
}

// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_libro = $_POST['id_libro'];
    $titulo = $_POST['titulo'];
    $id_autor = $_POST['id_autor'];
    $id_categoria = $_POST['id_categoria'];
    $id_editorial = $_POST['id_editorial'];
    $isbn = $_POST['isbn'];
    $ano_publicacion = $_POST['ano_publicacion'];

    // Actualizar datos en la base de datos
    $query = "UPDATE Libros SET titulo='$titulo', id_autor='$id_autor', id_categoria='$id_categoria', id_editorial='$id_editorial', isbn='$isbn', año_publicacion='$ano_publicacion' WHERE id_libro=$id_libro";
    
    if (mysqli_query($conexion, $query)) {
        echo "<div class='alert alert-success'>Libro actualizado correctamente.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error al actualizar el libro: " . mysqli_error($conexion) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modificar Libro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2 class="mb-4">Modificar Libro</h2>
    <form method="POST" action="" class="card p-4 shadow-sm">
        <input type="hidden" name="id_libro" value="<?php echo $libro['id_libro']; ?>">
        <div class="mb-3">
            <label class="form-label">Título:</label>
            <input type="text" name="titulo" class="form-control" value="<?php echo $libro['titulo']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">ID Autor:</label>
            <input type="number" name="id_autor" class="form-control" value="<?php echo $libro['id_autor']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">ID Categoría:</label>
            <input type="number" name="id_categoria" class="form-control" value="<?php echo $libro['id_categoria']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">ID Editorial:</label>
            <input type="number" name="id_editorial" class="form-control" value="<?php echo $libro['id_editorial']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">ISBN:</label>
            <input type="text" name="isbn" class="form-control" value="<?php echo $libro['isbn']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Año de Publicación:</label>
            <input type="date" name="ano_publicacion" class="form-control" value="<?php echo $libro['año_publicacion']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</body>
</html>
