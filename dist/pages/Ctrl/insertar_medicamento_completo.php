<?php
include '../Cnx/conexion.php'; // Ajusta esta ruta según tu estructura

// Leer datos desde el cuerpo de la solicitud (por ejemplo, con fetch o axios)
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    http_response_code(400);
    echo json_encode(["error" => "Datos inválidos o incompletos"]);
    exit;
}

$conn->begin_transaction();

try {
    // 1. Insertar en medicamento
    $stmt = $conn->prepare("INSERT INTO medicamento (Nombre_Medicamento, Imagen, Descripcion_Medicamento, IdCategoria, Estado, Requiere_Receta, Id_Proveedor)
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiiii", $data['nombre'], $data['imagen'], $data['descripcion'], $data['id_categoria'], $data['estado'], $data['requiere_receta'], $data['id_proveedor']);
    $stmt->execute();
    $id_medicamento = $conn->insert_id;

    // 2. Insertar en medicamento_dosis
    $stmt = $conn->prepare("INSERT INTO medicamento_dosis (Dosis, ID_Medicamento) VALUES (?, ?)");
    $stmt->bind_param("si", $data['dosis'], $id_medicamento);
    $stmt->execute();
    $id_dosis = $conn->insert_id;

    // 3. Insertar en medicamento_forma_farmaceutica
    $stmt = $conn->prepare("INSERT INTO medicamento_forma_farmaceutica (ID_Medicamento, Forma_Farmaceutica) VALUES (?, ?)");
    $stmt->bind_param("is", $id_medicamento, $data['forma_farmaceutica']);
    $stmt->execute();
    $id_forma = $conn->insert_id;

    // 4. Insertar en forma_farmaceutica_dosis
    $stmt = $conn->prepare("INSERT INTO forma_farmaceutica_dosis (ID_Forma_Farmaceutica, ID_Dosis) VALUES (?, ?)");
    $stmt->bind_param("ii", $id_forma, $id_dosis);
    $stmt->execute();

    // 5. Insertar en medicamento_presentacion (pueden ser múltiples)
    $presentaciones = $data['presentaciones']; // arreglo de presentaciones
    $id_presentaciones = [];

    foreach ($presentaciones as $presentacion) {
        $stmt = $conn->prepare("INSERT INTO medicamento_presentacion (ID_Medicamento, Tipo_Presentacion, Unidad_Desglose, Total_Presentacion, Precio)
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issid", $id_medicamento, $presentacion['tipo'], $presentacion['unidad_desglose'], $presentacion['total'], $presentacion['precio']);
        $stmt->execute();
        $id_presentaciones[] = $conn->insert_id;
    }

    // 6. Insertar en lote
    $stmt = $conn->prepare("INSERT INTO lote (Descripcion_Lote, Estado_Lote, Cantidad_Lote, Fecha_Fabricacion_Lote, Fecha_Caducidad_Lote, Fecha_Emision_Lote, Fecha_Recibido_Lote, Precio_Total_Lote, ID_Medicamento, Stock_Minimo_Lote, Stock_Maximo_Lote)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissssdiii",
        $data['lote']['descripcion'],
        $data['lote']['estado'],
        $data['lote']['cantidad'],
        $data['lote']['fecha_fabricacion'],
        $data['lote']['fecha_caducidad'],
        $data['lote']['fecha_emision'],
        $data['lote']['fecha_recibido'],
        $data['lote']['precio_total'],
        $id_medicamento,
        $data['lote']['stock_minimo'],
        $data['lote']['stock_maximo']
    );
    $stmt->execute();
    $id_lote = $conn->insert_id;

    // 7. Insertar en lote_presentacion
    foreach ($id_presentaciones as $index => $id_presentacion) {
        $cantidad_pres = $presentaciones[$index]['cantidad_lote'];
        $stmt = $conn->prepare("INSERT INTO lote_presentacion (ID_Lote, ID_Presentacion, Cantidad_Presentacion)
                                VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $id_lote, $id_presentacion, $cantidad_pres);
        $stmt->execute();
    }

    $conn->commit();

    echo json_encode(["success" => true, "ID_Medicamento" => $id_medicamento]);
} catch (Exception $e) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode(["error" => "Error al insertar: " . $e->getMessage()]);
}
