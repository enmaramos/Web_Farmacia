<?php
include('../Cnx/conexion.php');

// Verificar si se recibió el ID de la categoría
if (isset($_POST['categoriaId']) && !empty($_POST['categoriaId'])) {
    $categoriaId = intval($_POST['categoriaId']);

    // Iniciar transacción
    $conn->begin_transaction();

    try {
        // Reactivar la categoría (Estado = 1)
        $sql = "UPDATE categoria SET estado_categoria = 1 WHERE ID_Categoria = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $categoriaId);
        $stmt->execute();
        $stmt->close();

        // Confirmar cambios
        $conn->commit();

        echo json_encode(["success" => "Categoría reactivada correctamente."]);

    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(["error" => "Error al reactivar la categoría: " . $e->getMessage()]);
    }

} else {
    echo json_encode(["error" => "ID de categoría no proporcionado."]);
}

$conn->close();
?>
