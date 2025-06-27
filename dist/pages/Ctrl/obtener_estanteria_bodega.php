<?php
header('Content-Type: application/json');

// ✅ Conexión a la base de datos
include '../Cnx/conexion.php';

// ✅ Validar ID recibido
$idMedicamento = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($idMedicamento <= 0) {
    echo json_encode(["mensaje" => "ID de medicamento inválido."], JSON_UNESCAPED_UNICODE);
    exit;
}

// ✅ Consulta mejorada incluyendo fecha de recibido del lote
$sql = "SELECT 
    b.ID_Bodega,
    b.Cantidad_Total_Bodega,
    b.Stock_Minimo,
    b.Stock_Maximo,
    b.ID_Posicion,
    b.ID_Medicamento,

    pe.Coordenada_X,
    pe.Coordenada_Y,
    pe.Piso,
    pe.SubFila,
    pe.SubColumna,

    e.ID_Estanteria,
    e.Nombre_Estanteria,
    e.Cantidad_Filas,
    e.Cantidad_Columnas,
    e.SubFilas,
    e.SubColumnas,
    e.Tipo_Estanteria,

    -- ✅ Campo adicional de lote
    lo.Fecha_Recibido_Lote

FROM bodega b
INNER JOIN posicion_estanteria pe ON b.ID_Posicion = pe.ID_Posicion
INNER JOIN estanteria e ON pe.ID_Estanteria = e.ID_Estanteria
LEFT JOIN lote lo ON lo.ID_Medicamento = b.ID_Medicamento

WHERE e.Tipo_Estanteria = 'Bodega'
AND b.ID_Medicamento = ?";

// ✅ Preparar y ejecutar
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idMedicamento);
$stmt->execute();
$result = $stmt->get_result();

$bodegas = [];

while ($row = $result->fetch_assoc()) {
    $bodegas[] = $row;
}

// ✅ Mostrar resultado
if (empty($bodegas)) {
    echo json_encode(["mensaje" => "❌ No se encontraron datos de bodega para este medicamento."], JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode($bodegas, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

$conn->close();
