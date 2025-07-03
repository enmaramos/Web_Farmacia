<?php
include '../Cnx/conexion.php';

$idRespaldo = intval($_POST['id'] ?? 0);

if (!$idRespaldo) {
    echo json_encode(['exito' => false, 'error' => 'ID inválido']);
    exit;
}

$stmt = $conn->prepare("SELECT Archivo, estad FROM respaldos WHERE ID_Respaldo = ?");
$stmt->bind_param('i', $idRespaldo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['exito' => false, 'error' => 'Respaldo no encontrado']);
    exit;
}

$row = $result->fetch_assoc();

if ($row['estad'] === 'papelera') {
    echo json_encode(['exito' => false, 'error' => 'Archivo ya está en la papelera']);
    exit;
}

$archivo = $row['Archivo'];

$rutaOriginal = "C:/xampp/htdocs/Web_Farmacia/dist/pages/respaldos/archivos/" . $archivo;
$rutaPapelera = "C:/xampp/htdocs/Web_Farmacia/dist/pages/respaldos/papelera_respaldo/";

if (!is_dir($rutaPapelera)) {
    mkdir($rutaPapelera, 0777, true);
}

$rutaNuevo = $rutaPapelera . $archivo;

if (!file_exists($rutaOriginal)) {
    echo json_encode(['exito' => false, 'error' => 'Archivo original no existe']);
    exit;
}

if (!rename($rutaOriginal, $rutaNuevo)) {
    echo json_encode(['exito' => false, 'error' => 'No se pudo mover el archivo']);
    exit;
}

// Actualizar estado y fecha para saber cuándo se envió a papelera
$fechaHoy = date('Y-m-d H:i:s');
$stmtUpdate = $conn->prepare("UPDATE respaldos SET estad = 'papelera', Fecha = ? WHERE ID_Respaldo = ?");
$stmtUpdate->bind_param('si', $fechaHoy, $idRespaldo);
$stmtUpdate->execute();
$stmtUpdate->close();

$conn->close();

echo json_encode(['exito' => true]);
