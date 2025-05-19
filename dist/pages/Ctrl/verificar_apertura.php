<?php
include '../Cnx/conexion.php'; // Ajusta la ruta si es diferente
session_start();

$id_usuario = $_SESSION['ID_Usuario']; // Asegúrate de que esta variable esté en sesión
$hoy = date('Y-m-d');

// Verificar si ya hay una caja tipo "apertura" para hoy
$sql = "SELECT ID_Caja FROM caja 
        WHERE DATE(Fecha_Hora) = ? AND Tipo = 'apertura' AND ID_Usuario = ?
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $hoy, $id_usuario);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo 'existe';
} else {
    echo 'no_existe';
}
