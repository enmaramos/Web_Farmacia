<?php
include_once "Ctrl/head.php";
?>

<?php
include('../pages/Cnx/conexion.php');

// Definir el estado por defecto (vacío significa mostrar todos)
$estadoFiltro = isset($_GET['estado']) ? $_GET['estado'] : '1'; // Por defecto, mostrar solo activos

// Consulta dependiendo del estado seleccionado
if ($estadoFiltro == '1') {
    // Clientes activos
    $query = "SELECT * FROM clientes WHERE Estado = 1";
} elseif ($estadoFiltro == '0') {
    // Mostrar todos los clientes inactivos
    $query = "SELECT * FROM clientes WHERE Estado = 0";
} else {
    // Clientes activos e inactivos (por si alguien introduce algo inesperado)
    $query = "SELECT * FROM clientes";
}

$result = $conn->query($query);
?>



<?php
include_once "Ctrl/menu.php";
?>

  <!---table JQUERY -->
  <script>
            $(document).ready(function () {
    $('#clientesTable').DataTable({
        responsive: true,
        dom: '<"row mb-3"<"col-sm-6"l><"col-sm-6 text-end"f>>rt<"row mt-3"<"col-sm-6"i><"col-sm-6 text-end"p>>'
    });
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

        <!-- TABLA DE Clientes -->
        <div class="container mt-4">
            <div class="card p-3 shadow-sm">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3 gap-2">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarCliente">
                        <i class="fas fa-user-plus"></i> Agregar
                    </button>
                    <h3 class="text-center flex-grow-1">Lista de Clientes</h3>
                </div>

                <!-- Filtro de Estado -->
                <div class="mb-3">
                    <select id="filtroEstado" class="form-select w-auto" onchange="filtrarEstado()">
                        <option value="1" <?php if ($estadoFiltro == '1') echo 'selected'; ?>>Activos</option>
                        <option value="0" <?php if ($estadoFiltro == '0') echo 'selected'; ?>>Inactivos</option>
                    </select>
                </div>

                <div class="table-responsive">
                    <table id="clientesTable" class="display text-center">
                        <thead>
                            <tr>
                                <th>Clientes</th>
                                <th>Género</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
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
                            <?php while ($row = $result->fetch_assoc()) {
                                // Cortar el primer nombre y primer apellido
                                $primerNombre = explode(' ', trim($row['Nombre']))[0];
                                $primerApellido = explode(' ', trim($row['Apellido']))[0];
                                $nombreCompleto = $primerNombre . ' ' . $primerApellido;
                            ?>
                                <tr class="clientes" data-estado="<?= $row['Estado'] ?>">
                                    <td><?= htmlspecialchars($nombreCompleto) ?></td>
                                    <td><?= htmlspecialchars($row['Genero']) ?></td>
                                    <td><?= htmlspecialchars($row['Direccion']) ?></td>
                                    <td>+(505) <?= htmlspecialchars($row['Telefono']) ?></td>
                                    <td>
                                        <?php if ($row['Estado'] == 1): ?>
                                            <span class='badge bg-success'>Activo</span>
                                        <?php else: ?>
                                            <span class='badge bg-danger'>Inactivo</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Botón Ver -->
                                    <td>
                                        <button class='btn btn-success VerClientesBtn btn-sm' data-bs-toggle='modal' data-bs-target='#modalVerClientes' data-id='<?= $row['ID_Cliente'] ?>' title="Ver Detalles">
                                            <i class='fas fa-eye'></i>
                                        </button>
                                    </td>

                                    <?php if ($estadoFiltro == 1) { ?>
                                        <!-- Botón Editar -->
                                        <td>
                                            <a href='' class='btn btn-warning editarClientesBtn btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditarClientes' data-id='<?= $row['ID_Cliente'] ?>' title="Editar Clientes">
                                                <i class='fas fa-edit'></i>
                                            </a>
                                        </td>
                                        <!-- Botón Eliminar -->
                                        <td>
                                            <button class='btn btn-danger eliminarClientesBtn btn-sm' data-id='<?= $row['ID_Cliente'] ?>' title="Eliminar Cliente">
                                                <i class='fas fa-trash-alt'></i>
                                            </button>
                                        </td>
                                    <?php } ?>

                                    <?php if ($estadoFiltro == 0) { ?>
                                        <!-- Botón Activar -->
                                        <td>
                                            <button class='btn btn-primary activarClientesBtn btn-sm' data-id='<?= $row['ID_Cliente'] ?>' title="Reactivar Cliente">
                                                <i class="fas fa-user-check"></i>
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
                window.location.href = 'cliente.php?estado=' + estado; // Recargar la página con el filtro en la URL
            }
        </script>


        <!-- Modal para agregar cliente en el archivo Cliente.php -->
        <div class="modal fade" id="modalAgregarCliente" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header  text-white" style="background-color: #17d5bb; color: #2e2e2e;">
                        <h5 class="modal-title" id="modalLabel">
                        <i class="fas fa-user-plus"></i>Agregar Clientes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <form action="../pages/Ctrl/agregar_cliente.php" method="POST">
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row g-3">
                                    <!-- Nombre -->
                                    <div class="col-md-6">
                                        <label for="nombreCliente" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" name="nombreCliente" id="nombreCliente" placeholder="Ingrese el primer y segundo nombre" required>
                                    </div>

                                    <!-- Apellido -->
                                    <div class="col-md-6">
                                        <label for="apellidoCliente" class="form-label">Apellido</label>
                                        <input type="text" class="form-control" name="apellidoCliente" id="apellidoCliente" placeholder="Ingrese el primer y segundo apellido" required>
                                    </div>

                                    <!-- Cédula -->
                                    <div class="col-md-6">
                                        <label for="cedulaCliente" class="form-label">Cédula</label>
                                        <input type="text" class="form-control" name="cedulaCliente" id="cedulaCliente" placeholder="000-000000-0000X" pattern="[0-9]{3}-[0-9]{6}-[0-9]{4}[A-Z]{1}" title="Formato: 000-000000-0000X" required>
                                    </div>

                                    <!-- Género -->
                                    <div class="col-md-6">
                                        <label for="generoCliente" class="form-label">Género</label>
                                        <select class="form-select" name="generoCliente" id="generoCliente" required>
                                            <option value="">Seleccione género</option>
                                            <option value="Masculino">Masculino</option>
                                            <option value="Femenino">Femenino</option>
                                        </select>
                                    </div>

                                    <!-- Dirección -->
                                    <div class="col-md-12">
                                        <label for="direccionCliente" class="form-label">Dirección</label>
                                        <input type="text" class="form-control" name="direccionCliente" id="direccionCliente" placeholder="Ingrese dirección" required>
                                    </div>

                                    <!-- Teléfono -->
                                    <div class="col-md-6">
                                        <label for="telefonoCliente" class="form-label">Teléfono</label>
                                        <input type="tel" class="form-control" name="telefonoCliente" id="telefonoCliente" placeholder="8888-8888" pattern="[0-9]{4}-[0-9]{4}" title="Formato: 8888-8888" required>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <label for="emailCliente" class="form-label">Correo Electrónico</label>
                                        <input type="email" class="form-control" name="emailCliente" id="emailCliente" placeholder="ejemplo@correo.com" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cliente</button>
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

                // Configurar modal de clientes
configurarModal("modalAgregarCliente", "telefonoCliente", "cedulaCliente", "generoCliente", "formAgregarCliente", ".btn-secundario");
configurarModal("modalEditarClientes", "editarTelefonoCliente", "editarCedulaCliente", "editarSexoCliente", "formEditarCliente", ".btn-secondary");


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

<!-- Modal para editar cliente -->
<div class="modal fade" id="modalEditarClientes" tabindex="-1" aria-labelledby="modalLabelEditar" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #17d5bb; color: #2e2e2e;">
                <h5 class="modal-title" id="modalLabelEditar">
                <i class='bx bx-edit'></i>Editar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form id="formEditarCliente">
                <div class="modal-body">
                    <input type="hidden" name="idCliente" id="idCliente">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="editarNombreCliente" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="editarNombreCliente" placeholder="Ingrese el primer y segundo nombre" id="editarNombreCliente" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editarApellidoCliente" class="form-label">Apellido</label>
                            <input type="text" class="form-control" name="editarApellidoCliente" placeholder="Ingrese el primer y segundo apellido" id="editarApellidoCliente" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editarCedulaCliente" class="form-label">N° Cédula</label>
                            <input type="text" class="form-control" name="editarCedulaCliente" placeholder="000-000000-0000X" id="editarCedulaCliente" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editarTelefonoCliente" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" name="editarTelefonoCliente" id="editarTelefonoCliente">
                        </div>
                        <div class="col-md-6">
                            <label for="editarDireccionCliente" class="form-label">Dirección</label>
                            <input type="text" class="form-control" name="editarDireccionCliente" placeholder="Ingrese su dirección" id="editarDireccionCliente">
                        </div>
                        <div class="col-md-6">
                            <label for="editarSexoCliente" class="form-label">Sexo</label>
                            <select class="form-select" name="editarSexoCliente" id="editarSexoCliente" required>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="editarCorreoCliente" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" name="editarCorreoCliente" placeholder="ej: nombre@ejemplo.com" id="editarCorreoCliente" required>
                        </div>
                        <!-- Puedes agregar más campos específicos para clientes si es necesario -->
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

<!-- Modal para ver cliente -->
<div class="modal fade" id="modalVerClientes" tabindex="-1" aria-labelledby="modalVerClienteLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #17d5bb; color: #2e2e2e;">
                <h5 class="modal-title" id="modalVerClienteLabel">
                    <i class='bx bx-show'></i> Ver Cliente
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombreClienteVer" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellidoClienteVer" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">N° Cédula</label>
                        <input type="text" class="form-control" id="cedulaClienteVer" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefonoClienteVer" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccionClienteVer" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sexo</label>
                        <input type="text" class="form-control" id="sexoClienteVer" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="emailClienteVer" disabled>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>



<script src="../js/ver_cliente.js?123457"></script>
<script src="../js/editar_cliente.js?12345"></script>
<script src="../js/baja_cliente.js?12345"></script>
<script src="../js/reactivar_cliente.js?12345"></script>

<?php
include_once "Ctrl/footer.php";
?>