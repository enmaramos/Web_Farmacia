<?php
include('../Cnx/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreProveedor = $_POST['nombreProveedor'];
    $laboratorio = $_POST['laboratorioProveedor'];
    $direccion = $_POST['direccionProveedor'];
    $telefono = str_replace("(+505) ", "", $_POST['telefonoProveedor']);
    $email = $_POST['emailProveedor'];
    $ruc = $_POST['rucProveedor'];

    // Validar si el RUC ya existe
    $queryVerificarRUC = "SELECT COUNT(*) FROM proveedor WHERE RUC = ?";
    $stmtVerificarRUC = $conn->prepare($queryVerificarRUC);
    $stmtVerificarRUC->bind_param("s", $ruc);
    $stmtVerificarRUC->execute();
    $stmtVerificarRUC->bind_result($existeRUC);
    $stmtVerificarRUC->fetch();
    $stmtVerificarRUC->close();

    if ($existeRUC > 0) {
        echo "<script>
                alert('Error: El RUC ya está registrado. Ingrese uno diferente.');
                sessionStorage.setItem('modalOpenProveedor', 'true');
                window.location.href = '../proveedores.php';
              </script>";
        exit();
    }

    // Validar si el correo ya existe
    $queryVerificarCorreo = "SELECT COUNT(*) FROM proveedor WHERE Email = ?";
    $stmtVerificarCorreo = $conn->prepare($queryVerificarCorreo);
    $stmtVerificarCorreo->bind_param("s", $email);
    $stmtVerificarCorreo->execute();
    $stmtVerificarCorreo->bind_result($existeCorreo);
    $stmtVerificarCorreo->fetch();
    $stmtVerificarCorreo->close();

    if ($existeCorreo > 0) {
        echo "<script>
                alert('Error: El correo ya está registrado. Ingrese uno diferente.');
                sessionStorage.setItem('modalOpenProveedor', 'true');
                window.location.href = '../proveedores.php';
              </script>";
        exit();
    }

    // Insertar nuevo proveedor
    $queryInsertar = "INSERT INTO proveedor (Nombre, Laboratorio, Direccion, Telefono, Email, RUC) 
                      VALUES (?, ?, ?, ?, ?, ?)";
    $stmtInsertar = $conn->prepare($queryInsertar);
    $stmtInsertar->bind_param("ssssss", $nombreProveedor, $laboratorio, $direccion, $telefono, $email, $ruc);

    if ($stmtInsertar->execute()) {
        echo "<script>
                alert('Proveedor agregado correctamente');
                window.location.href = '../proveedores.php';
              </script>";
    } else {
        echo "<script>
                alert('Error al agregar el proveedor: " . $stmtInsertar->error . "');
                window.history.back();
              </script>";
    }

    $stmtInsertar->close();
}

$conn->close();
?>
