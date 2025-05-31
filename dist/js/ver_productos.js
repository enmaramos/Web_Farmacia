$(document).ready(function () {
    $(".imagenMedicamentoCard").click(function () {
        var medicamentoId = $(this).data("id");

        console.log("ID del medicamento:", medicamentoId);

        $.ajax({
            url: "../pages/Ctrl/obtener_producto.php",
            type: "POST",
            data: { medicamentoId: medicamentoId },
            dataType: "json",
            success: function (response) {
                console.log("Respuesta del servidor:", response);

                if (!response.success) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.mensaje
                    });
                    return;
                }

                const medicamento = response.medicamento;
                const lote = response.lote;

                // Medicamento
                $("#nombreMedicamentoVer").val(medicamento.Nombre_Medicamento);
                $("#laboratorioMedicamentoVer").val(medicamento.LAB_o_MARCA);
                $("#categoriaMedicamentoVer").val(medicamento.IdCategoria);
                $("#proveedorMedicamentoVer").val(medicamento.ID_Proveedor);
                $("#descripcionMedicamentoVer").val(medicamento.Descripcion_Medicamento);
                $("#estadoMedicamentoVer").val(medicamento.Estado === '1' ? 'Activo' : 'Inactivo');

                // Lote
                $("#cantidadLoteVer").val(lote.Cantidad_Lote);
                $("#fechaFabricacionLoteVer").val(lote.Fecha_Fabricacion_Lote);
                $("#fechaCaducidadLoteVer").val(lote.Fecha_Caducidad_Lote);
                $("#fechaEmisionLoteVer").val(lote.Fecha_Emision_Lote);
                $("#fechaRecibidoLoteVer").val(lote.Fecha_Recibido_Lote);
                $("#precioUnidadLoteVer").val(lote.Prec_Unidad_lote);
                $("#precioTotalLoteVer").val(lote.Precio_Total_lote);
                $("#stockMinimoLoteVer").val(lote.Stock_Minimo_Lote);
                $("#stockMaximoLoteVer").val(lote.Stock_Maximo_Lote);

                // Imagen
                const ruta = medicamento.Imagen
                    ? `../img/medicamentos/${medicamento.Imagen}`
                    : `../img/medicamentos/default.png`;

                $("#imagenMedicamentoVer").attr("src", ruta);

                $("#modalVerMedicamento").modal("show");
            },
            error: function (xhr) {
                console.error("Error en AJAX:", xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudieron obtener los datos del medicamento.'
                });
            }
        });
    });
});
