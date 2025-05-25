<?php
session_start();
include "../Cnx/conexion.php";

date_default_timezone_set('America/Managua'); // Ajusta si usas otra zona horaria

$response = [
    'totalVentas' => 0,
    'aperturaConvertida' => 0,
    'debug' => []
];

if (isset($_SESSION['Nombre_Usuario'])) {
    $nombreUsuario = $_SESSION['Nombre_Usuario'];
    $response['debug'][] = "Usuario: $nombreUsuario";

    // Obtener ID del usuario
    $query = "SELECT ID_Usuario FROM usuarios WHERE Nombre_Usuario = ?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("s", $nombreUsuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $idUsuario = $row['ID_Usuario'];
            $response['debug'][] = "ID_Usuario: $idUsuario";

            $fechaHoy = date('Y-m-d');
            $tasaCambio = 36.80;

            // Obtener la última apertura de hoy
            $queryUltimaApertura = "SELECT Fecha_Hora, Monto_Cordobas, Monto_Dolares 
                                    FROM caja
                                    WHERE ID_Usuario = ? AND Tipo = 'apertura' AND DATE(Fecha_Hora) = ?
                                    ORDER BY Fecha_Hora DESC LIMIT 1";
            $stmtUltApertura = $conn->prepare($queryUltimaApertura);
            $stmtUltApertura->bind_param("is", $idUsuario, $fechaHoy);
            $stmtUltApertura->execute();
            $resultUltApertura = $stmtUltApertura->get_result();

            if ($rowUltApertura = $resultUltApertura->fetch_assoc()) {
                $fechaUltApertura = $rowUltApertura['Fecha_Hora'];
                $response['debug'][] = "Última apertura registrada: $fechaUltApertura";

                // Mostrar el monto de la última apertura, siempre
                $montoCordobas = floatval($rowUltApertura['Monto_Cordobas'] ?? 0);
                $montoDolares = floatval($rowUltApertura['Monto_Dolares'] ?? 0);
                $response['aperturaConvertida'] = round($montoCordobas + ($montoDolares * $tasaCambio), 2);
                $response['debug'][] = "Mostrando monto de la última apertura registrada";

                // Verificar si hay un cierre posterior a esa apertura
                $queryUltimoCierre = "SELECT Fecha_Hora FROM caja 
                                      WHERE ID_Usuario = ? AND Tipo = 'cierre' AND Fecha_Hora > ?
                                      ORDER BY Fecha_Hora ASC LIMIT 1";
                $stmtUltCierre = $conn->prepare($queryUltimoCierre);
                $stmtUltCierre->bind_param("is", $idUsuario, $fechaUltApertura);
                $stmtUltCierre->execute();
                $resultUltCierre = $stmtUltCierre->get_result();

                if ($resultUltCierre->num_rows === 0) {
                    // No hay cierre posterior → caja abierta
                    $response['debug'][] = "Caja abierta (sin cierre posterior)";

                    // Sumar ventas desde esa apertura
                    $queryVentas = "SELECT SUM(Total) AS total FROM factura_venta 
                                    WHERE ID_Usuario = ? AND Fecha >= ?";
                    $stmtVentas = $conn->prepare($queryVentas);
                    $stmtVentas->bind_param("is", $idUsuario, $fechaUltApertura);
                    $stmtVentas->execute();
                    $resultVentas = $stmtVentas->get_result();

                    if ($rowVentas = $resultVentas->fetch_assoc()) {
                        $response['totalVentas'] = round(floatval($rowVentas['total'] ?? 0), 2);
                        $response['debug'][] = "Total de ventas desde la apertura: C$ ".$response['totalVentas'];
                    }
                    $stmtVentas->close();
                } else {
                    // Caja ya fue cerrada
                    $fechaUltCierre = $resultUltCierre->fetch_assoc()['Fecha_Hora'];
                    $response['debug'][] = "Caja cerrada. Último cierre registrado: $fechaUltCierre";
                }

                $stmtUltCierre->close();
            } else {
                $response['debug'][] = "No hay aperturas registradas para hoy.";
            }

            $stmtUltApertura->close();
        } else {
            $response['debug'][] = "No se encontró el ID del usuario.";
        }

        $stmt->close();
    } else {
        $response['debug'][] = "Error al preparar consulta para obtener ID_Usuario.";
    }
} else {
    $response['debug'][] = "No hay sesión activa.";
}

header('Content-Type: application/json');
echo json_encode($response);
$conn->close();
exit;
