<?php
include_once "Ctrl/head.php";
?>

<?php
include('../pages/Cnx/conexion.php');

// Obtener estado desde el filtro (por defecto: activos)
$estadoFiltro = isset($_GET['estado']) ? $_GET['estado'] : '1';

// Consulta filtrada
if ($estadoFiltro === '1') {
    $sql = "SELECT * FROM categoria WHERE estado_categoria = 1";
} elseif ($estadoFiltro === '0') {
    $sql = "SELECT * FROM categoria WHERE estado_categoria = 0";
} else {
    $sql = "SELECT * FROM categoria";
}

$result = $conn->query($sql);
?>




<?php
include_once "Ctrl/menu.php";
?>

<!---table JQUERY -->
<script>
    $(document).ready(function() {
        $('#categoriaTable').DataTable();
    });
</script>


<!-- TABLA DE Categoria -->
<div class="container  mt-4">
    <div class="card p-3 shadow-sm">
        <div class="d-flex justify-content-between mb-3">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarCategoria">
                <i class="fas fa-user-plus"></i> Agregar
            </button>
            <h3 class="text-center flex-grow-1">Lista de Categorías</h3>
        </div>

          <!-- Filtro por estado -->
          <div class="mb-3">
                <select id="filtroEstado" class="form-select w-auto d-inline" onchange="filtrarEstado()">
                    <option value="1" <?= ($estadoFiltro == '1') ? 'selected' : '' ?>>Activos</option>
                    <option value="0" <?= ($estadoFiltro == '0') ? 'selected' : '' ?>>Inactivos</option>
                </select>
            </div>

        <table id="categoriaTable" class="display text-center">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
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
            <tr class="categoria" data-estado="<?= $row['estado_categoria'] ?>">
                <td><?= $row['Nombre_Categoria'] ?></td>
                <td><?= $row['Descripcion'] ?></td>
                <td>
                    <?php
                    $estado = $row['estado_categoria'] ?? 1;
                    echo $estado == 1
                        ? "<span class='badge bg-success'>Activo</span>"
                        : "<span class='badge bg-danger'>Inactivo</span>";
                    ?>
                </td>

                <!-- Botón Ver -->
                <td>
                    <button class='btn btn-success VerCategoriaBtn btn-sm'
                        data-bs-toggle='modal'
                        data-bs-target='#modalVerCategoria'
                        data-id='<?= $row['ID_Categoria'] ?>'
                        title="Ver Detalles">
                        <i class='bx bx-show'></i>
                    </button>
                </td>

                <?php if ($estadoFiltro == 1) { ?>
                    <!-- Botón Editar -->
                    <td>
                        <a href='' class='btn btn-warning editarCategoriaBtn btn-sm'
                            data-bs-toggle='modal'
                            data-bs-target='#modalEditarCategoria'
                            data-id='<?= $row['ID_Categoria'] ?>'
                            title="Editar Categoría">
                            <i class='bx bx-edit'></i>
                        </a>
                    </td>
                    <!-- Botón Eliminar -->
                    <td>
                        <button class='btn btn-danger eliminarCategoriaBtn btn-sm'
                            data-id='<?= $row['ID_Categoria'] ?>'
                            title="Eliminar Categoría">
                            <i class='bx bx-trash'></i>
                        </button>
                    </td>
                <?php } ?>

                <?php if ($estadoFiltro == 0) { ?>
                    <!-- Botón Activar -->
                    <td>
                        <button class='btn btn-primary activarCategoriaBtn btn-sm'
                            data-id='<?= $row['ID_Categoria'] ?>'
                            title="Reactivar Categoría">
                            <i class='bx bx-check-circle'></i>
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
function filtrarEstado() {
    var estado = document.getElementById('filtroEstado').value;
    window.location.href = 'categoria.php?estado=' + estado;
}
</script>


<!-- Modal para agregar categoría -->
<div class="modal fade" id="modalAgregarCategoria" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color: #17d5bb;">
                <h5 class="modal-title" id="modalLabel">
                <i class="fas fa-user-plus"></i>Agregar Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <form action="../pages/Ctrl/agregar_categoria.php" method="POST">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row g-3">

                            <!-- Nombre -->
                            <div class="col-md-6">
                                <label for="nombreCategoria" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="nombreCategoria" id="nombreCategoria" placeholder="Ingrese el nombre completo" required>
                            </div>

                            <!-- Descripción (más grande) -->
                            <div class="col-md-12">
                                <label for="Descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" name="Descripcion" id="Descripcion" placeholder="Ingrese la descripción de la categoría" rows="4" required></textarea>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn bg-primary text-white">Guardar Categoría</button>
                </div>
            </form>
        </div>
    </div>
</div>




<!-- Validaciones de los Modales -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let modal = document.getElementById("modalAgregarCategoria");
        let formulario = modal.querySelector("form");

        // Resetear formulario al cerrar el modal con la "X" o el botón Cancelar
        modal.addEventListener("hidden.bs.modal", function() {
            formulario.reset();
        });

        let btnCancelar = modal.querySelector(".btn-secundario");
        if (btnCancelar) {
            btnCancelar.addEventListener("click", function() {
                formulario.reset();
            });
        }

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

        // Verificar si el modal debe abrirse después de un error
        if (sessionStorage.getItem("modalOpen") === "true") {
            var modalBootstrap = new bootstrap.Modal(modal);
            modalBootstrap.show();
            sessionStorage.removeItem("modalOpen");
        }
    });
</script>


<!-- Modal para editar categoría -->
<div class="modal fade" id="modalEditarCategoria" tabindex="-1" aria-labelledby="modalLabelEditar" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color: #17d5bb;">
                <h5 class="modal-title" id="modalLabelEditar">
                <i class='bx bx-edit'></i>Editar Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <form id="formEditarCategoria">
                <div class="modal-body">
                    <input type="hidden" name="idCategoria" id="idCategoria">
                    <div class="container-fluid">
                        <div class="row g-3">

                            <!-- Nombre -->
                            <div class="col-md-6">
                                <label for="editarNombreCategoria" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="editarNombreCategoria" id="editarNombreCategoria" required>
                            </div>

                            <!-- Descripción -->
                            <div class="col-md-12">
                                <label for="editarDescripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" name="editarDescripcion" id="editarDescripcion" rows="4" placeholder="Ingrese la descripción de la categoría" required></textarea>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn bg-primary text-white">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- estilo del aler en el modal editar -->
<style>
    /* Elevar el z-index de los popups de SweetAlert2 */
    .swal2-container {
        z-index: 20000 !important;
    }
</style>


<!-- Modal para ver categoría (con estilo similar a "editar categoría") -->
<div class="modal fade" id="modalVerCategoria" tabindex="-1" aria-labelledby="modalVerCategoriaLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color: #17d5bb;">
                <h5 class="modal-title" id="modalVerCategoriaLabel">
                    <i class="fas fa-eye me-2"></i> Ver Categoría
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row g-3">

                        <!-- Nombre -->
                        <div class="col-md-6">
                            <label for="nombreCategoriaVer" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombreCategoriaVer" disabled>
                        </div>

                        <!-- Descripción -->
                        <div class="col-md-12">
                            <label for="DescripcionVer" class="form-label">Descripción</label>
                            <textarea class="form-control" id="DescripcionVer" rows="4" disabled></textarea>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>





<script src="../js/ver_categoria.js?12345"></script>
<script src="../js/editar_categoria.js?12345"></script>
<script src="../js/baja_categoria.js?12345"></script>
<script src="../js/reactivar_categoria.js?12345"></script>

<?php
include_once "Ctrl/footer.php";
?>