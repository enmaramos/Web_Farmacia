<?php
include '../Cnx/conexion.php';

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar si se recibieron todos los datos necesarios
    $requiredFields = ['idVendedor', 'editarNombreVendedor', 'editarApellidoVendedor', 'editarCedulaVendedor', 'editarTelefonoVendedor', 'editarDireccionVendedor', 'editarSexoVendedor', 'editarCorreoVendedor', 'editarRolVendedor'];

    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            echo json_encode(["error" => "Faltan datos obligatorios"]);
            exit;
        }
    }

    // Obtener datos del formulario
    $idVendedor = intval($_POST['idVendedor']);
    $nombre = trim($_POST['editarNombreVendedor']);
    $apellido = trim($_POST['editarApellidoVendedor']);
    $cedula = trim($_POST['editarCedulaVendedor']);
    $telefono = trim($_POST['editarTelefonoVendedor']);
    $direccion = trim($_POST['editarDireccionVendedor']);
    $sexo = trim($_POST['editarSexoVendedor']);
    $email = trim($_POST['editarCorreoVendedor']);
    $rol = intval($_POST['editarRolVendedor']); // Agregado para actualizar el rol

    // Verificar si el vendedor existe antes de actualizar
    $checkQuery = "SELECT ID_Vendedor FROM vendedor WHERE ID_Vendedor = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("i", $idVendedor);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows == 0) {
        echo json_encode(["error" => "El empleado no existe"]);
        exit;
    }

    // Actualizar el vendedor con todos los datos
    $sql = "UPDATE vendedor SET Nombre = ?, Apellido = ?, N_Cedula = ?, Telefono = ?, Direccion = ?, Sexo = ?, Email = ?, ID_Rol = ? WHERE ID_Vendedor = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssii", $nombre, $apellido, $cedula, $telefono, $direccion, $sexo, $email, $rol, $idVendedor);

    if ($stmt->execute()) {
        echo json_encode(["success" => "Vendedor actualizado correctamente"]);
    } else {
        echo json_encode(["error" => "Error al actualizar el empelado: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => "Método no permitido"]);
}
?>
