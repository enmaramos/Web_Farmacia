<?php
include('../Cnx/conexion.php'); // Asegúrate de que la conexión sea válida

if (isset($_POST['id_cliente'])) {
    $id_cliente = $_POST['id_cliente'];

    // Desactivar el cliente
    $sqlDesactivarCliente = "UPDATE clientes SET Estado = 0 WHERE ID_Cliente = ?";
    $stmtCliente = $conn->prepare($sqlDesactivarCliente);
    $stmtCliente->bind_param("i", $id_cliente);

    if ($stmtCliente->execute()) {
        echo "Cliente dado de baja correctamente";
    } else {
        echo "Error al dar de baja al cliente: " . $conn->error;
    }

    $stmtCliente->close();
    $conn->close();
}
?>
