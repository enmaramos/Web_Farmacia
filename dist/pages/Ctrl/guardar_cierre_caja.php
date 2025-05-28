<?php
session_start();
include('../Cnx/conexion.php');

if (!isset($_SESSION['ID_Usuario'])) {
  echo "❌ Usuario no autenticado.";
  exit;
}

$tipo = 'cierre';
$cajero = $_POST['cajero'] ?? '';
$fecha_hora = $_POST['fecha_hora'] ?? '';
$monto_cordobas = isset($_POST['monto_cordobas']) ? floatval($_POST['monto_cordobas']) : 0;
$monto_dolares = isset($_POST['monto_dolares']) ? floatval($_POST['monto_dolares']) : 0;
$observaciones = $_POST['observaciones'] ?? '';
$estado_cierre = $_POST['estado_cierre'] ?? 'CUADRA';
$diferencia = isset($_POST['diferencia']) ? floatval($_POST['diferencia']) : 0;
$id_usuario = $_SESSION['ID_Usuario'];

// Insertar registro cierre caja
$stmt = $conn->prepare("INSERT INTO caja (Cajero, Fecha_Hora, Tipo, Monto_Cordobas, Monto_Dolares, Observaciones, ID_Usuario, Estado_Cierre, Diferencia)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssddsssd", $cajero, $fecha_hora, $tipo, $monto_cordobas, $monto_dolares, $observaciones, $id_usuario, $estado_cierre, $diferencia);

if (!$stmt->execute()) {
  echo "❌ Error: " . $stmt->error;
  exit;
}

$id_caja = $stmt->insert_id;

// Definir denominaciones
$denominaciones = [
  'billete_5' => ['C$5', 'billete', 'cordoba'],
  'billete_10' => ['C$10', 'billete', 'cordoba'],
  'billete_20' => ['C$20', 'billete', 'cordoba'],
  'billete_50' => ['C$50', 'billete', 'cordoba'],
  'billete_100' => ['C$100', 'billete', 'cordoba'],
  'billete_200' => ['C$200', 'billete', 'cordoba'],
  'billete_500' => ['C$500', 'billete', 'cordoba'],
  'billete_1000' => ['C$1000', 'billete', 'cordoba'],
  'moneda_c5' => ['¢5', 'moneda', 'cordoba'],
  'moneda_c10' => ['¢10', 'moneda', 'cordoba'],
  'moneda_c25' => ['¢25', 'moneda', 'cordoba'],
  'moneda_c50' => ['¢50', 'moneda', 'cordoba'],
  'moneda_1' => ['C$1', 'moneda', 'cordoba'],
  'moneda_5' => ['C$5', 'moneda', 'cordoba'],
  'moneda_10' => ['C$10', 'moneda', 'cordoba'],
  'usd_1' => ['$1', 'billete', 'dolar'],
  'usd_2' => ['$2', 'billete', 'dolar'],
  'usd_5' => ['$5', 'billete', 'dolar'],
  'usd_10' => ['$10', 'billete', 'dolar'],
  'usd_20' => ['$20', 'billete', 'dolar'],
  'usd_50' => ['$50', 'billete', 'dolar'],
  'usd_100' => ['$100', 'billete', 'dolar'],
];

$stmt_detalle = $conn->prepare("INSERT INTO detalle_caja (ID_Caja, Denominacion, Cantidad, Moneda, Tipo) VALUES (?, ?, ?, ?, ?)");

foreach ($denominaciones as $input => $info) {
  $cantidad = isset($_POST[$input]) ? intval($_POST[$input]) : 0;
  if ($cantidad > 0) {
    list($denominacion, $tipo_den, $moneda) = $info;
    $stmt_detalle->bind_param("isiss", $id_caja, $denominacion, $cantidad, $moneda, $tipo_den);
    if (!$stmt_detalle->execute()) {
      error_log("Error detalle_caja: " . $stmt_detalle->error);
    }
  }
}

echo "✅ Caja cerrada correctamente.";
?>
