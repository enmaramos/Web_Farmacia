<?php
include('../Cnx/conexion.php'); // Asegúrate de que la ruta sea correcta

$query = "
SELECT 
    m.ID_Medicamento,
    m.Nombre_Medicamento,
    m.LAB_o_MARCA,
    m.Imagen,
    GROUP_CONCAT(DISTINCT f.Forma_Farmaceutica ORDER BY f.Forma_Farmaceutica ASC SEPARATOR ', ') AS Forma_Farmaceutica,
    GROUP_CONCAT(DISTINCT d.Dosis ORDER BY d.Dosis ASC SEPARATOR ', ') AS Dosis,
    GROUP_CONCAT(DISTINCT CONCAT(p.Tipo_Presentacion, ' (C$ ', p.Precio, ')') ORDER BY p.Tipo_Presentacion ASC SEPARATOR '<br>') AS Presentaciones
FROM medicamento m
LEFT JOIN medicamento_forma_farmaceutica f ON m.ID_Medicamento = f.ID_Medicamento
LEFT JOIN forma_farmaceutica_dosis fd ON f.ID_Forma_Farmaceutica = fd.ID_Forma_Farmaceutica
LEFT JOIN medicamento_dosis d ON fd.ID_Dosis = d.ID_Dosis
LEFT JOIN medicamento_presentacion p ON m.ID_Medicamento = p.ID_Medicamento
WHERE m.Estado = 1
GROUP BY m.ID_Medicamento;
";

$result = $conn->query($query);

if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

if ($result->num_rows > 0) {
    $productos = [];
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
    echo json_encode($productos);
} else {
    echo json_encode([]);
}
?>
