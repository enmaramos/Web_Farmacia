// Activar cliente (cambiar estado a 1)
$(document).on('click', '.activarClientesBtn', function() {
    var clienteId = $(this).data('id'); // Obtener el ID del cliente

    // Mostrar un mensaje de confirmación antes de activar
    var confirmacion = confirm("¿Estás seguro de que deseas reactivar a este cliente?");
    
    if (confirmacion) {
        // Realizar la petición AJAX para activar el cliente
        $.ajax({
            url: '../pages/Ctrl/reactivar_cliente.php', 
            method: 'POST', 
            data: { clienteId: clienteId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert(response.success); // Mostrar mensaje de éxito
                    location.reload(); // Recargar la página para ver el cambio
                } else {
                    alert(response.error); // Mostrar mensaje de error
                }
            },
            error: function() {
                alert("Error en la solicitud. Inténtelo nuevamente.");
            }
        });
    } else {
        alert("La reactivación fue cancelada.");
    }
});
