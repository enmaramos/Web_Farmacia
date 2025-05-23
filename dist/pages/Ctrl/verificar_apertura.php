<?php
include '../Cnx/conexion.php';
session_start();

$id_usuario = $_SESSION['ID_Usuario'];
$hoy = date('Y-m-d');

// Buscar la última apertura de hoy
$sql = "SELECT Fecha_Hora FROM caja 
        WHERE DATE(Fecha_Hora) = ? AND Tipo = 'apertura' AND ID_Usuario = ? 
        ORDER BY Fecha_Hora DESC LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $hoy, $id_usuario);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($fecha_apertura);
    $stmt->fetch();

    // Verificar si existe un cierre después de esa apertura
    $sql2 = "SELECT 1 FROM caja 
             WHERE Tipo = 'cierre' AND ID_Usuario = ? AND Fecha_Hora > ? 
             LIMIT 1";

    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("is", $id_usuario, $fecha_apertura);
    $stmt2->execute();
    $stmt2->store_result();

    if ($stmt2->num_rows > 0) {
        // Hubo un cierre después de la apertura → se puede abrir de nuevo
        echo 'no_existe';
    } else {
        // No hay cierre después de la apertura → ya está aperturada
        echo 'existe';
    }

    $stmt2->close();
} else {
    // No hubo apertura hoy → se puede abrir caja
    echo 'no_existe';
}

$stmt->close();
$conn->close();
?>
