<?php
session_start();
require_once '../Cnx/conexion.php';

$id_usuario = $_SESSION['ID_Usuario'] ?? null;

if (!$id_usuario) {
    echo 'no_existe';
    exit;
}

// Obtener la última apertura
$sql_apertura = "SELECT Fecha_Hora FROM caja 
                 WHERE ID_Usuario = ? AND Tipo = 'apertura' 
                 ORDER BY Fecha_Hora DESC LIMIT 1";
$stmt_apertura = $conn->prepare($sql_apertura);
$stmt_apertura->bind_param("i", $id_usuario);
$stmt_apertura->execute();
$stmt_apertura->bind_result($ultima_apertura);
$stmt_apertura->fetch();
$stmt_apertura->close();

// Obtener el último cierre
$sql_cierre = "SELECT Fecha_Hora FROM caja 
               WHERE ID_Usuario = ? AND Tipo = 'cierre' 
               ORDER BY Fecha_Hora DESC LIMIT 1";
$stmt_cierre = $conn->prepare($sql_cierre);
$stmt_cierre->bind_param("i", $id_usuario);
$stmt_cierre->execute();
$stmt_cierre->bind_result($ultimo_cierre);
$stmt_cierre->fetch();
$stmt_cierre->close();

// Lógica de verificación
if ($ultima_apertura) {
    if (!$ultimo_cierre || $ultima_apertura > $ultimo_cierre) {
        echo 'existe'; // Hay una apertura activa
    } else {
        echo 'no_existe'; // El cierre es igual o posterior a la apertura
    }
} else {
    echo 'no_existe'; // Nunca se ha aperturado caja
}
?>

