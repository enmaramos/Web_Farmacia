$(document).ready(function() {
    // Cargar los datos de la categoría en el modal
    $(".editarCategoriaBtn").click(function() {
        var categoriaId = $(this).data("id");
        console.log("Categoría ID enviado:", categoriaId);

        $.ajax({
            url: "../pages/Ctrl/obtener_categoria.php", // Ruta al script PHP
            type: "POST",
            data: { categoriaId: categoriaId },
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.error
                    });
                } else {
                    console.log("Datos recibidos:", response);

                    // Llenar el formulario del modal con los datos de la categoría
                    $("#idCategoria").val(response.ID_Categoria);
                    $("#editarNombreCategoria").val(response.Nombre_Categoria);
                    $("#editarDescripcion").val(response.Descripcion);

                    // Mostrar el modal de edición
                    $("#modalEditarCategoria").modal("show");
                }
            },
            error: function(xhr) {
                console.error("Error al obtener los datos:", xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al obtener los datos de la categoría.'
                });
            }
        });
    });

    // Enviar datos del formulario de edición
    $("#formEditarCategoria").submit(function(event) {
        event.preventDefault();

        var formData = $(this).serialize();
        console.log("Datos enviados para actualización:", formData);

        $.ajax({
            url: "../pages/Ctrl/actualizar_categoria.php", // Ruta al script PHP
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: response.success
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.error
                    });
                }
            },
            error: function(xhr) {
                console.error("Error al actualizar:", xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al actualizar la categoría.'
                });
            }
        });
    });
});
