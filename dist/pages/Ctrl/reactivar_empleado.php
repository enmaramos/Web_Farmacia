<?php
include('../Cnx/conexion.php');

// Verificar si se recibió el ID del vendedor
if (isset($_POST['vendedorId']) && !empty($_POST['vendedorId'])) {
    $vendedorId = intval($_POST['vendedorId']);

    // Iniciar una transacción para asegurar consistencia
    $conn->begin_transaction();

    try {
        // 1. Actualizar el estado del vendedor a activo (1)
        $sqlVendedor = "UPDATE vendedor SET Estado = 1 WHERE ID_Vendedor = ?";
        $stmtVendedor = $conn->prepare($sqlVendedor);
        $stmtVendedor->bind_param("i", $vendedorId);
        $stmtVendedor->execute();
        $stmtVendedor->close();

        // 2. Actualizar también el estado del usuario relacionado (si existe)
        $sqlUsuario = "UPDATE usuarios SET estado_usuario = 1 WHERE ID_Vendedor = ?";
        $stmtUsuario = $conn->prepare($sqlUsuario);
        $stmtUsuario->bind_param("i", $vendedorId);
        $stmtUsuario->execute();
        $stmtUsuario->close();

        // Confirmar la transacción
        $conn->commit();

        echo json_encode(["success" => "Empleado y usuario activados correctamente"]);

    } catch (Exception $e) {
        // En caso de error, hacer rollback
        $conn->rollback();
        echo json_encode(["error" => "Error al activar empleado y usuario: " . $e->getMessage()]);
    }

} else {
    echo json_encode(["error" => "ID de empleado no proporcionado"]);
}

$conn->close();
?>
