<?php
include '../Cnx/conexion.php';

$sql = "SELECT ID_Respaldo, Archivo, Tamano, Fecha FROM respaldos WHERE estad = 'papelera' ORDER BY Fecha DESC";
$result = $conn->query($sql);

$datos = [];
while ($row = $result->fetch_assoc()) {
    $datos[] = [
        'ID_Respaldo' => $row['ID_Respaldo'],
        'Archivo' => $row['Archivo'],
        'Tamano' => $row['Tamano'],
        'Fecha' => $row['Fecha']
    ];
}

header('Content-Type: application/json');
echo json_encode($datos);
