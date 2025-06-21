<?php
include('../Cnx/conexion.php'); // Asegúrate de tener este archivo con la conexión a tu DB

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nombre = $_POST['nombre'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    $columnas = $_POST['columnas'] ?? 1;
    $filas = $_POST['filas'] ?? 1;
    $subColumnas = $_POST['subColumnas'] ?? 0;
    $subFilas = $_POST['subFilas'] ?? 0;

    if (!$id || $nombre === '') {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
        exit;
    }

    $sql = "UPDATE estanteria 
            SET Nombre_Estanteria = ?, Tipo_Estanteria = ?, Cantidad_Columnas = ?, Cantidad_Filas = ?, SubColumnas = ?, SubFilas = ?
            WHERE ID_Estanteria = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiiiii", $nombre, $tipo, $columnas, $filas, $subColumnas, $subFilas, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Estantería actualizada correctamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar la estantería.']);
    }

    $stmt->close();
    $conn->close();
}
