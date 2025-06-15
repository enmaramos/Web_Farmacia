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
    $query = "SELECT * FROM vendedor WHERE Estado = 1";
} elseif ($estadoFiltro == '0') {
    // Mostrar todos los vendedores inactivos
    $query = "SELECT * FROM vendedor WHERE Estado = 0";
} else {
    // Vendedores activos e inactivos (por si alguien introduce algo inesperado)
    $query = "SELECT * FROM vendedor";
}

$result = $conn->query($query);
?>


<?php
include_once "Ctrl/menu.php";
?>



<!---table JQUERY -->
<script>
    $(document).ready(function() {
        $('#vendedoresTable').DataTable();
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
<!-- TABLA DE VENDEDORES -->
<div class="container  mt-4">
    <div class="card p-3 shadow-sm">
        <div class="d-flex justify-content-between mb-3">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarVendedor">
                <i class="fas fa-user-plus"></i> Agregar
            </button>
            <h3 class="text-center flex-grow-1">Lista de Empleados</h3>
        </div>

        <!-- Filtro de Estado -->
        <div class="mb-3">
            <select id="filtroEstado" class="form-select w-auto" onchange="filtrarEstado()">
                <option value="1" <?php if ($estadoFiltro == '1') echo 'selected'; ?>>Activos</option>
                <option value="0" <?php if ($estadoFiltro == '0') echo 'selected'; ?>>Inactivos</option>
            </select>
        </div>

        <div class="table-responsive">
            <table id="vendedoresTable" class="display text-center">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Correo Electrónico</th>
                        <th>Rol</th>
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
                        <tr class="vendedor" data-estado="<?= $row['Estado'] ?>">
                            <td><?= explode(' ', $row['Nombre'])[0] . ' ' . explode(' ', $row['Apellido'])[0] ?></td>
                            <td>(+505) <?= $row['Telefono'] ?></td>
                            <td><?= $row['Email'] ?></td>
                            <td>
                                <?php
                                switch ($row['ID_Rol']) {
                                    case 1:
                                        echo "Administrador";
                                        break;
                                    case 2:
                                        echo "Vendedor";
                                        break;
                                    case 3:
                                        echo "Bodeguero";
                                        break;
                                    default:
                                        echo "Desconocido";
                                        break;
                                }

                                ?>
                            </td>
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
                                <button class='btn btn-success VerVendedorBtn btn-sm' data-bs-toggle='modal' data-bs-target='#modalVerVendedor' data-id='<?= $row['ID_Vendedor'] ?>' title="Ver Detalles">
                                    <i class='bx bx-show'></i>
                                </button>
                            </td>
                            <?php if ($estadoFiltro == 1) { ?>
                                <!-- Botón Editar (solo para activos) -->
                                <td>
                                    <a href='' class='btn btn-warning editarVendedorBtn btn-sm ' data-bs-toggle='modal' data-bs-target='#modalEditarVendedor' data-id='<?= $row['ID_Vendedor'] ?>' title="Editar Vendedor">
                                        <i class='bx bx-edit'></i>
                                    </a>
                                </td>
                                <!-- Botón Eliminar (solo para activos) -->
                                <td>
                                    <button class='btn btn-danger eliminarVendedorBtn btn-sm' data-id='<?= $row['ID_Vendedor'] ?>' title="Eliminar Vendedor">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </td>
                            <?php } ?>
                            <?php if ($estadoFiltro == 0) { ?>
                                <!-- Botón Activar (solo para inactivos) -->
                                <td>
                                    <button class='btn btn-primary activarVendedorBtn btn-sm' data-id='<?= $row['ID_Vendedor'] ?>' title="Reactivar Vendedor">
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
</div>

<script>
    // Función para recargar la página con el filtro aplicado
    function filtrarEstado() {
        var estado = document.getElementById('filtroEstado').value;
        window.location.href = 'empleado.php?estado=' + estado; // Recargar la página con el filtro en la URL
    }
</script>


<!-- Modal para agregar empleado -->
<div class="modal fade" id="modalAgregarVendedor" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header  text-white" style="background-color: #17d5bb; color: #2e2e2e;">
                <h5 class="modal-title" id="modalLabel">
                <i class="fas fa-user-plus"></i>Agregar Empleado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form action="../pages/Ctrl/agregar_empleado.php" method="POST">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row g-3">

                            <!-- Nombre -->
                            <div class="col-md-6">
                                <label for="nombreVendedor" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="nombreVendedor" id="nombreVendedor" placeholder="Primer y segundo nombre" required>
                            </div>

                            <!-- Apellido -->
                            <div class="col-md-6">
                                <label for="apellidoVendedor" class="form-label">Apellido</label>
                                <input type="text" class="form-control" name="apellidoVendedor" id="apellidoVendedor" placeholder="Primer y segundo apellido" required>
                            </div>

                            <!-- Cédula -->
                            <div class="col-md-6">
                                <label for="cedulaVendedor" class="form-label">N° Cédula</label>
                                <input type="text" class="form-control" name="cedulaVendedor" placeholder="000-000000-0000X" id="cedulaVendedor" required>
                            </div>

                            <!-- Teléfono -->
                            <div class="col-md-6">
                                <label for="telefonoVendedor" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" name="telefonoVendedor" id="telefonoVendedor" required>
                            </div>

                            <!-- Dirección -->
                            <div class="col-md-12">
                                <label for="direccionVendedor" class="form-label">Dirección</label>
                                <input type="text" class="form-control" name="direccionVendedor" placeholder="Ingrese dirección" id="direccionVendedor" required>
                            </div>

                            <!-- Sexo -->
                            <div class="col-md-6">
                                <label for="sexoVendedor" class="form-label">Sexo</label>
                                <select class="form-select" name="sexoVendedor" id="sexoVendedor" required>
                                    <option value="H">Masculino</option>
                                    <option value="M">Femenino</option>
                                </select>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="emailVendedor" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" name="emailVendedor" value="<?php echo htmlspecialchars($email); ?>" placeholder="ej: myname@example.com" id="emailVendedor" required>
                            </div>

                            <!-- Rol -->
                            <div class="col-md-6">
                                <label for="rolVendedor" class="form-label">Rol</label>
                                <select class="form-select" name="rolVendedor" id="rolVendedor" required>
                                    <option value="1">Vendedor</option>
                                    <option value="2">Administrador</option>
                                    <option value="3">Bodeguero</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn bg-primary text-white">Guardar Empleado</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Validaciones de los Modales -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        function configurarModal(modalId, telefonoId, cedulaId, formularioId, cancelarClass) {
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

            // Validación del campo cédula
            const cedulaInput = document.getElementById(cedulaId);

            cedulaInput.addEventListener("input", function() {
                let valor = cedulaInput.value.toUpperCase(); // Convertir a mayúsculas
                let numeros = valor.replace(/\D/g, ""); // Extraer solo números
                let letraFinal = valor.match(/[A-Z]$/) ? valor.match(/[A-Z]$/)[0] : ""; // Extraer la última letra si es mayúscula

                // Evitar que el usuario escriba letras antes de los números
                if (valor.length > 0 && valor[0].match(/[A-Z]/)) {
                    cedulaInput.value = "";
                    return;
                }

                // Limitar a los primeros 15 números
                if (numeros.length > 15) {
                    numeros = numeros.slice(0, 15);
                }

                // Aplicar el formato ###-######-###X
                let cedulaFormateada = "";
                if (numeros.length > 3) {
                    cedulaFormateada += numeros.slice(0, 3) + "-";
                    if (numeros.length > 9) {
                        cedulaFormateada += numeros.slice(3, 9) + "-";
                        cedulaFormateada += numeros.slice(9);
                    } else {
                        cedulaFormateada += numeros.slice(3);
                    }
                } else {
                    cedulaFormateada += numeros;
                }

                // Agregar la última letra si ya está presente
                if (letraFinal) {
                    cedulaFormateada += letraFinal;
                }

                cedulaInput.value = cedulaFormateada;
            });

            // Evitar caracteres incorrectos al escribir
            cedulaInput.addEventListener("keydown", function(event) {
                let valor = cedulaInput.value;

                // Permitir Backspace, Delete y teclas de navegación
                if (["Backspace", "Delete", "ArrowLeft", "ArrowRight", "Tab"].includes(event.key)) {
                    return;
                }

                // No permitir más de 16 caracteres
                if (valor.length >= 16) {
                    event.preventDefault();
                    return;
                }

                // Evitar letras antes de los números
                if (valor.length === 0 && event.key.match(/[A-Za-z]/)) {
                    event.preventDefault();
                }

                // Evitar números en la última posición
                if (valor.length === 15 && event.key.match(/\d/)) {
                    event.preventDefault();
                }
            });
        }

        // Configurar ambos modales
        configurarModal("modalAgregarVendedor", "telefonoVendedor", "cedulaVendedor", "formAgregarVendedor", ".btn-secundario");
        configurarModal("modalEditarVendedor", "editarTelefonoVendedor", "editarCedulaVendedor", "formEditarVendedor", ".btn-secondary");

        // Verificar si el modal debe abrirse después de un error
        if (sessionStorage.getItem("modalOpen") === "true") {
            var modalBootstrap = new bootstrap.Modal(document.getElementById("modalEditarVendedor"));
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

<!-- Modal para editar empleado -->
<div class="modal fade" id="modalEditarVendedor" tabindex="-1" aria-labelledby="modalLabelEditar" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg"> <!-- más ancho -->
        <div class="modal-content">
            <div class="modal-header " style="background-color: #17d5bb; color: #2e2e2e;">
                <h5 class="modal-title" id="modalLabelEditar">
                <i class='bx bx-edit'></i>Editar Empleado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form id="formEditarVendedor">
                <div class="modal-body">
                    <input type="hidden" name="idVendedor" id="idVendedor">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="editarNombreVendedor" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="editarNombreVendedor" placeholder="Ingrese el primer y segundo nombre" id="editarNombreVendedor" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editarApellidoVendedor" class="form-label">Apellido</label>
                            <input type="text" class="form-control" name="editarApellidoVendedor" placeholder="Ingrese el primer y segundo apellido" id="editarApellidoVendedor" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editarCedulaVendedor" class="form-label">N° Cédula</label>
                            <input type="text" class="form-control" name="editarCedulaVendedor" placeholder="000-000000-0000X" id="editarCedulaVendedor" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editarTelefonoVendedor" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" name="editarTelefonoVendedor" id="editarTelefonoVendedor">
                        </div>
                        <div class="col-md-6">
                            <label for="editarDireccionVendedor" class="form-label">Dirección</label>
                            <input type="text" class="form-control" name="editarDireccionVendedor" placeholder="Ingrese su dirección" id="editarDireccionVendedor">
                        </div>
                        <div class="col-md-6">
                            <label for="editarSexoVendedor" class="form-label">Sexo</label>
                            <select class="form-select" name="editarSexoVendedor" id="editarSexoVendedor" required>
                                <option value="H">Masculino</option>
                                <option value="M">Femenino</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="editarCorreoVendedor" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" name="editarCorreoVendedor" placeholder="ej: nombre@ejemplo.com" id="editarCorreoVendedor" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editarRolVendedor" class="form-label">Rol</label>
                            <select class="form-select" name="editarRolVendedor" id="editarRolVendedor" required>
                                <option value="2">Empleado</option>
                                <option value="1">Administrador</option>
                                <option value="3">Bodeguero</option>
                            </select>
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


<!-- Modal para ver empleado -->
<div class="modal fade" id="modalVerVendedor" tabindex="-1" aria-labelledby="modalVerVendedorLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #17d5bb; color: #2e2e2e;">
                <h5 class="modal-title" id="modalVerVendedorLabel">
                <i class='bx bx-show'></i>Ver Empleado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombreVendedorVer" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellidoVendedorVer" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">N° Cédula</label>
                        <input type="text" class="form-control" id="cedulaVendedorVer" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefonoVendedorVer" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccionVendedorVer" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sexo</label>
                        <input type="text" class="form-control" id="sexoVendedorVer" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="emailVendedorVer" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Rol</label>
                        <input type="text" class="form-control" id="rolVendedorVer" disabled>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>



<script src="../js/ver_empleados.js?123457"></script>
<script src="../js/editar_empleado.js?12345"></script>
<script src="../js/baja_empleado.js?12345"></script>
<script src="../js/reactivar_empleado.js?12345"></script>




<?php
include_once "Ctrl/footer.php";
?>