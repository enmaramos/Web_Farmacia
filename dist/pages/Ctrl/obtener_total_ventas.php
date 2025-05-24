<?php
session_start();
include "../Cnx/conexion.php";

$response = [
    'totalVentas' => 0,
    'aperturaConvertida' => 0
];

if (isset($_SESSION['Nombre_Usuario'])) {
    $nombreUsuario = $_SESSION['Nombre_Usuario'];

    // Obtener ID_Usuario
    $query = "SELECT ID_Usuario FROM usuarios WHERE Nombre_Usuario = ?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("s", $nombreUsuario);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $idUsuario = $row['ID_Usuario'];
            $fechaHoy = date('Y-m-d');
            $tasaCambio = 36.80;

            // Buscar última apertura de hoy
            $queryApertura = "SELECT Fecha_Hora, Monto_Cordobas, Monto_Dolares FROM caja 
                              WHERE ID_Usuario = ? AND Tipo = 'apertura' AND DATE(Fecha_Hora) = ? 
                              ORDER BY Fecha_Hora DESC LIMIT 1";
            $stmtApertura = $conn->prepare($queryApertura);
            $stmtApertura->bind_param("is", $idUsuario, $fechaHoy);
            $stmtApertura->execute();
            $resultApertura = $stmtApertura->get_result();

            if ($rowApertura = $resultApertura->fetch_assoc()) {
                $horaApertura = $rowApertura['Fecha_Hora'];
                $montoCordobas = floatval($rowApertura['Monto_Cordobas'] ?? 0);
                $montoDolares = floatval($rowApertura['Monto_Dolares'] ?? 0);
                $response['aperturaConvertida'] = round($montoCordobas + ($montoDolares * $tasaCambio), 2);

                // Verificar si hay cierre posterior
                $queryCierre = "SELECT 1 FROM caja 
                                WHERE ID_Usuario = ? AND Tipo = 'cierre' AND Fecha_Hora > ? 
                                ORDER BY Fecha_Hora ASC LIMIT 1";
                $stmtCierre = $conn->prepare($queryCierre);
                $stmtCierre->bind_param("is", $idUsuario, $horaApertura);
                $stmtCierre->execute();
                $resultCierre = $stmtCierre->get_result();

                if ($resultCierre->num_rows === 0) {
                    // Sumar ventas desde la hora de apertura
                    $queryVentas = "
                        SELECT 
                            SUM(CASE WHEN Moneda_Backup = 'C$' THEN Total ELSE 0 END) AS total_cordobas,
                            SUM(CASE WHEN Moneda_Backup = 'USD' THEN Total ELSE 0 END) AS total_dolares
                        FROM factura_venta 
                        WHERE ID_Usuario = ? AND Fecha >= ?
                    ";
                    $stmtVentas = $conn->prepare($queryVentas);
                    $stmtVentas->bind_param("is", $idUsuario, $horaApertura);
                    $stmtVentas->execute();
                    $resultVentas = $stmtVentas->get_result();

                    if ($rowVentas = $resultVentas->fetch_assoc()) {
                        $ventasCordobas = floatval($rowVentas['total_cordobas'] ?? 0);
                        $ventasDolares = floatval($rowVentas['total_dolares'] ?? 0);
                        $response['totalVentas'] = round($ventasCordobas + ($ventasDolares * $tasaCambio), 2);
                    }
                    $stmtVentas->close();
                }

                $stmtCierre->close();
            }

            $stmtApertura->close();
        }
        $stmt->close();
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>
