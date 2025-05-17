$(document).ready(function () {
    $('#tablaProducto tbody').on('click', '.seleccionarProducto', function () {
        let idMedicamento = $(this).data('id');

        $.ajax({
            url: '../pages/Ctrl/obtener_detalles_medicamento.php',
            type: 'GET',
            data: { id: idMedicamento },
            dataType: 'json',
            success: function (data) {
                if (data.error) {
                    alert(data.error);
                    return;
                }

                $('#nombreProducto').val(data.Nombre_Medicamento);
                $('#laboratorio').val(data.LAB_o_MARCA);
                $('#imagenProducto').attr('src', '../../dist/assets/img-medicamentos/' + data.Imagen);
                $('#descripcion').val(data.Descripcion_Medicamento);
                $('#requiereReceta').val(data.Requiere_Receta ? 'Sí' : 'No');

                if (data.Requiere_Receta) {
                    $('#requiereReceta').addClass('requiere-receta-advertencia');
                } else {
                    $('#requiereReceta').removeClass('requiere-receta-advertencia');
                }

                if (data.Fecha_Caducidad_Lote) {
                    let fechaVencimiento = data.Fecha_Caducidad_Lote.split(',')[0].trim();
                    $('#vencimiento').val(formatFecha(fechaVencimiento));
                } else {
                    $('#vencimiento').val('');
                }

                // Llenar el select de Forma Farmacéutica
                llenarSelect('#unidad', data.Forma_Farmaceutica);

                // Llenar el select de Presentación con precios
                let presentaciones = data.Presentaciones.split(', ');
                let presentacionSelect = $('#presentacion');
                presentacionSelect.empty().append('<option selected>Seleccione Presentación</option>');

                presentaciones.forEach(function (presentacion) {
                    let partes = presentacion.split('|');
                    if (partes.length === 2) {
                        let tipo = partes[0].trim();
                        let precio = partes[1].trim();
                        presentacionSelect.append(`<option value="${tipo}" data-precio="${precio}">${tipo}</option>`);
                    }
                });

                // Evento para actualizar el precio según la presentación seleccionada
                $('#presentacion').off('change').on('change', function () {
                    let precioSeleccionado = $(this).find(':selected').data('precio');
                    $('#precio').val(precioSeleccionado || '');
                });

                // --- NUEVO: Relación Forma Farmacéutica → Dosis ---
                let dosisPorFormato = {};
                if (data.FormaFarmaceuticaDosis) {
                    data.FormaFarmaceuticaDosis.split('|').forEach(function (entry) {
                        let [forma, dosis] = entry.split(':');
                        forma = forma.trim();
                        dosis = dosis.trim();
                        if (!dosisPorFormato[forma]) dosisPorFormato[forma] = [];
                        dosisPorFormato[forma].push(dosis);
                    });
                }

                // Evento: al cambiar la forma farmacéutica, llenar las dosis correspondientes
                $('#unidad').off('change').on('change', function () {
                    let formaSeleccionada = $(this).val();
                    let dosisSelect = $('#dosis');
                    dosisSelect.empty().append('<option selected>Seleccione una opción</option>');

                    if (dosisPorFormato[formaSeleccionada]) {
                        dosisPorFormato[formaSeleccionada].forEach(function (dosis) {
                            dosisSelect.append(`<option value="${dosis}">${dosis}</option>`);
                        });

                        // Auto-seleccionar si solo hay una dosis
                        if (dosisPorFormato[formaSeleccionada].length === 1) {
                            dosisSelect.val(dosisPorFormato[formaSeleccionada][0]);
                        }
                    }
                });

                // Cerrar el modal
                $('#modalBusquedaProducto').modal('hide');
            },
            error: function (xhr, status, error) {
                console.log("Error en la solicitud AJAX:", status, error);
                console.log("Respuesta del servidor:", xhr.responseText);
                alert('Error al obtener los detalles del medicamento.');
            }
        });
    });

    function llenarSelect(selectId, valores) {
        let select = $(selectId);
        select.empty().append('<option selected>Seleccione una opción</option>');

        if (valores) {
            valores.split(/[,\/]/).forEach(function (opcion) {
                select.append(`<option value="${opcion.trim()}">${opcion.trim()}</option>`);
            });
        }
    }

    function formatFecha(fecha) {
        let fechaObj = new Date(fecha);
        let dia = String(fechaObj.getDate()).padStart(2, '0');
        let mes = String(fechaObj.getMonth() + 1).padStart(2, '0');
        let año = fechaObj.getFullYear();
        return dia + '/' + mes + '/' + año;
    }
});
