<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root"; // Cambia si es necesario
$password = ""; // Cambia si es necesario
$dbname = "farmacia_san_francisco_javier2";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
