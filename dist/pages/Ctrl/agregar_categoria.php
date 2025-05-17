<?php
include('../Cnx/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreCategoria = $_POST['nombreCategoria'];
    $descripcion = $_POST['Descripcion'];

    // Insertar en la tabla 'categoria'
    $queryCategoria = "INSERT INTO categoria (Nombre_Categoria, Descripcion) VALUES (?, ?)";
    $stmtCategoria = $conn->prepare($queryCategoria);
    $stmtCategoria->bind_param("ss", $nombreCategoria, $descripcion);

    if ($stmtCategoria->execute()) {
        echo "<script>
                alert('Categoría agregada correctamente');
                window.location.href = '../categoria.php';
              </script>";
    } else {
        echo "<script>
                alert('Error al agregar la categoría: " . $stmtCategoria->error . "');
                window.history.back();
              </script>";
    }

    $stmtCategoria->close();
}

$conn->close();
?>
