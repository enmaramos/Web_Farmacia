<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../Cnx/conexion.php');

header('Content-Type: application/json');

$numeroFactura = $_GET['numero'] ?? '';

if (!$numeroFactura) {
    echo json_encode(['success' => false, 'message' => 'Número de factura no proporcionado.']);
    exit;
}

// Buscar datos de factura
$sql = "SELECT f.*, c.Nombre
        FROM factura_venta f
        JOIN clientes c ON f.ID_Cliente = c.ID_Cliente
        WHERE f.Numero_Factura = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $numeroFactura);
$stmt->execute();
$resultado = $stmt->get_result();
$factura = $resultado->fetch_assoc();

if (!$factura) {
    echo json_encode(['success' => false, 'message' => 'Factura no encontrada.']);
    exit;
}

// Buscar detalles
$sqlDetalle = "SELECT df.*, m.Nombre_Medicamento, ff.Forma_Farmaceutica, d.Dosis, p.Tipo_Presentacion
               FROM detalle_factura_venta df
               JOIN medicamento m ON df.ID_Medicamento = m.ID_Medicamento
               LEFT JOIN medicamento_forma_farmaceutica ff ON df.ID_Forma_Farmaceutica = ff.ID_Forma_Farmaceutica
               LEFT JOIN medicamento_dosis d ON df.ID_Dosis = d.ID_Dosis
               LEFT JOIN medicamento_presentacion p ON df.ID_Presentacion = p.ID_Presentacion
               WHERE df.ID_FacturaV = ?";
$stmtDetalle = $conn->prepare($sqlDetalle);
$stmtDetalle->bind_param("i", $factura['ID_FacturaV']);
$stmtDetalle->execute();
$detalles = $stmtDetalle->get_result()->fetch_all(MYSQLI_ASSOC);

echo json_encode([
    'success' => true,
    'factura' => $factura,
    'detalles' => $detalles
]);
