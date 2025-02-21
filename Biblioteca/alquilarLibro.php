<?php
session_start();
include('conexion.php');

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); // Si no está logueado, redirigir al login
    exit();
}

// Verificar si se ha pasado un id de libro válido
if (isset($_GET['id_libro'])) {
    $id_libro = $_GET['id_libro'];
    $id_usuario = $_SESSION['id_usuario']; // Supongamos que el id del usuario está en la sesión

    // Verificar si el libro está disponible para alquilar (es decir, no está prestado)
    $query = "SELECT L.id_libro, X.id_ejemplar
              FROM libros L
              JOIN ejemplares X ON L.id_libro = X.id_libro
              LEFT JOIN prestamos P ON X.id_ejemplar = P.id_ejemplar AND P.estado = 'Prestado'
              WHERE L.id_libro = ? AND P.id_prestamo IS NULL";
    
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id_libro);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    // Si no se encuentran ejemplares disponibles para alquilar
    if (mysqli_stmt_num_rows($stmt) == 0) {
        echo "<script>alert('Este libro ya está prestado o no está disponible.'); window.location.href='libros_disponibles.php';</script>";
        exit();
    }

    // Obtener el ID del ejemplar disponible
    mysqli_stmt_bind_result($stmt, $id_libro, $id_ejemplar);
    mysqli_stmt_fetch($stmt);

    // Crear el préstamo en la base de datos
    $query_insert = "INSERT INTO prestamos (id_usuario, id_ejemplar, estado, fecha_prestamo) 
                     VALUES (?, ?, 'Prestado', NOW())";
    $stmt_insert = mysqli_prepare($conexion, $query_insert);
    mysqli_stmt_bind_param($stmt_insert, 'ii', $id_usuario, $id_ejemplar);

    if (mysqli_stmt_execute($stmt_insert)) {
        // Redirigir a la página de libros disponibles después de realizar el alquiler
        echo "<script>alert('¡Libro alquilado exitosamente!'); window.location.href='librosDisponibles.php';</script>";
    } else {
        echo "<script>alert('Error al alquilar el libro.'); window.location.href='librosDisponibles.php';</script>";
    }

} else {
    echo "<script>alert('ID de libro no válido.'); window.location.href='libros_disponibles.php';</script>";
}
?>
