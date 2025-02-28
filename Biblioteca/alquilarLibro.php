<?php
session_start();
include('conexion.php');

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['usuario'];
$id_usuario = $_SESSION['tipo_usuario'] == 'admin' ? null : $_SESSION['id_usuario'];

// Obtener el libro seleccionado
if (isset($_GET['id_libro'])) {
    $id_libro = $_GET['id_libro'];

    // Obtener los detalles del libro
    $sql_libro = "SELECT * FROM Libros WHERE id_libro = ?";
    $stmt = $conexion->prepare($sql_libro);
    $stmt->bind_param("i", $id_libro);
    $stmt->execute();
    $resultado_libro = $stmt->get_result()->fetch_assoc();

    if (!$resultado_libro) {
        // Si el libro no existe, redirigir
        header("Location: usuario.php");
        exit();
    }
} else {
    // Si no se pasa un id_libro, redirigir
    header("Location: usuario.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Alquilar el libro
    $sql_prestamo = "INSERT INTO Prestamos (id_usuario, id_libro, estado) VALUES (?, ?, 'Prestado')";
    $stmt = $conexion->prepare($sql_prestamo);
    $stmt->bind_param("ii", $id_usuario, $id_libro);
    if ($stmt->execute()) {
        $modal_message = "Libro alquilado correctamente";
        $modal_type = "success";
        $redirect_url = "librosAlquilados.php"; // Página de libros alquilados
    } else {
        $modal_message = "Hubo un error al alquilar el libro";
        $modal_type = "danger";
        $redirect_url = "usuario.php"; // Volver a la página de libros disponibles
    }
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alquilar Libro</title>
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
            width: 80%;
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

        .book-details {
            margin-bottom: 20px;
        }

        .book-details p {
            font-size: 1.2rem;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="title">Alquilar Libro</div>

        <div class="book-details">
            <h3><?php echo $resultado_libro['titulo']; ?></h3>
            <p><strong>Autor:</strong> <?php echo $resultado_libro['id_autor']; ?></p>
            <p><strong>ISBN:</strong> <?php echo $resultado_libro['isbn']; ?></p>
            <p><strong>Año:</strong> <?php echo $resultado_libro['año_publicacion']; ?></p>
        </div>

        <p><strong>Bienvenido, <?php echo $usuario; ?>!</strong></p> <!-- Nombre del usuario -->

        <form method="POST">
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Alquilar</button>
            </div>
        </form>

        <br>

        <div class="text-center">
            <a href="usuario.php" class="btn btn-danger">Volver a la lista de libros</a>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="alquilerModal" tabindex="-1" role="dialog" aria-labelledby="alquilerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alquilerModalLabel">Notificación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-<?php echo isset($modal_type) ? $modal_type : 'info'; ?>" role="alert">
                        <?php echo isset($modal_message) ? $modal_message : ''; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <a href="<?php echo isset($redirect_url) ? $redirect_url : 'usuario.php'; ?>" class="btn btn-primary">Ir a los libros alquilados</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.5/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Mostrar el modal si hay mensaje
        <?php if (isset($modal_message)) { ?>
            $('#alquilerModal').modal('show');
        <?php } ?>
    </script>
</body>
</html>
