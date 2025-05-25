<?php
include_once "Ctrl/head.php";
?>


<?php
include('../pages/Cnx/conexion.php');

// Definir el estado por defecto (vacío significa mostrar todos)
$estadoFiltro = isset($_GET['estado']) ? $_GET['estado'] : '1'; // Por defecto, mostrar solo activos

// Consulta dependiendo del estado seleccionado
if ($estadoFiltro == '1') {
    // Vendedores activos
    $query = "SELECT * FROM proveedor WHERE Estado = 1";
} elseif ($estadoFiltro == '0') {
    // Mostrar todos los vendedores inactivos
    $query = "SELECT * FROM proveedor WHERE Estado = 0";
} else {
    // Vendedores activos e inactivos (por si alguien introduce algo inesperado)
    $query = "SELECT * FROM proveedor";
}

$result = $conn->query($query);
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

<?php
$error = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]); // Elimina espacios en blanco

    if (empty($email)) {
        $error = "El campo de correo es obligatorio.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "El correo ingresado no es válido.";
    } else {
        $error = "Correo válido: " . htmlspecialchars($email);
    }
}
?>
<!-- TABLA DE PROVEEDORES -->
<div class="container  mt-4">
    <div class="card p-3 shadow-sm">
        <div class="d-flex justify-content-between mb-3">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarProveedor">
                <i class="fas fa-user-plus"></i> Agregar
            </button>
            <h3 class="text-center flex-grow-1">Lista de Proveedores</h3>
        </div>

        <!-- Filtro de Estado -->
        <div class="mb-3">
            <select id="filtroEstado" class="form-select w-auto" onchange="filtrarEstado()">
                <option value="1" <?php if ($estadoFiltro == '1') echo 'selected'; ?>>Activos</option>
                <option value="0" <?php if ($estadoFiltro == '0') echo 'selected'; ?>>Inactivos</option>
            </select>
        </div>

        <table id="proveedoresTable" class="display text-center">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Laboratorio</th>
                    <th>Telefono</th>
                    <th>Email</th>
                    <th>Estado</th>
                    <th>Ver</th>
                    <?php if ($estadoFiltro == 1) { ?>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    <?php } ?>
                    <?php if ($estadoFiltro == 0) { ?>
                        <th>Activar</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr class="proveedor" data-estado="<?= $row['Estado'] ?>">
                        <td><?= $row['Nombre'] ?></td>
                        <td><?= $row['Laboratorio'] ?></td>
                        <td>(+505) <?= $row['Telefono'] ?></td>
                        <td><?= $row['Email'] ?></td>
                        <td>
                            <?php
                            if ($row['Estado'] == 1) {
                                echo "<span class='badge bg-success'>Activo</span>";
                            } else {
                                echo "<span class='badge bg-danger'>Inactivo</span>";
                            }
                            ?>
                        </td>
                        <!-- Botón Ver -->
                        <td>
                            <button class='btn btn-success VerProveedorBtn btn-sm' data-bs-toggle='modal' data-bs-target='#modalVerProveedor' data-id='<?= $row['ID_Proveedor'] ?>' title="Ver Detalles">
                                <i class='bx bx-show'></i>
                            </button>
                        </td>
                        <?php if ($estadoFiltro == 1) { ?>
                            <!-- Botón Editar (solo para activos) -->
                            <td>
                                <a href='' class='btn btn-warning editarProveedorBtn btn-sm ' data-bs-toggle='modal' data-bs-target='#modalEditarProveedor' data-id='<?= $row['ID_Proveedor'] ?>' title="Editar Proveedor">
                                    <i class='bx bx-edit'></i>
                                </a>
                            </td>
                            <!-- Botón Eliminar (solo para activos) -->
                            <td>
                                <button class='btn btn-danger eliminarProveedorBtn btn-sm' data-id='<?= $row['ID_Proveedor'] ?>' title="Eliminar Proveedor">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>
                        <?php } ?>
                        <?php if ($estadoFiltro == 0) { ?>
                            <!-- Botón Activar (solo para inactivos) -->
                            <td>
                                <button class='btn btn-primary activarProveedorBtn btn-sm' data-id='<?= $row['ID_Proveedor'] ?>' title="Reactivar Proveedor">
                                    <i class='bx bx-user-check'></i>
                                </button>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Función para recargar la página con el filtro aplicado
    function filtrarEstado() {
        var estado = document.getElementById('filtroEstado').value;
        window.location.href = 'proveedores.php?estado=' + estado; // Recargar la página con el filtro en la URL
    }
</script>


<!-- Modal para agregar proveedor -->
<div class="modal fade" id="modalAgregarProveedor" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header  text-white" style="background-color: #17d5bb; color: #2e2e2e;">
                <h5 class="modal-title" id="modalLabel">
                <i class="fas fa-user-plus"></i>Agregar Proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form action="../pages/Ctrl/agregar_proveedor.php" method="POST">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row g-3">

                            <!-- Nombre -->
                            <div class="col-md-6">
                                <label for="nombreProveedor" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="nombreProveedor" id="nombreProveedor" placeholder="Ingrese nombre" required>
                            </div>

                            <!-- Laboratorio -->
                            <div class="col-md-6">
                                <label for="laboratorioProveedor" class="form-label">Laboratorio</label>
                                <input type="text" class="form-control" name="laboratorioProveedor" id="laboratorioProveedor" placeholder="Ingrese laboratorio" required>
                            </div>

                            <!-- Dirección -->
                            <div class="col-md-12">
                                <label for="direccionProveedor" class="form-label">Dirección</label>
                                <input type="text" class="form-control" name="direccionProveedor" placeholder="Ingrese dirección" id="direccionProveedor" required>
                            </div>

                            <!-- Teléfono -->
                            <div class="col-md-6">
                                <label for="telefonoProveedor" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" name="telefonoProveedor" id="telefonoProveedor" required>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="emailProveedor" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" name="emailProveedor" value="<?php echo htmlspecialchars($email); ?>" placeholder="ej: myname@example.com" id="emailVendedor" required>
                            </div>

                            <!-- RUC -->
                            <div class="col-md-6">
                                <label for="rucProveedor" class="form-label">RUC</label>
                                <input type="text" class="form-control" name="rucProveedor" id="rucProveedor" placeholder="Ingrese el RUC del proveedor" required>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn bg-primary text-white">Guardar Proveedor</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Validaciones de los Modales -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        function configurarModal(modalId, telefonoId, formularioId, cancelarClass) {
            let modal = document.getElementById(modalId);
            let formulario = document.getElementById(formularioId);

            // Resetear formulario al cerrar el modal con la "X" o el botón Cancelar
            modal.addEventListener("hidden.bs.modal", function() {
                formulario.reset();
            });

            let btnCancelar = modal.querySelector(cancelarClass);
            if (btnCancelar) {
                btnCancelar.addEventListener("click", function() {
                    formulario.reset();
                });
            }

            // Validación del campo teléfono
            const telefonoInput = document.getElementById(telefonoId);
            telefonoInput.value = "(+505)  ";

            telefonoInput.addEventListener("input", function() {
                let valor = telefonoInput.value;

                if (!valor.startsWith("(+505) ")) {
                    telefonoInput.value = "(+505) ";
                    return;
                }

                let numeros = valor.replace(/\D/g, "").substring(3);

                if (numeros.length > 8) {
                    numeros = numeros.slice(0, 8);
                }

                let telefonoFormateado = "(+505) ";
                if (numeros.length > 4) {
                    telefonoFormateado += numeros.slice(0, 4) + "-" + numeros.slice(4);
                } else {
                    telefonoFormateado += numeros;
                }

                telefonoInput.value = telefonoFormateado;
            });

            telefonoInput.addEventListener("keydown", function(event) {
                if (telefonoInput.selectionStart < 7 && (event.key === "Backspace" || event.key === "Delete")) {
                    event.preventDefault();
                }
            });

            telefonoInput.addEventListener("blur", function() {
                if (telefonoInput.value.trim() === "" || telefonoInput.value === "(+505)") {
                    telefonoInput.value = "(+505) ";
                }
            });

            

        }

        // Configurar ambos modales
        configurarModal("modalAgregarProveedor", "telefonoProveedor", "laboratorioProveedor", "formAgregarProveedor", ".btn-secundario");
        configurarModal("modalEditarProveedor", "editarTelefonoProveedor", "editarlaboratorioProveedor", "formEditarProveedor", ".btn-secondary");

        // Verificar si el modal debe abrirse después de un error
        if (sessionStorage.getItem("modalOpen") === "true") {
            var modalBootstrap = new bootstrap.Modal(document.getElementById("modalEditarProveedor"));
            modalBootstrap.show();
            sessionStorage.removeItem("modalOpen");
        }
    });
</script>

<style>
    /* Elevar el z-index de los popups de SweetAlert2 */
    .swal2-container {
        z-index: 20000 !important;
    }
</style>

<!-- Modal para editar proveedor -->
<div class="modal fade" id="modalEditarProveedor" tabindex="-1" aria-labelledby="modalLabelEditar" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg"> <!-- más ancho -->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #17d5bb; color: #2e2e2e;">
                <h5 class="modal-title" id="modalLabelEditar">
                    <i class='bx bx-edit'></i> Editar Proveedor
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form id="formEditarProveedor">
                <div class="modal-body">
                    <input type="hidden" name="idProveedor" id="idProveedor">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="editarNombreProveedor" class="form-label">Nombre del proveedor</label>
                            <input type="text" class="form-control" name="editarNombreProveedor" id="editarNombreProveedor" placeholder="Ingrese el nombre del proveedor" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editarLaboratorioProveedor" class="form-label">Laboratorio</label>
                            <input type="text" class="form-control" name="editarLaboratorioProveedor" placeholder="Nombre del laboratorio" id="editarLaboratorioProveedor">
                        </div>
                        <div class="col-12">
                            <label for="editarDireccionProveedor" class="form-label">Dirección</label>
                            <input type="text" class="form-control" name="editarDireccionProveedor" id="editarDireccionProveedor" placeholder="Ingrese la dirección del proveedor">
                        </div>
                        <div class="col-md-6">
                            <label for="editarTelefonoProveedor" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" name="editarTelefonoProveedor" id="editarTelefonoProveedor" placeholder="0000-0000">
                        </div>
                        <div class="col-md-6">
                            <label for="editarCorreoProveedor" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" name="editarCorreoProveedor" id="editarCorreoProveedor" placeholder="nombre@ejemplo.com">
                        </div>
                        <div class="col-md-6">
                            <label for="editarRUCProveedor" class="form-label">RUC / NIT</label>
                            <input type="text" class="form-control" name="editarRUCProveedor" id="editarRUCProveedor" placeholder="Ingrese el RUC o NIT" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Modal para ver proveedor -->
<div class="modal fade" id="modalVerProveedor" tabindex="-1" aria-labelledby="modalVerProveedorLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #17d5bb; color: #2e2e2e;">
                <h5 class="modal-title" id="modalVerProveedorLabel">
                    <i class='bx bx-show'></i> Ver Proveedor
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombreProveedorVer" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Laboratorio</label>
                        <input type="text" class="form-control" id="laboratorioProveedorVer" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccionProveedorVer" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefonoProveedorVer" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="emailProveedorVer" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">RUC</label>
                        <input type="text" class="form-control" id="rucProveedorVer" disabled>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>




<script src="../js/ver_proveedor.js?123457"></script>
<script src="../js/editar_proveedor.js?12345"></script>
<script src="../js/baja_proveedor.js?12345"></script>
<script src="../js/reactivar_proveedor.js?12345"></script>




<?php
include_once "Ctrl/footer.php";
?>