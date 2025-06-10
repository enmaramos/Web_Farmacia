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


                    <!-- Estilos de Pestaña 2: Estantería -->
                    <style>
                        /* Estilos generales */
                        .estanteria-container {
                            background-color: #f9f9f9;
                            padding: 10px;
                            border: 1px solid #ddd;
                            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                        }

                        .estanteria-row {
                            display: flex;
                            justify-content: space-between;
                            margin-bottom: 10px;
                        }

                        .estanteria-compartment {
                            width: calc(30% - 10px);
                            height: 120px;
                            background-color: white;
                            border: 1px solid #ccc;
                            position: relative;
                            overflow: hidden;
                            transition: transform 0.3s ease;
                        }

                        .compartment-label {
                            position: absolute;
                            top: 5px;
                            left: 5px;
                            font-size: 0.8rem;
                            color: #666;
                        }

                        .medication-card {
                            display: flex;
                            flex-direction: column;
                            align-items: center;
                            justify-content: center;
                            height: 100%;
                            text-align: center;
                            background-color: #fff;
                            border: 1px solid #ccc;
                            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                            transition: transform 0.3s ease;
                        }

                        .medication-name {
                            font-weight: bold;
                            color: #333;
                        }

                        .medication-quantity {
                            font-size: 0.9rem;
                            color: #666;
                        }
                    </style>

                    <!-- Pestaña 2: Estantería -->
                    <div class="tab-pane fade" id="estanteria" role="tabpanel" aria-labelledby="estanteria-tab">
                        <div class="mt-3">
                            <h5 class="small fw-bold mb-2">Ubicación en Estantería</h5>

                            <!-- Fila con estantería y formulario lateral -->
                            <div class="row g-3">

                                <!-- Columna Izquierda: Estantería Visual -->
                                <div class="col-md-8">
                                    <div class="estanteria-container">
                                        <!-- Compartimientos de la estantería -->
                                        <div class="estanteria-row">
                                            <div class="estanteria-compartment">
                                                <div class="compartment-label">(1,1)</div>
                                                <div class="medication-card">
                                                    <div class="medication-name">Paracetamol</div>
                                                    <div class="medication-quantity">20</div>
                                                </div>
                                            </div>
                                            <div class="estanteria-compartment">
                                                <div class="compartment-label">(2,1)</div>
                                                <div class="medication-card">
                                                    <div class="medication-name">Amoxicilina</div>
                                                    <div class="medication-quantity">15</div>
                                                </div>
                                            </div>
                                            <div class="estanteria-compartment">
                                                <div class="compartment-label">(3,1)</div>
                                                <div class="medication-card">
                                                    <div class="medication-name">VACÍO</div>
                                                    <div class="medication-quantity">0</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="estanteria-row">
                                            <div class="estanteria-compartment">
                                                <div class="compartment-label">(1,2)</div>
                                                <div class="medication-card">
                                                    <div class="medication-name">Ibuprofeno</div>
                                                    <div class="medication-quantity">30</div>
                                                </div>
                                            </div>
                                            <div class="estanteria-compartment">
                                                <div class="compartment-label">(2,2)</div>
                                                <div class="medication-card">
                                                    <div class="medication-name">VACÍO</div>
                                                    <div class="medication-quantity">0</div>
                                                </div>
                                            </div>
                                            <div class="estanteria-compartment">
                                                <div class="compartment-label">(3,2)</div>
                                                <div class="medication-card">
                                                    <div class="medication-name">Loratadina</div>
                                                    <div class="medication-quantity">25</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="estanteria-row">
                                            <div class="estanteria-compartment">
                                                <div class="compartment-label">(1,3)</div>
                                                <div class="medication-card">
                                                    <div class="medication-name">VACÍO</div>
                                                    <div class="medication-quantity">0</div>
                                                </div>
                                            </div>
                                            <div class="estanteria-compartment">
                                                <div class="compartment-label">(2,3)</div>
                                                <div class="medication-card">
                                                    <div class="medication-name">Omeprazol</div>
                                                    <div class="medication-quantity">10</div>
                                                </div>
                                            </div>
                                            <div class="estanteria-compartment">
                                                <div class="compartment-label">(3,3)</div>
                                                <div class="medication-card">
                                                    <div class="medication-name">Metformina</div>
                                                    <div class="medication-quantity">18</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="estanteria-row">
                                            <div class="estanteria-compartment">
                                                <div class="compartment-label">(1,4)</div>
                                                <div class="medication-card">
                                                    <div class="medication-name">VACÍO</div>
                                                    <div class="medication-quantity">0</div>
                                                </div>
                                            </div>
                                            <div class="estanteria-compartment">
                                                <div class="compartment-label">(2,4)</div>
                                                <div class="medication-card">
                                                    <div class="medication-name">Metformina</div>
                                                    <div class="medication-quantity">18</div>
                                                </div>
                                            </div>
                                            <div class="estanteria-compartment">
                                                <div class="compartment-label">(3,4)</div>
                                                <div class="medication-card">
                                                    <div class="medication-name">VACÍO</div>
                                                    <div class="medication-quantity">0</div>
                                                </div>
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
                                                <input type="text" class="form-control form-control-sm" id="nombreEstanteriaVer" value="Estantería A" disabled>
                                            </div>
                                            <div class="mb-2">
                                                <label for="posicionEstanteVer" class="form-label small">Posición en Estantería</label>
                                                <input type="text" class="form-control form-control-sm" id="posicionEstanteVer" value="(2,3)" disabled>
                                            </div>
                                            <div class="mb-2">
                                                <label for="stockMinimoEstanteVer" class="form-label small">Stock Mínimo</label>
                                                <input type="number" class="form-control form-control-sm" id="stockMinimoEstanteVer" value="10">
                                            </div>
                                            <div class="mb-2">
                                                <label for="stockMaximoEstanteVer" class="form-label small">Stock Máximo</label>
                                                <input type="number" class="form-control form-control-sm" id="stockMaximoEstanteVer" value="50">
                                            </div>
                                            <div class="mb-2">
                                                <label for="cantidadEnEstanteVer" class="form-label small">Cantidad en Estante</label>
                                                <input type="number" class="form-control form-control-sm" id="cantidadEnEstanteVer" value="18">
                                            </div>
                                            <div class="mb-0">
                                                <label for="fechaActualizacionEstanteVer" class="form-label small">Fecha de Actualización</label>
                                                <input type="text" class="form-control form-control-sm" id="fechaActualizacionEstanteVer" value="2025-06-09" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pestaña 3: Bodega -->
<div class="tab-pane fade" id="bodega" role="tabpanel" aria-labelledby="bodega-tab">
    <div class="mt-3">
        <h5 class="small fw-bold mb-2">Ubicación en Bodega</h5>

        <!-- Fila con bodega visual y formulario lateral -->
        <div class="row g-3">

            <!-- Columna Izquierda: Bodega Visual -->
            <div class="col-md-8">
                <div class="estanteria-container">
                    <!-- Compartimientos de la bodega -->
                    <div class="estanteria-row">
                        <div class="estanteria-compartment">
                            <div class="compartment-label">(A,1)</div>
                            <div class="medication-card">
                                <div class="medication-name">Paracetamol</div>
                                <div class="medication-quantity">50</div>
                            </div>
                        </div>
                        <div class="estanteria-compartment">
                            <div class="compartment-label">(B,1)</div>
                            <div class="medication-card">
                                <div class="medication-name">Amoxicilina</div>
                                <div class="medication-quantity">30</div>
                            </div>
                        </div>
                        <div class="estanteria-compartment">
                            <div class="compartment-label">(C,1)</div>
                            <div class="medication-card">
                                <div class="medication-name">VACÍO</div>
                                <div class="medication-quantity">0</div>
                            </div>
                        </div>
                    </div>

                    <div class="estanteria-row">
                        <div class="estanteria-compartment">
                            <div class="compartment-label">(A,2)</div>
                            <div class="medication-card">
                                <div class="medication-name">Ibuprofeno</div>
                                <div class="medication-quantity">40</div>
                            </div>
                        </div>
                        <div class="estanteria-compartment">
                            <div class="compartment-label">(B,2)</div>
                            <div class="medication-card">
                                <div class="medication-name">VACÍO</div>
                                <div class="medication-quantity">0</div>
                            </div>
                        </div>
                        <div class="estanteria-compartment">
                            <div class="compartment-label">(C,2)</div>
                            <div class="medication-card">
                                <div class="medication-name">Loratadina</div>
                                <div class="medication-quantity">25</div>
                            </div>
                        </div>
                    </div>

                    <div class="estanteria-row">
                        <div class="estanteria-compartment">
                            <div class="compartment-label">(A,3)</div>
                            <div class="medication-card">
                                <div class="medication-name">VACÍO</div>
                                <div class="medication-quantity">0</div>
                            </div>
                        </div>
                        <div class="estanteria-compartment">
                            <div class="compartment-label">(B,3)</div>
                            <div class="medication-card">
                                <div class="medication-name">Metformina</div>
                                <div class="medication-quantity">60</div>
                            </div>
                        </div>
                        <div class="estanteria-compartment">
                            <div class="compartment-label">(C,3)</div>
                            <div class="medication-card">
                                <div class="medication-name">Omeprazol</div>
                                <div class="medication-quantity">20</div>
                            </div>
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
                            <label for="nombreBodegaVer" class="form-label small">Nombre de la Bodega</label>
                            <input type="text" class="form-control form-control-sm" id="nombreBodegaVer" value="Bodega Principal" disabled>
                        </div>
                        <div class="mb-2">
                            <label for="posicionBodegaVer" class="form-label small">Posición en Bodega</label>
                            <input type="text" class="form-control form-control-sm" id="posicionBodegaVer" value="(B,2)" disabled>
                        </div>
                        <div class="mb-2">
                            <label for="stockMinimoBodegaVer" class="form-label small">Stock Mínimo</label>
                            <input type="number" class="form-control form-control-sm" id="stockMinimoBodegaVer" value="20">
                        </div>
                        <div class="mb-2">
                            <label for="stockMaximoBodegaVer" class="form-label small">Stock Máximo</label>
                            <input type="number" class="form-control form-control-sm" id="stockMaximoBodegaVer" value="100">
                        </div>
                        <div class="mb-2">
                            <label for="cantidadEnBodegaVer" class="form-label small">Cantidad en Bodega</label>
                            <input type="number" class="form-control form-control-sm" id="cantidadEnBodegaVer" value="45">
                        </div>
                        <div class="mb-0">
                            <label for="fechaCaducidadBodegaVer" class="form-label small">Fecha de Caducidad</label>
                            <input type="text" class="form-control form-control-sm" id="fechaCaducidadBodegaVer" value="2026-03-15" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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