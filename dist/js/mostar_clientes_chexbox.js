$(document).ready(function () {
    // Función para manejar el cambio del checkbox
    $('#clienteAleatorio').on('change', function () {
        if ($(this).is(':checked')) {
            // Se marcó el checkbox → buscar cliente aleatorio (cliente fijo con ID = 89)
            $.ajax({
                url: '../pages/Ctrl/clientes_chexbox.php',  // PHP que maneja el cliente fijo
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    if (!data.error) {
                        // Si se encontró el cliente, se llenan los campos
                        $('#nombreCliente').val(data.Nombre);
                        $('#cedulaCliente').val(data.Cedula);
                        
                        // Actualizar el campo oculto con el ID del cliente
                        $('#idClienteSeleccionado').val(89);  // Aquí actualizamos con el ID fijo
                    } else {
                        // Si no se encontró el cliente, muestra un mensaje de error
                        alert(data.error);
                    }
                },
                error: function () {
                    // Si hay un error al hacer la solicitud AJAX
                    alert('Error al obtener cliente aleatorio');
                }
            });
        } else {
            // Si se desmarcó el checkbox → limpiar los campos
            $('#nombreCliente').val('');
            $('#cedulaCliente').val('');
            
            // Limpiar el campo oculto de ID de cliente
            $('#idClienteSeleccionado').val('');
        }
    });
});

