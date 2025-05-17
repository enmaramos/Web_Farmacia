$(document).ready(function() {
    // Cargar los datos de la categoría en el modal de ver detalles
    $(".VerCategoriaBtn").click(function() {
        var categoriaId = $(this).data("id");
        console.log("Categoría ID enviado para ver:", categoriaId);

        $.ajax({
            url: "../pages/Ctrl/obtener_categoria.php",
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

                    // Verificar si los datos están presentes
                    if (response.Nombre_Categoria && response.Descripcion) {
                        // Llenar el modal con los datos de la categoría
                        $("#nombreCategoriaVer").val(response.Nombre_Categoria);
                        $("#DescripcionVer").val(response.Descripcion);
                    } else {
                        console.log("Datos incompletos recibidos:", response);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Faltan algunos datos de la categoría.'
                        });
                    }

                    // Mostrar el modal de ver detalles
                    $("#modalVerCategoria").modal("show");
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
});
