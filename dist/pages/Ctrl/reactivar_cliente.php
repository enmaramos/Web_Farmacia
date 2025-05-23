<?php
include('../Cnx/conexion.php');

// Verificar si se recibió el ID del cliente
if (isset($_POST['clienteId']) && !empty($_POST['clienteId'])) {
    $clienteId = intval($_POST['clienteId']);

    // Iniciar una transacción para asegurar consistencia
    $conn->begin_transaction();

    try {
        // 1. Actualizar el estado del cliente a activo (1)
        $sqlCliente = "UPDATE clientes SET Estado = 1 WHERE ID_Cliente = ?";
        $stmtCliente = $conn->prepare($sqlCliente);
        $stmtCliente->bind_param("i", $clienteId);
        $stmtCliente->execute();
        $stmtCliente->close();

        // Confirmar la transacción
        $conn->commit();

        echo json_encode(["success" => "Cliente activado correctamente"]);

    } catch (Exception $e) {
        // En caso de error, hacer rollback
        $conn->rollback();
        echo json_encode(["error" => "Error al activar cliente y usuario: " . $e->getMessage()]);
    }

} else {
    echo json_encode(["error" => "ID de cliente no proporcionado"]);
}

$conn->close();
?>
