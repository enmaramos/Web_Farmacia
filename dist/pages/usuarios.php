<?php
include_once "Ctrl/head.php";
?>

<?php
include('../pages/Cnx/conexion.php');

// Obtener el filtro de estado (si no se pasa, mostrar activos por defecto)
$estadoFiltro = isset($_GET['estado']) ? $_GET['estado'] : '1'; // 1 por defecto para activos

// Consulta dependiendo del estado seleccionado
if ($estadoFiltro == '1') {
    // Mostrar solo usuarios activos
    $sql = "SELECT * FROM usuarios WHERE estado_usuario = 1";
} elseif ($estadoFiltro == '0') {
    // Mostrar solo usuarios inactivos
    $sql = "SELECT * FROM usuarios WHERE estado_usuario = 0";
}

$result = $conn->query($sql);

// Verificar si hay resultados para los inactivos
if ($estadoFiltro == '0' && $result->num_rows == 0) {
    echo "<script>
            alert('No hay usuarios inactivos. Redirigiendo a la vista de activos.');
            window.location.href = 'usuarios.php?estado=1';
          </script>";
}

?>





<?php
include_once "Ctrl/menu.php";
?>


<!---table JQUERY -->
<script>
    $(document).ready(function() {
        $('#usuariosTable').DataTable();
    });
</script>

<!---ESTILOS DE LA TABLA JQUERY --->

<style>
    .container {
        margin-top: 20px;
    }

    .avatar-column img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #ddd;
    }

    .btn-actions {
        display: flex;
        gap: 5px;
    }
</style>

<!-- TABLA USUARIOS -->
<div class="container mt-4">
    <div class="card p-3 shadow-sm">
        <h3 class="text-center mb-3">Lista de Usuarios</h3>

        <!-- Filtro de Estado -->
        <div class="mb-3">
            <label for="filtroEstadoUsuarios" class="form-label">Estado:</label>
            <select id="filtroEstadoUsuarios" class="form-select w-auto d-inline-block" onchange="filtrarUsuarios()">
                <option value="1" <?= $estadoFiltro == '1' ? 'selected' : '' ?>>Activos</option>
                <option value="0" <?= $estadoFiltro == '0' ? 'selected' : '' ?>>Inactivos</option>
            </select>
        </div>

        <table id="usuariosTable" class="table table-striped text-center">
            <thead>
                <tr>
                    <th>Nombre de Usuario</th>
                    <th>Imagen</th>
                    <th>Estado</th>
                    <th>Fecha Creación</th>
                    <th>Último Acceso</th>
                    <th>Ver</th>
                    <?php if ($estadoFiltro === '1') : ?>
                        <th>Editar</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $rutaImagen = !empty($row['Imagen']) ? "../../dist/pages/uploads/" . $row['Imagen'] : "../../dist/pages/uploads/default.jpg";

                        echo "<tr>";
                        echo "<td>" . $row['Nombre_Usuario'] . "</td>";
                        echo "<td><img src='" . $rutaImagen . "' class='rounded-circle' width='50' height='50'></td>";
                        echo "<td>" . ($row['estado_usuario'] == 1 ? "<span class='badge bg-success'>Activo</span>" : "<span class='badge bg-danger'>Inactivo</span>") . "</td>";
                        echo "<td>" . $row['Fecha_Creacion'] . "</td>";
                        echo "<td>" . ($row['Ultimo_Acceso'] ? $row['Ultimo_Acceso'] : 'No disponible') . "</td>";
                        echo "<td>
                            <button class='btn btn-success btn-sm' data-bs-toggle='modal' data-bs-target='#modalVerUsuario' data-id='" . $row['ID_Usuario'] . "' title='Ver'>
                                <i class='bx bx-show'></i>
                            </button>
                        </td>";
                        if ($estadoFiltro === '1') {
                            echo "<td>
                                <a href='#' class='btn btn-warning btn-sm text-white' data-bs-toggle='modal' data-bs-target='#modalEditarUsuario' data-id='" . $row['ID_Usuario'] . "' title='Editar'>
                                    <i class='bx bx-edit'></i>
                                </a>
                            </td>";
                        }
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No se encontraron usuarios</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function filtrarUsuarios() {
        var estado = document.getElementById('filtroEstadoUsuarios').value;
        window.location.href = 'usuarios.php?estado=' + estado;
    }
</script>



<!-- Modal para Ver Usuario -->
<div class="modal fade" id="modalVerUsuario" tabindex="-1" aria-labelledby="modalVerUsuarioLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg"> <!-- Cambio aquí -->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #17d5bb; color: #2e2e2e;"> <!-- Igual al modal de empleado -->
                <h5 class="modal-title" id="modalVerUsuarioLabel">
                <i class='bx bx-show'></i>Ver Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3"> <!-- Grid de Bootstrap -->
                    <div class="col-md-6 text-center">
                        <label for="imagenUsuarioVer" class="form-label">Imagen</label><br>
                        <img id="imagenUsuarioVer" src="" alt="Imagen del Usuario" class="rounded-circle" width="100" height="100">
                    </div>

                    <div class="col-md-6">
                        <label for="nombreUsuarioVer" class="form-label">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="nombreUsuarioVer" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="passwordUsuarioVer" class="form-label">Contraseña</label>
                        <input type="text" class="form-control" id="passwordUsuarioVer" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="vendedorUsuarioVer" class="form-label">Nombre del Vendedor</label>
                        <input type="text" class="form-control" id="vendedorUsuarioVer" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="estadoUsuarioVerInput" class="form-label">Estado</label>
                        <input type="text" class="form-control" id="estadoUsuarioVerInput" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="fechaCreacionUsuarioVer" class="form-label">Fecha de Creación</label>
                        <input type="text" class="form-control" id="fechaCreacionUsuarioVer" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="ultimoAccesoUsuarioVer" class="form-label">Último Acceso</label>
                        <input type="text" class="form-control" id="ultimoAccesoUsuarioVer" disabled>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal para Editar Usuario -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg"> <!-- Modal grande -->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #17d5bb; color: #2e2e2e;">
                <h5 class="modal-title" id="modalEditarUsuarioLabel">
                <i class='bx bx-edit'></i>Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarUsuario" enctype="multipart/form-data">
                    <div class="row g-3">

                        <!-- Imagen -->
                        <div class="col-12 text-center">
                            <label class="form-label">Imagen</label><br>
                            <div id="dropArea" class="border border-dashed p-3 rounded" style="cursor:pointer; display: inline-block;">
                                <img id="previewImagenUsuario" src="#" alt="Vista previa" class="rounded-circle mb-2" style="display:none; max-width: 100px; max-height: 100px;">
                                <div id="textoSubida">Haz clic aquí para subir imagen</div>
                                <input type="file" id="imagenUsuarioInput" accept="image/*" style="display:none;">
                            </div>
                            <input type="hidden" id="imagenActualUsuario" name="Imagen">
                        </div>

                        <!-- Nombre y contraseña -->
                        <div class="col-md-6">
                            <label for="nombreUsuarioEditar" class="form-label">Nombre de Usuario</label>
                            <input type="text" class="form-control" id="nombreUsuarioEditar" required>
                        </div>

                        <div class="col-md-6">
                            <label for="passwordUsuarioEditar" class="form-label">Contraseña</label>
                            <input type="text" class="form-control" id="passwordUsuarioEditar" required>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnActualizarUsuario">Actualizar</button>
            </div>
        </div>
    </div>
</div>





<script src="../js/ver_usuario.js?12346"></script>
<script src="../js/editar_usuario.js?12346"></script>


<?php
include_once "Ctrl/footer.php";
?>