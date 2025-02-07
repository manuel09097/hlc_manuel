<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Introducir Alumno</title>
    
    <!-- Link al CSS de Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php
// Incluir el archivo de conexión
include('conexion.php');

// Compruebo que he entrado en enviarDatos.php por llamada POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Verificar y sanitizar entrada
    if (isset($_POST['nombre']) && !empty($_POST['nombre']) &&
        isset($_POST['edad']) && $_POST['edad'] !== "" &&
        isset($_POST['curso']) && !empty($_POST['curso']) &&
        isset($_POST['promociona'])) {

        $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $edad = (int) $_POST['edad']; // Asegurar que es un número entero
        $curso = mysqli_real_escape_string($conexion, $_POST['curso']);
        $promociona = (int) $_POST['promociona']; // Convertir a entero (0 o 1)

        // Consulta SQL de inserción
        $sql = "INSERT INTO alumnos (nombre, edad, curso, promociona) VALUES ('$nombre', '$edad', '$curso', '$promociona')";
        $resultado = mysqli_query($conexion, $sql);

        // Comprobar si la consulta se ejecutó correctamente
        if ($resultado) {
            echo "<div class='alert alert-success' role='alert'>
            Alumno con nombre: $nombre insertado correctamente.</div>";
            ?>
            
               <div class="card-body">
                <div class="mb-3">
                    <div class="mb-3">
                        <a href="opciones.php" class="btn btn-primary">Volver</a>
                    </div>
                </div>
            
            

        </div>
        <?php
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error al insertar el alumno: " . mysqli_error($conexion) . "</div>";
        }

    } else {
        echo "<div class='alert alert-warning' role='alert'>Faltan datos obligatorios. Por favor, complete todos los campos.</div>";
    }

    // Cerrar conexión
    mysqli_close($conexion);
}
?>

<!-- Scripts de Bootstrap -->
     <!-- Agregar el script de Bootstrap 5 desde el CDN al final del body -->
     <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>