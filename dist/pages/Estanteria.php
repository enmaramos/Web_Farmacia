<?php
include_once "Ctrl/head.php";
?>


<?php
include('../pages/Cnx/conexion.php');

// Obtener el filtro del tipo de estantería (Sala, Bodega o Todos)
$tipoFiltro = isset($_GET['tipo']) ? $_GET['tipo'] : 'Todos';

// Crear consulta según filtro
if ($tipoFiltro !== 'Todos') {
  $sql = "SELECT * FROM estanteria WHERE Tipo_Estanteria = '$tipoFiltro'";
} else {
  $sql = "SELECT * FROM estanteria";
}

$result = $conn->query($sql);
?>

<?php
include_once "Ctrl/menu.php";
?>

<!---table JQUERY -->
<script>
  $(document).ready(function() {
    $('#tablaEstanterias').DataTable();
  });
</script>

<!-- TABLA ESTANTERÍAS -->
<div class="container mt-4">
  <div class="card p-3 shadow-sm">
    <h3 class="text-center mb-3">Lista de Estanterías</h3>

    <div class="d-flex justify-content-between align-items-center mb-3">
      <!-- Botón Agregar -->
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarEstanteria">
        <i class="bx bx-plus"></i> Agregar Estantería
      </button>

      <!-- Filtro de Tipo -->
      <div>
        <label for="filtroTipoEstanteria" class="form-label me-2">Tipo:</label>
        <select id="filtroTipoEstanteria" class="form-select w-auto d-inline-block" onchange="filtrarTipoEstanteria()">
          <option value="Todos" <?= $tipoFiltro == 'Todos' ? 'selected' : '' ?>>Todos</option>
          <option value="Sala" <?= $tipoFiltro == 'Sala' ? 'selected' : '' ?>>Sala</option>
          <option value="Bodega" <?= $tipoFiltro == 'Bodega' ? 'selected' : '' ?>>Bodega</option>
        </select>
      </div>
    </div>

    <script>
      function filtrarTipoEstanteria() {
        const tipo = document.getElementById('filtroTipoEstanteria').value;
        window.location.href = "?tipo=" + tipo;
      }
    </script>

    <div class="table-responsive">
      <table id="tablaEstanterias" class="table table-striped text-center">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Ver</th>
            <th>Editar</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row['Nombre_Estanteria'] . "</td>";

              // Asignar clase de badge según tipo
              $tipo = $row['Tipo_Estanteria'];
              if ($tipo == 'Sala') {
                $claseBadge = 'bg-info';  // azul claro
              } elseif ($tipo == 'Bodega') {
                $claseBadge = 'bg-warning';  // amarillo (café claro)
              } else {
                $claseBadge = 'bg-secondary';  // gris por defecto
              }
              echo "<td><span class='badge $claseBadge'>" . $tipo . "</span></td>";

              // Botón Ver
              echo "<td>
                                    <button class='btn btn-success btn-sm' data-bs-toggle='modal' data-bs-target='#modalVerEstanteria' data-id='" . $row['ID_Estanteria'] . "' title='Ver'>
                                        <i class='bx bx-show'></i>
                                    </button>
                                  </td>";
              // Botón Editar
              echo "<td>
                                    <button class='btn btn-warning btn-sm text-white' data-bs-toggle='modal' data-bs-target='#modalEditarEstanteria' data-id='" . $row['ID_Estanteria'] . "' title='Editar'>
                                        <i class='bx bx-edit'></i>
                                    </button>
                                  </td>";
            }
          } else {
            echo "<tr><td colspan='5'>No se encontraron estanterías con el tipo seleccionado</td></tr>";
          }

          $conn->close();
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Agregar Estantería -->
<div class="modal fade" id="modalAgregarEstanteria" tabindex="-1" aria-labelledby="modalAgregarEstanteriaLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color: #17d5bb;">
        <h5 class="modal-title" id="modalAgregarEstanteriaLabel">Agregar Estantería</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">
          <!-- Estantería visual -->
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

          <!-- Formulario detalles -->
          <div class="col-md-4">
            <div class="card h-100 shadow-sm">
              <div class="card-header bg-light fw-bold small">Detalles del Estante</div>
              <div class="card-body p-3">
                <div class="mb-2">
                  <label class="form-label small">Nombre de la Estantería</label>
                  <input type="text" id="inputNombreEstanteria" class="form-control form-control-sm" placeholder="Ej: Estantería A">
                </div>

                <div class="mb-2">
                  <label class="form-label small">Ubicación</label>
                  <select class="form-select form-select-sm" id="selectUbicacion">
                    <option value="Sala">Sala</option>
                    <option value="Bodega">Bodega</option>
                  </select>
                </div>

                <div class="mb-2 d-flex align-items-center">
                  <div class="color-box bg-primary me-2"></div>
                  <label class="form-label small mb-0 me-2">Número de Columnas</label>
                  <input type="number" id="inputColumnas" class="form-control form-control-sm" style="width: 100px;" min="1" value="1">
                </div>

                <div class="mb-2 d-flex align-items-center">
                  <div class="color-box bg-success me-2"></div>
                  <label class="form-label small mb-0 me-2">Número de Filas</label>
                  <input type="number" id="inputFilas" class="form-control form-control-sm" style="width: 100px;" min="1" value="1">
                </div>

                <div class="mb-2 d-flex align-items-center">
                  <div class="color-box bg-warning me-2"></div>
                  <label class="form-label small mb-0 me-2">SubColumnas</label>
                  <input type="number" id="inputSubColumnas" class="form-control form-control-sm" style="width: 100px;" min="0" value="0">
                </div>

                <div class="mb-2 d-flex align-items-center">
                  <div class="color-box bg-danger me-2"></div>
                  <label class="form-label small mb-0 me-2">SubFilas</label>
                  <input type="number" id="inputSubFilas" class="form-control form-control-sm" style="width: 100px;" min="0" value="0">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn bg-primary text-white" id="btnGuardarEstanteria">Guardar</button>
      </div>
    </div>
  </div>
</div>

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
    grid-auto-rows: minmax(80px, auto);
    gap: 10px;
  }

  .indicadores-filas .color-indicator {
    justify-content: flex-start;
  }

  .area-estanteria {
    background: #c2c3c2;
    padding: 10px;
    border-radius: 8px;
    display: grid;
    grid-template-columns: repeat(var(--columnas), minmax(100px, 1fr));
    grid-auto-rows: minmax(80px, auto);
    gap: 10px;
    border: 2px solid #999;
    box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
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

  .estanteria-compartment {
    border: 1px solid #ccc;
    border-radius: 5px;
    text-align: center;
    padding: 8px;
    cursor: pointer;
    transition: transform 0.3s ease;
    animation: fadeIn 0.4s ease;
    position: relative;
    background: white;
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
    transform: translateX(-50%);
  }

  .linea-subfila {
    position: absolute;
    left: 0;
    right: 0;
    height: 2px;
    background-color: #dc3545;
    transform: translateY(-50%);
  }

  .swal2-container {
    z-index: 20000 !important;
    /* Más alto que el modal de bootstrap */
  }
</style>

<!-- script Agregar Estantería -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modalAgregarEstanteria');
    const encabezado = modal.querySelector('.encabezado-filas-columnas');
    const areaEstanteria = modal.querySelector('.area-estanteria');
    const indicadoresFilas = modal.querySelector('.indicadores-filas');

    const columnasInput = document.getElementById('inputColumnas');
    const filasInput = document.getElementById('inputFilas');
    const subColumnasInput = document.getElementById('inputSubColumnas');
    const subFilasInput = document.getElementById('inputSubFilas');

    function validarInput(input, min, max) {
      let valor = parseInt(input.value) || 0;
      if (valor < min) valor = min;
      if (valor > max) valor = max;
      input.value = valor;
    }

    function dibujarEstanteria() {
      validarInput(columnasInput, 1, 6);
      validarInput(filasInput, 1, 6);
      validarInput(subColumnasInput, 1, 5);
      validarInput(subFilasInput, 1, 5);

      let columnas = parseInt(columnasInput.value);
      let filas = parseInt(filasInput.value);
      let subColumnas = parseInt(subColumnasInput.value);
      let subFilas = parseInt(subFilasInput.value);

      encabezado.style.setProperty('--columnas', columnas);
      areaEstanteria.style.setProperty('--columnas', columnas);
      encabezado.innerHTML = '';
      areaEstanteria.innerHTML = '';
      indicadoresFilas.innerHTML = '';

      // Indicadores de columna
      for (let c = 1; c <= columnas; c++) {
        const colorColumna = document.createElement('div');
        colorColumna.classList.add('color-indicator');
        colorColumna.innerHTML = `<div class="color-box bg-primary" title="Columna ${c}"></div>`;
        encabezado.appendChild(colorColumna);
      }

      // Indicadores de fila y compartimentos
      for (let fila = 1; fila <= filas; fila++) {
        const colorFila = document.createElement('div');
        colorFila.classList.add('color-indicator');
        colorFila.innerHTML = `<div class="color-box bg-success" title="Fila ${fila}"></div>`;
        indicadoresFilas.appendChild(colorFila);

        for (let col = 1; col <= columnas; col++) {
          const compartimento = document.createElement('div');
          compartimento.classList.add('estanteria-compartment');
          compartimento.innerHTML = `
            <div class="subcolumnas-container"></div>
            <div class="subfilas-container"></div>
          `;

          const subcolumnasContainer = compartimento.querySelector('.subcolumnas-container');
          for (let i = 1; i < subColumnas; i++) {
            const lineaV = document.createElement('div');
            lineaV.classList.add('linea-subcolumna');
            lineaV.style.left = `${(100 / subColumnas) * i}%`;
            subcolumnasContainer.appendChild(lineaV);
          }

          const subfilasContainer = compartimento.querySelector('.subfilas-container');
          for (let j = 1; j < subFilas; j++) {
            const lineaH = document.createElement('div');
            lineaH.classList.add('linea-subfila');
            lineaH.style.top = `${(100 / subFilas) * j}%`;
            subfilasContainer.appendChild(lineaH);
          }

          areaEstanteria.appendChild(compartimento);
        }
      }
    }

    [columnasInput, filasInput, subColumnasInput, subFilasInput].forEach(input => {
      input.addEventListener('change', dibujarEstanteria);
    });

    modal.addEventListener('shown.bs.modal', () => {
      dibujarEstanteria();
    });

    modal.addEventListener('hidden.bs.modal', () => {
      columnasInput.value = '';
      filasInput.value = '';
      subColumnasInput.value = '';
      subFilasInput.value = '';
      encabezado.innerHTML = '';
      areaEstanteria.innerHTML = '';
      indicadoresFilas.innerHTML = '';
    });
  });


  //guardar datos ne mi base de datos 
  document.getElementById('btnGuardarEstanteria').addEventListener('click', () => {
    const nombre = document.getElementById('inputNombreEstanteria').value.trim();
    const tipo = document.getElementById('selectUbicacion').value;
    const columnas = document.getElementById('inputColumnas').value;
    const filas = document.getElementById('inputFilas').value;
    const subColumnas = document.getElementById('inputSubColumnas').value;
    const subFilas = document.getElementById('inputSubFilas').value;

    if (nombre === '') {
      Swal.fire({
        icon: 'warning',
        title: 'Oops...',
        text: 'Por favor, ingresa el nombre de la estantería.'
      });
      return;
    }

    const data = new URLSearchParams();
    data.append('nombre', nombre);
    data.append('tipo', tipo);
    data.append('columnas', columnas);
    data.append('filas', filas);
    data.append('subColumnas', subColumnas);
    data.append('subFilas', subFilas);

    fetch('../pages/Ctrl/guardar_estanteria.php', {
        method: 'POST',
        body: data
      })
      .then(response => response.json())
      .then(result => {
        if (result.success) {
          Swal.fire({
            icon: 'success',
            title: 'Guardado',
            text: result.message,
            timer: 2000,
            showConfirmButton: false
          }).then(() => {
            // Cerrar modal y recargar página para ver cambios
            const modalEl = document.getElementById('modalAgregarEstanteria');
            const modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();
            window.location.reload();
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: result.message
          });
        }
      })
      .catch(error => {
        Swal.fire({
          icon: 'error',
          title: 'Error en la petición',
          text: error
        });
      });
  });
</script>

<!-- Modal Ver Estantería -->
<div class="modal fade" id="modalVerEstanteria" tabindex="-1" aria-labelledby="modalVerEstanteriaLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #17d5bb; color: #2e2e2e;">
        <h5 class="modal-title" id="modalVerEstanteriaLabel">Detalle Estantería</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- Columna del dibujo -->
          <div class="col-lg-8">
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

          <!-- Columna de datos -->
          <div class="col-lg-4">
            <div id="detalleEstanteriaTexto" class="mb-3"></div>

            <div class="mb-3">
              <label class="form-label small">Ubicación</label>
              <select class="form-select form-select-sm" id="selectUbicacion" disabled>
                <option value="Sala">Sala</option>
                <option value="Bodega">Bodega</option>
              </select>
            </div>

            <div class="mb-2 d-flex align-items-center">
              <div class="color-box bg-primary me-2"></div>
              <label class="form-label small mb-0 me-2">N° Columnas</label>
              <input type="number" id="inputColumnas" class="form-control form-control-sm" style="width: 100px;" min="1" disabled>
            </div>

            <div class="mb-2 d-flex align-items-center">
              <div class="color-box bg-success me-2"></div>
              <label class="form-label small mb-0 me-2">N° Filas</label>
              <input type="number" id="inputFilas" class="form-control form-control-sm" style="width: 100px;" min="1" disabled>
            </div>

            <div class="mb-2 d-flex align-items-center">
              <div class="color-box bg-warning me-2"></div>
              <label class="form-label small mb-0 me-2">SubColumnas</label>
              <input type="number" id="inputSubColumnas" class="form-control form-control-sm" style="width: 100px;" min="0" disabled>
            </div>

            <div class="mb-2 d-flex align-items-center">
              <div class="color-box bg-danger me-2"></div>
              <label class="form-label small mb-0 me-2">SubFilas</label>
              <input type="number" id="inputSubFilas" class="form-control form-control-sm" style="width: 100px;" min="0" disabled>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- script Ver Estantería -->
<script>
  modalVerEstanteria.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget;
    const idEstanteria = button.getAttribute('data-id');

    const encabezado = modalVerEstanteria.querySelector('.encabezado-filas-columnas');
    const areaEstanteria = modalVerEstanteria.querySelector('.area-estanteria');
    const indicadoresFilas = modalVerEstanteria.querySelector('.indicadores-filas');
    const detalleTexto = modalVerEstanteria.querySelector('#detalleEstanteriaTexto');

    // Nuevos campos
    const selectUbicacion = modalVerEstanteria.querySelector('#selectUbicacion');
    const inputColumnas = modalVerEstanteria.querySelector('#inputColumnas');
    const inputFilas = modalVerEstanteria.querySelector('#inputFilas');
    const inputSubColumnas = modalVerEstanteria.querySelector('#inputSubColumnas');
    const inputSubFilas = modalVerEstanteria.querySelector('#inputSubFilas');

    encabezado.innerHTML = 'Cargando...';
    areaEstanteria.innerHTML = '';
    indicadoresFilas.innerHTML = '';
    detalleTexto.innerHTML = '';

    // Reset inputs
    selectUbicacion.value = '';
    inputColumnas.value = '';
    inputFilas.value = '';
    inputSubColumnas.value = '';
    inputSubFilas.value = '';

    fetch(`../pages/Ctrl/ver_estanteria.php?id=${idEstanteria}`)
      .then(response => response.json())
      .then(data => {
        if (!data.success) {
          encabezado.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
          return;
        }

        const est = data.estanteria;

        const columnas = parseInt(est.Cantidad_Columnas) || 1;
        const filas = parseInt(est.Cantidad_Filas) || 1;
        const subColumnas = parseInt(est.SubColumnas) || 0;
        const subFilas = parseInt(est.SubFilas) || 0;

        encabezado.innerHTML = '';
        areaEstanteria.innerHTML = '';
        indicadoresFilas.innerHTML = '';
        detalleTexto.innerHTML = `
        <p><strong>Nombre:</strong> ${est.Nombre_Estanteria}</p>
        <p><strong>Tipo:</strong> ${est.Tipo_Estanteria}</p>
      `;

        // Asignar valores a inputs/select
        selectUbicacion.value = est.Tipo_Estanteria || 'Sala';
        inputColumnas.value = columnas;
        inputFilas.value = filas;
        inputSubColumnas.value = subColumnas;
        inputSubFilas.value = subFilas;

        encabezado.style.setProperty('--columnas', columnas);
        areaEstanteria.style.setProperty('--columnas', columnas);

        // Dibujar encabezado columnas
        for (let c = 1; c <= columnas; c++) {
          const col = document.createElement('div');
          col.classList.add('color-indicator');
          col.innerHTML = `<div class="color-box bg-primary" title="Columna ${c}"></div>`;
          encabezado.appendChild(col);
        }

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

            const subColsCont = compartimento.querySelector('.subcolumnas-container');
            for (let i = 1; i < subColumnas; i++) {
              const lineaV = document.createElement('div');
              lineaV.classList.add('linea-subcolumna');
              lineaV.style.left = `${(100 / subColumnas) * i}%`;
              subColsCont.appendChild(lineaV);
            }

            const subFilasCont = compartimento.querySelector('.subfilas-container');
            for (let j = 1; j < subFilas; j++) {
              const lineaH = document.createElement('div');
              lineaH.classList.add('linea-subfila');
              lineaH.style.top = `${(100 / subFilas) * j}%`;
              subFilasCont.appendChild(lineaH);
            }

            areaEstanteria.appendChild(compartimento);
          }
        }
      })
      .catch(err => {
        encabezado.innerHTML = `<div class="alert alert-danger">Error al cargar datos</div>`;
        console.error(err);
      });
  });
</script>

<!-- Modal Editar Estantería -->
<div class="modal fade" id="modalEditarEstanteria" tabindex="-1" aria-labelledby="modalEditarEstanteriaLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #17d5bb; color: #2e2e2e;">
        <h5 class="modal-title" id="modalEditarEstanteriaLabel">Editar Estantería</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- Estantería visual -->
          <div class="col-lg-8">
            <div class="estanteria-container bg-metalica p-2 rounded">
              <div class="zona-principal">
                <div class="encabezado-filas-columnas" id="encabezadoEditar"></div>
                <div class="estanteria-wrapper">
                  <div class="indicadores-filas" id="indicadoresEditar"></div>
                  <div class="area-estanteria" id="areaEditar"></div>
                </div>
              </div>
            </div>
          </div>

          <!-- Formulario -->
          <div class="col-lg-4">
            <input type="hidden" id="inputIDEstanteriaEditar">
            <div class="mb-2">
              <label class="form-label small">Nombre de la Estantería</label>
              <input type="text" id="inputNombreEstanteriaEditar" class="form-control form-control-sm">
            </div>

            <div class="mb-2">
              <label class="form-label small">Ubicación</label>
              <select class="form-select form-select-sm" id="selectUbicacionEditar">
                <option value="Sala">Sala</option>
                <option value="Bodega">Bodega</option>
              </select>
            </div>

            <div class="mb-2 d-flex align-items-center">
              <div class="color-box bg-primary me-2"></div>
              <label class="form-label small mb-0 me-2">N° Columnas</label>
              <input type="number" id="inputColumnasEditar" class="form-control form-control-sm" style="width: 100px;" min="1">
            </div>

            <div class="mb-2 d-flex align-items-center">
              <div class="color-box bg-success me-2"></div>
              <label class="form-label small mb-0 me-2">N° Filas</label>
              <input type="number" id="inputFilasEditar" class="form-control form-control-sm" style="width: 100px;" min="1">
            </div>

            <div class="mb-2 d-flex align-items-center">
              <div class="color-box bg-warning me-2"></div>
              <label class="form-label small mb-0 me-2">SubColumnas</label>
              <input type="number" id="inputSubColumnasEditar" class="form-control form-control-sm" style="width: 100px;" min="0">
            </div>

            <div class="mb-2 d-flex align-items-center">
              <div class="color-box bg-danger me-2"></div>
              <label class="form-label small mb-0 me-2">SubFilas</label>
              <input type="number" id="inputSubFilasEditar" class="form-control form-control-sm" style="width: 100px;" min="0">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn bg-primary text-white" id="btnActualizarEstanteria">Actualizar</button>
      </div>
    </div>
  </div>
</div>

<!-- script Editar Estantería -->
<script>
  const modalEditarEstanteria = document.getElementById('modalEditarEstanteria');

  modalEditarEstanteria.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget;
    const idEstanteria = button.getAttribute('data-id');

    const encabezado = modalEditarEstanteria.querySelector('#encabezadoEditar');
    const areaEstanteria = modalEditarEstanteria.querySelector('#areaEditar');
    const indicadores = modalEditarEstanteria.querySelector('#indicadoresEditar');

    const nombreInput = modalEditarEstanteria.querySelector('#inputNombreEstanteriaEditar');
    const selectUbicacion = modalEditarEstanteria.querySelector('#selectUbicacionEditar');
    const inputColumnas = modalEditarEstanteria.querySelector('#inputColumnasEditar');
    const inputFilas = modalEditarEstanteria.querySelector('#inputFilasEditar');
    const inputSubColumnas = modalEditarEstanteria.querySelector('#inputSubColumnasEditar');
    const inputSubFilas = modalEditarEstanteria.querySelector('#inputSubFilasEditar');
    const inputID = modalEditarEstanteria.querySelector('#inputIDEstanteriaEditar');

    // Limpiar
    encabezado.innerHTML = 'Cargando...';
    areaEstanteria.innerHTML = '';
    indicadores.innerHTML = '';

    fetch(`../pages/Ctrl/ver_estanteria.php?id=${idEstanteria}`)
      .then(response => response.json())
      .then(data => {
        if (!data.success) {
          encabezado.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
          return;
        }

        const est = data.estanteria;

        const columnas = parseInt(est.Cantidad_Columnas) || 1;
        const filas = parseInt(est.Cantidad_Filas) || 1;
        const subColumnas = parseInt(est.SubColumnas) || 0;
        const subFilas = parseInt(est.SubFilas) || 0;

        // Asignar
        inputID.value = est.ID_Estanteria || '';
        nombreInput.value = est.Nombre_Estanteria || '';
        selectUbicacion.value = est.Tipo_Estanteria || 'Sala';
        inputColumnas.value = columnas;
        inputFilas.value = filas;
        inputSubColumnas.value = subColumnas;
        inputSubFilas.value = subFilas;

        // Dibujar
        function dibujarEditarEstanteria() {
          encabezado.innerHTML = '';
          areaEstanteria.innerHTML = '';
          indicadores.innerHTML = '';
          encabezado.style.setProperty('--columnas', columnas);
          areaEstanteria.style.setProperty('--columnas', columnas);

          for (let c = 1; c <= columnas; c++) {
            const col = document.createElement('div');
            col.classList.add('color-indicator');
            col.innerHTML = `<div class="color-box bg-primary" title="Columna ${c}"></div>`;
            encabezado.appendChild(col);
          }

          for (let f = 1; f <= filas; f++) {
            const fila = document.createElement('div');
            fila.classList.add('color-indicator');
            fila.innerHTML = `<div class="color-box bg-success" title="Fila ${f}"></div>`;
            indicadores.appendChild(fila);

            for (let c = 1; c <= columnas; c++) {
              const compartimento = document.createElement('div');
              compartimento.classList.add('estanteria-compartment');
              compartimento.innerHTML = `
                <div class="subcolumnas-container"></div>
                <div class="subfilas-container"></div>
              `;

              const subColsCont = compartimento.querySelector('.subcolumnas-container');
              for (let i = 1; i < subColumnas; i++) {
                const lineaV = document.createElement('div');
                lineaV.classList.add('linea-subcolumna');
                lineaV.style.left = `${(100 / subColumnas) * i}%`;
                subColsCont.appendChild(lineaV);
              }

              const subFilasCont = compartimento.querySelector('.subfilas-container');
              for (let j = 1; j < subFilas; j++) {
                const lineaH = document.createElement('div');
                lineaH.classList.add('linea-subfila');
                lineaH.style.top = `${(100 / subFilas) * j}%`;
                subFilasCont.appendChild(lineaH);
              }

              areaEstanteria.appendChild(compartimento);
            }
          }
        }

        // Redibujar cuando cambian los valores
        [inputColumnas, inputFilas, inputSubColumnas, inputSubFilas].forEach(input => {
          input.addEventListener('input', dibujarEditarEstanteria);
        });

        dibujarEditarEstanteria();
      })
      .catch(err => {
        encabezado.innerHTML = `<div class="alert alert-danger">Error al cargar datos</div>`;
        console.error(err);
      });
  });


  // para aumentar y encluir colunas y filas y sub columnas y sub filas 
   document.addEventListener('DOMContentLoaded', () => {
    const modalEditar = document.getElementById('modalEditarEstanteria');
    const encabezadoEditar = modalEditar.querySelector('#encabezadoEditar');
    const areaEditar = modalEditar.querySelector('#areaEditar');
    const indicadoresEditar = modalEditar.querySelector('#indicadoresEditar');

    const columnasInputEditar = document.getElementById('inputColumnasEditar');
    const filasInputEditar = document.getElementById('inputFilasEditar');
    const subColumnasInputEditar = document.getElementById('inputSubColumnasEditar');
    const subFilasInputEditar = document.getElementById('inputSubFilasEditar');

    function validarInput(input, min, max) {
      let valor = parseInt(input.value) || 0;
      if (valor < min) valor = min;
      if (valor > max) valor = max;
      input.value = valor;
    }

    function redibujarEstanteriaEditar() {
      validarInput(columnasInputEditar, 1, 6);
      validarInput(filasInputEditar, 1, 6);
      validarInput(subColumnasInputEditar, 0, 5);
      validarInput(subFilasInputEditar, 0, 5);

      let columnas = parseInt(columnasInputEditar.value);
      let filas = parseInt(filasInputEditar.value);
      let subColumnas = parseInt(subColumnasInputEditar.value);
      let subFilas = parseInt(subFilasInputEditar.value);

      encabezadoEditar.style.setProperty('--columnas', columnas);
      areaEditar.style.setProperty('--columnas', columnas);

      encabezadoEditar.innerHTML = '';
      areaEditar.innerHTML = '';
      indicadoresEditar.innerHTML = '';

      // Encabezado columnas
      for (let c = 1; c <= columnas; c++) {
        const divCol = document.createElement('div');
        divCol.classList.add('color-indicator');
        divCol.innerHTML = `<div class="color-box bg-primary" title="Columna ${c}"></div>`;
        encabezadoEditar.appendChild(divCol);
      }

      // Filas y compartimentos
      for (let f = 1; f <= filas; f++) {
        const divFila = document.createElement('div');
        divFila.classList.add('color-indicator');
        divFila.innerHTML = `<div class="color-box bg-success" title="Fila ${f}"></div>`;
        indicadoresEditar.appendChild(divFila);

        for (let c = 1; c <= columnas; c++) {
          const compartimento = document.createElement('div');
          compartimento.classList.add('estanteria-compartment');
          compartimento.innerHTML = `
            <div class="subcolumnas-container"></div>
            <div class="subfilas-container"></div>
          `;

          const subColsCont = compartimento.querySelector('.subcolumnas-container');
          for (let i = 1; i < subColumnas; i++) {
            const lineaV = document.createElement('div');
            lineaV.classList.add('linea-subcolumna');
            lineaV.style.left = `${(100 / subColumnas) * i}%`;
            subColsCont.appendChild(lineaV);
          }

          const subFilasCont = compartimento.querySelector('.subfilas-container');
          for (let j = 1; j < subFilas; j++) {
            const lineaH = document.createElement('div');
            lineaH.classList.add('linea-subfila');
            lineaH.style.top = `${(100 / subFilas) * j}%`;
            subFilasCont.appendChild(lineaH);
          }

          areaEditar.appendChild(compartimento);
        }
      }
    }

    // Redibujar al cambiar cualquier input
    [columnasInputEditar, filasInputEditar, subColumnasInputEditar, subFilasInputEditar].forEach(input => {
      input.addEventListener('change', redibujarEstanteriaEditar);
    });

    // También podrías agregarlo al evento de mostrar el modal
    modalEditar.addEventListener('shown.bs.modal', () => {
      redibujarEstanteriaEditar();
    });
  });

   // Actualisar estante en la base de datos 
  document.getElementById('btnActualizarEstanteria').addEventListener('click', () => {
    const idEstanteria = document.getElementById('inputIDEstanteriaEditar').value;
    const nombre = document.getElementById('inputNombreEstanteriaEditar').value.trim();
    const tipo = document.getElementById('selectUbicacionEditar').value;
    const columnas = document.getElementById('inputColumnasEditar').value;
    const filas = document.getElementById('inputFilasEditar').value;
    const subColumnas = document.getElementById('inputSubColumnasEditar').value;
    const subFilas = document.getElementById('inputSubFilasEditar').value;

    if (nombre === '') {
      Swal.fire({
        icon: 'warning',
        title: 'Campo vacío',
        text: 'Por favor, ingresa el nombre de la estantería.'
      });
      return;
    }

    const datos = new URLSearchParams();
    datos.append('id', idEstanteria);
    datos.append('nombre', nombre);
    datos.append('tipo', tipo);
    datos.append('columnas', columnas);
    datos.append('filas', filas);
    datos.append('subColumnas', subColumnas);
    datos.append('subFilas', subFilas);

    fetch('../pages/Ctrl/actualizar_estanteria.php', {
      method: 'POST',
      body: datos
    })
    .then(response => response.json())
    .then(resultado => {
      if (resultado.success) {
        Swal.fire({
          icon: 'success',
          title: 'Estantería actualizada',
          text: resultado.message,
          timer: 2000,
          showConfirmButton: false
        }).then(() => {
          const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarEstanteria'));
          modal.hide();
          window.location.reload(); // Actualiza para reflejar cambios
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: resultado.message
        });
      }
    })
    .catch(error => {
      Swal.fire({
        icon: 'error',
        title: 'Error de red',
        text: error
      });
    });
  });

</script>



<?php
include_once "Ctrl/footer.php";
?>