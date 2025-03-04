<?php
session_start();
include('conexion.php');

// Verificar que el usuario esté autenticado como admin
if (!isset($_SESSION['usuario']) || $_SESSION['tipo_usuario'] != 'admin') {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['usuario'];

// Obtener todos los préstamos activos junto con los datos del usuario y del libro
$sql_prestamos = "SELECT 
                        p.id_prestamo,
                        p.fecha_prestamo,
                        p.fecha_devolucion,
                        p.estado,
                        u.nombre AS usuario_nombre,
                        u.correo AS usuario_correo,
                        l.titulo AS libro_titulo,
                        a.nombre_autor AS libro_autor,
                        l.isbn AS libro_isbn
                  FROM 
                        Prestamos p
                  JOIN 
                        Usuarios u ON p.id_usuario = u.id_usuario
                  JOIN 
                        Libros l ON p.id_libro = l.id_libro
                  JOIN 
                        Autores a ON l.id_autor = a.id_autor
                  WHERE 
                        p.estado = 'Prestado'";

$resultado_prestamos = mysqli_query($conexion, $sql_prestamos);
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteca - Ver Préstamos Activos</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            width: 90%;
            margin-left: auto;
            margin-right: auto;
        }

        .title {
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
        }

        table {
            width: 100%;
            background-color: rgba(0, 0, 0, 0.6);
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
                <a href="admin.php" class="btn btn-primary">Gestionar Libros</a>
                <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="title">Préstamos Activos</div>

        <!-- MENSAJE DE CONFIRMACIÓN -->
        <?php
        if (isset($_SESSION['mensaje'])) {
            $clase_alerta = strpos($_SESSION['mensaje'], 'Error') !== false ? 'alert-danger' : 'alert-success';
            echo '<div class="alert ' . $clase_alerta . ' text-center" role="alert">' . $_SESSION['mensaje'] . '</div>';
            unset($_SESSION['mensaje']); // Limpiar mensaje después de mostrarlo
        }
        ?>

        <table>
            <thead>
                <tr>
                    <th>Libro</th>
                    <th>Autor</th>
                    <th>ISBN</th>
                    <th>Correo Usuario</th>
                    <th>Fecha Préstamo</th>
                    <th>Fecha Devolución</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($prestamo = mysqli_fetch_assoc($resultado_prestamos)) { ?>
                    <tr>
                        <td><?php echo $prestamo['libro_titulo']; ?></td>
                        <td><?php echo $prestamo['libro_autor']; ?></td>
                        <td><?php echo $prestamo['libro_isbn']; ?></td>
                        <td><?php echo $prestamo['usuario_correo']; ?></td>
                        <td><?php echo $prestamo['fecha_prestamo']; ?></td>
                        <td><?php echo $prestamo['fecha_devolucion']; ?></td>
                        <td><?php echo $prestamo['estado']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>
