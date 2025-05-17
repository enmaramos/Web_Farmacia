$(document).ready(function() {
    // Función para buscar clientes cuando se escribe en el campo de búsqueda
    $('#buscarCliente').on('input', function() {
        var termino = $(this).val(); // Obtener el valor del campo de búsqueda

        if (termino.length >= 2) { // Comienza a buscar si hay al menos 2 caracteres
            $.ajax({
                url: '../pages/Ctrl/buscar_clientes.php',
                type: 'GET',
                data: { termino: termino },
                success: function(data) {
                    var clientes = JSON.parse(data);
                    var listaResultados = $('#resultadosBusqueda');
                    listaResultados.empty();

                    if (clientes.length > 0) {
                        clientes.forEach(function(cliente) {
                            listaResultados.append(
                                '<a href="#" class="list-group-item list-group-item-action" ' +
                                'data-id="' + cliente.ID_Cliente + '" ' +
                                'data-nombre="' + cliente.Nombre + '" ' +
                                'data-apellido="' + cliente.Apellido + '" ' +
                                'data-cedula="' + cliente.Cedula + '">' +
                                cliente.Nombre + ' ' + cliente.Apellido + ' (' + cliente.Cedula + ')' +
                                '</a>'
                            );
                        });
                        listaResultados.show();
                    } else {
                        listaResultados.hide();
                    }
                }
            });
        } else {
            $('#resultadosBusqueda').hide();
        }
    });

    // Función para seleccionar un cliente de la lista
    $(document).on('click', '#resultadosBusqueda a', function(e) {
        e.preventDefault();

        var idCliente = $(this).data('id');  // Mantén solo esta declaración
        var nombre = $(this).data('nombre');
        var apellido = $(this).data('apellido');
        var cedula = $(this).data('cedula');

        $('#nombreCliente').val(nombre + ' ' + apellido);
        $('#cedulaCliente').val(cedula);

        // Solo esta línea, no es necesario declarar `idCliente` nuevamente
        $('#idClienteSeleccionado').val(idCliente);  // Actualiza el campo oculto

        $('#resultadosBusqueda').hide();
    });
});
