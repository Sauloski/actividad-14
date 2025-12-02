<?php
// db.php - Archivo de conexión a la base de datos

$servername = "localhost";
$username = "root";
$password = ""; // La contraseña por defecto en XAMPP es vacía
$dbname = "notes_app";

// Crear la conexión usando MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si hay errores de conexión
if ($conn->connect_error) {
    // Detener la ejecución y mostrar el error
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Opcional: Establecer el juego de caracteres a UTF-8
$conn->set_charset("utf8");
?>
