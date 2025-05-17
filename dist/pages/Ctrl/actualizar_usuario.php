<?php
include '../Cnx/conexion.php';  // Asegúrate de que esta conexión sea la correcta

// Verifica que los datos han sido enviados
if (isset($_POST['ID_Usuario']) && isset($_POST['Nombre_Usuario']) && isset($_POST['Password'])) {
    $userId = $_POST['ID_Usuario'];
    $nombreUsuario = $_POST['Nombre_Usuario'];
    $password = $_POST['Password'];
    $imagen = null;

    // Si se ha subido una nueva imagen, procesarla
    if (isset($_FILES['Imagen']) && $_FILES['Imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen = $_FILES['Imagen']['name'];
        $uploadDir = realpath($_SERVER['DOCUMENT_ROOT']) . '/Web_Farmacia/dist/pages/uploads/';
        $uploadFile = $uploadDir . basename($imagen);

        // Mover el archivo a la carpeta de uploads
        if (!move_uploaded_file($_FILES['Imagen']['tmp_name'], $uploadFile)) {
            echo "Error al subir la imagen.";
            exit();
        }
    }

    // Si no se ha subido una imagen, mantén la imagen actual del usuario
    if ($imagen === null) {
        // Verificar si se está enviando el nombre de la imagen
        $imagen = isset($_POST['Imagen']) ? $_POST['Imagen'] : null;
    }

    // Consulta SQL para actualizar los datos del usuario
    $sql = "UPDATE usuarios 
            SET Nombre_Usuario = ?, Password = ?, Imagen = ? 
            WHERE ID_Usuario = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nombreUsuario, $password, $imagen, $userId);

    if ($stmt->execute()) {
        echo "Usuario actualizado correctamente.";
    } else {
        echo "Error al actualizar el usuario.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Faltan datos para actualizar el usuario.";
}
?>
