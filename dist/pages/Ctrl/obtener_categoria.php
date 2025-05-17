<?php
include '../Cnx/conexion.php';

header("Content-Type: application/json");

// Verificar si se envió el ID de la categoría
if (!isset($_POST['categoriaId']) || empty($_POST['categoriaId'])) {
    echo json_encode(['error' => 'ID de categoría no proporcionado']);
    exit;
}

$categoriaId = $_POST['categoriaId'];

// Debug: Mostrar el ID recibido en el log del servidor
error_log("ID de categoría recibido: " . $categoriaId);

// Consulta para obtener los datos de la categoría
$sql = "SELECT ID_Categoria, Nombre_Categoria, Descripcion FROM categoria WHERE ID_Categoria = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $categoriaId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    
    // Debug: Verificar los datos recuperados
    error_log("Datos obtenidos: " . json_encode($data));
    
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Categoría no encontrada']);
}

$stmt->close();
$conn->close();
?>
