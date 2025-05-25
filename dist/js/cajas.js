document.getElementById('aperturaCajaForm').addEventListener('submit', function (e) {
  e.preventDefault();
  const form = this;

  // Paso 1: Verificar si ya hay una apertura para hoy
  fetch('../pages/Ctrl/verificar_apertura.php')
    .then(res => res.text())
    .then(resultado => {
      if (resultado.trim() === 'existe') {
        Swal.fire({
          icon: 'warning',
          title: 'Caja ya aperturada',
          text: 'Ya se ha registrado una apertura de caja hoy para este usuario.',
          confirmButtonText: 'Aceptar'
        });
        return; // Detener el proceso
      }

      // Si no existe apertura, continuar con validación de montos y envío
      procesarAperturaCaja(form);
    })
    .catch(err => {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'No se pudo verificar el estado de la caja.',
      });
      console.error(err);
    });
});

function procesarAperturaCaja(form) {
  const montoCordobas = parseFloat(form.monto_cordobas.value) || 0;
  const montoDolares = parseFloat(form.monto_dolares.value) || 0;

  // Validaciones mínimas
  if (montoCordobas === 0 && montoDolares === 0) {
    Swal.fire({
      icon: 'error',
      title: 'Montos requeridos',
      text: 'Debe ingresar al menos un monto en Córdobas o en Dólares para abrir la caja.'
    });
    return;
  }

  if (montoCordobas > 0 && montoCordobas < 500) {
    Swal.fire({
      icon: 'error',
      title: 'Monto en Córdobas insuficiente',
      text: 'El monto mínimo para abrir la caja en Córdobas es de C$500.'
    });
    return;
  }

  if (montoCordobas === 0 && montoDolares < 10) {
    Swal.fire({
      icon: 'error',
      title: 'Monto insuficiente',
      text: 'Si no hay monto en Córdobas, debe ingresar al menos $10 en Dólares.'
    });
    return;
  }

  const denominacionesCordoba = {
    'billete_5': 5,
    'billete_10': 10,
    'billete_20': 20,
    'billete_50': 50,
    'billete_100': 100,
    'billete_200': 200,
    'billete_500': 500,
    'billete_1000': 1000,
    'moneda_c5': 0.05,
    'moneda_c10': 0.10,
    'moneda_c25': 0.25,
    'moneda_c50': 0.50,
    'moneda_1': 1,
    'moneda_5': 5,
    'moneda_10': 10
  };

  const denominacionesDolar = {
    'usd_1': 1,
    'usd_2': 2,
    'usd_5': 5,
    'usd_10': 10,
    'usd_20': 20,
    'usd_50': 50,
    'usd_100': 100
  };

  let sumaCordobas = 0;
  let sumaDolares = 0;
  let totalDenominaciones = 0;

  for (const nombre in denominacionesCordoba) {
    const input = form[nombre];
    const cantidad = parseInt(input?.value) || 0;
    sumaCordobas += cantidad * denominacionesCordoba[nombre];
    totalDenominaciones += cantidad;
  }

  for (const nombre in denominacionesDolar) {
    const input = form[nombre];
    const cantidad = parseInt(input?.value) || 0;
    sumaDolares += cantidad * denominacionesDolar[nombre];
    totalDenominaciones += cantidad;
  }

  if (totalDenominaciones === 0) {
    Swal.fire({
      icon: 'error',
      title: 'Desglose vacío',
      text: 'Debe ingresar al menos una cantidad en billetes o monedas para abrir la caja.'
    });
    return;
  }

  const redondear = n => Math.round(n * 100) / 100;
  const cordobasRedondeado = redondear(sumaCordobas);
  const dolaresRedondeado = redondear(sumaDolares);

  if (redondear(montoCordobas) !== cordobasRedondeado) {
    Swal.fire({
      icon: 'warning',
      title: 'Monto en Córdobas no coincide',
      html: `Monto declarado: <strong>C$${montoCordobas.toFixed(2)}</strong><br>
             Suma de billetes y monedas: <strong>C$${cordobasRedondeado.toFixed(2)}</strong>`,
    });
    return;
  }

  if (redondear(montoDolares) !== dolaresRedondeado) {
    Swal.fire({
      icon: 'warning',
      title: 'Monto en Dólares no coincide',
      html: `Monto declarado: <strong>$${montoDolares.toFixed(2)}</strong><br>
             Suma de billetes: <strong>$${dolaresRedondeado.toFixed(2)}</strong>`,
    });
    return;
  }

  const formData = new FormData(form);

 fetch('../pages/Ctrl/guardar_caja.php', {
  method: 'POST',
  body: formData
})
  .then(res => res.text())
  .then(respuesta => {
    Swal.fire({
      icon: 'success',
      title: 'Caja Abierta',
      text: respuesta,
      confirmButtonText: 'Aceptar'
    }).then((result) => {
      if (result.isConfirmed) {
        // Redirigir al usuario a otra página (por ejemplo: dashboard.php)
        window.location.href = '../pages/facturacion.php';
      }
    });
  

      // Deshabilitar y resaltar campos
      // Deshabilitar y resaltar campos
      document.querySelectorAll('#aperturaCajaForm input, #aperturaCajaForm textarea, #aperturaCajaForm button').forEach(el => {
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
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '❌ Ocurrió un error al guardar la apertura de caja.',
      });
      console.error(err);
    });
}

//////////////////////////////////////CIERRE DE CAJA//////////////////////////////////////////////////

//////////// Mostrar el total de ventas y apertura ////////////
document.addEventListener('DOMContentLoaded', function () {
  fetch('../pages/Ctrl/obtener_total_ventas.php')
    .then(response => response.json())
    .then(data => {
      const inputVentasTexto = document.querySelector('input[name="total_ventas_mostrado"]');
      const inputVentasNumero = document.querySelector('input[name="total_ventas"]');
      const inputAperturaTexto = document.querySelector('input[name="monto_apertura_mostrado"]');
      const inputAperturaNumero = document.querySelector('input[name="monto_apertura"]');

      const totalVentas = parseFloat(data.totalVentas ?? 0);
      const aperturaConvertida = parseFloat(data.aperturaConvertida ?? 0);

      // Formato Nicaragüense
      const formatoCordobas = valor =>
        'C$ ' + valor.toLocaleString('es-NI', {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        });

      // Mostrar total de ventas
      if (inputVentasTexto && inputVentasNumero) {
        inputVentasTexto.value = formatoCordobas(totalVentas);
        inputVentasNumero.value = totalVentas.toFixed(2);
      }

      // Mostrar monto de apertura convertido
      if (inputAperturaTexto && inputAperturaNumero) {
        inputAperturaTexto.value = formatoCordobas(aperturaConvertida);
        inputAperturaNumero.value = aperturaConvertida.toFixed(2);
      }
    })
    .catch(error => {
      console.error('Error al obtener datos:', error);
    });
});



