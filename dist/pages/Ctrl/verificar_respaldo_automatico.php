<?php
// verificar_respaldo_automatico.php

date_default_timezone_set('America/Managua');
include '../Cnx/conexion.php';

$horaLimite = "19:00:00"; // 7:00 pm
$ahora = date("H:i:s");
$hoy = date("Y-m-d");

// Verificar si ya existe respaldo de 'sistema' para hoy
$sql = "SELECT COUNT(*) as total FROM respaldos WHERE Fecha = ? AND Origen = 'sistema'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $hoy);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['total'] == 0) {
    // No hay respaldo para hoy, verificar si ya pasamos la hora límite
    if ($ahora >= $horaLimite) {
        // Generar respaldo automático llamando la lógica de respaldo
        // Lo mejor es incluir tu código o llamar un método que lo haga

        // Cambiar variables para respaldo automático
        $nombreArchivo = "respaldo_" . date("Y-m-d_H-i-s") . ".sql";
        $rutaCarpeta = "C:/xampp/htdocs/Web_Farmacia/dist/pages/respaldos/archivos/";
        $rutaCompleta = $rutaCarpeta . $nombreArchivo;

        if (!is_dir($rutaCarpeta)) {
            mkdir($rutaCarpeta, 0777, true);
        }

        $host = "localhost";
        $usuario = "root";
        $contrasena = "";
        $baseDeDatos = "farmacia_san_francisco_javier2";

        $comando = "C:\\xampp\\mysql\\bin\\mysqldump.exe -h $host -u $usuario";
        if (!empty($contrasena)) {
            $comando .= " -p$contrasena";
        }
        $comando .= " $baseDeDatos > \"$rutaCompleta\"";

        exec($comando, $output, $resultCode);

        $estado = "exito";
        if (!file_exists($rutaCompleta) || filesize($rutaCompleta) == 0 || $resultCode !== 0) {
            $estado = "fallido";
            $tamano = "0 KB";
        } else {
            $tamanoBytes = filesize($rutaCompleta);
            $tamano = round($tamanoBytes / 1024, 2) . " KB";
        }

        $fecha = $hoy;
        $hora = $ahora;
        $origen = "sistema";
        $idUsuario = null; // No hay usuario para respaldo automático

        $stmtInsert = $conn->prepare("INSERT INTO respaldos (Fecha, Hora, Archivo, Tamano, Estado, Origen, ID_Usuario)
                                    VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmtInsert->bind_param("ssssssi", $fecha, $hora, $nombreArchivo, $tamano, $estado, $origen, $idUsuario);
        $stmtInsert->execute();
        $stmtInsert->close();

        echo json_encode([
            "estado" => $estado,
            "archivo" => $nombreArchivo,
            "tamano" => $tamano
        ]);
    } else {
        // No es hora aún, no hacer nada
        echo json_encode(["estado" => "no_hora"]);
    }
} else {
    // Ya hay respaldo hoy, no hacer nada
    echo json_encode(["estado" => "ya_existe"]);
}

$stmt->close();
$conn->close();
