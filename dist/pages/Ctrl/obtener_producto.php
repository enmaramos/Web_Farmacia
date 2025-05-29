<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

if (!isset($_POST['medicamentoId'])) {
    echo json_encode([
        'success' => false,
        'mensaje' => 'No se recibió el ID del medicamento.'
    ]);
    exit;
}

$medicamentoId = $_POST['medicamentoId'];

require_once '../../conexion.php'; // Ajusta la ruta según tu estructura

try {
    // Consultar medicamento
    $stmt = $conexion->prepare("SELECT * FROM medicamento WHERE ID_Medicamento = ?");
    $stmt->execute([$medicamentoId]);
    $medicamento = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$medicamento) {
        echo json_encode([
            'success' => false,
            'mensaje' => 'No se encontró el medicamento.'
        ]);
        exit;
    }

    // Consultar lote asociado
    $stmtLote = $conexion->prepare("SELECT * FROM lote WHERE ID_Medicamento = ? ORDER BY ID_Lote DESC LIMIT 1");
    $stmtLote->execute([$medicamentoId]);
    $lote = $stmtLote->fetch(PDO::FETCH_ASSOC);

    if (!$lote) {
        echo json_encode([
            'success' => false,
            'mensaje' => 'No se encontró un lote para este medicamento.'
        ]);
        exit;
    }

    echo json_encode([
        'success' => true,
        'medicamento' => $medicamento,
        'lote' => $lote
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'mensaje' => 'Error en la base de datos: ' . $e->getMessage()
    ]);
}
