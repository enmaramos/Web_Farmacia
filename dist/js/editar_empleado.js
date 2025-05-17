$(document).ready(function() {
    // Cargar los datos del vendedor en el modal
    $(".editarVendedorBtn").click(function() {
        var vendedorId = $(this).data("id");
        console.log("Vendedor ID enviado:", vendedorId);

        $.ajax({
            url: "../pages/Ctrl/obtener_empleado.php",
            type: "POST",
            data: { vendedorId: vendedorId },
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

                    // Llenar el formulario del modal con los datos del vendedor
                    $("#idVendedor").val(response.ID_Vendedor);
                    $("#editarNombreVendedor").val(response.Nombre);
                    $("#editarApellidoVendedor").val(response.Apellido || "");
                    $("#editarCedulaVendedor").val(response.N_Cedula);
                    $("#editarTelefonoVendedor").val(response.Telefono);
                    $("#editarDireccionVendedor").val(response.Direccion);
                    $("#editarSexoVendedor").val(response.Sexo);
                    $("#editarCorreoVendedor").val(response.Email || "");
                    $("#editarRolVendedor").val(response.ID_Rol); // Asegurar que el rol se actualiza

                    // Mostrar el modal de edición
                    $("#modalEditarVendedor").modal("show");
                }
            },
            error: function(xhr) {
                console.error("Error al obtener los datos:", xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al obtener los datos del vendedor.'
                });
            }
        });
    });

    // Enviar datos del formulario de edición
    $("#formEditarVendedor").submit(function(event) {
        event.preventDefault();

        var formData = $(this).serialize();
        console.log("Datos enviados para actualización:", formData);

        $.ajax({
            url: "../pages/Ctrl/actualizar_empleado.php",
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
                    text: 'Hubo un problema al actualizar el vendedor.'
                });
            }
        });
    });
});
