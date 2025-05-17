<?php
header('Content-Type: application/json');

// Incluye tu conexión con mysqli
require '../Cnx/conexion.php'; // Asegúrate que la ruta sea correcta

$prefijo = 'N505';

try {
    $sql = "SELECT Numero_Factura FROM factura_venta ORDER BY ID_FacturaV DESC LIMIT 1";
    $resultado = $conn->query($sql);

    $nuevoSecuencial = 1;

    if ($resultado && $fila = $resultado->fetch_assoc()) {
        $numero = $fila['Numero_Factura'];
        $partes = explode('-', $numero);
        if (count($partes) === 2 && $partes[0] === $prefijo) {
            $secuencial = (int)$partes[1];
            $nuevoSecuencial = $secuencial + 1;
            if ($nuevoSecuencial > 9999) {
                $nuevoSecuencial = 1;
            }
        }
    }

    $nuevoNumero = $prefijo . '-' . str_pad($nuevoSecuencial, 4, '0', STR_PAD_LEFT);
    echo json_encode(['exito' => true, 'numeroFactura' => $nuevoNumero]);
} catch (Exception $e) {
    echo json_encode(['exito' => false, 'mensaje' => $e->getMessage()]);
}
