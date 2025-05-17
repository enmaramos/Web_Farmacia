<?php
// Incluir el archivo de conexión a la base de datos
include('../conexion.php');

// Verificar si la cédula ha sido proporcionada
if (isset($_GET['cedula'])) {
    $cedula = $_GET['cedula'];

    // Consulta para obtener el ID del cliente usando la cédula
    $query = "SELECT ID_Cliente FROM cliente WHERE Cedula = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $cedula);  // Vincular la cédula de forma segura
    $stmt->execute();
    $stmt->bind_result($clienteId);

    // Si encontramos el cliente, devolvemos su ID
    if ($stmt->fetch()) {
        echo json_encode(['clienteId' => $clienteId]);
    } else {
        echo json_encode(['error' => 'Cliente no encontrado']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Cédula no proporcionada']);
}
?>
