<?php
include_once "Ctrl/head.php";
?>





<?php include_once "Ctrl/menu.php"; ?>



<!-- CSS para animaciones -->
 <style>
    /* Ocultamos inicialmente los desglose de efectivo */
    .desglose-cordobas, .desglose-dolares {
      display: none;
      border: 1px solid #ddd;
      padding: 15px;
      border-radius: 5px;
      background-color: #f9f9f9;
    }
  </style>
</head>
<body>

<!-- 🔹 Apertura de Caja -->
<div class="container my-5">
  <div class="card shadow-lg">
    <div class="card-header text-center" style="background-color: #0076ad; color: white;">
      <h4 class="mb-0" style="color: black;"><i class="bi bi-box-arrow-in-right me-2"></i>Apertura de Caja</h4>
    </div>
    <div class="card-body">
      <form id="aperturaCajaForm" class="form-caja">
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label">Cajero</label>
            <input type="text" name="cajero" class="form-control" required />
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
                min="0"
              />
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
                min="0"
              />
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

<!-- 🔻 Cierre de Caja (estructura similar) -->
<div class="container my-5">
  <div class="card shadow-lg">
    <div class="card-header text-center" style="background-color: #dc3545; color: white;">
      <h4 class="mb-0" style="color: black;"><i class="bi bi-box-arrow-left me-2"></i>Cierre de Caja</h4>
    </div>
    <div class="card-body">
      <form id="cierreCajaForm" class="form-caja">
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label">Cajero</label>
            <input type="text" name="cajero" class="form-control" required />
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
                min="0"
              />
            </div>
          </div>
        </div>

        <!-- Desglose Córdobas -->
        <div class="desglose-efectivo desglose-cordobas mb-3">
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
                min="0"
              />
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



<script>
  // Función para mostrar u ocultar los desgloses según monto
  function toggleDesglose() {
    document.querySelectorAll('.form-caja').forEach(form => {
      const montoCordobasInput = form.querySelector('.monto-cordobas');
      const montoDolaresInput = form.querySelector('.monto-dolares');
      const desgloseCordobas = form.querySelector('.desglose-cordobas');
      const desgloseDolares = form.querySelector('.desglose-dolares');

      // Mostrar desglose córdobas solo si monto_cordobas > 0
      if (montoCordobasInput && desgloseCordobas) {
        desgloseCordobas.style.display = parseFloat(montoCordobasInput.value) > 0 ? 'block' : 'none';
      }

      // Mostrar desglose dólares solo si monto_dolares > 0
      if (montoDolaresInput && desgloseDolares) {
        desgloseDolares.style.display = parseFloat(montoDolaresInput.value) > 0 ? 'block' : 'none';
      }
    });
  }

  // Asociar eventos input para actualización en tiempo real
  document.querySelectorAll('.form-caja').forEach(form => {
    const cordobasInput = form.querySelector('.monto-cordobas');
    const dolaresInput = form.querySelector('.monto-dolares');

    if (cordobasInput) {
      cordobasInput.addEventListener('input', toggleDesglose);
    }
    if (dolaresInput) {
      dolaresInput.addEventListener('input', toggleDesglose);
    }
  });

  // Ejecutar una vez al cargar la página para estado inicial
  window.addEventListener('DOMContentLoaded', toggleDesglose);

  // Aquí puedes agregar el manejo de submit si quieres procesar datos con JS
  // Por ejemplo:
  document.getElementById('aperturaCajaForm').addEventListener('submit', e => {
    e.preventDefault();
    alert('Formulario de Apertura de Caja enviado.');
    // Aquí puedes enviar por AJAX o hacer lo que necesites
  });
  document.getElementById('cierreCajaForm').addEventListener('submit', e => {
    e.preventDefault();
    alert('Formulario de Cierre de Caja enviado.');
  });
</script>



<?php include_once "Ctrl/footer.php"; ?>
