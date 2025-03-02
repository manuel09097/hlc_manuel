<?php
session_start();
include('conexion.php');

// Verificar si el usuario es admin
if (!isset($_SESSION['usuario']) || $_SESSION['tipo_usuario'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Obtener ID del libro
if (!isset($_GET['id_libro']) || empty($_GET['id_libro'])) {
    header("Location: admin.php");
    exit();
}

$id_libro = $_GET['id_libro'];

// Obtener datos del libro
$stmt = $conexion->prepare("SELECT * FROM Libros WHERE id_libro = ?");
$stmt->bind_param("i", $id_libro);
$stmt->execute();
$resultado = $stmt->get_result();
$libro = $resultado->fetch_assoc();
$stmt->close();

if (!$libro) {
    header("Location: admin.php");
    exit();
}

$mensaje = "";
$tipo_mensaje = "";

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $categoria = $_POST['categoria'];
    $editorial = $_POST['editorial'];
    $isbn = $_POST['isbn'];
    $año_publicacion = $_POST['año_publicacion'];

    // Verificar o insertar autor
    $stmt = $conexion->prepare("SELECT id_autor FROM Autores WHERE nombre_autor = ?");
    $stmt->bind_param("s", $autor);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_autor);
        $stmt->fetch();
    } else {
        $stmt->close();
        $stmt = $conexion->prepare("INSERT INTO Autores (nombre_autor) VALUES (?)");
        $stmt->bind_param("s", $autor);
        $stmt->execute();
        $id_autor = $stmt->insert_id;
    }
    $stmt->close();

    // Verificar o insertar editorial
    $stmt = $conexion->prepare("SELECT id_editorial FROM Editoriales WHERE nombre = ?");
    $stmt->bind_param("s", $editorial);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_editorial);
        $stmt->fetch();
    } else {
        $stmt->close();
        $stmt = $conexion->prepare("INSERT INTO Editoriales (nombre) VALUES (?)");
        $stmt->bind_param("s", $editorial);
        $stmt->execute();
        $id_editorial = $stmt->insert_id;
    }
    $stmt->close();

    // Actualizar datos del libro
    $stmt = $conexion->prepare("UPDATE Libros SET titulo = ?, id_autor = ?, id_categoria = ?, id_editorial = ?, isbn = ?, año_publicacion = ? WHERE id_libro = ?");
    $stmt->bind_param("siiiisi", $titulo, $id_autor, $categoria, $id_editorial, $isbn, $año_publicacion, $id_libro);

    if ($stmt->execute()) {
        $mensaje = "Libro actualizado correctamente.";
        $tipo_mensaje = "success";
    } else {
        $mensaje = "Error al actualizar el libro.";
        $tipo_mensaje = "danger";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modificar Libro</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?fm=jpg&q=60&w=3000');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Lato', sans-serif;
            color: #fff;
        }

        .container {
            margin-top: 50px;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 10px;
            width: 50%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }

        .alert {
            text-align: center;
            font-weight: bold;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-danger {
            background-color: #e74c3c;
            border-color: #e74c3c;
        }

        .btn-danger:hover {
            background-color: #c0392b;
            border-color: #c0392b;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2 class="text-center mb-4">Modificar Libro</h2>

        <!-- Mensaje de alerta -->
        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-<?php echo $tipo_mensaje; ?>" role="alert">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" name="titulo" id="titulo" class="form-control" value="<?php echo $libro['titulo']; ?>" required>
            </div>

            <div class="form-group">
                <label for="autor">Autor:</label>
                <input type="text" name="autor" id="autor" class="form-control" value="<?php 
                    $stmt = $conexion->prepare("SELECT nombre_autor FROM Autores WHERE id_autor = ?");
                    $stmt->bind_param("i", $libro['id_autor']);
                    $stmt->execute();
                    $stmt->bind_result($nombre_autor);
                    $stmt->fetch();
                    echo $nombre_autor;
                    $stmt->close();
                ?>" required>
            </div>

            <div class="form-group">
                <label for="categoria">Categoría (ID):</label>
                <input type="number" name="categoria" id="categoria" class="form-control" value="<?php echo $libro['id_categoria']; ?>" required>
            </div>

            <div class="form-group">
                <label for="editorial">Editorial:</label>
                <input type="text" name="editorial" id="editorial" class="form-control" value="<?php 
                    $stmt = $conexion->prepare("SELECT nombre FROM Editoriales WHERE id_editorial = ?");
                    $stmt->bind_param("i", $libro['id_editorial']);
                    $stmt->execute();
                    $stmt->bind_result($nombre_editorial);
                    $stmt->fetch();
                    echo $nombre_editorial;
                    $stmt->close();
                ?>" required>
            </div>

            <div class="form-group">
                <label for="isbn">ISBN:</label>
                <input type="text" name="isbn" id="isbn" class="form-control" value="<?php echo $libro['isbn']; ?>" required>
            </div>

            <div class="form-group">
                <label for="año_publicacion">Año de Publicación:</label>
                <input type="number" name="año_publicacion" id="año_publicacion" class="form-control" value="<?php echo $libro['año_publicacion']; ?>" required>
            </div>

            <button type="submit" class="btn btn-success btn-block">Guardar Cambios</button>
            <a href="admin.php" class="btn btn-secondary btn-block">Volver a Admin</a>
        </form>
    </div>

</body>
</html>
