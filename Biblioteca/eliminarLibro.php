<?php
session_start();
include('conexion.php');

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id_libro'])) {
    $id_libro = $_GET['id_libro'];

    // Preparar y ejecutar la consulta SQL para eliminar el libro
    $query = "DELETE FROM Libros WHERE id_libro = $id_libro";

    if (mysqli_query($conexion, $query)) {
        // Al eliminar el libro, guardar el mensaje de éxito en la sesión
        $_SESSION['mensaje'] = "El libro se ha eliminado correctamente.";
        // Redirigir a la página de administración
        header("Location: admin.php");
        exit();
    } else {
        // En caso de error, guardar el mensaje de error en la sesión
        $_SESSION['mensaje'] = "Error al eliminar el libro.";
        header("Location: admin.php");
        exit();
    }
} else {
    // Si no se pasa el id_libro, redirigir a la página de administración
    header("Location: admin.php");
    exit();
}

mysqli_close($conexion);
?>
