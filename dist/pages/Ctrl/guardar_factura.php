<?php
ob_start();
session_start();

ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_php.log');
error_reporting(E_ALL);

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

include('../Cnx/conexion.php');

// Leer JSON del frontend
$rawInput = file_get_contents("php://input");
file_put_contents('debug_guardar.txt', $rawInput); // Para depuración

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

if (!isset($_SESSION['ID_Usuario'])) {
    cleanOutput();
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado.']);
    exit;
}

// Extraer datos del JSON
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
$montoPagado = $data['monto_pagado'] ?? '';
$cambio      = 'C$' . ($data['cambio'] ?? '0.00');

$ID_Cliente  = intval($data['ID_Cliente'] ?? 0);
$ID_Usuario  = intval($_SESSION['ID_Usuario']);

$ID_Caja = intval($data['ID_Caja'] ?? 0);
if ($ID_Caja <= 0) {
    $query = $conn->prepare("SELECT ID_Caja FROM caja WHERE ID_Usuario = ? AND Tipo = 'apertura' ORDER BY Fecha_Hora DESC LIMIT 1");
    if (!$query) {
        cleanOutput();
        echo json_encode(['success' => false, 'message' => 'Error en consulta caja: ' . $conn->error]);
        exit;
    }
    $query->bind_param("i", $ID_Usuario);
    $query->execute();
    $query->bind_result($idCajaEncontrada);
    if ($query->fetch()) {
        $ID_Caja = $idCajaEncontrada;
    } else {
        cleanOutput();
        echo json_encode(['success' => false, 'message' => 'No se encontró una caja abierta para este usuario.']);
        exit;
    }
    $query->close();
}

// Validación básica
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
    'ID_Usuario' => $ID_Usuario,
    'ID_Caja' => $ID_Caja
] as $campo => $valor) {
    if ($valor === '' || ($campo !== 'numero_factura' && $campo !== 'metodo_pago' && $valor === 0)) {
        $faltan[] = $campo;
    }
}
if ($faltan) {
    cleanOutput();
    echo json_encode(['success' => false, 'message' => 'Faltan datos: ' . implode(', ', $faltan)]);
    exit;
}

// Verificar si el número de factura ya existe
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
    echo json_encode(['success' => false, 'message' => 'El número de factura ya existe. Generá uno nuevo.']);
    exit;
}

// Insertar en factura_venta
$sql = "INSERT INTO factura_venta
(Numero_Factura, Fecha, Metodo_Pago, Subtotal, Total, Monto_Pagado, Cambio, ID_Cliente, ID_Usuario, ID_Caja)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    cleanOutput();
    echo json_encode(['success' => false, 'message' => 'Prepare falló: ' . $conn->error]);
    exit;
}
$stmt->bind_param(
    "ssssdssiii",
    $numeroFactura,
    $fecha,
    $metodoPago,
    $subtotal,
    $total,
    $montoPagado,
    $cambio,
    $ID_Cliente,
    $ID_Usuario,
    $ID_Caja
);
if (!$stmt->execute()) {
    cleanOutput();
    echo json_encode(['success' => false, 'message' => 'Execute falló: ' . $stmt->error]);
    exit;
}
$ID_FacturaV = $conn->insert_id;
$stmt->close();

// Guardar detalles de productos
$productos = $data['productos'] ?? [];

if (!is_array($productos) || empty($productos)) {
    cleanOutput();
    echo json_encode(['success' => false, 'message' => 'No se recibieron productos para la factura.']);
    exit;
}

$detalleSQL = "INSERT INTO detalle_factura_venta 
(ID_FacturaV, ID_Medicamento, Cantidad, Precio_Unitario, Subtotal, ID_Forma_Farmaceutica, ID_Dosis, ID_Presentacion) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$detalleStmt = $conn->prepare($detalleSQL);
if (!$detalleStmt) {
    cleanOutput();
    echo json_encode(['success' => false, 'message' => 'Error al preparar detalle: ' . $conn->error]);
    exit;
}

foreach ($productos as $producto) {
    $nombreProducto = $producto['nombreProducto'];
    $cantidad = intval($producto['cantidad']);
    $precio = floatval($producto['precio']);
    $subtotal = $cantidad * $precio;

    $unidad = trim($producto['unidad']);
    $dosis = trim($producto['dosis']);
    $presentacion = trim($producto['presentacion']);

    $idMedicamento = buscarID($conn, "medicamento", "Nombre_Medicamento", $nombreProducto);
    $idForma = buscarIDPorMedicamento($conn, "medicamento_forma_farmaceutica", "Forma_Farmaceutica", $unidad, $idMedicamento);
    $idDosis = buscarIDPorMedicamento($conn, "medicamento_dosis", "Dosis", $dosis, $idMedicamento);
    $idPresentacion = buscarIDPorMedicamento($conn, "medicamento_presentacion", "Tipo_Presentacion", $presentacion, $idMedicamento);

    $detalleStmt->bind_param("iiiddiii", $ID_FacturaV, $idMedicamento, $cantidad, $precio, $subtotal, $idForma, $idDosis, $idPresentacion);

    if (!$detalleStmt->execute()) {
        cleanOutput();
        echo json_encode(['success' => false, 'message' => 'Error al guardar detalle: ' . $detalleStmt->error]);
        exit;
    }

    // 🔁 NUEVO: Reducir stock en lote_presentacion
    if ($idPresentacion) {
        $stmtLote = $conn->prepare("SELECT ID_Lote, Cantidad_Presentacion 
            FROM lote_presentacion 
            WHERE ID_Presentacion = ? AND Cantidad_Presentacion >= ? 
            ORDER BY ID_Lote ASC LIMIT 1");
        $stmtLote->bind_param("ii", $idPresentacion, $cantidad);
        $stmtLote->execute();
        $stmtLote->bind_result($idLote, $stockActual);

        if ($stmtLote->fetch()) {
            $stmtLote->close();
            $nuevoStock = $stockActual - $cantidad;

            $stmtUpdate = $conn->prepare("UPDATE lote_presentacion 
                SET Cantidad_Presentacion = ? 
                WHERE ID_Lote = ? AND ID_Presentacion = ?");
            $stmtUpdate->bind_param("iii", $nuevoStock, $idLote, $idPresentacion);
            $stmtUpdate->execute();
            $stmtUpdate->close();
        } else {
            $stmtLote->close();
            cleanOutput();
            echo json_encode(['success' => false, 'message' => "No hay stock suficiente para '{$nombreProducto}' en la presentación '{$presentacion}'."]);
            exit;
        }
    }
}

$detalleStmt->close();
$conn->close();

cleanOutput();
echo json_encode([
    'success' => true,
    'message' => 'Factura, detalles y reducción de stock completados correctamente.',
    'datosFactura' => [
        'numero_factura' => $numeroFactura,
        'fecha'          => $fecha,
        'total'          => $total,
        'metodo_pago'    => $metodoPago,
        'monto_pagado'   => $montoPagado,
        'cambio'         => $cambio,
        'ID_Caja'        => $ID_Caja
    ]
]);
exit;

// FUNCIONES AUXILIARES

function buscarID($conn, $tabla, $campo, $valor) {
    $campoID = "ID_" . ucfirst($tabla);
    $stmt = $conn->prepare("SELECT $campoID FROM $tabla WHERE $campo = ? LIMIT 1");
    if (!$stmt) return null;

    $stmt->bind_param("s", $valor);
    $stmt->execute();

    $id = null;
    $stmt->bind_result($id);
    $stmt->fetch();
    $stmt->close();
    return $id ?: null;
}

function buscarIDPorMedicamento($conn, $tabla, $campo, $valor, $idMedicamento) {
    if ($valor === '-' || !$valor || !$idMedicamento) return null;

    $campoID = "ID_" . ucfirst(str_replace("medicamento_", "", $tabla));
    $stmt = $conn->prepare("SELECT $campoID FROM $tabla WHERE $campo = ? AND ID_Medicamento = ? LIMIT 1");
    if (!$stmt) return null;

    $stmt->bind_param("si", $valor, $idMedicamento);
    $stmt->execute();

    $id = null;
    $stmt->bind_result($id);
    $stmt->fetch();
    $stmt->close();
    return $id ?: null;
}
?>
