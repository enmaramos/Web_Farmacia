<?php
header('Content-Type: application/json');
include('../Cnx/conexion.php'); // Ajusta la ruta si es necesario

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
    exit;
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM estanteria WHERE ID_Estanteria = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Estantería no encontrada']);
    exit;
}

$estanteria = $result->fetch_assoc();

echo json_encode([
    'success' => true,
    'estanteria' => $estanteria
]);
?>
