<?php
include '../Cnx/conexion.php';

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar si se recibieron todos los datos necesarios
    $requiredFields = ['idCliente', 'editarNombreCliente', 'editarApellidoCliente', 'editarCedulaCliente', 'editarTelefonoCliente', 'editarDireccionCliente', 'editarSexoCliente', 'editarCorreoCliente'];

    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            echo json_encode(["error" => "Faltan datos obligatorios"]);
            exit;
        }
    }

    // Obtener datos del formulario
    $idCliente = intval($_POST['idCliente']);
    $nombre = trim($_POST['editarNombreCliente']);
    $apellido = trim($_POST['editarApellidoCliente']);
    $cedula = trim($_POST['editarCedulaCliente']);
    $telefono = trim($_POST['editarTelefonoCliente']);
    $direccion = trim($_POST['editarDireccionCliente']);
    $genero = trim($_POST['editarSexoCliente']);
    $email = trim($_POST['editarCorreoCliente']);

    // Verificar si el cliente existe antes de actualizar
    $checkQuery = "SELECT ID_Cliente FROM clientes WHERE ID_Cliente = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("i", $idCliente);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows == 0) {
        echo json_encode(["error" => "El cliente no existe"]);
        exit;
    }

    // Actualizar el cliente
    $sql = "UPDATE clientes SET Nombre = ?, Apellido = ?, Cedula = ?, Telefono = ?, Direccion = ?, Genero = ?, Email = ? WHERE ID_Cliente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $nombre, $apellido, $cedula, $telefono, $direccion, $genero, $email, $idCliente);

    if ($stmt->execute()) {
        echo json_encode(["success" => "Cliente actualizado correctamente"]);
    } else {
        echo json_encode(["error" => "Error al actualizar el cliente: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => "Método no permitido"]);
}
?>
