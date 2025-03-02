<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenido a la Biblioteca</title>
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
            margin-top: 100px;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 10px;
            width: 40%; /* Reducido el ancho del contenedor */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }

        .title {
            font-size: 2rem; /* Reducido el tamaño del título */
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
            color: #fff;
        }

        .btn {
            padding: 12px 25px; /* Reducido el tamaño de los botones */
            font-size: 1.1rem; /* Reducido el tamaño de la fuente de los botones */
            margin: 8px 0;
            text-transform: uppercase;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
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

        .navbar {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 10px 20px;
        }

        .navbar .navbar-brand {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Biblioteca</a>
        </div>
    </nav>

    <!-- Contenedor principal -->
    <div class="container">
        <div class="title">Bienvenido a la Biblioteca</div>

        <!-- Mensaje de bienvenida -->
        <p class="text-center" style="font-size: 1.1rem; color: #fff;">
            ¡Nos alegra que estés aquí! Puedes iniciar sesión o registrarte para comenzar a gestionar tus libros.
        </p>

        <!-- Botones para iniciar sesión o registrarse -->
        <a href="login.php" class="btn btn-primary">Iniciar sesión</a>
        <a href="registro.php" class="btn btn-success">Registrarse</a>
    </div>

</body>
</html>
