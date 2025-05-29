<?php
include('../Cnx/conexion.php');

// Verificar si se recibió el ID del proveedor
if (isset($_POST['proveedorId']) && !empty($_POST['proveedorId'])) {
    $proveedorId = intval($_POST['proveedorId']);

    // Iniciar una transacción para asegurar consistencia
    $conn->begin_transaction();

    try {
        // 1. Actualizar el estado del proveedor a activo (1)
        $sqlProveedor = "UPDATE proveedor SET Estado = 1 WHERE ID_Proveedor = ?";
        $stmtProveedor = $conn->prepare($sqlProveedor);
        $stmtProveedor->bind_param("i", $proveedorId);
        $stmtProveedor->execute();
        $stmtProveedor->close();

        // Confirmar la transacción
        $conn->commit();

        echo json_encode(["success" => "Proveedor activado correctamente"]);

    } catch (Exception $e) {
        // En caso de error, hacer rollback
        $conn->rollback();
        echo json_encode(["error" => "Error al activar proveedor: " . $e->getMessage()]);
    }

} else {
    echo json_encode(["error" => "ID de proveedor no proporcionado"]);
}

$conn->close();
?>
