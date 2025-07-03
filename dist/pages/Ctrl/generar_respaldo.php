<?php
// generar_respaldo.php

date_default_timezone_set('America/Managua');
include '../Cnx/conexion.php';

// DATOS
$fecha = date("Y-m-d");
$hora = date("H:i:s");
$nombreArchivo = "respaldo_" . date("Y-m-d_H-i-s") . ".sql";

// RUTA EXACTA A LA CARPETA DONDE SE GUARDARÁ EL ARCHIVO
$rutaCarpeta = "C:/xampp/htdocs/Web_Farmacia/dist/pages/respaldos/archivos/";
$rutaCompleta = $rutaCarpeta . $nombreArchivo;

$estado = "exito";
$origen = "usuario"; // "sistema" si es automático
$idUsuario = 1; // cámbialo si usas sesión dinámica

// Crear carpeta si no existe
if (!is_dir($rutaCarpeta)) {
    mkdir($rutaCarpeta, 0777, true);
}

// Comando mysqldump
$host = "localhost";
$usuario = "root";
$contrasena = "";
$baseDeDatos = "farmacia_san_francisco_javier2";

$comando = "C:\\xampp\\mysql\\bin\\mysqldump.exe -h $host -u $usuario";
if (!empty($contrasena)) {
    $comando .= " -p$contrasena";
}
$comando .= " $baseDeDatos > \"$rutaCompleta\"";

// Ejecutar respaldo
exec($comando, $output, $resultCode);

// Verificar si se creó correctamente
if (!file_exists($rutaCompleta) || filesize($rutaCompleta) == 0 || $resultCode !== 0) {
    $estado = "fallido";
    $tamano = "0 KB";
} else {
    $tamanoBytes = filesize($rutaCompleta);
    $tamano = round($tamanoBytes / 1024, 2) . " KB";
}

// Guardar en base de datos
$stmt = $conn->prepare("INSERT INTO respaldos (Fecha, Hora, Archivo, Tamano, Estado, Origen, ID_Usuario)
                        VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssi", $fecha, $hora, $nombreArchivo, $tamano, $estado, $origen, $idUsuario);
$stmt->execute();
$stmt->close();
$conn->close();

// Respuesta para frontend
echo json_encode([
    "estado" => $estado,
    "archivo" => $nombreArchivo,
    "tamano" => $tamano
]);
?>
