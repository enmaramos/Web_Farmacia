<?php
// --- INICIO: Limpieza y configuración del entorno ---
ob_start();
session_start();

ini_set('display_errors', 0); // No mostrar errores directamente
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_php.log');
error_reporting(E_ALL);

// Asegurar respuesta JSON y capturar errores fatales
function cleanOutput() {
    while (ob_get_level()) {
        ob_end_clean();
    }
    header('Content-Type: application/json');
}

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE])) {
        cleanOutput();
        echo json_encode([
            'success' => false,
            'message' => 'Error fatal en el servidor.',
            'error' => $error
        ]);
        exit;
    }
});

// --- INICIO DEL CÓDIGO ---
include('../Cnx/conexion.php');

// Leer el JSON de entrada
$rawInput = file_get_contents("php://input");
file_put_contents('debug_guardar.txt', $rawInput); // para depuración

$data = json_decode($rawInput, true);
if ($data === null) {
    cleanOutput();
    echo json_encode([
        'success' => false,
        'message' => 'Error al decodificar JSON',
        'input_recibido' => $rawInput,
        'error_json' => json_last_error_msg()
    ]);
    exit;
}

// Verificar autenticación
if (!isset($_SESSION['ID_Usuario'])) {
    cleanOutput();
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado.']);
    exit;
}

// Extraer y validar datos
$numeroFactura = $data['numero_factura'] ?? '';
$fechaRaw      = $data['fecha'] ?? '';
try {
    $fecha = (new DateTime($fechaRaw))->format('Y-m-d H:i:s');
} catch (Exception $e) {
    cleanOutput();
    echo json_encode(['success' => false, 'message' => 'Formato de fecha inválido.']);
    exit;
}

$metodoPago  = $data['metodo_pago']   ?? '';
$subtotal    = floatval($data['subtotal']    ?? 0);
$total       = floatval($data['total']       ?? 0);
$montoPagado = floatval($data['monto_pagado'] ?? 0);
$cambio      = floatval($data['cambio']      ?? 0);
$ID_Cliente  = intval($data['ID_Cliente']    ?? 0);
$ID_Usuario  = intval($_SESSION['ID_Usuario']);

// Validar campos requeridos
$faltan = [];
foreach ([
    'numero_factura' => $numeroFactura,
    'fecha' => $fecha,
    'metodo_pago' => $metodoPago,
    'subtotal' => $subtotal,
    'total' => $total,
    'monto_pagado' => $montoPagado,
    'cambio' => $cambio,
    'ID_Cliente' => $ID_Cliente,
    'ID_Usuario' => $ID_Usuario
] as $campo => $valor) {
    if ($valor === '' || ($campo !== 'numero_factura' && $campo !== 'metodo_pago' && $valor === 0)) {
        $faltan[] = $campo;
    }
}
if ($faltan) {
    cleanOutput();
    echo json_encode([
        'success' => false,
        'message' => 'Faltan datos: ' . implode(', ', $faltan)
    ]);
    exit;
}

// Verificar existencia del número de factura
$verifica = $conn->prepare("SELECT COUNT(*) FROM factura_venta WHERE Numero_Factura = ?");
if (!$verifica) {
    cleanOutput();
    echo json_encode(['success' => false, 'message' => 'Prepare falla en verificación: ' . $conn->error]);
    exit;
}
$verifica->bind_param("s", $numeroFactura);
$verifica->execute();
$verifica->bind_result($existe);
$verifica->fetch();
$verifica->close();

if ($existe > 0) {
    cleanOutput();
    echo json_encode([
        'success' => false,
        'message' => 'El número de factura ya existe. Generá uno nuevo.'
    ]);
    exit;
}

// Insertar la factura
$sql = "INSERT INTO factura_venta
    (Numero_Factura, Fecha, Metodo_Pago, Subtotal, Total, Monto_Pagado, Cambio, ID_Cliente, ID_Usuario)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    cleanOutput();
    echo json_encode([
        'success' => false,
        'message' => 'Prepare falló: ' . $conn->error
    ]);
    exit;
}

$stmt->bind_param(
    "sssdddiii",
    $numeroFactura,
    $fecha,
    $metodoPago,
    $subtotal,
    $total,
    $montoPagado,
    $cambio,
    $ID_Cliente,
    $ID_Usuario
);

if (!$stmt->execute()) {
    cleanOutput();
    echo json_encode([
        'success' => false,
        'message' => 'Execute falló: ' . $stmt->error
    ]);
    exit;
}

// Éxito
$stmt->close();
$conn->close();

cleanOutput();
echo json_encode([
    'success' => true,
    'message' => 'Factura guardada correctamente.',
    'datosFactura' => [
        'numero_factura' => $numeroFactura,
        'fecha'          => $fecha,
        'total'          => $total,
        'metodo_pago'    => $metodoPago,
        'monto_pagado'   => $montoPagado,
        'cambio'         => $cambio
    ]
]);
exit;
