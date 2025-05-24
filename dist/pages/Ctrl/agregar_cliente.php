<?php
include('../Cnx/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreCliente = $_POST['nombreCliente'];
    $apellidoCliente = $_POST['apellidoCliente'];
    $cedulaCliente = $_POST['cedulaCliente'];
    $telefonoCliente = str_replace("(+505) ", "", $_POST['telefonoCliente']);
    $direccionCliente = $_POST['direccionCliente'];
    $generoCliente = $_POST['generoCliente'];
    $emailCliente = $_POST['emailCliente'];

    // Verificar si la cédula ya existe en la tabla 'cliente'
    $queryVerificarCedula = "SELECT COUNT(*) FROM clientes WHERE Cedula = ?";
    $stmtVerificarCedula = $conn->prepare($queryVerificarCedula);
    $stmtVerificarCedula->bind_param("s", $cedulaCliente);
    $stmtVerificarCedula->execute();
    $stmtVerificarCedula->bind_result($existeCedula);
    $stmtVerificarCedula->fetch();
    $stmtVerificarCedula->close();

    if ($existeCedula > 0) {
        echo "<script> 
                alert('Error: La cédula ya está registrada. Por favor, ingrese una cédula diferente.');
                sessionStorage.setItem('modalOpen', 'true');
                window.location.href = '../../cliente.php';
              </script>";
        exit();
    }

    // Verificar si el correo ya existe en la tabla 'cliente'
    $queryVerificarCorreo = "SELECT COUNT(*) FROM clientes WHERE Email = ?";
    $stmtVerificarCorreo = $conn->prepare($queryVerificarCorreo);
    $stmtVerificarCorreo->bind_param("s", $emailCliente);
    $stmtVerificarCorreo->execute();
    $stmtVerificarCorreo->bind_result($existeCorreo);
    $stmtVerificarCorreo->fetch();
    $stmtVerificarCorreo->close();

    if ($existeCorreo > 0) {
        echo "<script> 
                alert('Error: El correo ya está registrado. Por favor, ingrese un correo diferente.');
                sessionStorage.setItem('modalOpen', 'true');
                window.location.href = '../../cliente.php';
              </script>";
        exit();
    }

    // Insertar en la tabla 'cliente'
    $queryCliente = "INSERT INTO clientes (Nombre, Apellido, Cedula, Telefono, Direccion, Genero, Email) 
                     VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmtCliente = $conn->prepare($queryCliente);
    $stmtCliente->bind_param("sssssss", $nombreCliente, $apellidoCliente, $cedulaCliente, $telefonoCliente, $direccionCliente, $generoCliente, $emailCliente);

    if ($stmtCliente->execute()) {
        echo "<script>
                alert('Cliente agregado correctamente.');
                window.location.href = '../cliente.php';
              </script>";
    } else {
        echo "<script>
                alert('Error al agregar el cliente: " . $stmtCliente->error . "');
                window.history.back();
              </script>";
    }

    $stmtCliente->close();
}

$conn->close();
?>
