<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar sesión
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['ID_Usuario'])) {
    echo json_encode(['data' => [], 'error' => 'Sesión no iniciada']);
    exit;
}

require '../Cnx/conexion.php';

$idUsuario = $_SESSION['ID_Usuario'];

// Obtener la última apertura de caja del usuario
$sql_apertura = "SELECT Fecha_Hora FROM caja 
                 WHERE ID_Usuario = ? AND Tipo = 'apertura' 
                 ORDER BY Fecha_Hora DESC LIMIT 1";

$stmt_apertura = $conn->prepare($sql_apertura);
$stmt_apertura->bind_param("i", $idUsuario);
$stmt_apertura->execute();
$result_apertura = $stmt_apertura->get_result();

if ($result_apertura->num_rows === 0) {
    echo json_encode(['data' => [], 'error' => 'No hay apertura de caja']);
    exit;
}

$fila_apertura = $result_apertura->fetch_assoc();
$fecha_apertura = $fila_apertura['Fecha_Hora'];

// Obtener el cierre posterior (si existe)
$sql_cierre = "SELECT Fecha_Hora FROM caja 
               WHERE ID_Usuario = ? AND Tipo = 'cierre' AND Fecha_Hora > ? 
               ORDER BY Fecha_Hora ASC LIMIT 1";

$stmt_cierre = $conn->prepare($sql_cierre);
$stmt_cierre->bind_param("is", $idUsuario, $fecha_apertura);
$stmt_cierre->execute();
$result_cierre = $stmt_cierre->get_result();

$fecha_cierre = null;
if ($result_cierre->num_rows > 0) {
    $fila_cierre = $result_cierre->fetch_assoc();
    $fecha_cierre = $fila_cierre['Fecha_Hora'];
}

// Consulta de facturas según rango entre apertura y cierre (o solo apertura si no hay cierre aún)
if ($fecha_cierre) {
    $sql_facturas = "SELECT 
                        f.Numero_Factura,
                        CONCAT(c.Nombre, ' ', c.Apellido) AS Cliente,
                        f.Metodo_Pago,
                        f.Subtotal,
                        f.Total,
                        f.ID_FacturaV
                    FROM factura_venta f
                    LEFT JOIN clientes c ON f.ID_Cliente = c.ID_Cliente
                    WHERE f.ID_Usuario = ? AND f.Fecha BETWEEN ? AND ?
                    ORDER BY f.Fecha DESC";

    $stmt_facturas = $conn->prepare($sql_facturas);
    $stmt_facturas->bind_param("iss", $idUsuario, $fecha_apertura, $fecha_cierre);
} else {
    $sql_facturas = "SELECT 
                        f.Numero_Factura,
                        CONCAT(c.Nombre, ' ', c.Apellido) AS Cliente,
                        f.Metodo_Pago,
                        f.Subtotal,
                        f.Total,
                        f.ID_FacturaV
                    FROM factura_venta f
                    LEFT JOIN clientes c ON f.ID_Cliente = c.ID_Cliente
                    WHERE f.ID_Usuario = ? AND f.Fecha >= ?
                    ORDER BY f.Fecha DESC";

    $stmt_facturas = $conn->prepare($sql_facturas);
    $stmt_facturas->bind_param("is", $idUsuario, $fecha_apertura);
}

$stmt_facturas->execute();
$result_facturas = $stmt_facturas->get_result();

$data = [];
while ($row = $result_facturas->fetch_assoc()) {
    $data[] = [
        'Numero_Factura' => $row['Numero_Factura'],
        'Cliente' => $row['Cliente'],
        'Metodo_Pago' => $row['Metodo_Pago'],
        'Subtotal' => $row['Subtotal'],
        'Total' => $row['Total'],
        'ID_FacturaV' => $row['ID_FacturaV']
    ];
}

echo json_encode(['data' => $data]);
