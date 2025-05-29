<?php
include('../Cnx/conexion.php'); // Asegúrate de incluir tu conexión

if (isset($_POST['id_proveedor'])) {
    $id_proveedor = $_POST['id_proveedor'];

    // Desactivar el proveedor
    $sqlDesactivarProveedor = "UPDATE proveedor SET Estado = 0 WHERE ID_Proveedor = ?";
    $stmtProveedor = $conn->prepare($sqlDesactivarProveedor);
    $stmtProveedor->bind_param("i", $id_proveedor);

    if ($stmtProveedor->execute()) {
        echo "Proveedor dado de baja correctamente";
    } else {
        echo "Error al dar de baja al proveedor: " . $conn->error;
    }

    $stmtProveedor->close();
    $conn->close();
}
?>
