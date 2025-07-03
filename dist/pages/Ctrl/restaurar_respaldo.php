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

if ($row['estad'] !== 'papelera') {
    echo json_encode(['exito' => false, 'error' => 'Archivo no está en la papelera']);
    exit;
}

$archivo = $row['Archivo'];

$rutaPapelera = "C:/xampp/htdocs/Web_Farmacia/dist/pages/respaldos/papelera_respaldo/" . $archivo;
$rutaOriginal = "C:/xampp/htdocs/Web_Farmacia/dist/pages/respaldos/archivos/" . $archivo;

if (!file_exists($rutaPapelera)) {
    echo json_encode(['exito' => false, 'error' => 'Archivo en papelera no existe']);
    exit;
}

if (!rename($rutaPapelera, $rutaOriginal)) {
    echo json_encode(['exito' => false, 'error' => 'No se pudo mover el archivo']);
    exit;
}

// Actualizar estado a 'activo' y fecha actual
$fechaHoy = date('Y-m-d H:i:s');
$stmtUpdate = $conn->prepare("UPDATE respaldos SET estad = 'activo', Fecha = ? WHERE ID_Respaldo = ?");
$stmtUpdate->bind_param('si', $fechaHoy, $idRespaldo);
$stmtUpdate->execute();
$stmtUpdate->close();

$conn->close();

echo json_encode(['exito' => true]);
