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

  let sumaCordobas = 0;
  for (const nombre in denominacionesCordoba) {
    const input = form[nombre];
    const cantidad = parseInt(input?.value) || 0;
    sumaCordobas += cantidad * denominacionesCordoba[nombre];
  }

  const denominacionesDolar = {
    'usd_1': 1,
    'usd_2': 2,
    'usd_5': 5,
    'usd_10': 10,
    'usd_20': 20,
    'usd_50': 50,
    'usd_100': 100
  };

  let sumaDolares = 0;
  for (const nombre in denominacionesDolar) {
    const input = form[nombre];
    const cantidad = parseInt(input?.value) || 0;
    sumaDolares += cantidad * denominacionesDolar[nombre];
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
    });

    // Deshabilitar y resaltar campos
    document.querySelectorAll('#aperturaCajaForm input, #aperturaCajaForm textarea').forEach(el => {
      if (el.type !== 'hidden') {
        el.setAttribute('readonly', true);
        el.setAttribute('disabled', true);
        if (el.value.trim() !== '') {
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