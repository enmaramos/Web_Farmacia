<?php
// Mostrar errores en desarrollo (puedes quitar esto en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../Cnx/conexion.php'); // tu conexión mysqli

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

$conn->begin_transaction();

try {
    // 1. Subir imagen
    $rutaImagen = null;
    if (!empty($_FILES['imagenMedicamento']['name'])) {
        $nombreImagen = basename($_FILES["imagenMedicamento"]["name"]);
        $rutaDestino = "../../assets/img-medicamentos" . $nombreImagen;
        move_uploaded_file($_FILES["imagenMedicamento"]["tmp_name"], $rutaDestino);
        $rutaImagen = $nombreImagen;
    }

    // 2. Insertar en medicamento
    $stmt = $conn->prepare("INSERT INTO medicamento (Nombre_Medicamento, Imagen, Descripcion_Medicamento, IdCategoria, Requiere_Receta, Id_Proveedor)
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiii",
        $_POST['nombreMedicamento'],
        $rutaImagen,
        $_POST['descripcionMedicamento'],
        $_POST['idCategoria'],
        $_POST['requiereReceta'],
        $_POST['idProveedor']
    );
    $stmt->execute();
    $idMedicamento = $conn->insert_id;

    // 3. Insertar formas farmacéuticas
    $formas = $_POST['nuevas_formas'] ?? [];
    $idFormas = [];
    foreach ($formas as $forma) {
        $stmt = $conn->prepare("INSERT INTO medicamento_forma_farmaceutica (ID_Medicamento, Forma_Farmaceutica) VALUES (?, ?)");
        $stmt->bind_param("is", $idMedicamento, $forma);
        $stmt->execute();
        $idFormas[] = $conn->insert_id;
    }

    // 4. Insertar dosis
    $dosis = $_POST['nueva_dosis'];
    $stmt = $conn->prepare("INSERT INTO medicamento_dosis (Dosis, ID_Medicamento) VALUES (?, ?)");
    $stmt->bind_param("si", $dosis, $idMedicamento);
    $stmt->execute();
    $idDosis = $conn->insert_id;

    // 5. Insertar forma_farmaceutica_dosis
    foreach ($idFormas as $idForma) {
        $stmt = $conn->prepare("INSERT INTO forma_farmaceutica_dosis (ID_Forma_Farmaceutica, ID_Dosis) VALUES (?, ?)");
        $stmt->bind_param("ii", $idForma, $idDosis);
        $stmt->execute();
    }

    // 6. Insertar presentaciones
    $tipos = $_POST['tipoPresentacion'];
    $desgloses = $_POST['desglosePresentacion'];
    $cantidades = $_POST['cantidadPresentacion'];
    $precios = $_POST['precioPresentacion'];

    $idPresentaciones = [];
    for ($i = 0; $i < count($tipos); $i++) {
        $stmt = $conn->prepare("INSERT INTO medicamento_presentacion (ID_Medicamento, Tipo_Presentacion, Unidad_Desglose, Total_Presentacion, Precio)
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issid",
            $idMedicamento,
            $tipos[$i],
            $desgloses[$i],
            $cantidades[$i],
            $precios[$i]
        );
        $stmt->execute();
        $idPresentaciones[] = $conn->insert_id;
    }

    // 7. Insertar lote (CORREGIDO aquí el bind_param)
    $stmt = $conn->prepare("INSERT INTO lote (
        Descripcion_Lote, Estado_Lote, Cantidad_Lote, Fecha_Fabricacion_Lote,
        Fecha_Caducidad_Lote, Fecha_Emision_Lote, Fecha_Recibido_Lote,
        Precio_Total_Lote, ID_Medicamento, Stock_Minimo_Lote, Stock_Maximo_Lote
    ) VALUES (?, 'Activo', ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sisssssiii",
        $_POST['descripcionLote'],
        $_POST['cantidadLote'],
        $_POST['fechaFabricacionLote'],
        $_POST['fechaCaducidadLote'],
        $_POST['fechaEmisionLote'],
        $_POST['fechaRecibidoLote'],
        $_POST['precioTotalLote'],
        $idMedicamento,
        $_POST['stockMinimoLote'],
        $_POST['stockMaximoLote']
    );
    $stmt->execute();
    $idLote = $conn->insert_id;

    // 8. Insertar lote_presentacion
    $totales = $_POST['totalPresentacion'];
    for ($i = 0; $i < count($idPresentaciones); $i++) {
        $stmt = $conn->prepare("INSERT INTO lote_presentacion (ID_Lote, ID_Presentacion, Cantidad_Presentacion)
                                VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $idLote, $idPresentaciones[$i], $totales[$i]);
        $stmt->execute();
    }

    $conn->commit();
    echo json_encode(['success' => true, 'message' => '✅ Medicamento registrado correctamente.']);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
