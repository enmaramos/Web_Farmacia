<?php
session_start();
include("../Cnx/conexion.php");

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    if ($usuario === "" || $password === "") {
        echo json_encode(['success' => false, 'message' => 'Campos vacíos']);
        exit;
    }

    // Consulta que obtiene los datos del usuario, incluyendo imagen y rol
    $stmt = $conn->prepare("
        SELECT 
            u.ID_Usuario, 
            u.Nombre_Usuario, 
            u.Password, 
            u.ID_Vendedor, 
            u.Imagen,
            v.ID_Rol,
            r.Nombre_Rol
        FROM usuarios u
        INNER JOIN vendedor v ON u.ID_Vendedor = v.ID_Vendedor
        INNER JOIN roles r ON v.ID_Rol = r.ID_Rol
        WHERE LOWER(u.Nombre_Usuario) = LOWER(?) AND u.estado_usuario = 1
        LIMIT 1
    ");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if ($password === $user['Password']) {  // comparación directa (sin hash)
            // Guardar datos en la sesión
            $_SESSION['ID_Usuario'] = $user['ID_Usuario'];
            $_SESSION['Nombre_Usuario'] = $user['Nombre_Usuario'];
            $_SESSION['ID_Vendedor'] = $user['ID_Vendedor'];
            $_SESSION['ID_Rol'] = $user['ID_Rol'];
            $_SESSION['Nombre_Rol'] = $user['Nombre_Rol'];
            $_SESSION['Imagen'] = $user['Imagen'];
            $_SESSION['Password'] = $user['Password']; // <-- AGREGADO

            // Actualizar el último acceso en la base de datos
            $updateStmt = $conn->prepare("
                UPDATE usuarios 
                SET Ultimo_Acceso = NOW() 
                WHERE ID_Usuario = ?
            ");
            $updateStmt->bind_param("i", $user['ID_Usuario']);
            $updateStmt->execute();
            $updateStmt->close();

            echo json_encode([
                'success' => true,
                'nombre' => $user['Nombre_Usuario'],
                'rol' => $user['Nombre_Rol'],
                'imagen' => $user['Imagen']
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Usuario no encontrado o inactivo']);
    }

    $stmt->close();
    $conn->close();
}
