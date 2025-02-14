<?php
// Incluir el archivo de conexión
include('conexion.php'); // Asegúrate de que el archivo 'conexion.php' esté en el mismo directorio o ajusta la ruta

// Consulta para obtener los datos de la tabla "Libros" con información de autores, categorías y editoriales
$query = "SELECT Libros.id_libro, Libros.titulo, Autores.nombre AS autor, Categorias.nombre AS categoria, Editoriales.nombre AS editorial, Libros.isbn, Libros.año_publicacion 
          FROM Libros
          LEFT JOIN Autores ON Libros.id_autor = Autores.id_autor
          LEFT JOIN Categorias ON Libros.id_categoria = Categorias.id_categoria
          LEFT JOIN Editoriales ON Libros.id_editorial = Editoriales.id_editorial";
$resultado = mysqli_query($conexion, $query);

// Verificar si la consulta fue exitosa
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

// Mostrar los resultados en formato de tabla
echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Autor</th>
            <th>Categoría</th>
            <th>Editorial</th>
            <th>ISBN</th>
            <th>Año de Publicación</th>
        </tr>";

// Recorrer cada fila de resultados y mostrarla
while ($row = mysqli_fetch_assoc($resultado)) {
    echo "<tr>
            <td>" . $row['id_libro'] . "</td>
            <td>" . $row['titulo'] . "</td>
            <td>" . $row['autor'] . "</td>
            <td>" . $row['categoria'] . "</td>
            <td>" . $row['editorial'] . "</td>
            <td>" . $row['isbn'] . "</td>
            <td>" . $row['año_publicacion'] . "</td>
        </tr>";
}

// Cerrar la tabla HTML
echo "</table>";

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
