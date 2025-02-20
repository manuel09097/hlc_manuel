<?php
// Incluir el archivo de conexión
include('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $id_autor = $_POST['id_autor'];
    $id_categoria = $_POST['id_categoria'];
    $id_editorial = $_POST['id_editorial'];
    $isbn = $_POST['isbn'];
    $ano_publicacion = $_POST['ano_publicacion'];

    // Preparar la consulta SQL para insertar datos
    $query = "INSERT INTO Libros (titulo, id_autor, id_categoria, id_editorial, isbn, año_publicacion) 
              VALUES ('$titulo', '$id_autor', '$id_categoria', '$id_editorial', '$isbn', '$ano_publicacion')";
    
    if (mysqli_query($conexion, $query)) {
        echo "<div class='alert alert-success'>Libro agregado correctamente.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error al agregar el libro: " . mysqli_error($conexion) . "</div>";
    }
    
    mysqli_close($conexion);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Insertar Libro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2 class="mb-4">Insertar Nuevo Libro</h2>
    <form method="POST" action="" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label class="form-label">Título:</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">ID Autor:</label>
            <input type="number" name="id_autor" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">ID Categoría:</label>
            <input type="number" name="id_categoria" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">ID Editorial:</label>
            <input type="number" name="id_editorial" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">ISBN:</label>
            <input type="text" name="isbn" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Año de Publicación:</label>
            <input type="date" name="ano_publicacion" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</body>
</html>
