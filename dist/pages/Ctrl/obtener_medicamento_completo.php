<?php
header('Content-Type: application/json');

// Conexión segura usando __DIR__ para rutas absolutas
include '../Cnx/conexion.php'; // Ajusta si tu estructura cambia

// Validar ID de medicamento
$idMedicamento = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($idMedicamento <= 0) {
    echo json_encode(["mensaje" => "ID de medicamento inválido."], JSON_UNESCAPED_UNICODE);
    exit;
}

// Consulta SQL filtrada por ID
$sql = "
SELECT 
    m.ID_Medicamento,
    m.Nombre_Medicamento,
    m.Descripcion_Medicamento,
    m.Imagen,
    c.Nombre_Categoria,
    m.Requiere_Receta,
    p.Nombre AS Proveedor,
    l.Nombre_Laboratorio,

    -- Dosis
    d.ID_Dosis,
    d.Dosis,

    -- Forma farmacéutica
    ff.ID_Forma_Farmaceutica,
    ff.Forma_Farmaceutica,

    -- Presentación
    mp.ID_Presentacion,
    mp.Tipo_Presentacion,
    mp.Unidad_Desglose,
    mp.Total_Presentacion,
    mp.Precio,

    -- Lote
    lo.ID_Lote,
    lo.Descripcion_Lote,
    lo.Estado_Lote,
    lo.Cantidad_Lote,
    lo.Fecha_Fabricacion_Lote,
    lo.Fecha_Caducidad_Lote,
    lo.Fecha_Emision_Lote,
    lo.Fecha_Recibido_Lote,
    lo.Precio_Total_Lote,
    lo.Stock_Minimo_Lote,
    lo.Stock_Maximo_Lote,

    -- Lote-Presentación
    lp.ID_Lote_Presentacion,
    lp.Cantidad_Presentacion,

    -- Estantería y posición
    e.ID_Estanteria,
    e.Nombre_Estanteria,
    e.Cantidad_Columnas,
    e.Cantidad_Filas,
    e.SubColumnas,
    e.SubFilas,
    e.Tipo_Estanteria AS tipo_estanteria,
    pe.ID_Posicion,
    pe.Coordenada_X,
    pe.Coordenada_Y,
    pe.SubFila,
    pe.SubColumna,
    me.Cantidad_Disponible,
    me.Stock_Minimo,
    me.Stock_Maximo,
    me.Fecha_Actualizacion,

    -- Bodega
    b.ID_Bodega,
    b.Cantidad_Total_Bodega,
    b.Stock_Minimo AS Stock_Min_Bodega,
    b.Stock_Maximo AS Stock_Max_Bodega,
    b.ID_Posicion,

    -- Almacén
    a.ID_Almacen,
    a.Cantidad_Trasladada,
    a.Fecha_Movimiento,
    a.Observaciones

FROM medicamento m

LEFT JOIN categoria c ON m.IdCategoria = c.ID_Categoria
LEFT JOIN proveedor p ON m.Id_Proveedor = p.ID_Proveedor
LEFT JOIN laboratorio l ON p.ID_Laboratorio = l.ID_Laboratorio

LEFT JOIN medicamento_dosis d ON d.ID_Medicamento = m.ID_Medicamento
LEFT JOIN medicamento_forma_farmaceutica ff ON ff.ID_Medicamento = m.ID_Medicamento
LEFT JOIN medicamento_presentacion mp ON mp.ID_Medicamento = m.ID_Medicamento

LEFT JOIN lote lo ON lo.ID_Medicamento = m.ID_Medicamento
LEFT JOIN lote_presentacion lp ON lp.ID_Lote = lo.ID_Lote AND lp.ID_Presentacion = mp.ID_Presentacion

LEFT JOIN medicamento_estanteria me ON me.ID_Medicamento = m.ID_Medicamento
LEFT JOIN posicion_estanteria pe ON me.ID_Posicion = pe.ID_Posicion
LEFT JOIN estanteria e ON pe.ID_Estanteria = e.ID_Estanteria

LEFT JOIN bodega b ON b.ID_Medicamento = m.ID_Medicamento
LEFT JOIN almacen a ON a.ID_Medicamento = m.ID_Medicamento

WHERE m.ID_Medicamento = $idMedicamento
";


// Ejecutar la consulta
$resultado = $conn->query($sql);

$medicamentos = [];

if ($resultado && $resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $medicamentos[] = $fila;
    }
    echo json_encode($medicamentos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} else {
    echo json_encode(["mensaje" => "No se encontraron medicamentos."], JSON_UNESCAPED_UNICODE);
}

// Cerrar la conexión
$conn->close();
