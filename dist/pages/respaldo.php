<?php

include_once "Ctrl/head.php";

include '../pages/Cnx/conexion.php';

$sql = "SELECT * FROM respaldos WHERE estad = 'activo' ORDER BY Fecha DESC, Hora DESC";
$result = $conn->query($sql);
?>









<?php include_once "Ctrl/menu.php"; ?>

<script>
    $(document).ready(function() {
        $('#tablaRespaldos').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            "order": [
                [0, "desc"]
            ],
            "error": function(e) {
                console.log('Error en tabla:', e);
            }
        });
    });
</script>



<!-- TABLA DE RESPALDOS -->
<div class="container mt-4">
    <div class="card p-3 shadow-sm">

        <!-- Contenedor flex para título y botones -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <button id="btnCrearRespaldo" class="btn btn-primary">
                    <i class="bx bx-save"></i> Crear Respaldo Manual
                </button>
            </div>
            <h3 class="mb-0 text-center flex-grow-1">Historial de Respaldos</h3>
            <div>
                <button id="btnAbrirPapelera" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalPapelera">
                    <i class="bx bx-trash"></i> Papelera
                </button>

            </div>
        </div>


        <div class="table-responsive">
            <table id="tablaRespaldos" class="table table-striped text-center">
                <thead>
                    <tr>
                        <th>Archivo</th>
                        <th>Tamaño</th>
                        <th>Estado</th>
                        <th>Origen</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Descargar</th> <!-- NUEVA COLUMNA -->
                        <th>Eliminar</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        $archivo = htmlspecialchars($row['Archivo']);
                        $ruta = "respaldos/archivos/" . $archivo; // Asegúrate de que sea la ruta correcta

                        echo "<tr>";
                        echo "<td>" . $archivo . "</td>";
                        echo "<td>" . $row['Tamano'] . "</td>";
                        echo "<td>" . ($row['Estado'] === 'exito'
                            ? "<span class='badge bg-success'>Éxito</span>"
                            : "<span class='badge bg-danger'>Fallido</span>") . "</td>";
                        echo "<td>" . ucfirst($row['Origen']) . "</td>";
                        echo "<td>" . $row['Fecha'] . "</td>";
                        echo "<td>" . $row['Hora'] . "</td>";
                        echo "<td>
                            <a href='" . $ruta . "' class='btn btn-outline-success btn-sm' download title='Descargar respaldo'>
                                <i class='bx bx-download'></i>
                            </a>
                        </td>";
                        echo "<td>
                                <button class='btn btn-outline-danger btn-sm btnEliminar' data-id='" . $row['ID_Respaldo'] . "' title='Eliminar a papelera'>
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Papelera -->
<div class="modal fade" id="modalPapelera" tabindex="-1" aria-labelledby="modalPapeleraLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPapeleraLabel">Archivos en Papelera</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger text-center" role="alert">
                    Los archivos en papelera se eliminarán automáticamente después de 5 días.
                </div>
                <table id="tablaPapelera" class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>Archivo</th>
                            <th>Tamaño</th>
                            <th>Fecha Eliminación</th>
                            <th>Restaurar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Aquí se cargarán los archivos con AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- script Modal Papelera -->
<script>
    function cargarPapelera() {
        fetch('../pages/Ctrl/listar_papelera.php')
            .then(res => res.json())
            .then(data => {
                const tbody = document.querySelector('#tablaPapelera tbody');
                tbody.innerHTML = ''; // limpiar tabla

                data.forEach(item => {
                    const tr = document.createElement('tr');

                    tr.innerHTML = `
                <td>${item.Archivo}</td>
                <td>${item.Tamano}</td>
                <td>${item.Fecha}</td>
                <td>
                    <button class="btn btn-sm btn-success btnRestaurar" data-id="${item.ID_Respaldo}" title="Restaurar">
                        <i class="bx bx-rotate-left"></i>
                    </button>
                </td>
            `;

                    tbody.appendChild(tr);
                });

                // Agregar eventos para restaurar
                document.querySelectorAll('.btnRestaurar').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        restaurarArchivo(id);
                    });
                });
            })
            .catch(e => {
                console.error('Error al cargar papelera:', e);
            });
    }

    // Abrir modal y cargar datos
    document.getElementById('btnAbrirPapelera').addEventListener('click', function() {
        cargarPapelera();
    });

    function restaurarArchivo(id) {
        fetch('../pages/Ctrl/restaurar_respaldo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${id}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.exito) {
                    Swal.fire('Restaurado', 'El archivo fue restaurado correctamente.', 'success').then(() => {
                        cargarPapelera(); // recarga tabla de papelera
                        location.reload(); // refresca tabla principal para mostrar archivo restaurado
                    });
                } else {
                    Swal.fire('Error', data.error || 'No se pudo restaurar.', 'error');
                }
            })
            .catch(() => {
                Swal.fire('Error', 'Fallo la petición al servidor.', 'error');
            });
    }
</script>

<style>
    .swal2-container {
        z-index: 20000 !important;
    }
</style>


<script>
    document.getElementById("btnCrearRespaldo").addEventListener("click", function() {
        Swal.fire({
            title: '¿Deseas crear un respaldo manual?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, crear respaldo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("../pages/Ctrl/generar_respaldo.php")
                    .then(res => res.json())
                    .then(data => {
                        if (data.estado === 'exito') {
                            Swal.fire({
                                title: '¡Respaldo exitoso!',
                                text: 'El archivo se guardó como ' + data.archivo,
                                icon: 'success'
                            }).then(() => {
                                // Aquí se recarga la página justo después de cerrar el alert
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', 'No se pudo crear el respaldo.', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'Fallo la petición al servidor.', 'error');
                        console.error(error);
                    });
            }
        });
    });

    $(document).ready(function() {
        // Acción eliminar a papelera
        $('#tablaRespaldos').on('click', '.btnEliminar', function() {
            const idRespaldo = $(this).data('id');
            Swal.fire({
                title: '¿Eliminar respaldo?',
                text: "El archivo será movido a la papelera y ocultado de la lista.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('../pages/Ctrl/eliminar_respaldo.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: 'id=' + idRespaldo
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.exito) {
                                Swal.fire('¡Eliminado!', 'El respaldo fue movido a la papelera.', 'success')
                                    .then(() => location.reload());
                            } else {
                                Swal.fire('Error', data.error || 'No se pudo eliminar.', 'error');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Error', 'Error en la petición al servidor.', 'error');
                        });
                }
            });
        });
    });
</script>





<?php include_once "Ctrl/footer.php"; ?>