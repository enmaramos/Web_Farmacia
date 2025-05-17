<?php
include '../Cnx/conexion.php';

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar si se recibieron todos los datos necesarios
    $requiredFields = ['idCategoria', 'editarNombreCategoria', 'editarDescripcion'];

    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            echo json_encode(["error" => "Faltan datos obligatorios"]);
            exit;
        }
    }

    // Obtener datos del formulario
    $idCategoria = intval($_POST['idCategoria']);
    $nombre = trim($_POST['editarNombreCategoria']);
    $descripcion = trim($_POST['editarDescripcion']);

    // Verificar si la categoría existe antes de actualizar
    $checkQuery = "SELECT ID_Categoria FROM categoria WHERE ID_Categoria = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("i", $idCategoria);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows == 0) {
        echo json_encode(["error" => "La categoría no existe"]);
        exit;
    }

    // Actualizar la categoría con todos los datos
    $sql = "UPDATE categoria SET Nombre_Categoria = ?, Descripcion = ? WHERE ID_Categoria = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nombre, $descripcion, $idCategoria);

    if ($stmt->execute()) {
        echo json_encode(["success" => "Categoría actualizada correctamente"]);
    } else {
        echo json_encode(["error" => "Error al actualizar la categoría: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => "Método no permitido"]);
}
?>
