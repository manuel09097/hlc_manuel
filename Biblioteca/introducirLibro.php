<?php
session_start();
include('conexion.php');

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$mensaje = ""; // Variable para el mensaje de éxito

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor']; // Autor ingresado manualmente
    $categoria = $_POST['categoria'];
    $editorial = $_POST['editorial']; // Editorial ingresada manualmente
    $isbn = $_POST['isbn'];
    $año_publicacion = $_POST['año_publicacion'];

    // Insertar el autor en la tabla de autores (si no existe)
    $query_autor = "INSERT INTO Autores (nombre_autor) SELECT '$autor' WHERE NOT EXISTS (SELECT 1 FROM Autores WHERE nombre_autor = '$autor')";
    mysqli_query($conexion, $query_autor);

    // Obtener el id del autor
    $query_get_autor = "SELECT id_autor FROM Autores WHERE nombre_autor = '$autor'";
    $resultado_autor = mysqli_query($conexion, $query_get_autor);
    $row_autor = mysqli_fetch_assoc($resultado_autor);
    $id_autor = $row_autor['id_autor'];

    // Insertar la editorial en la tabla de editoriales (si no existe)
    $query_editorial = "INSERT INTO Editoriales (nombre) SELECT '$editorial' WHERE NOT EXISTS (SELECT 1 FROM Editoriales WHERE nombre = '$editorial')";
    mysqli_query($conexion, $query_editorial);

    // Obtener el id de la editorial
    $query_get_editorial = "SELECT id_editorial FROM Editoriales WHERE nombre = '$editorial'";
    $resultado_editorial = mysqli_query($conexion, $query_get_editorial);
    $row_editorial = mysqli_fetch_assoc($resultado_editorial);
    $id_editorial = $row_editorial['id_editorial'];

    // Insertar el libro en la base de datos
    $query_libro = "INSERT INTO Libros (titulo, id_autor, id_categoria, id_editorial, isbn, año_publicacion) 
                    VALUES ('$titulo', $id_autor, $categoria, $id_editorial, '$isbn', $año_publicacion)";
    mysqli_query($conexion, $query_libro);

    // Establecer mensaje de éxito
    $mensaje = "¡El libro se ha añadido correctamente!";
}

// Obtener las categorías para el desplegable
$sql_categorias = "SELECT * FROM Categorias";
$resultado_categorias = mysqli_query($conexion, $sql_categorias);
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Insertar Libro</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-image: url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8Ym9vayUyMGJhY2tncm91bmR8ZW58MHx8MHx8fDA%3D');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Lato', sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
            height: 100%;
        }

        .container {
            margin-top: 50px;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            width: 90%;
            margin-left: auto;
            margin-right: auto;
        }

        .title {
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 20px;
            text-align: center;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
        }

        .alert {
            margin-bottom: 20px;
        }

        .btn {
            padding: 12px 20px;
            font-size: 1rem;
            text-transform: uppercase;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: #f39c12;
            border-color: #f39c12;
        }

        .btn-primary:hover {
            background-color: #e67e22;
            border-color: #e67e22;
        }

        .navbar {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 10px 20px;
        }

        .navbar .navbar-brand {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .navbar .navbar-text {
            color: white;
            font-size: 1rem;
        }
    </style>
</head>
<body>

    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Biblioteca</a>
            <span class="navbar-text">Insertar Nuevo Libro</span>
            <a href="admin.php" class="btn btn-primary">Volver a la Administración</a>
        </div>
    </nav>

    <div class="container">
        <div class="title">Formulario para Insertar Libro</div>

        <!-- Mostrar mensaje de éxito -->
        <?php if (!empty($mensaje)) { ?>
            <div class="alert alert-success text-center" role="alert">
                <?php echo $mensaje; ?>
            </div>
        <?php } ?>

        <form method="POST">
            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="form-group">
                <label for="autor">Autor (agregar manualmente)</label>
                <input type="text" class="form-control" id="autor" name="autor" required>
            </div>
            <div class="form-group">
                <label for="categoria">Categoría</label>
                <select class="form-control" id="categoria" name="categoria" required>
                    <?php while ($categoria = mysqli_fetch_assoc($resultado_categorias)) { ?>
                        <option value="<?php echo $categoria['id_categoria']; ?>"><?php echo $categoria['nombre']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="editorial">Editorial (agregar manualmente)</label>
                <input type="text" class="form-control" id="editorial" name="editorial" required>
            </div>
            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn" required>
            </div>
            <div class="form-group">
                <label for="año_publicacion">Año de Publicación</label>
                <input type="number" class="form-control" id="año_publicacion" name="año_publicacion" required>
            </div>

            <button type="submit" class="btn btn-primary">Añadir Libro</button>
        </form>
    </div>

</body>
</html>
