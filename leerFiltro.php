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
        if (!$resultado) {
            die("Error en la consulta: " . mysqli_error($conexion)); // Entre las comillas puede poner lo que quiera cuando me dé error. 
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