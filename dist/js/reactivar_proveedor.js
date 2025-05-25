// Activar proveedor (cambiar estado a 1)
$(document).on('click', '.activarProveedorBtn', function() {
    var proveedorId = $(this).data('id'); // Obtener el ID del proveedor

    // Mostrar un mensaje de confirmación antes de activar
    var confirmacion = confirm("¿Estás seguro de que deseas reactivar a este proveedor?");
    
    if (confirmacion) {
        // Realizar la petición AJAX para activar el proveedor
        $.ajax({
            url: '../pages/Ctrl/reactivar_proveedor.php', 
            method: 'POST', 
            data: { proveedorId: proveedorId },
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
        // Si el usuario cancela, no hacer nada
        alert("La reactivación fue cancelada.");
    }
});
