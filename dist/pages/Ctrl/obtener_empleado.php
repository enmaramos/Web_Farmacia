<?php
include '../Cnx/conexion.php';

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se recibió el ID del vendedor
    if (isset($_POST['vendedorId']) && !empty($_POST['vendedorId'])) {
        $vendedorId = intval($_POST['vendedorId']);

        // Consulta para obtener los datos del vendedor
        $sql = "SELECT v.ID_Vendedor, v.Nombre, v.Apellido, v.N_Cedula, v.Telefono, v.Direccion, v.Sexo, v.Email, v.ID_Rol, r.Nombre_Rol, v.Estado
                FROM vendedor v
                LEFT JOIN roles r ON v.ID_Rol = r.ID_Rol
                WHERE v.ID_Vendedor = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $vendedorId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Obtener los datos del vendedor
            $vendedor = $result->fetch_assoc();

            // Devolver los datos en formato JSON
            echo json_encode($vendedor);
        } else {
            // Si no se encuentra el vendedor
            echo json_encode(["error" => "empleado no encontrado"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["error" => "ID de empleado no proporcionado"]);
    }

    $conn->close();
} else {
    echo json_encode(["error" => "Método no permitido"]);
}
?>
