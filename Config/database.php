<?php
$dsn = 'mysql:host=localhost;dbname=comandos';
$usuario = 'root';
$contraseña = '';

try {
    $conexion = new PDO($dsn, $usuario, $contraseña);
    // Realiza operaciones en la base de datos aquí
} catch (PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}
?>