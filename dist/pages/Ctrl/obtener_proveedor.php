<?php
include '../Cnx/conexion.php';

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se recibió el ID del proveedor
    if (isset($_POST['proveedorId']) && !empty($_POST['proveedorId'])) {
        $proveedorId = intval($_POST['proveedorId']);

        // Consulta para obtener los datos del proveedor
        $sql = "SELECT ID_Proveedor, Nombre, Laboratorio, Direccion, Telefono, Email, RUC 
                FROM proveedor
                WHERE ID_Proveedor = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $proveedorId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Obtener los datos del proveedor
            $proveedor = $result->fetch_assoc();

            // Devolver los datos en formato JSON
            echo json_encode($proveedor);
        } else {
            // Si no se encuentra el proveedor
            echo json_encode(["error" => "Proveedor no encontrado"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["error" => "ID de proveedor no proporcionado"]);
    }

    $conn->close();
} else {
    echo json_encode(["error" => "Método no permitido"]);
}
