<?php
$host = "localhost";        // O "127.0.0.1"
$user = "root";             // Usuario por defecto en XAMPP
$password = "";             // Contraseña vacía por defecto
$dbname = "farmacia_san_francisco_javier2"; // Reemplaza esto por el nombre real de tu base

$conexion = new mysqli($host, $user, $password, $dbname);

if ($conexion->connect_error) {
    die("❌ Error de conexión: " . $conexion->connect_error);
}

echo "✅ Conexión exitosa a la base de datos";
?>
