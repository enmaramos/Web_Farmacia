<?php
// limpiar_papelera.php

date_default_timezone_set('America/Managua');
include '../Cnx/conexion.php';

$rutaPapelera = "C:/xampp/htdocs/Web_Farmacia/dist/pages/respaldos/papelera_respaldo/";

// Fecha límite para eliminar archivos (hace 5 días)
$fechaLimite = date('Y-m-d H:i:s', strtotime('-5 days'));

// Buscar archivos en papelera con fecha anterior a la fecha límite
$sql = "SELECT ID_Respaldo, Archivo FROM respaldos WHERE estad = 'papelera' AND Fecha <= ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $fechaLimite);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $archivo = $row['Archivo'];
    $rutaArchivo = $rutaPapelera . $archivo;

    // Borrar archivo físico si existe
    if (file_exists($rutaArchivo)) {
        unlink($rutaArchivo);
    }

    // Borrar registro de base de datos
    $stmtDelete = $conn->prepare("DELETE FROM respaldos WHERE ID_Respaldo = ?");
    $stmtDelete->bind_param('i', $row['ID_Respaldo']);
    $stmtDelete->execute();
    $stmtDelete->close();
}

$stmt->close();
$conn->close();

// Puedes poner un echo o log para confirmar ejecución si quieres
echo "Papelera limpiada correctamente.";
?>
