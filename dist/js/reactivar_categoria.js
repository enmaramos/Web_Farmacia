// Activar categoría (cambiar estado a 1)
$(document).on('click', '.activarCategoriaBtn', function() {
    var categoriaId = $(this).data('id'); // Obtener el ID de la categoría

    // Mostrar mensaje de confirmación
    var confirmacion = confirm("¿Estás seguro de que deseas reactivar esta categoría?");
    
    if (confirmacion) {
        $.ajax({
            url: '../pages/Ctrl/reactivar_categoria.php', 
            method: 'POST', 
            data: { categoriaId: categoriaId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert(response.success); // Éxito
                    location.reload(); // Recargar tabla o página
                } else {
                    alert(response.error); // Error del servidor
                }
            },
            error: function() {
                alert("Error en la solicitud AJAX.");
            }
        });
    } else {
        alert("La reactivación fue cancelada.");
    }
});
