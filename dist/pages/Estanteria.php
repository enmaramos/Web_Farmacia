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
            <th>Eliminar</th> <!-- Solo si quieres eliminar -->
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
              // Botón Eliminar
              echo "<td>
                                    <button class='btn btn-danger btn-sm' data-id='" . $row['ID_Estanteria'] . "' title='Eliminar' onclick='confirmarEliminar(" . $row['ID_Estanteria'] . ")'>
                                        <i class='bx bx-trash'></i>
                                    </button>
                                  </td>";
              echo "</tr>";
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
<div class="modal fade" id="modalAgregarEstanteria" tabindex="-1" aria-labelledby="modalAgregarEstanteriaLabel" aria-hidden="true">
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
            <div class="estanteria-container">
              <div class="encabezado-filas-columnas"></div>
              <div class="estanteria-wrapper">
                <div class="indicadores-filas"></div>
                <div class="area-estanteria"></div>
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
        <button type="button" class="btn bg-primary text-white">Guardar</button>
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
    margin-left: 30px;
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
</style>

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
      input.addEventListener('input', dibujarEstanteria);
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
</script>


<?php
include_once "Ctrl/footer.php";
?>