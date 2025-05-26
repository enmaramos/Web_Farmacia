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
        if(inputMostrado && inputOculto) {
          // Formatear total de ventas a 2 decimales con formato local
          const totalVentas = Number(data.Total_Ventas || 0).toLocaleString('es-NI', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          });
          inputMostrado.value = `${totalVentas} C$`;  // Mostrar con signo de córdobas
          inputOculto.value = data.Total_Ventas;
        }
      } else {
        if(inputMostrado && inputOculto) {
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
      if(inputMostrado && inputOculto) {
        inputMostrado.value = "Error al cargar";
        inputOculto.value = 0;
      }
    });
}

// Ejecutar al cargar la página o cuando necesites
window.onload = cargarDatosCaja;
