<?php
// Incluir el archivo de conexión (si es necesario)
include('conexion.php');

// Verificar si se ha enviado el formulario por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nombre']) && !empty($_POST['nombre'])) // Paso la variable nombre y además especifico que no está vacío
    {
        $nombre = $_POST['nombre'];

        // Consultar los datos de la base de datos filtrados por nombre
        $query = "SELECT id, nombre, edad, curso, promociona FROM alumnos WHERE nombre LIKE '%$nombre%'"; // Selecciona todo o los campos  // Si con el select empiezo con comillas dobles la variable le pongo comillas simple y al revés. 
                                                                                                          // Si no imprime la variable.
                                                                                                          // que me interesen de la tabla alumno, pero puede que me interese filtrar por ese nombre. 
                                                                     // Preguntar mañana lo de las mayúsculas.                                     // Cuando pones Ana te sale Ana.
        $resultado = mysqli_query($conexion, $query); // Angela recomienda activar buscar por mayúsculas y minúsculas para tener más nota.
                                                                    // Se establece la consulta, ya que la variable query contiene la consulta y se almacena en $resultado.+

        // Verificar si la consulta fue exitosa
        if (!$resultado) {
           // die("Error en la consulta: " . mysqli_error($conexion));
           // pongo un mensaje para explicar que no se ha encontrado un alumno con ese nombre.
           // le facilito un enlace al fichero de alta de alumno, por si quiere introducirlo.
           // Le facilito un enlace al fichero que muestra todos los alumnos.
           // Y añado un botón de volver para, que vuelva a la página opciones.php.
            echo "<div class='container mt-4'>
                    <h2>Error en la consulta: " . mysqli_error($conexion) . "</h2>
                    <div class='alert alert-danger'>Hubo un problema al ejecutar la consulta. Por favor, inténtalo de nuevo más tarde.</div>
                    <div class='mb-3'>
                        <a href='altaAlumno.php' class='btn btn-primary'>Introducir nuevo alumno</a>
                    </div>
                    <div class='mb-3'>
                        <a href='leerTodos.php' class='btn btn-primary'>Ver todos los alumnos</a>
                    </div>
                    <div class='mb-3'>
                        <a href='opciones.php' class='btn btn-primary'>Volver</a>
                    </div>
                  </div>";
        } else {
            // Si la consulta es exitosa y no retorna resultados, se muestra un mensaje
            if (mysqli_num_rows($resultado) == 0) {
                echo "<div class='container mt-4'>
                        <h2>No se encontraron resultados para el nombre: " . htmlspecialchars($nombre) . "</h2>
                        <div class='alert alert-warning'>No se han encontrado estudiantes con ese nombre. ¿Deseas añadir uno?</div>
                        <div class='mb-3'>
                            <a href='altaAlumno.php' class='btn btn-primary'>Introducir nuevo alumno</a>
                        </div>
                        <div class='mb-3'>
                            <a href='leerTodos.php' class='btn btn-primary'>Ver todos los alumnos</a>
                        </div>
                        <div class='mb-3'>
                            <a href='opciones.php' class='btn btn-primary'>Volver</a>
                        </div>
                      </div>";
            } else {
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
                while ($row = mysqli_fetch_assoc($resultado)) { // Con el mysqli_fetch_assoc coge las filas una por una y la va metiendo en la tabla o lo que haya. Si lo copiamos y pegamos el código de abajo no lo hace porque solo lo hace una vez, para hacerlo 2 veces tenemos que lanzar la variable $resultado y hacer otra vez la línea:  $resultado = mysqli_query($conexion, $query);
                    echo "<tr>                                          
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['nombre'] . "</td>
                            <td>" . $row['edad'] . "</td>
                            <td>" . $row['curso'] . "</td>
                            <td>" . $row['promociona'] . "</td>
                        </tr>";
                }

                echo "</tbody></table></div>";
            }
        }
    } else {
        echo "<div class='container mt-4'>
                <h2>No se proporcionó un nombre para la búsqueda</h2>
                <div class='alert alert-warning'>Por favor, ingrese un nombre para realizar la búsqueda.</div>
                <div class='mb-3'>
                    <a href='opciones.php' class='btn btn-primary'>Volver</a>
                </div>
              </div>";
    }
} else {
    echo "<div class='container mt-4'>
            <h2>Acceso no permitido. El formulario debe enviarse mediante POST.</h2>
            <div class='alert alert-danger'>Por razones de seguridad, este formulario solo se puede enviar mediante el método POST.</div>
            <div class='mb-3'>
                <a href='opciones.php' class='btn btn-primary'>Volver</a>
            </div>
          </div>";
}

?>