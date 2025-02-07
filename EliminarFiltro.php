<?php
// Incluir el archivo de conexión (si es necesario)
include('conexion.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumno eliminado</title>
    
    <!-- Link al CSS de Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Listado de Estudiantes Después de Eliminar</h2>

        
<?php

// Verificar si se ha enviado el formulario por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];

        // Verificar que existe el ID
        $query = "SELECT count(id) FROM alumnos WHERE id='$id'";
        $resultado = mysqli_query($conexion, $query);

        // Verificar si la consulta fue exitosa
        if (mysqli_num_rows($resultado) == 0) {
            //pngo un mensaje para explicar que no se ha encontrado
            //un alumno con ese nombre.

            //Le facilito un enlace al fichero de alta de alumnos, por si quiere introducirlo.

            // Le puedo facilitar un enlace al fichero que muestra todos los alumnos.

            // Añado un boton de volver para, que vuelva a la pagina de opciones.php.
            ?>
            <div class="card-body">
                <div class="mb-3">
                    <a href="#.php" class="btn btn-primary">Introducir alumnos</a>
                </div>

                <div class="mb-3">
                    <a href="leerTodos.php" class="btn btn-primary">Ver alumnos</a>
                </div>

                <div class="mb-3">
                    <a href="opciones.php" class="btn btn-primary">Volver</a>
                </div>
            </div>
            <?php
        }

        // Mostrar los resultados en formato de tabla
        echo "<div class='container mt-4'>
                <h2>Resultados para: " . htmlspecialchars($nombre) . "</h2>
                <table class='table table-bordered table-striped'>
                    <thead class='thead-dark'>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Edad</th>
                            <th>Curso</th>
                            <th>Promociona</th>
                        </tr>
                    </thead>
                    <tbody>";

        // Recorrer cada fila de resultados y mostrarla
        while ($row = mysqli_fetch_assoc($resultado)) {
            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['nombre'] . "</td>
                    <td>" . $row['edad'] . "</td>
                    <td>" . $row['curso'] . "</td>
                    <td>" . $row['promociona'] . "</td>
                </tr>";
        }

        echo "</tbody></table></div>";
    } else {
        echo "<div class='container mt-4'>
                <h2>No se proporcionó un nombre para la búsqueda</h2>
              </div>";
    }
} else {
    echo "<div class='container mt-4'>
            <h2>Acceso no permitido. El formulario debe enviarse mediante POST.</h2>
          </div>";
}

?>
<!-- Scripts de Bootstrap -->
     <!-- Agregar el script de Bootstrap 5 desde el CDN al final del body -->
     <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>