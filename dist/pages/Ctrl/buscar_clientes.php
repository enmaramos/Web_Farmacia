<?php
// Incluir el archivo de conexión
include('../Cnx/conexion.php');

// Obtener el término de búsqueda desde la petición (si está presente)
$termino = isset($_GET['termino']) ? $_GET['termino'] : '';

// Preparar la consulta para obtener clientes que coincidan con el término de búsqueda
$sql = "SELECT ID_Cliente, Nombre, Apellido, Cedula FROM clientes WHERE Nombre LIKE ? OR Cedula LIKE ? AND Estado = 1";
$stmt = $conn->prepare($sql);
$searchTerm = "%".$termino."%";
$stmt->bind_param("ss", $searchTerm, $searchTerm);

// Ejecutar la consulta
$stmt->execute();
$result = $stmt->get_result();

// Crear un array para almacenar los resultados
$clientes = array();
while ($row = $result->fetch_assoc()) {
    $clientes[] = $row;
}

// Devolver los resultados como JSON
echo json_encode($clientes);

// Cerrar la conexión
$conn->close();
?>
