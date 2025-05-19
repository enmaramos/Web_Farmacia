<?php
include_once "Ctrl/head.php";
date_default_timezone_set('America/Managua');
?>





<?php include_once "Ctrl/menu.php"; ?>



<!-- CSS para animaciones -->
<style>
  /* Ocultamos inicialmente los desglose de efectivo */
  .desglose-cordobas,
  .desglose-dolares {
    display: none;
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 5px;
    background-color: #f9f9f9;
  }

  /* esto cambia el color a los imput con contenido en formuario de apertura */
  .input-resaltado {
    background-color: #e9ecef !important;
    /* gris claro */
    border: 2px solid #0d6efd !important;
    /* azul Bootstrap */
    font-weight: bold;
    color: #000;
  }

   /* Solo para el formulario de cierre */
  #formCierre .desglose-cordobas,
  #formCierre .desglose-dolares {
    display: block !important;
  }

  /* Para que no se muestren en el de apertura */
  #formApertura .desglose-cordobas,
  #formApertura .desglose-dolares {
    display: none !important;
  }
</style>




<!-- 🔘 BOTONES PARA MOSTRAR FORMULARIOS -->
<div class="container mt-4 text-center">
  <button id="btnApertura" class="btn btn-primary me-2">🔹 Apertura de Caja</button>
  <button id="btnCierre" class="btn btn-danger">🔻 Cierre de Caja</button>
</div>

<!-- 🔹 Apertura de Caja -->
<div id="formApertura">
  <div class="container my-5">
    <div class="card shadow-lg">
      <div class="card-header text-center" style="background-color: #0076ad; color: white;">
        <h4 class="mb-0" style="color: black;"><i class="bi bi-box-arrow-in-right me-2"></i>Apertura de Caja</h4>
      </div>
      <div class="card-body">
        <form id="aperturaCajaForm" class="form-caja">
          <input type="hidden" name="tipo" value="apertura" />
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Cajero</label>
              <input type="text" name="cajero" class="form-control" value="<?php echo $_SESSION['Nombre_Usuario']; ?>" readonly />
            </div>
            <div class="col-md-6">
              <label class="form-label">Fecha y Hora</label>
              <input type="text" name="fecha_hora" class="form-control" value="<?php echo date('Y-m-d H:i:s'); ?>" readonly />
            </div>
          </div>

          <div class="row g-3 mb-2">
            <div class="col-md-6">
              <label class="form-label">Monto en Córdobas</label>
              <div class="input-group">
                <span class="input-group-text">C$</span>
                <input
                  type="number"
                  name="monto_cordobas"
                  class="form-control monto-cordobas"
                  step="0.01"
                  min="0" />
              </div>
            </div>
          </div>

          <!-- Desglose Córdobas -->
          <div class="desglose-efectivo desglose-cordobas mb-3">
            <label class="form-label">💵 Desglose de Billetes (C$)</label>
            <div class="row g-2 mb-2">
              <!-- Billetes -->
              <div class="col-3"><label>C$5</label><input type="number" class="form-control form-control-sm" name="billete_5" min="0" /></div>
              <div class="col-3"><label>C$10</label><input type="number" class="form-control form-control-sm" name="billete_10" min="0" /></div>
              <div class="col-3"><label>C$20</label><input type="number" class="form-control form-control-sm" name="billete_20" min="0" /></div>
              <div class="col-3"><label>C$50</label><input type="number" class="form-control form-control-sm" name="billete_50" min="0" /></div>
              <div class="col-3"><label>C$100</label><input type="number" class="form-control form-control-sm" name="billete_100" min="0" /></div>
              <div class="col-3"><label>C$200</label><input type="number" class="form-control form-control-sm" name="billete_200" min="0" /></div>
              <div class="col-3"><label>C$500</label><input type="number" class="form-control form-control-sm" name="billete_500" min="0" /></div>
              <div class="col-3"><label>C$1000</label><input type="number" class="form-control form-control-sm" name="billete_1000" min="0" /></div>
            </div>
            <label class="form-label">💵 Desglose de Monedas (¢)</label>
            <!-- Monedas -->
            <div class="row g-2">
              <div class="col-2"><label>¢5</label><input type="number" class="form-control form-control-sm" name="moneda_c5" min="0" /></div>
              <div class="col-2"><label>¢10</label><input type="number" class="form-control form-control-sm" name="moneda_c10" min="0" /></div>
              <div class="col-2"><label>¢25</label><input type="number" class="form-control form-control-sm" name="moneda_c25" min="0" /></div>
              <div class="col-2"><label>¢50</label><input type="number" class="form-control form-control-sm" name="moneda_c50" min="0" /></div>
              <div class="col-2"><label>C$1</label><input type="number" class="form-control form-control-sm" name="moneda_1" min="0" /></div>
              <div class="col-2"><label>C$5</label><input type="number" class="form-control form-control-sm" name="moneda_5" min="0" /></div>
              <div class="col-2"><label>C$10</label><input type="number" class="form-control form-control-sm" name="moneda_10" min="0" /></div>
            </div>
          </div>

          <!-- Dólares -->
          <div class="row g-3 mb-2">
            <div class="col-md-6">
              <label class="form-label">Monto en Dólares</label>
              <div class="input-group">
                <span class="input-group-text">$</span>
                <input
                  type="number"
                  name="monto_dolares"
                  class="form-control monto-dolares"
                  step="0.01"
                  min="0" />
              </div>
            </div>
          </div>

          <!-- Desglose Dólares -->
          <div class="desglose-efectivo desglose-dolares mb-3">
            <label class="form-label">💵 Desglose de Billetes (USD)</label>
            <div class="row g-2">
              <div class="col-2"><label>$1</label><input type="number" class="form-control form-control-sm" name="usd_1" min="0" /></div>
              <div class="col-2"><label>$2</label><input type="number" class="form-control form-control-sm" name="usd_2" min="0" /></div>
              <div class="col-2"><label>$5</label><input type="number" class="form-control form-control-sm" name="usd_5" min="0" /></div>
              <div class="col-2"><label>$10</label><input type="number" class="form-control form-control-sm" name="usd_10" min="0" /></div>
              <div class="col-2"><label>$20</label><input type="number" class="form-control form-control-sm" name="usd_20" min="0" /></div>
              <div class="col-2"><label>$50</label><input type="number" class="form-control form-control-sm" name="usd_50" min="0" /></div>
              <div class="col-2"><label>$100</label><input type="number" class="form-control form-control-sm" name="usd_100" min="0" /></div>
            </div>
          </div>

          <!-- Observaciones -->
          <div class="row g-3 mt-3">
            <div class="col-md-12">
              <label class="form-label">Observaciones</label>
              <textarea name="observaciones" class="form-control" rows="3"></textarea>
            </div>
          </div>

          <div class="text-center mt-3">
            <button type="submit" class="btn btn-success">
              <i class="bi bi-check-circle me-1"></i>Abrir Caja
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- 🔻 Cierre de Caja (estructura similar) -->
<div id="formCierre" style="display: none;">
  <div class="container my-5">
    <div class="card shadow-lg">
      <div class="card-header text-center" style="background-color: #dc3545; color: white;">
        <h4 class="mb-0" style="color: black;"><i class="bi bi-box-arrow-left me-2"></i>Cierre de Caja</h4>
      </div>
      <div class="card-body">
        <form id="cierreCajaForm" class="form-caja">
          <input type="hidden" name="tipo" value="cierre" />

          <!-- Cajero y Fecha -->
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Cajero</label>
              <input type="text" name="cajero" class="form-control" value="<?php echo $_SESSION['Nombre_Usuario']; ?>" readonly />
            </div>
            <div class="col-md-6">
              <label class="form-label">Fecha y Hora</label>
              <input type="text" name="fecha_hora" class="form-control" value="<?php echo date('Y-m-d H:i:s'); ?>" readonly />
            </div>

            <!-- Total de Ventas -->
            <div class="col-md-6">
              <label class="form-label">Total de Ventas</label>
              <input type="number" name="total_ventas" class="form-control" readonly style="background-color: #e9ecef;" />
            </div>
          </div>

          <!-- Montos C$ y USD en una sola fila -->
          <div class="row g-3 mb-2">
            <div class="col-md-6">
              <label class="form-label">Monto en Córdobas</label>
              <div class="input-group">
                <span class="input-group-text">C$</span>
                <input
                  type="text"
                  name="monto_cordobas"
                  class="form-control monto-cordobas"
                  readonly
                  style="background-color: #e9ecef;" />

              </div>
            </div>
            <div class="col-md-6">
              <label class="form-label">Monto en Dólares</label>
              <div class="input-group">
                <span class="input-group-text">$</span>
                <input
                  type="text"
                  name="monto_dolares"
                  class="form-control monto-dolares"
                  readonly
                  style="background-color: #e9ecef;" />

              </div>
            </div>
          </div>

          <!-- Desgloses en columnas: C$ izquierda, USD derecha -->
          <div class="row g-3 mb-3">
            <!-- Desglose Córdobas -->
            <div class="col-md-6 desglose-cordobas">
              <label class="form-label">💵 Desglose de Billetes y Monedas (C$)</label>
              <div class="row g-2 mb-2">
                <div class="col-3"><label>C$5</label><input type="number" class="form-control form-control-sm" name="billete_5" min="0" /></div>
                <div class="col-3"><label>C$10</label><input type="number" class="form-control form-control-sm" name="billete_10" min="0" /></div>
                <div class="col-3"><label>C$20</label><input type="number" class="form-control form-control-sm" name="billete_20" min="0" /></div>
                <div class="col-3"><label>C$50</label><input type="number" class="form-control form-control-sm" name="billete_50" min="0" /></div>
                <div class="col-3"><label>C$100</label><input type="number" class="form-control form-control-sm" name="billete_100" min="0" /></div>
                <div class="col-3"><label>C$200</label><input type="number" class="form-control form-control-sm" name="billete_200" min="0" /></div>
                <div class="col-3"><label>C$500</label><input type="number" class="form-control form-control-sm" name="billete_500" min="0" /></div>
                <div class="col-3"><label>C$1000</label><input type="number" class="form-control form-control-sm" name="billete_1000" min="0" /></div>
              </div>
              <div class="row g-2">
                <div class="col-2"><label>¢5</label><input type="number" class="form-control form-control-sm" name="moneda_c5" min="0" /></div>
                <div class="col-2"><label>¢10</label><input type="number" class="form-control form-control-sm" name="moneda_c10" min="0" /></div>
                <div class="col-2"><label>¢25</label><input type="number" class="form-control form-control-sm" name="moneda_c25" min="0" /></div>
                <div class="col-2"><label>¢50</label><input type="number" class="form-control form-control-sm" name="moneda_c50" min="0" /></div>
                <div class="col-2"><label>C$1</label><input type="number" class="form-control form-control-sm" name="moneda_1" min="0" /></div>
                <div class="col-2"><label>C$5</label><input type="number" class="form-control form-control-sm" name="moneda_5" min="0" /></div>
                <div class="col-2"><label>C$10</label><input type="number" class="form-control form-control-sm" name="moneda_10" min="0" /></div>
              </div>
            </div>

            <!-- Desglose Dólares -->
            <div class="col-md-6 desglose-dolares">
              <label class="form-label">💵 Desglose de Billetes (USD)</label>
              <div class="row g-2">
                <div class="col-3"><label>$1</label><input type="number" class="form-control form-control-sm" name="usd_1" min="0" /></div>
                <div class="col-3"><label>$2</label><input type="number" class="form-control form-control-sm" name="usd_2" min="0" /></div>
                <div class="col-3"><label>$5</label><input type="number" class="form-control form-control-sm" name="usd_5" min="0" /></div>
                <div class="col-3"><label>$10</label><input type="number" class="form-control form-control-sm" name="usd_10" min="0" /></div>
                <div class="col-3"><label>$20</label><input type="number" class="form-control form-control-sm" name="usd_20" min="0" /></div>
                <div class="col-3"><label>$50</label><input type="number" class="form-control form-control-sm" name="usd_50" min="0" /></div>
                <div class="col-3"><label>$100</label><input type="number" class="form-control form-control-sm" name="usd_100" min="0" /></div>
              </div>
            </div>
          </div>

          <!-- Observaciones -->
          <div class="row g-3 mt-3">
            <div class="col-md-12">
              <label class="form-label">Observaciones</label>
              <textarea name="observaciones" class="form-control" rows="3"></textarea>
            </div>
          </div>

          <div class="text-center mt-3">
            <button type="submit" class="btn btn-danger">
              <i class="bi bi-check-circle me-1"></i>Cerrar Caja
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>




<!-- 🔧 SCRIPTS -->

<script>
  // Alternar visibilidad de formularios
  document.getElementById('btnApertura').addEventListener('click', () => {
    document.getElementById('formApertura').style.display = 'block';
    document.getElementById('formCierre').style.display = 'none';
  });

  document.getElementById('btnCierre').addEventListener('click', () => {
    document.getElementById('formApertura').style.display = 'none';
    document.getElementById('formCierre').style.display = 'block';
  });

  // Envío de formularios (puedes reemplazar con fetch/AJAX después)
  document.getElementById('aperturaCajaForm')?.addEventListener('submit', e => {
    e.preventDefault();
    // Aquí va tu lógica de envío
  });

  document.getElementById('cierreCajaForm')?.addEventListener('submit', e => {
    e.preventDefault();
    // Aquí va tu lógica de envío
  });
</script>


<script src="../js/cajas.js?123"></script>

<?php include_once "Ctrl/footer.php"; ?>