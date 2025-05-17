<?php
include('../Cnx/conexion.php'); // Asegúrate de incluir tu conexión a la base de datos

if (isset($_POST['id_vendedor'])) {
    $id_vendedor = $_POST['id_vendedor'];

    // Desactivar el usuario asociado
    $sqlDesactivarUsuarios = "UPDATE usuarios SET estado_usuario = 0 WHERE ID_Vendedor = ?";
    $stmtUsuarios = $conn->prepare($sqlDesactivarUsuarios);
    $stmtUsuarios->bind_param("i", $id_vendedor);
    $stmtUsuarios->execute();
    $stmtUsuarios->close();

    // Desactivar el vendedor
    $sqlDesactivarVendedor = "UPDATE vendedor SET Estado = 0 WHERE ID_Vendedor = ?";
    $stmtVendedor = $conn->prepare($sqlDesactivarVendedor);
    $stmtVendedor->bind_param("i", $id_vendedor);

    if ($stmtVendedor->execute()) {
        echo "Empleado dado de baja correctamente";
    } else {
        echo "Error al dar de baja al empleado: " . $conn->error;
    }

    $stmtVendedor->close();
    $conn->close();
}
?>
