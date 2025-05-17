<?php
include('../Cnx/conexion.php');

if (isset($_POST['id'])) {
    $idCategoria = intval($_POST['id']);

    // Verificar si existen medicamentos activos en esta categoría
    $verificarSQL = "SELECT COUNT(*) as total FROM medicamento WHERE IdCategoria = ? AND Estado = 1";
    $stmtVerificar = $conn->prepare($verificarSQL);
    $stmtVerificar->bind_param("i", $idCategoria);
    $stmtVerificar->execute();
    $resultado = $stmtVerificar->get_result()->fetch_assoc();

    if ($resultado['total'] > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'No se puede dar de baja: existen medicamentos activos en esta categoría.'
        ]);
    } else {
        // Dar de baja la categoría (estado_categoria = 0)
        $updateSQL = "UPDATE categoria SET estado_categoria = 0 WHERE ID_Categoria = ?";
        $stmtUpdate = $conn->prepare($updateSQL);
        $stmtUpdate->bind_param("i", $idCategoria);

        if ($stmtUpdate->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'Categoría dada de baja exitosamente.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error al dar de baja la categoría.'
            ]);
        }
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'ID de categoría no recibido.'
    ]);
}
?>
