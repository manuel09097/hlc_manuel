<?php
session_start();
include('conexion.php');

// Verificar que el usuario esté autenticado como admin
if (!isset($_SESSION['usuario']) || $_SESSION['tipo_usuario'] != 'admin') {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['usuario'];

// Obtener todos los libros
$sql_libros = "SELECT * FROM Libros";
$resultado_libros = $conexion->query($sql_libros);
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteca - Admin</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Fondo con imagen que cubre toda la pantalla */
        body {
            background-image: url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8Ym9vayUyMGJhY2tncm91bmR8ZW58MHx8MHx8fDA%3D'); /* Imagen de fondo */
            background-size: cover; /* Asegura que la imagen cubra todo el fondo */
            background-position: center; /* Centra la imagen */
            background-attachment: fixed; /* Hace que el fondo no se mueva al hacer scroll */
            font-family: 'Lato', sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
            height: 100%; /* Hace que el body ocupe toda la altura de la ventana */
        }

        .container {
            margin-top: 50px;
            background-color: rgba(0, 0, 0, 0.7); /* Fondo oscuro semitransparente */
            padding: 40px; /* Aumentado el padding para estirar más el contenedor */
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5); /* Sombra para resaltar el contenedor */
            width: 90%; /* Aumentado el ancho para que ocupe más espacio */
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

        /* Estilo de la tabla */
        table {
            width: 100%; /* Asegura que la tabla ocupe todo el ancho disponible */
            margin: 0 auto; /* Centrado */
            background-color: rgba(0, 0, 0, 0.6); /* Fondo oscuro para la tabla */
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: left;
            color: #fff;
        }

        th {
            background-color: #f39c12;
        }

        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1);
        }

        tr:nth-child(odd) {
            background-color: rgba(255, 255, 255, 0.15);
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

        .navbar .btn {
            margin-left: 10px;
        }

        .ml-auto {
            margin-left: 0 !important;
        }
    </style>
</head>
<body>

    <!-- Barra de navegación con el nombre del usuario -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Biblioteca</a>
            <span class="navbar-text">
                Bienvenido, <?php echo $usuario; ?>
            </span>
            <div class="ml-auto">
                <!-- Botones con redirecciones intactas -->
                <a href="admin.php" class="btn btn-primary">Gestionar Libros</a>
                <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="title">Gestión de Libros</div>

        <!-- Botón para añadir un nuevo libro -->
        <a href="introducirLibro.php" class="btn btn-success mb-4">Añadir Nuevo Libro</a>

        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>ISBN</th>
                    <th>Año</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($libro = $resultado_libros->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $libro['titulo']; ?></td>
                        <td>
                            <?php 
                            // Obtener el nombre del autor
                            $stmt = $conexion->prepare("SELECT nombre_autor FROM Autores WHERE id_autor = ?");
                            $stmt->bind_param("i", $libro['id_autor']);
                            $stmt->execute();
                            $stmt->bind_result($nombre_autor);
                            $stmt->fetch();
                            $stmt->close();
                            echo $nombre_autor;
                            ?>
                        </td>
                        <td><?php echo $libro['isbn']; ?></td>
                        <td><?php echo $libro['año_publicacion']; ?></td>
                        <td>
                            <!-- Botones para editar y eliminar -->
                            <a href="editarLibro.php?id_libro=<?php echo $libro['id_libro']; ?>" class="btn btn-warning">Editar</a>
                            <a href="eliminarLibro.php?id_libro=<?php echo $libro['id_libro']; ?>" class="btn btn-danger">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>
