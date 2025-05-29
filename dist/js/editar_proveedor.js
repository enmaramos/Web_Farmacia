$(document).ready(function () {
    // Cargar los datos del proveedor en el modal
    $(".editarProveedorBtn").click(function () {
        var proveedorId = $(this).data("id");
        console.log("Proveedor ID enviado:", proveedorId);

        $.ajax({
            url: "../pages/Ctrl/obtener_proveedor.php",
            type: "POST",
            data: { proveedorId: proveedorId },
            dataType: "json",
            success: function (response) {
                if (response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.error
                    });
                } else {
                    console.log("Datos recibidos:", response);

                    // Llenar el formulario del modal con los datos del proveedor
                    $("#idProveedor").val(response.ID_Proveedor);
                    $("#editarNombreProveedor").val(response.Nombre);
                    $("#editarLaboratorioProveedor").val(response.Laboratorio);
                    $("#editarDireccionProveedor").val(response.Direccion);
                    $("#editarTelefonoProveedor").val(response.Telefono);
                    $("#editarCorreoProveedor").val(response.Email);                    
                    $("#editarRUCProveedor").val(response.RUC);

                    // Mostrar el modal de edición
                    $("#modalEditarProveedor").modal("show");
                }
            },
            error: function (xhr) {
                console.error("Error al obtener los datos:", xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al obtener los datos del proveedor.'
                });
            }
        });
    });

    // Enviar datos del formulario de edición
    $("#formEditarProveedor").submit(function (event) {
        event.preventDefault();

        var formData = $(this).serialize();
        console.log("Datos enviados para actualización:", formData);

        $.ajax({
            url: "../pages/Ctrl/actualizar_proveedor.php",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function (response) {
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
            error: function (xhr) {
                console.error("Error al actualizar:", xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al actualizar el proveedor.'
                });
            }
        });
    });
});
