<?php

// Incluir la conexión a la base de datos
require_once 'config/conexion.php';

try {
    // Definir la nueva contraseña que quieres actualizar
    $nueva_contrasena = 'admin'; // Esta es la contraseña actual que tienes en la BD

    // Hashear la contraseña utilizando password_hash
    $hashed_password = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

    // Preparar la consulta para actualizar la contraseña del usuario con ID 1 (el administrador)
    $stmt = $pdo->prepare('UPDATE usuarios SET contrasena = ? WHERE id = ?');

    // Ejecutar la consulta con el hash de la contraseña y el ID del usuario
    $stmt->execute([$hashed_password, 1]);

    echo "Contraseña actualizada exitosamente.";

} catch (PDOException $e) {
    // Manejar errores en caso de que falle la consulta
    echo 'Error: ' . $e->getMessage();
}

?>
