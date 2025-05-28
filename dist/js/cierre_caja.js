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

    // Actualizar totales cuando cambie cualquier input numérico
    form.querySelectorAll("input[type='number']").forEach(input => {
        input.addEventListener("input", actualizarTotales);
    });

    // Calcular totales al cargar la página (por si hay valores preexistentes)
    actualizarTotales();
});

//////////// Mostrar monto de apertura caja ////////////
document.addEventListener("DOMContentLoaded", function () {
    fetch("../pages/Ctrl/total_ventas_apertura.php")
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const tasaCambio = 36.80;
                const montoCordobas = parseFloat(data.Monto_Cordobas || 0);
                const montoDolares = parseFloat(data.Monto_Dolares || 0);

                const totalCordobas = (montoCordobas + (montoDolares * tasaCambio)).toFixed(2);

                // Mostrar en el input visible
                document.querySelector('input[name="monto_apertura_mostrado"]').value = `${totalCordobas} C$`;

                // Guardar en el input oculto
                document.querySelector('input[name="monto_apertura"]').value = totalCordobas;
            } else {
                // Si no hay apertura activa
                document.querySelector('input[name="monto_apertura_mostrado"]').value = "No hay apertura activa";
                document.querySelector('input[name="monto_apertura"]').value = 0;
                console.log(data.message);
            }
        })
        .catch(error => {
            console.error("Error al obtener datos de apertura:", error);
            document.querySelector('input[name="monto_apertura_mostrado"]').value = "Error al cargar";
            document.querySelector('input[name="monto_apertura"]').value = 0;
        });
});

//////////// Mostrar total de ventas caja ////////////
function cargarDatosCaja() {
    fetch('../pages/Ctrl/total_ventas_apertura.php')
        .then(response => response.json())
        .then(data => {
            const inputMostrado = document.querySelector('input[name="total_ventas_mostrado"]');
            const inputOculto = document.querySelector('input[name="total_ventas"]');

            if (data.success) {
                if (inputMostrado && inputOculto) {
                    // Formatear total de ventas a 2 decimales con formato local
                    const totalVentas = Number(data.Total_Ventas || 0).toLocaleString('es-NI', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    inputMostrado.value = `${totalVentas} C$`;  // Mostrar con signo de córdobas
                    inputOculto.value = data.Total_Ventas;
                }
            } else {
                if (inputMostrado && inputOculto) {
                    inputMostrado.value = "No hay ventas registradas";
                    inputOculto.value = 0;
                }
                console.log(data.message || 'No se pudo obtener el total de ventas');
            }
        })
        .catch(error => {
            console.error('Error en la petición:', error);
            const inputMostrado = document.querySelector('input[name="total_ventas_mostrado"]');
            const inputOculto = document.querySelector('input[name="total_ventas"]');
            if (inputMostrado && inputOculto) {
                inputMostrado.value = "Error al cargar";
                inputOculto.value = 0;
            }
        });
}

// Ejecutar al cargar la página o cuando necesites
window.onload = cargarDatosCaja;

//////////////////////calular el cierre de la caja ///////////////////////////////////////////

const form = document.getElementById('cierreCajaForm');

form.addEventListener('submit', function (e) {
    e.preventDefault();

    const totalVentas = Number(form.total_ventas.value);
    const montoApertura = Number(form.monto_apertura.value);
    const montoCordobas = Number(form.monto_cordobas.value);
    const montoDolaresCordobas = Number(form.monto_dolares_cordobas.value);

    // Validar que haya monto de apertura
    if (!(montoApertura > 0)) {
        Swal.fire({
            icon: 'error',
            title: '⛔ Error',
            text: 'El campo "Monto Apertura" es obligatorio y debe ser mayor que cero.'
        });
        return;
    }

    // VALIDAR QUE NO TODOS LOS INPUTS DE EFECTIVO ESTÉN VACÍOS O EN CERO
    const inputsEfectivo = form.querySelectorAll('input[name^="billete_"], input[name^="moneda_"], input[name^="usd_"]');
    const algunoConValor = Array.from(inputsEfectivo).some(input => Number(input.value) > 0);

    if (!algunoConValor) {
        Swal.fire({
            icon: 'warning',
            title: '⚠️ Efectivo vacío',
            text: 'Debes ingresar al menos un valor en los desgloses de billetes o monedas.'
        });
        return;
    }

    // Cálculos
    const totalContado = montoCordobas + montoDolaresCordobas;
    const montoEsperado = montoApertura + totalVentas;
    const diferencia = totalContado - montoEsperado;

    let estadoCaja = '';
    let icono = 'info';
    let emoji = '';
    let estado = ''; // CUADRA, FALTA, SOBRA

    if (Math.abs(diferencia) < 0.01) {
        estadoCaja = '✅ La caja CUADRA perfectamente. 🎉';
        icono = 'success';
        emoji = '🎯';
        estado = 'CUADRA';
    } else if (diferencia > 0) {
        estadoCaja = `🟡 La caja SOBRA C$${diferencia.toFixed(2)}. 💰`;
        icono = 'warning';
        emoji = '💸';
        estado = 'SOBRA';
    } else {
        estadoCaja = `🔴 La caja FALTA C$${Math.abs(diferencia).toFixed(2)}. 💸`;
        icono = 'error';
        emoji = '💸';
        estado = 'FALTA';
    }

    Swal.fire({
        title: `${emoji} Resumen de Cierre de Caja`,
        html: `
        <p><strong>Total de Ventas:</strong> C$${totalVentas.toFixed(2)}</p>
        <p><strong>Monto Apertura:</strong> C$${montoApertura.toFixed(2)}</p>
        <p><strong>Monto Contado (Córdobas):</strong> C$${montoCordobas.toFixed(2)}</p>
        <p><strong>Monto Contado (Dólares en córdobas):</strong> C$${montoDolaresCordobas.toFixed(2)}</p>
        <hr>
        <p><strong>Estado de la caja:</strong><br>${estadoCaja}</p>
        `,
        icon: icono,
        allowOutsideClick: false,
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: '🖨️ Imprimir',
        cancelButtonText: '', // Lo seteamos en didOpen
        didOpen: () => {
            const cancelBtn = Swal.getCancelButton();
            cancelBtn.innerHTML = '🔍 Revisar';  // Siempre igual
        }
    }).then((result) => {
        if (result.isConfirmed) {
            imprimirCierreCaja();
        }
    });
});



////////////////////////////factura////////////////////////////////////

function imprimirCierreCaja() {
  const form = document.getElementById('cierreCajaForm');

  const obtenerValor = (name) => {
    const input = form.querySelector(`[name="${name}"]`);
    return input && input.value ? Number(input.value) : 0;
  };

  const cajero = form.querySelector('[name="cajero"]').value;
  const fechaHora = form.querySelector('[name="fecha_hora"]').value;
  const totalVentas = Number(form.querySelector('[name="total_ventas"]').value) || 0;
  const montoApertura = Number(form.querySelector('[name="monto_apertura"]').value) || 0;
  const montoCordobas = Number(form.querySelector('[name="monto_cordobas"]').value) || 0;
  const montoDolares = Number(form.querySelector('[name="monto_dolares"]').value) || 0;
  const montoDolaresCordobas = Number(form.querySelector('[name="monto_dolares_cordobas"]').value) || 0;
  const observaciones = form.querySelector('[name="observaciones"]').value || "";

  const totalContado = montoCordobas + montoDolaresCordobas;
  const diferencia = totalContado - (montoApertura + totalVentas);

  let estadoLabel = '';
  let estadoCierreValor = '';
  if (Math.abs(diferencia) < 0.01) {
    estadoLabel = `<span style="color: green; font-weight: bold;">CUADRA 🎯</span>`;
    estadoCierreValor = 'CUADRA';
  } else if (diferencia > 0) {
    estadoLabel = `<span style="color: blue; font-weight: bold;">SOBRA: C$${diferencia.toFixed(2)} 💰</span>`;
    estadoCierreValor = 'SOBRA';
  } else {
    estadoLabel = `<span style="color: red; font-weight: bold;">FALTA: C$${Math.abs(diferencia).toFixed(2)} ⚠️</span>`;
    estadoCierreValor = 'FALTA';
  }

  const desglose = {
    billetes: {
      1000: obtenerValor('billete_1000'),
      500: obtenerValor('billete_500'),
      200: obtenerValor('billete_200'),
      100: obtenerValor('billete_100'),
      50: obtenerValor('billete_50'),
      20: obtenerValor('billete_20'),
      10: obtenerValor('billete_10'),
      5: obtenerValor('billete_5')
    },
    monedas: {
      1: obtenerValor('moneda_1'),
      5: obtenerValor('moneda_5'),
      10: obtenerValor('moneda_10'),
      0.5: obtenerValor('moneda_c50'),
      0.25: obtenerValor('moneda_c25'),
      0.10: obtenerValor('moneda_c10'),
      0.05: obtenerValor('moneda_c5')
    },
    dolares: {
      100: obtenerValor('usd_100'),
      50: obtenerValor('usd_50'),
      20: obtenerValor('usd_20'),
      10: obtenerValor('usd_10'),
      5: obtenerValor('usd_5'),
      2: obtenerValor('usd_2'),
      1: obtenerValor('usd_1')
    }
  };

  const contenido = `
    <div style="font-family: monospace; font-size: 12px; width: 250px;">
      <center>
        <div style="font-size: 14px; font-weight: bold;">Farmacia Batahola</div>
        <div>Resumen de Cierre de Caja</div>
        <div>${fechaHora}</div>
        <hr>
      </center>

      <div><strong>Total Ventas:</strong> C$${totalVentas.toFixed(2)}</div>
      <div><strong>Monto Apertura:</strong> C$${montoApertura.toFixed(2)}</div>
      <div><strong>Total Contado:</strong> C$${totalContado.toFixed(2)}</div>
      <div><strong>Estado:</strong> ${estadoLabel}</div>
      <hr>

      <strong>Desglose C$ - Billetes</strong><br>
      ${Object.entries(desglose.billetes).map(([valor, cant]) =>
        cant > 0 ? `C$${valor}: x${cant}<br>` : ''
      ).join('')}

      <strong>Desglose C$ - Monedas</strong><br>
      ${Object.entries(desglose.monedas).map(([valor, cant]) =>
        cant > 0 ? (valor >= 1 ? `C$${valor}` : `${(valor * 100).toFixed(0)}¢`) + `: x${cant}<br>` : ''
      ).join('')}

      <strong>Desglose USD</strong><br>
      ${Object.entries(desglose.dolares).map(([valor, cant]) =>
        cant > 0 ? `US$${valor}: x${cant}<br>` : ''
      ).join('')}

      <hr>
      <center>Gracias por su gestión 💼</center>
    </div>
  `;

  const ventana = window.open('', '', 'width=400,height=600');
  ventana.document.write(`
    <html>
      <head>
        <title>Resumen de Cierre</title>
        <style>
          @media print {
            @page { margin: 10mm; }
            body { font-family: Arial, sans-serif; }
          }
        </style>
      </head>
      <body onload="window.print(); window.close();">
        ${contenido}
      </body>
    </html>
  `);
  ventana.document.close();
  ventana.focus();

  // Preparar FormData para enviar al backend
  const formData = new FormData(form);
  formData.append('estado_cierre', estadoCierreValor); // <- ¡Aquí está el cambio clave!

  fetch('../pages/Ctrl/guardar_cierre_caja.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.text())
  .then(respuesta => {
    console.log('Cierre guardado:', respuesta);
    setTimeout(() => location.reload(), 1000);
  })
  .catch(error => {
    console.error('Error al guardar el cierre:', error);
    Swal.fire('Error', 'No se pudo guardar el cierre de caja.', 'error');
  });
}
