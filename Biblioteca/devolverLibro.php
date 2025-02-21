<?php
session_start();
include('conexion.php');

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); // Si no está logueado, redirigir al login
    exit();
}

// Verificar si se ha recibido un ID de préstamo
if (isset($_GET['id_prestamo'])) {
    $id_prestamo = $_GET['id_prestamo'];

    // Consultar el préstamo para obtener el id del ejemplar y usuario
    $query = "SELECT id_ejemplar, id_usuario, fecha_devolucion FROM prestamos WHERE id_prestamo = $id_prestamo AND estado = 'Prestado'";
    $result = mysqli_query($conexion, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $id_ejemplar = $row['id_ejemplar'];
        $id_usuario = $row['id_usuario'];

        // Actualizar el estado del préstamo a 'Devuelto'
        $query_update_prestamo = "UPDATE prestamos SET estado = 'Devuelto', fecha_devolucion = NOW() WHERE id_prestamo = $id_prestamo";
        mysqli_query($conexion, $query_update_prestamo);

        // Actualizar el estado del ejemplar a 'Disponible'
        $query_update_ejemplar = "UPDATE ejemplares SET estado = 'Disponible' WHERE id_ejemplar = $id_ejemplar";
        mysqli_query($conexion, $query_update_ejemplar);

        // Opcional: puedes mostrar un mensaje al usuario de éxito
        echo "<script>alert('El libro ha sido devuelto exitosamente.'); window.location.href='usuario.php';</script>";
    } else {
        echo "<script>alert('No se ha encontrado el préstamo o ya ha sido devuelto.'); window.location.href='index.php';</script>";
    }
} else {
    echo "<script>alert('No se ha recibido un ID de préstamo válido.'); window.location.href='usuario.php';</script>";
}

mysqli_close($conexion);
?>
