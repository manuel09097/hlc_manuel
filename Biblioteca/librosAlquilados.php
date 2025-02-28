<?php
session_start();
include('conexion.php'); // Conexión a la base de datos

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['usuario'];
$id_usuario = $_SESSION['tipo_usuario'] == 'admin' ? null : $_SESSION['id_usuario'];

// Procesar la devolución del libro cuando se envía el formulario
if (isset($_POST['devolver'])) {
    $id_prestamo = $_POST['id_prestamo'];

    // Actualizar el estado del préstamo a 'Devuelto'
    $sql_devolucion = "UPDATE Prestamos SET estado = 'Devuelto', fecha_devolucion = NOW() WHERE id_prestamo = ? AND id_usuario = ?";
    $stmt = $conexion->prepare($sql_devolucion);
    $stmt->bind_param("ii", $id_prestamo, $_SESSION['id_usuario']);
    $stmt->execute();

    // Verificar si la actualización fue exitosa
    if ($stmt->affected_rows > 0) {
        echo "<div class='alert alert-success'>Libro devuelto correctamente.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error al devolver el libro o el libro no está registrado como alquilado.</div>";
    }
    $stmt->close();
}

// Obtener los libros alquilados
$sql_libros_alquilados = "SELECT Libros.titulo, Libros.id_libro, Prestamos.id_prestamo, Prestamos.fecha_prestamo, Prestamos.fecha_devolucion 
                          FROM Prestamos 
                          JOIN Libros ON Prestamos.id_libro = Libros.id_libro
                          WHERE Prestamos.id_usuario = ? AND Prestamos.estado = 'Prestado'";

$stmt = $conexion->prepare($sql_libros_alquilados);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado_libros_alquilados = $stmt->get_result();
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Libros Alquilados</title>
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

        /* Barra superior con el nombre del usuario */
        .navbar {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 10px 30px;
        }

        .navbar .navbar-brand {
            color: #fff;
            font-size: 1.2rem;
        }

        .navbar .navbar-text {
            color: #fff;
            font-size: 1rem;
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

        .btn-danger {
            background-color: #e74c3c;
            border-color: #e74c3c;
        }

        .btn-danger:hover {
            background-color: #c0392b;
            border-color: #c0392b;
        }

        .btn-back {
            background-color: #3498db;
            border-color: #3498db;
        }

        .btn-back:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }
    </style>
</head>
<body>

    <!-- Barra superior con el nombre del usuario -->
    <nav class="navbar">
        <span class="navbar-brand">Biblioteca</span>
        <span class="navbar-text">Bienvenido, <?php echo $usuario; ?></span>
    </nav>

    <div class="container">
        <div class="title">Libros Alquilados</div>

        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Fecha de Alquiler</th>
                    <th>Fecha de Devolución</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($libro = $resultado_libros_alquilados->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $libro['titulo']; ?></td>
                        <td><?php echo $libro['fecha_prestamo']; ?></td>
                        <td><?php echo $libro['fecha_devolucion']; ?></td>
                        <td>
                            <!-- Formulario para devolver el libro -->
                            <form method="post" action="">
                                <input type="hidden" name="id_prestamo" value="<?php echo $libro['id_prestamo']; ?>">
                                <button type="submit" name="devolver" class="btn btn-primary">Devolver</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Botón para volver a los libros disponibles -->
        <div class="text-center mt-4">
            <a href="usuario.php" class="btn btn-back">Volver a los Libros Disponibles</a>
        </div>
    </div>

</body>
</html>
