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

    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 5px;
    background-color: #f9f9f9;
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

          <!-- Nueva organización: montos y desgloses -->
          <div class="row g-4 mb-3">
            <!-- Columna Córdobas -->
            <div class="col-md-6">
              <label class="form-label">Monto en Córdobas</label>
              <div class="input-group mb-2">
                <span class="input-group-text">C$</span>
                <input
                  type="number"
                  name="monto_cordobas"
                  class="form-control monto-cordobas"
                  step="0.01"
                  min="0" />
              </div>

              <!-- Desglose Córdobas -->
              <div class="desglose-efectivo desglose-cordobas">
                <label class="form-label">💵 Desglose de Billetes (C$)</label>
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
                <label class="form-label">💵 Desglose de Monedas (¢)</label>
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
            </div>

            <!-- Columna Dólares -->
            <div class="col-md-6">
              <label class="form-label">Monto en Dólares</label>
              <div class="input-group mb-2">
                <span class="input-group-text">$</span>
                <input
                  type="number"
                  name="monto_dolares"
                  class="form-control monto-dolares"
                  step="0.01"
                  min="0" />
              </div>

              <!-- Desglose Dólares -->
              <div class="desglose-efectivo desglose-dolares">
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


<!-- 🔻 Cierre de Caja (estilo igual a apertura) -->
<div id="formCierre" style="display: none;">
  <div class="container my-5">
    <div class="card shadow-lg">
      <div class="card-header text-center" style="background-color: #dc3545; color: black;">
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
          </div>



          <!-- Total de Ventas y Monto de Apertura -->
          <div class="row g-3 mb-3">
            <!-- Total de Ventas -->
            <div class="col-md-6">
              <label class="form-label">Total de Ventas</label>
              <input type="text" name="total_ventas_mostrado" class="form-control" readonly style="background-color: #e9ecef;" />
              <input type="number" name="total_ventas" hidden />
            </div>

            <!-- Monto de Apertura -->
            <div class="col-md-6">
              <label class="form-label">Monto Apertura</label>
              <input type="text" name="monto_apertura_mostrado" class="form-control" readonly style="background-color: #e9ecef;" />
              <input type="number" name="monto_apertura" hidden />
            </div>
          </div>


          <!-- Montos y desgloses organizados en dos columnas como apertura -->
          <div class="row g-4 mb-3">
            <!-- Columna Córdobas -->
            <div class="col-md-6">
              <label class="form-label">Monto en Córdobas</label>
              <div class="input-group mb-2">
                <span class="input-group-text">C$</span>
                <input
                  type="text"
                  name="monto_cordobas"
                  class="form-control monto-cordobas"
                  readonly
                  style="background-color: #e9ecef;" />
              </div>

              <!-- Desglose Córdobas -->
              <div class="desglose-efectivo desglose-cordobas">
                <label class="form-label">💵 Desglose de Billetes (C$)</label>
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
                <label class="form-label">💵 Desglose de Monedas (¢)</label>
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
            </div>

            <!-- Columna Dólares -->
            <div class="col-md-6">
              <label class="form-label">Monto en Dólares</label>
              <div class="input-group mb-2">
                <span class="input-group-text">$</span>
                <input
                  type="text"
                  name="monto_dolares"
                  class="form-control monto-dolares"
                  readonly
                  style="background-color: #e9ecef;" />

                <span class="input-group-text">⇨ C$</span>
                <input
                  type="text"
                  name="monto_dolares_cordobas"
                  class="form-control"
                  readonly
                  style="background-color: #e9ecef;"
                  placeholder="En córdobas" />
              </div>


              <!-- Desglose Dólares -->
              <div class="desglose-efectivo desglose-dolares">
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
          </div>

          <!-- Observaciones -->
          <div class="row g-3 mt-3">
            <div class="col-md-12">
              <label class="form-label">Observaciones</label>
              <textarea name="observaciones" class="form-control" rows="3"></textarea>
            </div>
          </div>

          <div class="text-center mt-3">
            <button id="btnMostrarCierre" type="submit" class="btn btn-danger">
              <i class="bi bi-check-circle me-1"></i>Cerrar Caja
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- 🔻 Cierre de Caja (JS) -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("cierreCajaForm");
    const tasaCambio = 36.80;

    function calcularTotalMoneda(inputs, valores) {
      return inputs.reduce((total, input) => {
        const cantidad = parseInt(input.value) || 0;
        const denominacion = valores[input.name] || 0;
        return total + cantidad * denominacion;
      }, 0);
    }

    function actualizarTotales() {
      const inputs = Array.from(form.querySelectorAll("input[type='number']"));

      const valoresCordobas = {
        billete_5: 5, billete_10: 10, billete_20: 20, billete_50: 50,
        billete_100: 100, billete_200: 200, billete_500: 500, billete_1000: 1000,
        moneda_c5: 0.05, moneda_c10: 0.10, moneda_c25: 0.25, moneda_c50: 0.50,
        moneda_1: 1, moneda_5: 5, moneda_10: 10,
      };

      const valoresDolares = {
        usd_1: 1, usd_2: 2, usd_5: 5, usd_10: 10,
        usd_20: 20, usd_50: 50, usd_100: 100,
      };

      const totalCordobas = calcularTotalMoneda(inputs, valoresCordobas);
      const totalDolares = calcularTotalMoneda(inputs, valoresDolares);
      const totalDolaresCordobas = totalDolares * tasaCambio;

      form.querySelector("input[name='monto_cordobas']").value = totalCordobas.toFixed(2);
      form.querySelector("input[name='monto_dolares']").value = totalDolares.toFixed(2);
      form.querySelector("input[name='monto_dolares_cordobas']").value = totalDolaresCordobas.toFixed(2);
    }

    // 🔁 Activar cálculo en todos los inputs
    form.querySelectorAll("input[type='number']").forEach((input) => {
      input.addEventListener("input", function () {
        let valor = input.value.replace(/\D/g, '');
        if (valor.length > 4) valor = valor.slice(0, 4);
        if (parseInt(valor) > 9999) valor = "9999";
        input.value = valor;
        actualizarTotales();
      });

      input.addEventListener("keydown", function (e) {
        const isNumber = e.key >= "0" && e.key <= "9";
        const allowedKeys = ["Delete", "Backspace", "ArrowLeft", "ArrowRight"];
        if (!isNumber && !allowedKeys.includes(e.key)) e.preventDefault();

        if (isNumber && input.value.length >= 4 && input.selectionStart === input.selectionEnd) {
          e.preventDefault();
        }
      });

      input.addEventListener("paste", function (e) {
        const pasted = e.clipboardData.getData("text").replace(/\D/g, '');
        if (!/^\d{1,4}$/.test(pasted) || parseInt(pasted) > 9999) {
          e.preventDefault();
        }
      });
    });

    // ✅ Enviar formulario con fetch
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      const formData = new FormData(form);

      const inputs = form.querySelectorAll("input[type='number']");
      const hayDenominaciones = Array.from(inputs).some(input => parseInt(input.value) > 0);

      if (!hayDenominaciones) {
        Swal.fire({
          icon: 'warning',
          title: 'Desglose vacío',
          text: 'Debe ingresar al menos una denominación para cerrar la caja.'
        });
        return;
      }

      Swal.fire({
        title: '¿Está seguro?',
        text: 'Se procederá a cerrar la caja y guardar los datos.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, cerrar caja',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          fetch('../pages/Ctrl/guardar_cierre_caja.php', {
            method: 'POST',
            body: formData
          })
            .then(res => res.text())
            .then(respuesta => {
              Swal.fire({
                icon: 'success',
                title: 'Caja cerrada correctamente',
                html: `<pre style="text-align:left;">${respuesta}</pre>`,
                width: 600,
                confirmButtonText: 'Aceptar'
              });

              // 🔒 Bloquear campos después de cerrar
              form.querySelectorAll('input, textarea, button').forEach(el => {
                if (el.type !== 'hidden') {
                  el.setAttribute('readonly', true);
                  el.setAttribute('disabled', true);
                  if (el.tagName !== 'BUTTON' && el.value.trim() !== '') {
                    el.classList.add('input-resaltado');
                  }
                }
              });
            })
            .catch(err => {
              console.error(err);
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '❌ Ocurrió un error al cerrar la caja.'
              });
            });
        }
      });
    });
  });
</script>






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


<script src="../js/cajas.js?56"></script>

<?php include_once "Ctrl/footer.php"; ?>