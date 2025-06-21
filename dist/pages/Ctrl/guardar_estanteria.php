<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../Cnx/conexion.php');


// Recibir datos del formulario por POST
$nombre = isset($_POST['nombre']) ? $conn->real_escape_string($_POST['nombre']) : '';
$columnas = isset($_POST['columnas']) ? (int)$_POST['columnas'] : 1;
$filas = isset($_POST['filas']) ? (int)$_POST['filas'] : 1;
$subColumnas = isset($_POST['subColumnas']) ? (int)$_POST['subColumnas'] : 1;
$subFilas = isset($_POST['subFilas']) ? (int)$_POST['subFilas'] : 1;
$tipo = isset($_POST['tipo']) && in_array($_POST['tipo'], ['Bodega','Sala']) ? $_POST['tipo'] : 'Sala';

// Validar datos mínimos
if ($nombre == '') {
    echo json_encode(['success' => false, 'message' => 'El nombre es obligatorio.']);
    exit;
}

$sql = "INSERT INTO estanteria (Nombre_Estanteria, Cantidad_Columnas, Cantidad_Filas, SubColumnas, SubFilas, Tipo_Estanteria) 
        VALUES ('$nombre', $columnas, $filas, $subColumnas, $subFilas, '$tipo')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Estantería guardada correctamente.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar: ' . $conn->error]);
}

$conn->close();
