<?php
include '../Cnx/conexion.php';  // Asegúrate de que esta conexión sea la correcta

// Verifica si se ha enviado el ID del usuario
if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Consulta con JOIN para obtener el nombre y apellido del vendedor
    $sql = "SELECT u.ID_Usuario, u.Nombre_Usuario, u.Imagen, u.Password, u.estado_usuario, 
                   u.Fecha_Creacion, u.Ultimo_Acceso, 
                   CONCAT(v.Nombre, ' ', v.Apellido) AS Nombre_Vendedor 
            FROM usuarios u 
            LEFT JOIN vendedor v ON u.ID_Vendedor = v.ID_Vendedor 
            WHERE u.ID_Usuario = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si el usuario existe, devolvemos los datos
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response = array(
            'ID_Usuario' => $row['ID_Usuario'],
            'Nombre_Usuario' => $row['Nombre_Usuario'],
            'Imagen' => $row['Imagen'],
            'Password' => $row['Password'], 
            'Nombre_Vendedor' => $row['Nombre_Vendedor'], // Ahora devuelve el nombre completo del vendedor
            'estado_usuario' => $row['estado_usuario'],
            'Fecha_Creacion' => $row['Fecha_Creacion'],
            'Ultimo_Acceso' => $row['Ultimo_Acceso']
        );
        echo json_encode($response);  // Devuelve los datos en formato JSON
    } else {
        echo json_encode(array('error' => 'Usuario no encontrado'));  
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(array('error' => 'No se recibió el userId.'));
}
