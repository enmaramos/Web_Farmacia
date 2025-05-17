<?php
include('../Cnx/conexion.php');

// ID del cliente fijo que se usará cuando se seleccione el checkbox
$idCliente = 89;

$sql = "SELECT Nombre, Apellido, Cedula FROM clientes WHERE ID_Cliente = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idCliente);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $cliente = $resultado->fetch_assoc();

    // Obtener primer nombre y primer apellido
    $primerNombre = explode(" ", $cliente['Nombre'])[0];
    $primerApellido = explode(" ", $cliente['Apellido'])[0];

    // Enviar datos procesados
    echo json_encode([
        'Nombre' => "$primerNombre $primerApellido",
        'Cedula' => $cliente['Cedula']
    ]);
} else {
    echo json_encode(['error' => 'Cliente no encontrado']);
}

$conn->close();
?>
