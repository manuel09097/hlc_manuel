<?php
// Incluir el archivo de conexión (si es necesario)
include('conexion.php');

// Verificar si se ha enviado el formulario por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nombre']) && !empty($_POST['nombre'])) {  //Paso la variable nombre y ademas especifico que
                                                                // no está vacío. 
        $nombre = $_POST['nombre'];

        // Consultar los datos de la base de datos filtrados por nombre
        $query = "SELECT id, nombre, edad, curso, promociona FROM alumnos WHERE nombre LIKE '%$nombre%'"; // Selecciona los campos que me interesan de la tabla alumno
                                                                                                          // pero puede que me interese filtrar por  ese nombre, Ej. Poner el nombre
                                                                                                          // de alguien y que te salga. 
        $resultado = mysqli_query($conexion, $query);  // Buscar por mayusculas y minusculas. // Tener en cuenta que puede poner nombre y busque nombre en lugar del contenido. 
                                                    // Establece la consulta ya que query contiene la consulta almacenandose en $resultado. CUIDADO MAYUSUCULAS A LA HORA DE BUSCAR IMPORTANTE. 
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
        while ($row = mysqli_fetch_assoc($resultado)) {      // Con el mysql_fetch_assoc coge las filas una a una y la va 
                                                             // metiendo en la tabla. Si queremos que salga otra vez las filas 
                                                             //tenemos que copiar nuevamente en la linea $resultado = mysqli_query($conexion, $query);
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