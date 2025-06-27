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
                            <button class="nav-link" id="forma-tab" data-bs-toggle="tab" data-bs-target="#forma" type="button">Forma Farmacéutica y Dosis</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="presentacion-tab" data-bs-toggle="tab" data-bs-target="#presentacion" type="button">Presentación</button>
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


                        <!-- Pestaña FORMAS FARMACÉUTICAS y Dosis-->
                        <div class="tab-pane fade" id="forma" role="tabpanel">
                            <div class="form-group p-3">
                                <div style="display: flex; gap: 24px; flex-wrap: wrap;">

                                    <!-- Contenedor de Formas Farmacéuticas -->
                                    <div style="flex: 1; min-width: 300px;">
                                        <label><strong>Selecciona las formas farmacéuticas:</strong></label>
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

                                        <!-- Botón para agregar nueva forma -->
                                        <div style="margin-top: 12px;">
                                            <button type="button" onclick="mostrarModalForma()" style="background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                                                <i class="fas fa-plus-circle" style="font-size: 20px; color: #007bff;"></i>
                                                <span style="color: #007bff;">Agregar nueva forma</span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Contenedor de Dosis -->
                                    <div style="flex: 1; min-width: 300px;">
                                        <label><strong>Selecciona las dosis:</strong></label>
                                        <div id="lista-dosis" style="display: flex; flex-wrap: wrap; gap: 12px; padding-top: 8px;">
                                            <?php
                                            if (isset($resultado_dosis) && $resultado_dosis->num_rows > 0) {
                                                while ($row = $resultado_dosis->fetch_assoc()) {
                                                    $dosis = htmlspecialchars($row['Dosis']);
                                                    echo '<label style="display: flex; align-items: center; gap: 6px;">';
                                                    echo '  <input type="checkbox" name="dosis[]" value="' . $dosis . '" />';
                                                    echo '  ' . $dosis;
                                                    echo '</label>';
                                                }
                                            } else {
                                                echo "<p>No hay dosis registradas.</p>";
                                            }
                                            ?>
                                        </div>

                                        <!-- Botón para agregar nueva dosis -->
                                        <div style="margin-top: 12px;">
                                            <button type="button" onclick="mostrarModalDosis()" style="background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                                                <i class="fas fa-plus-circle" style="font-size: 20px; color: #007bff;"></i>
                                                <span style="color: #007bff;">Agregar nueva dosis</span>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>



                        <!-- Presentación -->
                        <div class="tab-pane fade" id="presentacion" role="tabpanel">
                            <div id="contenedorPresentaciones" class="row g-3 mb-2">
                                <!-- Fila de presentación 1 -->
                                <div class="row g-3 align-items-end presentacion-item">
                                    <div class="col-md-2">
                                        <label class="form-label">Tipo Presentación</label>
                                        <input type="text" class="form-control" name="tipoPresentacion[]" placeholder="Ej: Caja" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Desglose de Presentación</label>
                                        <input type="text" class="form-control" name="desglosePresentacion[]" placeholder="Ej: Blister" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Total de esta presentación</label>
                                        <input type="text" class="form-control" name="totalPresentacion[]" placeholder="Ej: 1 caja = 5 blisters" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Cantidad de Presentación (Unidad)</label>
                                        <input type="number" class="form-control" name="cantidadPresentacion[]" placeholder="Ej: 20" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Precio</label>
                                        <input type="number" class="form-control" name="precioPresentacion[]" placeholder="Precio" step="0.01" required>
                                    </div>
                                    <div class="col-md-1 d-flex justify-content-center align-items-end">
                                        <!-- Botón eliminar no se muestra en la primera fila -->
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
                        <!-- Script Presentación -->
                        <script>
                            function agregarPresentacion() {
                                const contenedor = document.getElementById("contenedorPresentaciones");

                                const nuevaFila = document.createElement("div");
                                nuevaFila.className = "row g-3 align-items-end presentacion-item mt-1";

                                nuevaFila.innerHTML = `
                                    <div class="col-md-2">
                                        <label class="form-label">Tipo Presentación</label>
                                        <input type="text" class="form-control" name="tipoPresentacion[]" placeholder="Ej: Caja" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Desglose de Presentación</label>
                                        <input type="text" class="form-control" name="desglosePresentacion[]" placeholder="Ej: Blister" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Total de esta presentación (Ej: 1 caja = 5 blisters)</label>
                                        <input type="text" class="form-control" name="totalPresentacion[]" placeholder="Ej: 1 caja = 5 blisters" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Cantidad de Presentación (Unidad)</label>
                                        <input type="number" class="form-control" name="cantidadPresentacion[]" placeholder="Ej: 20" required>
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

<!-- Diseño del modal de agregar -->
<script>
    const tabs = ["medicamento", "lote", "forma", "presentacion"];

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
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="medicamentoTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="datos-medicamento-tab" data-bs-toggle="tab" data-bs-target="#datos-medicamento" type="button" role="tab" aria-controls="datos-medicamento" aria-selected="true">
                            Datos del Medicamento
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="estanteria-tab" data-bs-toggle="tab" data-bs-target="#estanteria" type="button" role="tab" aria-controls="estanteria" aria-selected="false">
                            Estantería
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="bodega-tab" data-bs-toggle="tab" data-bs-target="#bodega" type="button" role="tab" aria-controls="bodega" aria-selected="false">
                            Bodega
                        </button>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content mt-3">
                    <!-- Pestaña 1: Datos del Medicamento -->
                    <div class="tab-pane fade show active" id="datos-medicamento" role="tabpanel" aria-labelledby="datos-medicamento-tab">
                        <div class="container-fluid p-0">
                            <div class="row g-3">

                                <!-- Columna Izquierda: Información principal -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="nombreMedicamentoVer" class="form-label small">Nombre del Medicamento</label>
                                        <input type="text" class="form-control form-control-sm" id="nombreMedicamentoVer" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="laboratorioMedicamentoVer" class="form-label small">Laboratorio / Marca</label>
                                        <input type="text" class="form-control form-control-sm" id="laboratorioMedicamentoVer" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="categoriaMedicamentoVer" class="form-label small">Categoría</label>
                                        <input type="text" class="form-control form-control-sm" id="categoriaMedicamentoVer" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="proveedorMedicamentoVer" class="form-label small">Proveedor</label>
                                        <input type="text" class="form-control form-control-sm" id="proveedorMedicamentoVer" disabled>
                                    </div>
                                    <div class="mb-0">
                                        <label for="descripcionMedicamentoVer" class="form-label small">Descripción</label>
                                        <textarea class="form-control form-control-sm" id="descripcionMedicamentoVer" rows="2" disabled></textarea>
                                    </div>
                                </div>

                                <!-- Columna Central: Imagen, estado, stock y dosis -->
                                <div class="col-md-4 d-flex flex-column align-items-center">
                                    <div class="border rounded shadow p-2 bg-light mb-2" style="width: 120px; height: 120px;">
                                        <img id="imagenMedicamentoVer" src="" alt="Imagen Medicamento" class="img-fluid" style="max-height: 110px; object-fit: contain;">
                                    </div>

                                    <div class="w-100 mt-2">
                                        <div class="mb-2">
                                            <label for="estadoMedicamentoVer" class="form-label small">Estado</label>
                                            <input type="text" class="form-control form-control-sm" id="estadoMedicamentoVer" disabled>
                                        </div>
                                        <div class="row g-1 mb-2">
                                            <div class="col-6">
                                                <label for="stockMinimoLoteVer" class="form-label small">Stock Mín.</label>
                                                <input type="number" class="form-control form-control-sm" id="stockMinimoLoteVer" disabled>
                                            </div>
                                            <div class="col-6">
                                                <label for="stockMaximoLoteVer" class="form-label small">Stock Máx.</label>
                                                <input type="number" class="form-control form-control-sm" id="stockMaximoLoteVer" disabled>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <label for="formaFarmaceuticaVer" class="form-label small">Forma Farmacéutica</label>
                                            <input type="text" class="form-control form-control-sm" id="formaFarmaceuticaVer" disabled>
                                        </div>
                                        <div class="mb-0">
                                            <label for="dosisMedicamentoVer" class="form-label small">Dosis</label>
                                            <input type="text" class="form-control form-control-sm" id="dosisMedicamentoVer" disabled>
                                        </div>
                                    </div>
                                </div>

                                <!-- Columna Derecha: Detalles del Lote -->
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label for="fechaFabricacionLoteVer" class="form-label small">Fecha de Fabricación</label>
                                        <input type="text" class="form-control form-control-sm" id="fechaFabricacionLoteVer" disabled>
                                    </div>
                                    <div class="mb-2">
                                        <label for="fechaCaducidadLoteVer" class="form-label small">Fecha de Caducidad</label>
                                        <input type="text" class="form-control form-control-sm" id="fechaCaducidadLoteVer" disabled>
                                    </div>
                                    <div class="mb-2">
                                        <label for="fechaEmisionLoteVer" class="form-label small">Fecha de Emisión</label>
                                        <input type="text" class="form-control form-control-sm" id="fechaEmisionLoteVer" disabled>
                                    </div>
                                    <div class="mb-2">
                                        <label for="fechaRecibidoLoteVer" class="form-label small">Fecha de Recibido</label>
                                        <input type="text" class="form-control form-control-sm" id="fechaRecibidoLoteVer" disabled>
                                    </div>
                                    <div class="mb-0">
                                        <label for="precioTotalLoteVer" class="form-label small">Precio Total del Lote</label>
                                        <input type="text" class="form-control form-control-sm" id="precioTotalLoteVer" disabled>
                                    </div>
                                </div>
                            </div>

                            <!-- Presentaciones Disponibles -->
                            <div class="mt-3">
                                <h5 class="small fw-bold mb-1">Presentaciones Disponibles</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Presentación</th>
                                                <th>Cantidad</th>
                                                <th>Precio Unitario</th>
                                            </tr>
                                        </thead>
                                        <tbody id="presentacionesMedicamentoVer">
                                            <tr>
                                                <td colspan="3" class="text-center text-muted fst-italic small">No hay presentaciones registradas.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pestaña 2: Estantería -->
                    <div class="tab-pane fade" id="estanteria" role="tabpanel" aria-labelledby="estanteria-tab">
                        <div class="mt-3">
                            <h5 class="small fw-bold mb-2">Ubicación en Estantería</h5>

                            <div class="row g-3">
                                <!-- Columna Izquierda: Estantería Visual -->
                                <div class="col-md-8">
                                    <div class="estanteria-container bg-metalica p-2 rounded">
                                        <div class="zona-principal">
                                            <div class="encabezado-filas-columnas"></div>
                                            <div class="estanteria-wrapper">
                                                <div class="indicadores-filas"></div>
                                                <div class="area-estanteria"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Columna Derecha: Información del Estante Seleccionado -->
                                <div class="col-md-4">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-header bg-light fw-bold small">Detalles del Estante Seleccionado</div>
                                        <div class="card-body p-3">
                                            <div class="mb-2">
                                                <label for="nombreEstanteriaVer" class="form-label small">Nombre de la Estantería</label>
                                                <input type="text" class="form-control form-control-sm" id="nombreEstanteriaVer" disabled>
                                            </div>

                                            <!-- Columna y Fila -->
                                            <div class="mb-2 row align-items-center">
                                                <div class="col">
                                                    <label for="columnaEstanteVer" class="form-label small">Columna</label>
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" class="form-control" id="columnaEstanteVer" disabled>
                                                        <span class="input-group-text p-1">
                                                            <div class="color-box" style="background-color: #6f42c1;"></div> <!-- morado -->
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <label for="filaEstanteVer" class="form-label small">Fila</label>
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" class="form-control" id="filaEstanteVer" disabled>
                                                        <span class="input-group-text p-1">
                                                            <div class="color-box" style="background-color: #28a745;"></div> <!-- verde -->
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Posición Y y X -->
                                            <div class="mb-2 row align-items-center">
                                                <div class="col">
                                                    <label for="posicionYEstanteVer" class="form-label small">Posición Y</label>
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" class="form-control" id="posicionYEstanteVer" disabled>
                                                        <span class="input-group-text p-1">
                                                            <div class="color-box" style="background-color: #000;"></div> <!-- negro -->
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <label for="posicionXEstanteVer" class="form-label small">Posición X</label>
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" class="form-control" id="posicionXEstanteVer" disabled>
                                                        <span class="input-group-text p-1">
                                                            <div class="color-box" style="background-color: #000;"></div> <!-- negro -->
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Stock mínimo y máximo -->
                                            <div class="mb-2 row">
                                                <div class="col">
                                                    <label for="stockMinimoEstanteVer" class="form-label small">Stock Mínimo</label>
                                                    <input type="number" class="form-control form-control-sm" id="stockMinimoEstanteVer" disabled>
                                                </div>
                                                <div class="col">
                                                    <label for="stockMaximoEstanteVer" class="form-label small">Stock Máximo</label>
                                                    <input type="number" class="form-control form-control-sm" id="stockMaximoEstanteVer" disabled>
                                                </div>
                                            </div>

                                            <div class="mb-2">
                                                <label for="cantidadEnEstanteVer" class="form-label small">Cantidad en Estante</label>
                                                <input type="number" class="form-control form-control-sm" id="cantidadEnEstanteVer" disabled>
                                            </div>

                                            <div class="mb-0">
                                                <label for="fechaActualizacionEstanteVer" class="form-label small">Fecha de Actualización</label>
                                                <input type="text" class="form-control form-control-sm" id="fechaActualizacionEstanteVer" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- script que muestra la estanteria pestaña 2 -->
                    <script>
                        function dibujarEstanteriaEnPestania2(idEstanteria) {
                            fetch(`../pages/Ctrl/ver_estanteria.php?id=${idEstanteria}`)
                                .then(res => res.json())
                                .then(data => {
                                    if (!data.success) {
                                        console.error('Estantería no encontrada');
                                        return;
                                    }

                                    const est = data.estanteria;

                                    const columnas = parseInt(est.Cantidad_Columnas) || 1;
                                    const filas = parseInt(est.Cantidad_Filas) || 1;
                                    const subColumnas = parseInt(est.SubColumnas) || 1;
                                    const subFilas = parseInt(est.SubFilas) || 1;

                                    const contenedor = document.querySelector('#estanteria .estanteria-container');
                                    const encabezado = contenedor.querySelector('.encabezado-filas-columnas');
                                    const areaEstanteria = contenedor.querySelector('.area-estanteria');
                                    const indicadoresFilas = contenedor.querySelector('.indicadores-filas');

                                    encabezado.innerHTML = '';
                                    areaEstanteria.innerHTML = '';
                                    indicadoresFilas.innerHTML = '';

                                    encabezado.style.setProperty('--columnas', columnas);
                                    areaEstanteria.style.setProperty('--columnas', columnas);

                                    // Inputs
                                    const compartimentoCol = parseInt(document.getElementById('columnaEstanteVer').value); // columna principal
                                    const compartimentoFila = parseInt(document.getElementById('filaEstanteVer').value); // fila principal
                                    const subPosX = parseInt(document.getElementById('posicionXEstanteVer').value); // subcolumna
                                    const subPosY = parseInt(document.getElementById('posicionYEstanteVer').value); // subfila

                                    // Dibujar encabezado (morado)
                                    for (let c = 1; c <= columnas; c++) {
                                        const col = document.createElement('div');
                                        col.classList.add('color-indicator');
                                        col.innerHTML = `<div class="color-box bg-primary" title="Columna ${c}"></div>`;
                                        encabezado.appendChild(col);
                                    }

                                    // Dibujar filas y compartimentos
                                    for (let fila = 1; fila <= filas; fila++) {
                                        const filaIndicador = document.createElement('div');
                                        filaIndicador.classList.add('color-indicator');
                                        filaIndicador.innerHTML = `<div class="color-box bg-success" title="Fila ${fila}"></div>`;
                                        indicadoresFilas.appendChild(filaIndicador);

                                        for (let col = 1; col <= columnas; col++) {
                                            const compartimento = document.createElement('div');
                                            compartimento.classList.add('estanteria-compartment');
                                            compartimento.innerHTML = `
                                                <div class="subcolumnas-container"></div>
                                                <div class="subfilas-container"></div>
                                            `;

                                            // Dibujar subcolumnas (amarillas)
                                            const subColsCont = compartimento.querySelector('.subcolumnas-container');
                                            for (let i = 1; i < subColumnas; i++) {
                                                const lineaV = document.createElement('div');
                                                lineaV.classList.add('linea-subcolumna');
                                                lineaV.style.left = `${(100 / subColumnas) * i}%`;
                                                subColsCont.appendChild(lineaV);
                                            }

                                            // Dibujar subfilas (rojas)
                                            const subFilasCont = compartimento.querySelector('.subfilas-container');
                                            for (let j = 1; j < subFilas; j++) {
                                                const lineaH = document.createElement('div');
                                                lineaH.classList.add('linea-subfila');
                                                lineaH.style.top = `${(100 / subFilas) * j}%`;
                                                subFilasCont.appendChild(lineaH);
                                            }

                                            // Si estamos en el compartimento donde está el medicamento
                                            if (col === compartimentoCol && fila === compartimentoFila) {
                                                const marcador = document.createElement('div');
                                                marcador.style.position = 'absolute';
                                                marcador.style.width = '12px';
                                                marcador.style.height = '12px';
                                                marcador.style.backgroundColor = '#000';
                                                marcador.style.borderRadius = '50%';

                                                const top = (100 / subFilas) * (subPosY - 0.5);
                                                const left = (100 / subColumnas) * (subPosX - 0.5);

                                                marcador.style.top = `${top}%`;
                                                marcador.style.left = `${left}%`;
                                                marcador.style.transform = 'translate(-50%, -50%)';
                                                marcador.title = `Posición: Columna ${col} - Fila ${fila} - X:${subPosX}, Y:${subPosY}`;
                                                compartimento.appendChild(marcador);
                                            }

                                            areaEstanteria.appendChild(compartimento);
                                        }
                                    }
                                })
                                .catch(err => {
                                    console.error('Error al cargar estantería:', err);
                                });
                        }
                    </script>

                    <!-- estilos -->
                    <style>
                        .color-box {
                            width: 15px;
                            height: 15px;
                            border-radius: 3px;
                        }

                        .estanteria-container {
                            display: grid;
                            grid-template-rows: auto 1fr;
                            gap: 10px;
                            background-color: #f9f9f9;
                            padding: 10px;
                            border: 1px solid #ddd;
                            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                        }

                        .encabezado-filas-columnas {
                            display: inline-grid;
                            grid-template-columns: repeat(var(--columnas), minmax(100px, 1fr));
                            grid-auto-rows: auto;
                            gap: 10px;
                            margin-left: 70px;
                        }

                        .estanteria-wrapper {
                            display: flex;
                            align-items: flex-start;
                            gap: 10px;
                        }

                        .indicadores-filas {
                            display: grid;
                            grid-auto-rows: minmax(100px, auto);
                            gap: 10px;
                        }

                        .indicadores-filas .color-indicator {
                            justify-content: flex-start;
                        }

                        .color-indicator {
                            display: flex;
                            align-items: center;
                        }

                        .color-indicator div {
                            width: 20px;
                            height: 20px;
                            border-radius: 4px;
                        }

                        .area-estanteria {
                            background: #c2c3c2;
                            padding: 10px;
                            border-radius: 8px;
                            display: grid;
                            grid-template-columns: repeat(var(--columnas), minmax(100px, 1fr));
                            grid-auto-rows: minmax(100px, auto);
                            gap: 10px;
                            border: 2px solid #999;
                            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
                        }

                        .estanteria-compartment {
                            border: 1px solid #ccc;
                            border-radius: 5px;
                            text-align: center;
                            padding: 8px;
                            position: relative;
                            background: white;
                            transition: transform 0.3s ease;
                            animation: fadeIn 0.4s ease;
                            min-height: 100px;
                            height: 100%;
                        }

                        .estanteria-compartment:hover {
                            transform: scale(1.05);
                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                        }

                        @keyframes fadeIn {
                            from {
                                opacity: 0;
                                transform: scale(0.9);
                            }

                            to {
                                opacity: 1;
                                transform: scale(1);
                            }
                        }

                        .subcolumnas-container,
                        .subfilas-container {
                            position: absolute;
                            top: 0;
                            left: 0;
                            right: 0;
                            bottom: 0;
                            pointer-events: none;
                        }

                        .linea-subcolumna {
                            position: absolute;
                            top: 0;
                            bottom: 0;
                            width: 2px;
                            background-color: #ffc107;
                            /* Amarillo */
                            transform: translateX(-50%);
                        }

                        .linea-subfila {
                            position: absolute;
                            left: 0;
                            right: 0;
                            height: 2px;
                            background-color: #dc3545;
                            /* Rojo */
                            transform: translateY(-50%);
                        }

                        .swal2-container {
                            z-index: 20000 !important;
                        }
                    </style>

                    <!-- Pestaña 3: Bodega -->
                    <div class="tab-pane fade" id="bodega" role="tabpanel" aria-labelledby="bodega-tab">
                        <div class="mt-3">
                            <h5 class="small fw-bold mb-2">Ubicación en Bodega</h5>

                            <div class="row g-3">
                                <!-- Columna Izquierda: Bodega Visual -->
                                <div class="col-md-8">
                                    <div class="estanteria-container bg-metalica p-2 rounded" >
                                        <div class="zona-principal">
                                            <div class="encabezado-filas-columnas"></div>
                                            <div class="estanteria-wrapper">
                                                <div class="indicadores-filas"></div>
                                                <div class="area-estanteria"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Columna Derecha: Información de la Bodega Seleccionada -->
                                <div class="col-md-4">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-header bg-light fw-bold small">Detalles de la Bodega Seleccionada</div>
                                        <div class="card-body p-3">

                                            <div class="mb-2">
                                                <label for="nombreBodegaVer" class="form-label small">Nombre de la Estanteria</label>
                                                <input type="text" class="form-control form-control-sm" id="nombreBodegaVer" disabled>
                                            </div>

                                            <!-- Columna y Fila -->
                                            <div class="mb-2 row align-items-center">
                                                <div class="col">
                                                    <label for="columnaBodegaVer" class="form-label small">Columna</label>
                                                    <div class="input-group input-group-sm">
                                                        <input type="text" class="form-control" id="columnaBodegaVer" disabled>
                                                        <span class="input-group-text p-1">
                                                            <div class="color-box" style="background-color: #6f42c1;"></div>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <label for="filaBodegaVer" class="form-label small">Fila</label>
                                                    <div class="input-group input-group-sm">
                                                        <input type="text" class="form-control" id="filaBodegaVer" disabled>
                                                        <span class="input-group-text p-1">
                                                            <div class="color-box" style="background-color: #28a745;"></div>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Posición Y y X -->
                                            <div class="mb-2 row align-items-center">
                                                <div class="col">
                                                    <label for="posicionYBodegaVer" class="form-label small">Posición Y</label>
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" class="form-control" id="posicionYBodegaVer" disabled>
                                                        <span class="input-group-text p-1">
                                                            <div class="color-box" style="background-color: #000;"></div>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <label for="posicionXBodegaVer" class="form-label small">Posición X</label>
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" class="form-control" id="posicionXBodegaVer" disabled>
                                                        <span class="input-group-text p-1">
                                                            <div class="color-box" style="background-color: #000;"></div>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Stock mínimo y máximo -->
                                            <div class="mb-2 row">
                                                <div class="col">
                                                    <label for="stockMinimoBodegaVer" class="form-label small">Stock Mínimo</label>
                                                    <input type="number" class="form-control form-control-sm" id="stockMinimoBodegaVer" disabled>
                                                </div>
                                                <div class="col">
                                                    <label for="stockMaximoBodegaVer" class="form-label small">Stock Máximo</label>
                                                    <input type="number" class="form-control form-control-sm" id="stockMaximoBodegaVer" disabled>
                                                </div>
                                            </div>

                                            <div class="mb-2">
                                                <label for="cantidadEnBodegaVer" class="form-label small">Cantidad en Bodega</label>
                                                <input type="number" class="form-control form-control-sm" id="cantidadEnBodegaVer" disabled>
                                            </div>

                                            <div class="mb-3">
                                                <label for="fechaRecibidoBodegaVer" class="form-label small">Fecha de Ingreso</label>
                                                <input type="text" class="form-control form-control-sm" id="fechaRecibidoBodegaVer" disabled>
                                            </div>

                                            <!-- Inputs ocultos para las dimensiones totales de la estantería -->
                                            <input type="hidden" id="cantidadColumnasBodega" value="">
                                            <input type="hidden" id="cantidadFilasBodega" value="">
                                            <input type="hidden" id="cantidadSubColumnasBodega" value="">
                                            <input type="hidden" id="cantidadSubFilasBodega" value="">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Script que muestra la estantería en pestaña 3 -->
                    <script>
                        function dibujarEstanteriaEnPestania3(idEstanteria) {
                            fetch(`../pages/Ctrl/ver_estanteria.php?id=${idEstanteria}`)
                                .then(res => res.json())
                                .then(data => {
                                    if (!data.success) {
                                        console.error('Estantería no encontrada');
                                        return;
                                    }

                                    const est = data.estanteria;

                                    const columnas = parseInt(est.Cantidad_Columnas) || 1;
                                    const filas = parseInt(est.Cantidad_Filas) || 1;
                                    const subColumnas = parseInt(est.SubColumnas) || 1;
                                    const subFilas = parseInt(est.SubFilas) || 1;

                                    const contenedor = document.querySelector('#bodega .estanteria-container');
                                    const encabezado = contenedor.querySelector('.encabezado-filas-columnas');
                                    const areaEstanteria = contenedor.querySelector('.area-estanteria');
                                    const indicadoresFilas = contenedor.querySelector('.indicadores-filas');

                                    encabezado.innerHTML = '';
                                    areaEstanteria.innerHTML = '';
                                    indicadoresFilas.innerHTML = '';

                                    encabezado.style.setProperty('--columnas', columnas);
                                    areaEstanteria.style.setProperty('--columnas', columnas);

                                    // Inputs que indican la posición actual del medicamento
                                    const compartimentoCol = parseInt(document.getElementById('columnaBodegaVer').value);
                                    const compartimentoFila = parseInt(document.getElementById('filaBodegaVer').value);
                                    const subPosX = parseInt(document.getElementById('posicionXBodegaVer').value);
                                    const subPosY = parseInt(document.getElementById('posicionYBodegaVer').value);

                                    // Dibujar encabezado columnas (morado)
                                    for (let c = 1; c <= columnas; c++) {
                                        const col = document.createElement('div');
                                        col.classList.add('color-indicator');
                                        col.innerHTML = `<div class="color-box bg-primary" title="Columna ${c}"></div>`;
                                        encabezado.appendChild(col);
                                    }

                                    // Dibujar filas y compartimentos
                                    for (let fila = 1; fila <= filas; fila++) {
                                        const filaIndicador = document.createElement('div');
                                        filaIndicador.classList.add('color-indicator');
                                        filaIndicador.innerHTML = `<div class="color-box bg-success" title="Fila ${fila}"></div>`;
                                        indicadoresFilas.appendChild(filaIndicador);

                                        for (let col = 1; col <= columnas; col++) {
                                            const compartimento = document.createElement('div');
                                            compartimento.classList.add('estanteria-compartment');
                                            compartimento.innerHTML = `
                                                    <div class="subcolumnas-container"></div>
                                                    <div class="subfilas-container"></div>
                                                `;

                                            // Dibujar subcolumnas (líneas verticales amarillas)
                                            const subColsCont = compartimento.querySelector('.subcolumnas-container');
                                            for (let i = 1; i < subColumnas; i++) {
                                                const lineaV = document.createElement('div');
                                                lineaV.classList.add('linea-subcolumna');
                                                lineaV.style.left = `${(100 / subColumnas) * i}%`;
                                                subColsCont.appendChild(lineaV);
                                            }

                                            // Dibujar subfilas (líneas horizontales rojas)
                                            const subFilasCont = compartimento.querySelector('.subfilas-container');
                                            for (let j = 1; j < subFilas; j++) {
                                                const lineaH = document.createElement('div');
                                                lineaH.classList.add('linea-subfila');
                                                lineaH.style.top = `${(100 / subFilas) * j}%`;
                                                subFilasCont.appendChild(lineaH);
                                            }

                                            // Si es el compartimento donde está el medicamento
                                            if (col === compartimentoCol && fila === compartimentoFila) {
                                                const marcador = document.createElement('div');
                                                marcador.style.position = 'absolute';
                                                marcador.style.width = '12px';
                                                marcador.style.height = '12px';
                                                marcador.style.backgroundColor = '#000';
                                                marcador.style.borderRadius = '50%';
                                                marcador.title = `Columna ${col}, Fila ${fila}, X:${subPosX}, Y:${subPosY}`;

                                                const top = (100 / subFilas) * (subPosY - 0.5);
                                                const left = (100 / subColumnas) * (subPosX - 0.5);

                                                marcador.style.top = `${top}%`;
                                                marcador.style.left = `${left}%`;
                                                marcador.style.transform = 'translate(-50%, -50%)';

                                                compartimento.appendChild(marcador);
                                            }

                                            areaEstanteria.appendChild(compartimento);
                                        }
                                    }
                                })
                                .catch(err => {
                                    console.error('Error al cargar estantería:', err);
                                });
                        }
                    </script>

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

<!--muestra y captura los datos el los modales -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.imagenMedicamentoCard').forEach(img => {
            img.addEventListener('click', () => {
                const idMedicamento = img.getAttribute('data-id');
                if (!idMedicamento) return;

                limpiarModalMedicamento();
                limpiarEstanteriaModal(); // 🧽 Limpiar también pestaña estantería

                fetch(`../pages/Ctrl/obtener_medicamento_completo.php?id=${idMedicamento}`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data || data.length === 0 || data.mensaje) {
                            alert(data.mensaje || 'No se encontraron datos del medicamento.');
                            return;
                        }

                        const med = data[0];

                        // 🧩 Información general
                        document.getElementById('nombreMedicamentoVer').value = med.Nombre_Medicamento || '';
                        document.getElementById('laboratorioMedicamentoVer').value = med.Nombre_Laboratorio || '';
                        document.getElementById('categoriaMedicamentoVer').value = med.Nombre_Categoria || '';
                        document.getElementById('proveedorMedicamentoVer').value = med.Proveedor || '';
                        document.getElementById('descripcionMedicamentoVer').value = med.Descripcion_Medicamento || '';
                        document.getElementById('estadoMedicamentoVer').value = med.Estado_Lote || '';

                        // ⚠️ Desde lote
                        document.getElementById('stockMinimoLoteVer').value = med.Stock_Minimo_Lote || '';
                        document.getElementById('stockMaximoLoteVer').value = med.Stock_Maximo_Lote || '';
                        document.getElementById('formaFarmaceuticaVer').value = med.Forma_Farmaceutica || '';
                        document.getElementById('dosisMedicamentoVer').value = med.Dosis || '';
                        document.getElementById('fechaFabricacionLoteVer').value = med.Fecha_Fabricacion_Lote || '';
                        document.getElementById('fechaCaducidadLoteVer').value = med.Fecha_Caducidad_Lote || '';
                        document.getElementById('fechaEmisionLoteVer').value = med.Fecha_Emision_Lote || '';
                        document.getElementById('fechaRecibidoLoteVer').value = med.Fecha_Recibido_Lote || '';
                        document.getElementById('precioTotalLoteVer').value = med.Precio_Total_Lote || '';

                        // 🖼 Imagen
                        const imgElem = document.getElementById('imagenMedicamentoVer');
                        imgElem.src = med.Imagen ?
                            '../../dist/assets/img-medicamentos/' + med.Imagen :
                            '../../dist/assets/img-medicamentos/default.jpg';

                        // 🧊 Información de Estantería
                        document.getElementById("nombreEstanteriaVer").value = med.Nombre_Estanteria || '';
                        document.getElementById("columnaEstanteVer").value = med.SubColumna || '';
                        document.getElementById("filaEstanteVer").value = med.SubFila || '';
                        document.getElementById("posicionYEstanteVer").value = med.Coordenada_Y || '';
                        document.getElementById("posicionXEstanteVer").value = med.Coordenada_X || '';
                        document.getElementById("stockMinimoEstanteVer").value = med.Stock_Minimo || '';
                        document.getElementById("stockMaximoEstanteVer").value = med.Stock_Maximo || '';
                        document.getElementById("cantidadEnEstanteVer").value = med.Cantidad_Disponible || '';

                        if (med.Fecha_Actualizacion) {
                            const fecha = new Date(med.Fecha_Actualizacion);
                            document.getElementById("fechaActualizacionEstanteVer").value = fecha.toISOString().split('T')[0];
                            if (med.ID_Estanteria) {
                                dibujarEstanteriaEnPestania2(med.ID_Estanteria);
                            }

                        } else {
                            document.getElementById("fechaActualizacionEstanteVer").value = "";
                        }

                        llenarTablaPresentaciones(data);

                    })
                    .catch(err => {
                        console.error('Error al cargar medicamento:', err);
                        alert('Error al obtener datos del medicamento.');
                    });
            });
        });
    });

    function limpiarModalMedicamento() {
        const ids = [
            'nombreMedicamentoVer', 'laboratorioMedicamentoVer', 'categoriaMedicamentoVer',
            'proveedorMedicamentoVer', 'descripcionMedicamentoVer', 'estadoMedicamentoVer',
            'stockMinimoLoteVer', 'stockMaximoLoteVer', 'formaFarmaceuticaVer',
            'dosisMedicamentoVer', 'fechaFabricacionLoteVer', 'fechaCaducidadLoteVer',
            'fechaEmisionLoteVer', 'fechaRecibidoLoteVer', 'precioTotalLoteVer'
        ];
        ids.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });
        const imgElem = document.getElementById('imagenMedicamentoVer');
        if (imgElem) imgElem.src = '../../dist/assets/img-medicamentos/default.jpg';

        const tbody = document.getElementById('presentacionesMedicamentoVer');
        if (tbody) {
            tbody.innerHTML = `<tr><td colspan="3" class="text-center text-muted fst-italic small">Cargando presentaciones...</td></tr>`;
        }
    }

    function limpiarEstanteriaModal() {
        const ids = [
            'nombreEstanteriaVer', 'columnaEstanteVer', 'filaEstanteVer',
            'subcolumnaEstanteVer', 'subfilaEstanteVer', 'posicionYEstanteVer',
            'posicionXEstanteVer', 'stockMinimoEstanteVer', 'stockMaximoEstanteVer',
            'cantidadEnEstanteVer', 'fechaActualizacionEstanteVer'
        ];
        ids.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });
    }

    function llenarTablaPresentaciones(data) {
        const tbody = document.getElementById('presentacionesMedicamentoVer');
        if (!tbody) return;
        tbody.innerHTML = '';

        const presentacionesMap = new Map();

        data.forEach(row => {
            if (row.ID_Presentacion && row.Tipo_Presentacion) {
                if (!presentacionesMap.has(row.ID_Presentacion)) {
                    presentacionesMap.set(row.ID_Presentacion, {
                        Tipo_Presentacion: row.Tipo_Presentacion,
                        Cantidad: row.Cantidad_Presentacion,
                        Precio: row.Precio
                    });
                }
            }
        });

        if (presentacionesMap.size === 0) {
            tbody.innerHTML = `<tr><td colspan="3" class="text-center text-muted fst-italic small">No hay presentaciones registradas.</td></tr>`;
            return;
        }

        presentacionesMap.forEach(p => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
            <td>${p.Tipo_Presentacion}</td>
            <td>${p.Cantidad}</td>
            <td>${p.Precio}</td>
        `;
            tbody.appendChild(tr);
        });
    }

    // ** NUEVA FUNCIÓN para llenar la pestaña 3 - Bodega **
    // ✅ Función principal para cargar datos de bodega desde el PHP
    function cargarDatosBodega(idMedicamento) {
        fetch(`../pages/Ctrl/obtener_estanteria_bodega.php?id=${idMedicamento}`)
            .then(response => response.json())
            .then(data => {
                if (!data || data.length === 0) {
                    console.warn("⚠️ No se encontraron datos de bodega para el medicamento:", idMedicamento);

                    // Limpiar campos del formulario
                    document.getElementById("nombreBodegaVer").value = "";
                    document.getElementById("columnaBodegaVer").value = "";
                    document.getElementById("filaBodegaVer").value = "";
                    document.getElementById("posicionYBodegaVer").value = "";
                    document.getElementById("posicionXBodegaVer").value = "";
                    document.getElementById("stockMinimoBodegaVer").value = 0;
                    document.getElementById("stockMaximoBodegaVer").value = 0;
                    document.getElementById("cantidadEnBodegaVer").value = 0;
                    document.getElementById("fechaRecibidoBodegaVer").value = "";

                    return;
                }

                console.log("📦 Datos recibidos de bodega:", data);

                const bodega = data[0];

                // Llenar los inputs
                document.getElementById("nombreBodegaVer").value = bodega.Nombre_Estanteria || "";
                document.getElementById("columnaBodegaVer").value = bodega.SubColumna || "";
                document.getElementById("filaBodegaVer").value = bodega.SubFila || "";
                document.getElementById("posicionYBodegaVer").value = bodega.Coordenada_Y || "";
                document.getElementById("posicionXBodegaVer").value = bodega.Coordenada_X || "";
                document.getElementById("stockMinimoBodegaVer").value = bodega.Stock_Minimo || 0;
                document.getElementById("stockMaximoBodegaVer").value = bodega.Stock_Maximo || 0;
                document.getElementById("cantidadEnBodegaVer").value = bodega.Cantidad_Total_Bodega || 0;

                if (bodega.Fecha_Recibido_Lote) {
                    const fecha = new Date(bodega.Fecha_Recibido_Lote);
                    const fechaFormateada = fecha.toISOString().split("T")[0];
                    document.getElementById("fechaRecibidoBodegaVer").value = fechaFormateada;
                } else {
                    document.getElementById("fechaRecibidoBodegaVer").value = "";
                }

                // ✅ Verifica que exista el ID_Estanteria
                if (bodega.ID_Estanteria) {
                    dibujarEstanteriaEnPestania3(bodega.ID_Estanteria);
                } else {
                    console.warn("⚠️ No se encontró ID_Estanteria en los datos de bodega.");
                }
            })
            .catch(error => {
                console.error("❌ Error al cargar datos de bodega:", error);
            });
    }


    // Asignar evento cuando se haga clic en una imagen de medicamento
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".imagenMedicamentoCard").forEach(img => {
            img.addEventListener("click", function() {
                const idMedicamento = this.getAttribute("data-id");

                if (idMedicamento) {
                    console.log("🟢 ID del medicamento seleccionado:", idMedicamento);
                    cargarDatosBodega(idMedicamento);
                } else {
                    console.warn("⚠️ No se encontró el ID del medicamento.");
                }
            });
        });
    });
</script>







<!-- Modal para agregar nueva forma farmacéutica-->
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