<?php
// Establecemos las contraseñas en texto plano
$password_admin = "admin123";  // Contraseña del administrador
$password_user = "usuario123";  // Contraseña del usuario normal

// Usamos password_hash para generar el hash de las contraseñas
$hashed_admin = password_hash($password_admin, PASSWORD_DEFAULT);
$hashed_user = password_hash($password_user, PASSWORD_DEFAULT);

// Imprimimos las contraseñas cifradas para que puedas copiarlas
echo "Contraseña de admin cifrada: " . $hashed_admin . "<br>";
echo "Contraseña de usuario cifrada: " . $hashed_user . "<br>";
?>
