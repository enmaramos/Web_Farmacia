<?php
include '../Cnx/conexion.php';

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar si se recibieron todos los datos necesarios
    $requiredFields = ['idProveedor', 'editarNombreProveedor', 'editarLaboratorioProveedor', 'editarDireccionProveedor', 'editarTelefonoProveedor', 'editarCorreoProveedor', 'editarRUCProveedor'];

    foreach ($requiredFields as $field) {
    if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
        echo json_encode([
            "error" => "Falta el campo: $field",
            "recibido" => $_POST
        ]);
        exit;
    }
}


    // Obtener datos del formulario
    $idProveedor = intval($_POST['idProveedor']);
    $nombre = trim($_POST['editarNombreProveedor']);
    $laboratorio = trim($_POST['editarLaboratorioProveedor']);
    $direccion = trim($_POST['editarDireccionProveedor']);
    $telefono = trim($_POST['editarTelefonoProveedor']);
    $email = trim($_POST['editarCorreoProveedor']);
    $ruc = trim($_POST['editarRUCProveedor']);

    // Verificar si el proveedor existe antes de actualizar
    $checkQuery = "SELECT ID_Proveedor FROM proveedor WHERE ID_Proveedor = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("i", $idProveedor);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows == 0) {
        echo json_encode(["error" => "El proveedor no existe"]);
        exit;
    }

    // Actualizar el proveedor
    $sql = "UPDATE proveedor 
            SET Nombre = ?, Laboratorio = ?, Telefono = ?, Direccion = ?, Email = ?, RUC = ? 
            WHERE ID_Proveedor = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $nombre, $laboratorio, $telefono, $direccion, $email, $ruc, $idProveedor);

    if ($stmt->execute()) {
        echo json_encode(["success" => "Proveedor actualizado correctamente"]);
    } else {
        echo json_encode(["error" => "Error al actualizar el proveedor: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => "Método no permitido"]);
}
