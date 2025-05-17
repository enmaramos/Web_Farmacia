<?php
include_once "Ctrl/head.php";
?>



<?php
include_once "Ctrl/menu.php";
?>




       <!---table JQUERY -->
       <script>
            $(document).ready(function() {
                $('#proveedoresTable').DataTable();
            });
        </script>

<!-- TABLA PROVEEDOR -->
<div class="container mt-4">
    <div class="card p-3 shadow-sm">
        <div class="d-flex justify-content-between mb-3">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarProveedor">
                <i class="fas fa-user-plus"></i> Agregar
            </button>
            <h3 class="text-center flex-grow-1">Lista de Proveedores</h3>
        </div>

        <table id="proveedoresTable" class="table table-striped text-center">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Nombre</th>
                    <th>Laboratorio</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>RUC</th>
                    <th>Estado</th>
                    <th>Ver</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se llenarán los datos de los proveedores con PHP -->
                <?php
                include 'Cnx/conexion.php';
                // Consultar todos los proveedores
                $sql = "SELECT * FROM proveedor";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['ID_Proveedor'] . "</td>";
                        echo "<td>" . $row['Nombre'] . "</td>";
                        echo "<td>" . $row['Laboratorio'] . "</td>";
                        echo "<td>" . $row['Telefono'] . "</td>";
                        echo "<td>" . $row['Email'] . "</td>";
                        echo "<td>" . $row['RUC'] . "</td>";
                        echo "<td>" . ($row['Estado'] == 1 ? "<span class='badge bg-success'>Activo</span>" : "<span class='badge bg-danger'>Inactivo</span>") . "</td>";
                        echo "<td>
                        <button class='btn btn-success btn-sm' data-bs-toggle='modal' data-bs-target='#modalVerProveedor' data-id='" . $row['ID_Proveedor'] . "' title='Ver'>
                            <i class='bx bx-show'></i>
                        </button>
                        </td>";
                        echo "<td>
                        <a href='#' class='btn btn-warning btn-sm text-white' data-bs-toggle='modal' data-bs-target='#modalEditarProveedor' data-id='" . $row['ID_Proveedor'] . "' title='Editar'>
                            <i class='bx bx-edit'></i>
                        </a>
                        </td>";
                        echo "<td>
                        <button class='btn btn-danger btn-sm' title='Eliminar'>
                            <i class='bx bx-trash'></i>
                        </button>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No se encontraron proveedores</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>








<?php
include_once "Ctrl/footer.php";
?>