<?php
include '../Cnx/conexion.php';

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se recibió el ID del cliente
    if (isset($_POST['clienteId']) && !empty($_POST['clienteId'])) {
        $clienteId = intval($_POST['clienteId']);

        // Consulta para obtener los datos del cliente
        $sql = "SELECT ID_Cliente, Nombre, Apellido, Cedula, Telefono, Direccion, Genero, Email, Estado
                FROM clientes
                WHERE ID_Cliente = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $clienteId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Obtener los datos del cliente
            $cliente = $result->fetch_assoc();

            // Devolver los datos en formato JSON
            echo json_encode($cliente);
        } else {
            // Si no se encuentra el cliente
            echo json_encode(["error" => "Cliente no encontrado"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["error" => "ID de cliente no proporcionado"]);
    }

    $conn->close();
} else {
    echo json_encode(["error" => "Método no permitido"]);
}
?>
