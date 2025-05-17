$(document).ready(function() {
    let dataTable = $('#tablaProducto').DataTable(); // Inicializa DataTable

    $('#btnBuscarProducto').click(function() {
        $.ajax({
            url: '../pages/Ctrl/obtener_medicamentos.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log("Datos recibidos:", data);

                // Destruir la tabla antes de llenarla de nuevo
                dataTable.destroy();
                
                // Limpiar el tbody
                $('#tablaProducto tbody').empty();

                if (data.length === 0) {
                    alert('No se encontraron productos.');
                    return;
                }

                $.each(data, function(index, producto) {
                    // Ajustar la ruta de la imagen
                    var rutaImagen = '../../dist/assets/img-medicamentos/' + producto.Imagen;

                    var row = '<tr>' +
                        '<td><img src="' + rutaImagen + '" alt="' + producto.Nombre_Medicamento + '" class="img-fluid" style="width: 50px; height: auto;"></td>' +
                        '<td>' + producto.Nombre_Medicamento + '</td>' +
                        '<td>' + producto.LAB_o_MARCA + '</td>' +
                        '<td>' + producto.Dosis + '</td>' +
                        '<td>' + producto.Presentaciones + '</td>' +
                        '<td>' + producto.Forma_Farmaceutica + '</td>' + 
                        '<td><button class="btn btn-success seleccionarProducto" data-id="' + producto.ID_Medicamento + '">Seleccionar</button></td>' +
                        '</tr>';

                    $('#tablaProducto tbody').append(row);
                });

                // Volver a inicializar DataTable
                dataTable = $('#tablaProducto').DataTable();

                // Mostrar el modal
                $('#modalBusquedaProducto').modal('show');
            },
            error: function(xhr, status, error) {
                console.log("Error en la solicitud AJAX:", status, error);
                console.log("Respuesta del servidor:", xhr.responseText);
                alert('Error al obtener los productos.');
            }
        });
    });
});
