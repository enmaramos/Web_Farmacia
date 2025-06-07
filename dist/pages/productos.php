<?php
include_once "Ctrl/head.php";

include('../pages/Cnx/conexion.php');

//llamdo de medicamentos en el contenedor 

$queryCategorias = "SELECT ID_Categoria, Nombre_Categoria FROM categoria";
$resultCategorias = $conn->query($queryCategorias);

$queryProveedores = "SELECT ID_Proveedor, Nombre AS Nombre_Proveedor FROM proveedor";
$resultProveedores = $conn->query($queryProveedores);

// Definir el estado por defecto (vacío significa mostrar todos)
$estadoFiltro = isset($_GET['estado']) ? $_GET['estado'] : '1'; // Por defecto, mostrar solo activos

$sql = "SELECT DISTINCT Forma_Farmaceutica FROM medicamento_forma_farmaceutica";
$resultado_formas = $conn->query($sql);

// Validar errores en la consulta
if (!$resultado_formas) {
    die("Error en la consulta: " . $conn->error);
}

// Consulta dependiendo del estado seleccionado
if ($estadoFiltro == '1') {
    // Vendedores activos
    $query = "SELECT * FROM medicamento WHERE Estado = 1";
} elseif ($estadoFiltro == '0') {
    // Mostrar todos los vendedores inactivos
    $query = "SELECT * FROM medicamento WHERE Estado = 0";
} else {
    // Vendedores activos e inactivos (por si alguien introduce algo inesperado)
    $query = "SELECT * FROM medicamento";
}

$result = $conn->query($query);

?>







<?php
include_once "Ctrl/menu.php";
?>




<!-- Estilos CSS específicos para galería -->
<style>
    .medicamento-item {
        flex: 0 0 auto;
        width: 20%;
        /* 5 columnas */
        max-width: 20%;
        padding: 0.5rem;
    }

    @media (max-width: 1200px) {
        .medicamento-item {
            width: 25%;
            max-width: 25%;
        }
    }

    @media (max-width: 992px) {
        .medicamento-item {
            width: 33.33%;
            max-width: 33.33%;
        }
    }

    @media (max-width: 768px) {
        .medicamento-item {
            width: 50%;
            max-width: 50%;
        }
    }

    @media (max-width: 576px) {
        .medicamento-item {
            width: 100%;
            max-width: 100%;
        }
    }
</style>

<!----------------------------------------------- GALERÍA DE MEDICAMENTOS --------------------------------------------------->
<div class="container-xxl flex-grow-1 container-p-y mt-1">
    <div class="card p-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarMedicamento">
                <i class="fas fa-user-plus"></i> Agregar
            </button>
            <h3 class="text-center flex-grow-1 mb-0">Lista de Medicamentos</h3>
        </div>

        <!-- Filtro Activo/Inactivo y Buscador -->
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
            <div class="d-flex align-items-center gap-2">
                <select id="filtroEstado" class="form-select form-select-sm" onchange="filtrarEstado()" style="width: auto;">
                    <option value="1" <?php if ($estadoFiltro == '1') echo 'selected'; ?>>Activos</option>
                    <option value="0" <?php if ($estadoFiltro == '0') echo 'selected'; ?>>Inactivos</option>
                </select>
            </div>
            <div>
                <input type="search" id="buscadorMedicamento" class="form-control form-control-sm" placeholder="Buscar..." aria-controls="productosTable" onkeyup="filtrarPorNombre()" style="width: 200px;">
            </div>
        </div>

        <!-- Galería de Medicamentos -->
        <div class="d-flex flex-wrap justify-content-start" id="galeriaMedicamentos">
            <?php while ($row = $result->fetch_assoc()) {
                if ($row['Estado'] != $estadoFiltro) continue;

                $directorio = "../../dist/assets/img-medicamentos/";
                $nombreImagen = pathinfo($row['Imagen'], PATHINFO_FILENAME);
                $formatos = ['jpg', 'png', 'jpeg', 'gif', 'webp'];
                $rutaImagen = $directorio . "default.jpg";

                foreach ($formatos as $ext) {
                    if (file_exists($directorio . $nombreImagen . "." . $ext)) {
                        $rutaImagen = $directorio . $nombreImagen . "." . $ext;
                        break;
                    }
                }
            ?>
                <div class="medicamento-item" data-nombre="<?= strtolower($row['Nombre_Medicamento']) ?>">
                    <div class="card h-100 shadow-sm border border-1">
                        <div class="card-header text-center fw-bold">
                            <?= htmlspecialchars($row['Nombre_Medicamento']) ?>
                        </div>
                        <div class="card-body p-2 text-center">
                            <img src="<?= $rutaImagen ?>"
                                class="card-img-top img-fluid rounded imagenMedicamentoCard"
                                alt="Imagen Medicamento"
                                style="height: 150px; object-fit: cover; cursor: pointer;"
                                data-bs-toggle="modal"
                                data-bs-target="#modalVerMedicamento"
                                data-id="<?= $row['ID_Medicamento'] ?>">
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>


<!-- Script para Buscar medicamento filtro de nombre -->
<script>
    function filtrarPorNombre() {
        const input = document.getElementById('buscadorMedicamento');
        const filtro = input.value.toLowerCase();
        const items = document.querySelectorAll('.medicamento-item');

        items.forEach(item => {
            const nombre = item.getAttribute('data-nombre');
            item.style.display = nombre.includes(filtro) ? 'block' : 'none';
        });
    }

    function filtrarEstado() {
        const estado = document.getElementById('filtroEstado').value;
        const url = new URL(window.location.href);
        url.searchParams.set('estado', estado);
        window.location.href = url.toString();
    }
</script>


<!-- Modal para agregar medicamento -->
<div class="modal fade" id="modalAgregarMedicamento" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-3 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" style="color: black;">Agregar Medicamento Completo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <form action="../pages/Ctrl/agregar_medicamento_completo.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs mb-3" id="medicamentoTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="medicamento-tab" data-bs-toggle="tab" data-bs-target="#medicamento" type="button">Medicamento</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="lote-tab" data-bs-toggle="tab" data-bs-target="#lote" type="button">Lote</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="forma-tab" data-bs-toggle="tab" data-bs-target="#forma" type="button">Forma Farmacéutica</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="presentacion-tab" data-bs-toggle="tab" data-bs-target="#presentacion" type="button">Presentación</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="dosis-tab" data-bs-toggle="tab" data-bs-target="#dosis" type="button">Dosis</button>
                        </li>

                        <!-- Botón totalmente a la derecha -->
                        <div class="ms-auto">
                            <a href="pendientes_medicamentos.php" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-clock-history"></i> Pendientes
                            </a>
                        </div>
                    </ul>


                    <div class="tab-content" id="medicamentoTabsContent">
                        <!-- Medicamento -->
                        <div class="tab-pane fade show active" id="medicamento" role="tabpanel">
                            <div class="row g-4">
                                <!-- Imagen + Laboratorio/Marca -->
                                <div class="col-md-4">
                                    <label for="imagenMedicamento" class="form-label">Imagen del Medicamento</label>
                                    <div class="border rounded d-flex align-items-center justify-content-center p-3 mb-3"
                                        style="height: 220px; cursor: pointer; background-color: #f8f9fa;"
                                        onclick="document.getElementById('imagenMedicamento').click()">
                                        <img id="imagePreview" class="img-fluid h-100" style="display: none; object-fit: contain;" />
                                        <span id="imageNote" class="text-muted">Selecciona una imagen</span>
                                    </div>
                                    <input type="file" name="imagenMedicamento" id="imagenMedicamento" accept="image/*"
                                        onchange="previewImage(event)" style="display: none;" required>

                                    <label for="marcaMedicamento" class="form-label">Laboratorio / Marca</label>
                                    <input type="text" class="form-control" name="marcaMedicamento" id="marcaMedicamento" readonly placeholder="Se completa automáticamente">
                                </div>

                                <!-- Datos del medicamento -->
                                <div class="col-md-8">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="nombreMedicamento" class="form-label">Nombre</label>
                                            <input type="text" class="form-control" name="nombreMedicamento" id="nombreMedicamento" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="requiereReceta" class="form-label">¿Requiere Receta?</label>
                                            <select class="form-select" name="requiereReceta" id="requiereReceta" required>
                                                <option value="1">Sí</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>

                                        <!-- Proveedor con ícono -->
                                        <div class="col-md-6">
                                            <label for="idProveedor" class="form-label">Proveedor</label>
                                            <div class="input-group">
                                                <select class="form-select" name="idProveedor" id="idProveedor" required>
                                                    <option value="">Seleccione un proveedor</option>
                                                    <?php while ($row = $resultProveedores->fetch_assoc()) {
                                                        echo "<option value='" . $row['ID_Proveedor'] . "'>" . $row['Nombre_Proveedor'] . "</option>";
                                                    } ?>
                                                </select>
                                                <button class="btn btn-outline-secondary" type="button" onclick="agregarProveedor()" title="Agregar proveedor">
                                                    <i class="bi bi-person-plus"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Categoría con ícono -->
                                        <div class="col-md-6">
                                            <label for="idCategoria" class="form-label">Categoría</label>
                                            <div class="input-group">
                                                <select class="form-select" name="idCategoria" id="idCategoria" required>
                                                    <option value="">Seleccione una categoría</option>
                                                    <?php while ($row = $resultCategorias->fetch_assoc()) {
                                                        echo "<option value='" . $row['ID_Categoria'] . "'>" . $row['Nombre_Categoria'] . "</option>";
                                                    } ?>
                                                </select>
                                                <button class="btn btn-outline-secondary" type="button" onclick="agregarCategoria()" title="Agregar categoría">
                                                    <i class="bi bi-tags"></i>
                                                </button>
                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <label for="descripcionMedicamento" class="form-label">Descripción</label>
                                            <textarea class="form-control" name="descripcionMedicamento" id="descripcionMedicamento" placeholder="Descripción detallada..." rows="3" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- script de agregar medicamento -->
                        <script>
                            function previewImage(event) {
                                const file = event.target.files[0];
                                const preview = document.getElementById('imagePreview');
                                const note = document.getElementById('imageNote');

                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        preview.src = e.target.result;
                                        preview.style.display = 'block';
                                        note.style.display = 'none';
                                    };
                                    reader.readAsDataURL(file);
                                } else {
                                    preview.style.display = 'none';
                                    note.style.display = 'block';
                                }
                            }

                            function agregarProveedor() {
                                alert("Aquí puedes abrir un modal o redirigir a 'Agregar proveedor'.");
                            }

                            function agregarCategoria() {
                                alert("Aquí puedes abrir un modal o redirigir a 'Agregar categoría'.");
                            }
                        </script>



                        <!-- Lote -->
                        <div class="tab-pane fade" id="lote" role="tabpanel">
                            <div class="row g-3">
                                <!-- Fila 1: Fechas de Recepción y Emisión -->
                                <div class="col-md-6">
                                    <label for="fechaRecibidoLote" class="form-label">Fecha de Recepción</label>
                                    <input type="datetime-local" class="form-control" name="fechaRecibidoLote" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="fechaEmisionLote" class="form-label">Fecha de Emisión</label>
                                    <input type="datetime-local" class="form-control" name="fechaEmisionLote" required>
                                </div>

                                <!-- Fila 2: Fechas de Fabricación y Caducidad -->
                                <div class="col-md-6">
                                    <label for="fechaFabricacionLote" class="form-label">Fecha de Fabricación</label>
                                    <input type="datetime-local" class="form-control" name="fechaFabricacionLote" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="fechaCaducidadLote" class="form-label">Fecha de Caducidad</label>
                                    <input type="datetime-local" class="form-control" name="fechaCaducidadLote" required>
                                </div>

                                <!-- Fila 3: Cantidad y Precio Total -->
                                <div class="col-md-6">
                                    <label for="cantidadLote" class="form-label">Cantidad</label>
                                    <input type="number" class="form-control" name="cantidadLote" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="precioTotalLote" class="form-label">Precio Total</label>
                                    <input type="number" class="form-control" step="0.01" name="precioTotalLote" required>
                                </div>

                                <!-- Fila 4: Stock Mínimo y Máximo -->
                                <div class="col-md-6">
                                    <label for="stockMinimoLote" class="form-label">Stock Mínimo</label>
                                    <input type="number" class="form-control" name="stockMinimoLote" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="stockMaximoLote" class="form-label">Stock Máximo</label>
                                    <input type="number" class="form-control" name="stockMaximoLote" required>
                                </div>

                                <!-- Fila 5: Descripción del Lote (col-12 y más grande) -->
                                <div class="col-12">
                                    <label for="descripcionLote" class="form-label">Descripción del Lote</label>
                                    <textarea class="form-control" name="descripcionLote" rows="3" placeholder="Descripción detallada..." required></textarea>
                                </div>
                            </div>
                        </div>


                        <!-- Pestaña FORMAS FARMACÉUTICAS -->
                        <div class="tab-pane fade" id="forma" role="tabpanel">
                            <div class="form-group p-3">
                                <label>
                                    <strong>Selecciona las formas farmacéuticas:</strong>
                                </label>

                                <!-- Checkboxes existentes -->
                                <div id="lista-formas" style="display: flex; flex-wrap: wrap; gap: 12px; padding-top: 8px;">
                                    <?php
                                    if (isset($resultado_formas) && $resultado_formas->num_rows > 0) {
                                        while ($row = $resultado_formas->fetch_assoc()) {
                                            $forma = htmlspecialchars($row['Forma_Farmaceutica']);
                                            echo '<label style="display: flex; align-items: center; gap: 6px;">';
                                            echo '  <input type="checkbox" name="formas_farmaceuticas[]" value="' . $forma . '" />';
                                            echo '  ' . $forma;
                                            echo '</label>';
                                        }
                                    } else {
                                        echo "<p>No hay formas farmacéuticas registradas.</p>";
                                    }
                                    ?>
                                </div>

                                <!-- Botón para agregar forma nueva debajo de los checkboxes -->
                                <div style="margin-top: 12px;">
                                    <button type="button" onclick="mostrarModal()" style="background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                                        <i class="fas fa-plus-circle" style="font-size: 20px; color: #007bff;"></i>
                                        <span style="color: #007bff;">Agregar nueva forma</span>
                                    </button>
                                </div>
                            </div>
                        </div>


                        <!-- Presentación -->
                        <div class="tab-pane fade" id="presentacion" role="tabpanel">
                            <div id="contenedorPresentaciones" class="row g-3 mb-2">
                                <!-- Fila de presentación 1 -->
                                <div class="row g-3 align-items-end presentacion-item">
                                    <div class="col-md-3">
                                        <label class="form-label">Tipo Presentación</label>
                                        <input type="text" class="form-control" name="tipoPresentacion[]" placeholder="Tipo Presentación" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Desglose de Presentación</label>
                                        <input type="text" class="form-control" name="desglosePresentacion[]" placeholder="Desglose de Presentación" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Cantidad de Presentación (Unidad)</label>
                                        <input type="number" class="form-control" name="cantidadPresentacion[]" placeholder="Cantidad (Unidad)" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Precio</label>
                                        <input type="number" class="form-control" name="precioPresentacion[]" placeholder="Precio" step="0.01" required>
                                    </div>
                                    <div class="col-md-1 d-flex justify-content-center align-items-end">
                                        <!-- Botón de eliminar, oculto en el primero -->
                                    </div>
                                </div>
                            </div>

                            <!-- Botón para agregar nueva presentación -->
                            <div style="margin-top: 12px;">
                                <button type="button" onclick="agregarPresentacion()" style="background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                                    <i class="fas fa-plus-circle" style="font-size: 20px; color: #007bff;"></i>
                                    <span style="color: #007bff;">Agregar otra presentación</span>
                                </button>
                            </div>
                        </div>


                        <script>
                            function agregarPresentacion() {
                                const contenedor = document.getElementById("contenedorPresentaciones");

                                const nuevaFila = document.createElement("div");
                                nuevaFila.className = "row g-3 align-items-end presentacion-item mt-1";

                                nuevaFila.innerHTML = `
                                <div class="col-md-3">
                                    <label class="form-label">Tipo Presentación</label>
                                    <input type="text" class="form-control" name="tipoPresentacion[]" placeholder="Tipo Presentación" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Desglose de Presentación</label>
                                    <input type="text" class="form-control" name="desglosePresentacion[]" placeholder="Desglose de Presentación" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Cantidad de Presentación (Unidad)</label>
                                    <input type="number" class="form-control" name="cantidadPresentacion[]" placeholder="Cantidad (Unidad)" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Precio</label>
                                    <input type="number" class="form-control" name="precioPresentacion[]" placeholder="Precio" step="0.01" required>
                                </div>
                                <div class="col-md-1 d-flex justify-content-center">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarPresentacion(this)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            `;

                                contenedor.appendChild(nuevaFila);
                            }

                            function eliminarPresentacion(boton) {
                                const fila = boton.closest(".presentacion-item");
                                fila.remove();
                            }
                        </script>












                        <!-- Dosis -->
                        <div class="tab-pane fade" id="dosis" role="tabpanel">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="dosisMedicamento" class="form-label">Dosis</label>
                                    <input type="text" class="form-control" name="dosisMedicamento" placeholder="Ej: 500mg, 10ml" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnAnterior" class="btn btn-secondary" onclick="navegarAnteriorTab()">Anterior</button>
                    <button type="button" class="btn btn-primary" id="btnSiguiente" onclick="navegarSiguienteTab()">Siguiente</button>
                </div>


            </form>
        </div>
    </div>
</div>

<script>
    const tabs = ["medicamento", "lote", "forma", "presentacion", "dosis"];

    function navegarSiguienteTab() {
        const currentTab = document.querySelector(".nav-link.active");
        const currentId = currentTab.id.replace("-tab", "");
        const currentIndex = tabs.indexOf(currentId);

        if (currentIndex < tabs.length - 1) {
            const nextTabId = tabs[currentIndex + 1] + "-tab";
            document.getElementById(nextTabId).click();
        }
    }

    function navegarAnteriorTab() {
        const currentTab = document.querySelector(".nav-link.active");
        const currentId = currentTab.id.replace("-tab", "");
        const currentIndex = tabs.indexOf(currentId);

        if (currentIndex > 0) {
            const prevTabId = tabs[currentIndex - 1] + "-tab";
            document.getElementById(prevTabId).click();
        }
    }

    function actualizarBotones(index) {
        const btnAnterior = document.getElementById("btnAnterior");
        const btnSiguiente = document.getElementById("btnSiguiente");

        // Mostrar u ocultar "Anterior"
        btnAnterior.style.display = index === 0 ? "none" : "inline-block";

        // Configurar botón "Siguiente"
        if (index === tabs.length - 1) {
            btnSiguiente.textContent = "Guardar Medicamento Completo";
            btnSiguiente.type = "submit";
            btnSiguiente.removeAttribute("onclick");
        } else {
            btnSiguiente.textContent = "Siguiente";
            btnSiguiente.type = "button";
            btnSiguiente.setAttribute("onclick", "navegarSiguienteTab()");
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
        const currentTab = document.querySelector(".nav-link.active");
        const currentId = currentTab.id.replace("-tab", "");
        const currentIndex = tabs.indexOf(currentId);
        actualizarBotones(currentIndex);

        // Desactivar los clics en pestañas
        const navLinks = document.querySelectorAll(".nav-link");
        navLinks.forEach(link => {
            link.addEventListener("click", function(e) {
                e.preventDefault(); // Bloquea clics directos
            });
        });

        // Asegurar actualización de botones cuando cambie la pestaña
        const tabLinks = document.querySelectorAll('.nav-link');
        tabLinks.forEach(link => {
            link.addEventListener('shown.bs.tab', function(e) {
                const newId = e.target.id.replace("-tab", "");
                const newIndex = tabs.indexOf(newId);
                actualizarBotones(newIndex);
            });
        });
    });
</script>




<!-------------------------------------------------- Modal para ver medicamento ------------------------------------------>
<div class="modal fade" id="modalVerMedicamento" tabindex="-1" aria-labelledby="modalVerMedicamentoLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #17d5bb; color: #2e2e2e;">
                <h5 class="modal-title" id="modalVerMedicamentoLabel">
                    <i class='bx bx-show'></i> Detalles del Medicamento
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <!-- Lado izquierdo: Detalles del medicamento y lote -->
                    <div class="col-lg-8">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nombreMedicamentoVer" class="form-label">Nombre del Medicamento</label>
                                <input type="text" class="form-control" id="nombreMedicamentoVer" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="laboratorioMedicamentoVer" class="form-label">Laboratorio / Marca</label>
                                <input type="text" class="form-control" id="laboratorioMedicamentoVer" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="categoriaMedicamentoVer" class="form-label">Categoría</label>
                                <input type="text" class="form-control" id="categoriaMedicamentoVer" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="proveedorMedicamentoVer" class="form-label">Proveedor</label>
                                <input type="text" class="form-control" id="proveedorMedicamentoVer" disabled>
                            </div>
                            <div class="col-md-12">
                                <label for="descripcionMedicamentoVer" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcionMedicamentoVer" rows="2" disabled></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="estadoMedicamentoVer" class="form-label">Estado</label>
                                <input type="text" class="form-control" id="estadoMedicamentoVer" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="cantidadLoteVer" class="form-label">Cantidad</label>
                                <input type="number" class="form-control" id="cantidadLoteVer" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="fechaFabricacionLoteVer" class="form-label">Fecha de Fabricación</label>
                                <input type="text" class="form-control" id="fechaFabricacionLoteVer" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="fechaCaducidadLoteVer" class="form-label">Fecha de Caducidad</label>
                                <input type="text" class="form-control" id="fechaCaducidadLoteVer" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="fechaEmisionLoteVer" class="form-label">Fecha de Emisión</label>
                                <input type="text" class="form-control" id="fechaEmisionLoteVer" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="fechaRecibidoLoteVer" class="form-label">Fecha de Recibido</label>
                                <input type="text" class="form-control" id="fechaRecibidoLoteVer" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="precioUnidadLoteVer" class="form-label">Precio por Unidad</label>
                                <input type="text" class="form-control" id="precioUnidadLoteVer" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="precioTotalLoteVer" class="form-label">Precio Total</label>
                                <input type="text" class="form-control" id="precioTotalLoteVer" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="stockMinimoLoteVer" class="form-label">Stock Mínimo</label>
                                <input type="number" class="form-control" id="stockMinimoLoteVer" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="stockMaximoLoteVer" class="form-label">Stock Máximo</label>
                                <input type="number" class="form-control" id="stockMaximoLoteVer" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- Lado derecho: Imagen -->
                    <div class="col-lg-4 text-center">
                        <label class="form-label">Imagen del Medicamento</label>
                        <div class="border rounded shadow p-2 bg-light">
                            <img id="imagenMedicamentoVer" src="" alt="Imagen Medicamento" class="img-fluid" style="max-height: 400px; object-fit: contain;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <div>
                    <button type="button" class="btn btn-warning" id="btnEditarMedicamento"><i class="bi bi-pencil-square"></i> Editar</button>
                    <button type="button" class="btn btn-danger" id="btnEliminarMedicamento"><i class="bi bi-trash"></i> Eliminar</button>
                </div>
            </div>
        </div>
    </div>
</div>







<!-- Modal para agregar nueva forma farmacéutica -->
<div class="modal fade" id="modalForma" tabindex="-1" role="dialog" aria-labelledby="modalFormaLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content p-3">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="modalFormaLabel">Agregar nueva forma</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" id="nuevaForma" class="form-control" placeholder="Ej: Tableta, Jarabe, etc" />
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarForma()">Guardar</button>
            </div>
        </div>
    </div>
</div>








<?php
include_once "Ctrl/footer.php";

?>