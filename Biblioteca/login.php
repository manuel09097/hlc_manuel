<?php
session_start();
include('conexion.php'); // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];  // El correo electrónico
    $password = $_POST['password']; // La contraseña en texto plano

    // Preparar la consulta para evitar inyección SQL
    $stmt = $conexion->prepare("SELECT id_usuario, nombre, tipo_usuario, password FROM Usuarios WHERE correo = ?");
    $stmt->bind_param("s", $usuario); // 's' es para string
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $fila = $resultado->fetch_assoc();
        $hash_password = $fila['password']; // Contraseña encriptada de la BD

        // Verificar la contraseña encriptada con password_verify
        if (password_verify($password, $hash_password)) {
            $_SESSION['usuario'] = $fila['nombre']; // Guardar el nombre del usuario en sesión
            $_SESSION['tipo_usuario'] = $fila['tipo_usuario']; // Guardar el tipo de usuario en sesión
            $_SESSION['id_usuario'] = $fila['id_usuario']; // Guardar el ID del usuario en sesión

            // Redirigir dependiendo del tipo de usuario
            if ($fila['tipo_usuario'] == 'admin') {
                header("Location: admin.php"); // Página para administradores
            } else {
                header("Location: usuario.php"); // Página para usuarios normales
            }
            exit();
        } else {
            $error = "Contraseña incorrecta"; // Error si la contraseña no es válida
        }
    } else {
        $error = "Usuario no encontrado"; // Error si el usuario no existe
    }
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Biblioteca</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/style.css">
</head>
<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section">Biblioteca</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        <h3 class="mb-4 text-center">Iniciar sesión</h3>
                        <?php if (isset($error)) { echo "<p class='text-danger text-center'>$error</p>"; } ?>
                        <form method="POST" action="" class="signin-form">
                            <div class="form-group">
                                <input type="email" class="form-control" name="usuario" placeholder="Correo electrónico" required>
                            </div>
                            <div class="form-group">
                                <input id="password-field" type="password" class="form-control" name="password" placeholder="Contraseña" required>
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3">Entrar</button>
                            </div>
                            <div class="form-group d-md-flex">
                                <div class="w-50 text-left">
                                    <label class="checkbox-wrap checkbox-primary">Recordar sesión
                                        <input type="checkbox" checked>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-50 text-md-right">
                                    <a href="#">¿Olvidaste tu contraseña?</a>
                                </div>
                            </div>
                        </form>
                        
                        <!-- Enlace para redirigir al registro -->
                        <div class="form-group text-center">
                            <p>¿Aún no estás registrado? <a href="registro.php" class="btn btn-secondary">Registrarse</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.5/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
