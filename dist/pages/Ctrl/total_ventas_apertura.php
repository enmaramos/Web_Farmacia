<?php
session_start();
include "../Cnx/conexion.php";

header('Content-Type: application/json');
date_default_timezone_set('America/Managua');

$response = ['success' => false];

if (!isset($_SESSION['Nombre_Usuario'])) {
    $response['message'] = 'No hay sesión activa';
    echo json_encode($response);
    exit;
}

$nombreUsuario = $_SESSION['Nombre_Usuario'];

// Obtener ID del usuario
$sqlUsuario = "SELECT ID_Usuario FROM usuarios WHERE Nombre_Usuario = ?";
$stmtUsuario = $conn->prepare($sqlUsuario);
$stmtUsuario->bind_param("s", $nombreUsuario);
$stmtUsuario->execute();
$resultUsuario = $stmtUsuario->get_result();

if ($rowUsuario = $resultUsuario->fetch_assoc()) {
    $idUsuario = $rowUsuario['ID_Usuario'];
    $fechaHoy = date('Y-m-d');

    // Obtener la última apertura de hoy
    $sqlApertura = "
        SELECT *
        FROM caja
        WHERE ID_Usuario = ? 
          AND Tipo = 'apertura' 
          AND DATE(Fecha_Hora) = ?
        ORDER BY Fecha_Hora DESC
        LIMIT 1
    ";
    $stmtApertura = $conn->prepare($sqlApertura);
    $stmtApertura->bind_param("is", $idUsuario, $fechaHoy);
    $stmtApertura->execute();
    $resultApertura = $stmtApertura->get_result();

    if ($rowApertura = $resultApertura->fetch_assoc()) {
        $fechaApertura = $rowApertura['Fecha_Hora'];

        // Obtener el total de ventas desde la apertura de caja
        $sqlVentas = "
            SELECT SUM(Total) as TotalVentas
            FROM factura_venta
            WHERE ID_Usuario = ?
              AND Fecha >= ?
              AND DATE(Fecha) = DATE(?)
        ";
        $stmtVentas = $conn->prepare($sqlVentas);
        $stmtVentas->bind_param("iss", $idUsuario, $fechaApertura, $fechaApertura);
        $stmtVentas->execute();
        $resultVentas = $stmtVentas->get_result();
        $totalVentas = 0;
        if ($rowVentas = $resultVentas->fetch_assoc()) {
            $totalVentas = floatval($rowVentas['TotalVentas']);
        }
        $stmtVentas->close();

        // Verificar si hay cierre posterior
        $sqlCierre = "
            SELECT 1 
            FROM caja 
            WHERE ID_Usuario = ? 
              AND Tipo = 'cierre' 
              AND Fecha_Hora > ?
            LIMIT 1
        ";
        $stmtCierre = $conn->prepare($sqlCierre);
        $stmtCierre->bind_param("is", $idUsuario, $fechaApertura);
        $stmtCierre->execute();
        $resultCierre = $stmtCierre->get_result();

        if ($resultCierre->num_rows === 0) {
            // No hay cierre posterior → Caja abierta
            $response['success'] = true;
            $response['ID_Caja'] = $rowApertura['ID_Caja'];
            $response['Cajero'] = $rowApertura['Cajero'];
            $response['Fecha_Hora'] = $rowApertura['Fecha_Hora'];
            $response['Monto_Cordobas'] = floatval($rowApertura['Monto_Cordobas']);
            $response['Monto_Dolares'] = floatval($rowApertura['Monto_Dolares']);
            $response['Total_Ventas'] = $totalVentas;
        } else {
            $response['message'] = 'Caja ya fue cerrada después de esa apertura';
        }

        $stmtCierre->close();
    } else {
        $response['message'] = 'No hay apertura registrada para hoy';
    }

    $stmtApertura->close();
} else {
    $response['message'] = 'No se encontró el ID del usuario';
}

$stmtUsuario->close();
$conn->close();

echo json_encode($response);
