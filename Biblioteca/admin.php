<?php
session_start();
include('conexion.php');

// Verificar que el usuario esté autenticado como admin
if (!isset($_SESSION['usuario']) || $_SESSION['tipo_usuario'] != 'admin') {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['usuario'];

// Obtener el término de búsqueda (si existe)
$busqueda = isset($_GET['busqueda']) ? mysqli_real_escape_string($conexion, $_GET['busqueda']) : '';

// Modificar la consulta SQL para que filtre por búsqueda
$sql_libros = "
    SELECT l.id_libro, l.titulo, l.isbn, l.año_publicacion, l.id_autor
    FROM Libros l
    WHERE l.titulo LIKE '%$busqueda%' 
    OR l.isbn LIKE '%$busqueda%' 
    OR l.id_autor IN (
        SELECT id_autor FROM Autores WHERE nombre_autor LIKE '%$busqueda%'
    )
";

$resultado_libros = mysqli_query($conexion, $sql_libros);
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

        .search-form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Biblioteca</a>
            <span class="navbar-text">
                Bienvenido, <?php echo $usuario; ?>
            </span>
            <div class="ml-auto">
                <a href="admin.php" class="btn btn-primary">Gestionar Libros</a>
                <a href="verPrestamos.php" class="btn btn-info">Ver Préstamos Activos</a>
                <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="title">Gestión de Libros</div>

        <?php
        if (isset($_SESSION['mensaje'])) {
            $clase_alerta = strpos($_SESSION['mensaje'], 'Error') !== false ? 'alert-danger' : 'alert-success';
            echo '<div class="alert ' . $clase_alerta . ' text-center" role="alert">' . $_SESSION['mensaje'] . '</div>';
            unset($_SESSION['mensaje']);
        }
        ?>

        <!-- Formulario de búsqueda -->
        <form class="search-form" method="get" action="">
            <div class="input-group">
                <input type="text" name="busqueda" class="form-control" placeholder="Buscar por título, autor o ISBN" value="<?php echo htmlspecialchars($busqueda); ?>">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Buscar</button>
                </div>
            </div>
        </form>

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
                <?php while ($libro = mysqli_fetch_assoc($resultado_libros)) { ?>
                    <tr>
                        <td><?php echo $libro['titulo']; ?></td>
                        <td>
                            <?php 
                            $sql_autor = "SELECT nombre_autor FROM Autores WHERE id_autor = " . $libro['id_autor'];
                            $resultado_autor = mysqli_query($conexion, $sql_autor);
                            $fila_autor = mysqli_fetch_assoc($resultado_autor);
                            echo $fila_autor['nombre_autor'];
                            ?>
                        </td>
                        <td><?php echo $libro['isbn']; ?></td>
                        <td><?php echo $libro['año_publicacion']; ?></td>
                        <td>
                            <a href="modificarLibro.php?id_libro=<?php echo $libro['id_libro']; ?>" class="btn btn-warning">Editar</a>
                            <a href="eliminarLibro.php?id_libro=<?php echo $libro['id_libro']; ?>" class="btn btn-danger">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
