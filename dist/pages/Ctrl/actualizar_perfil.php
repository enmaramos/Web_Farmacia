<?php
session_start();
include '../Cnx/conexion.php';

if (
    isset($_POST['ID_Usuario']) &&
    isset($_POST['Nombre_Usuario'])
) {
    $userId = $_POST['ID_Usuario'];
    $nombreUsuario = trim($_POST['Nombre_Usuario']);
    $nuevaPassword = isset($_POST['Password']) ? trim($_POST['Password']) : null;

    // Procesar imagen
    $imagen = null;
    if (isset($_FILES['Imagen']) && $_FILES['Imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen = basename($_FILES['Imagen']['name']);
        $uploadDir = realpath($_SERVER['DOCUMENT_ROOT']) . '/Web_Farmacia/dist/pages/uploads/';
        $uploadFile = $uploadDir . $imagen;

        if (!move_uploaded_file($_FILES['Imagen']['tmp_name'], $uploadFile)) {
            echo "Error al subir la imagen.";
            exit();
        }
    } else if (!empty($_POST['ImagenActual'])) {
        $imagen = $_POST['ImagenActual'];
    } else {
        $imagen = $_SESSION['Imagen'];
    }

    if ($imagen === null || $imagen === '') {
        echo "No se pudo determinar la imagen a usar.";
        exit();
    }

    // Actualizar datos
    if ($nuevaPassword !== null && $nuevaPassword !== '') {
        $sql = "UPDATE usuarios SET Nombre_Usuario = ?, Password = ?, Imagen = ? WHERE ID_Usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nombreUsuario, $nuevaPassword, $imagen, $userId);
    } else {
        $sql = "UPDATE usuarios SET Nombre_Usuario = ?, Imagen = ? WHERE ID_Usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $nombreUsuario, $imagen, $userId);
    }

    if ($stmt->execute()) {
        // Actualizar la sesión con los nuevos valores
        $_SESSION['Nombre_Usuario'] = $nombreUsuario;
        $_SESSION['Imagen'] = $imagen;
        if ($nuevaPassword !== null && $nuevaPassword !== '') {
            $_SESSION['Password'] = $nuevaPassword;
        }

        // Respuesta de éxito
        echo "Usuario actualizado correctamente.";
    } else {
        echo "Error al actualizar el usuario: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Faltan datos obligatorios.";
}
