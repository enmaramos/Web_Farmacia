$(document).ready(function() {
    // Cargar los datos del cliente en el modal
    $(".editarClientesBtn").click(function() {
        var clienteId = $(this).data("id");
        console.log("Cliente ID enviado:", clienteId);

        $.ajax({
            url: "../pages/Ctrl/obtener_cliente.php", // Cambia el archivo PHP según tu estructura
            type: "POST",
            data: { clienteId: clienteId },
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

                    // Llenar el formulario del modal con los datos del cliente
                    $("#idCliente").val(response.ID_Cliente);
                    $("#editarNombreCliente").val(response.Nombre);
                    $("#editarApellidoCliente").val(response.Apellido || "");
                    $("#editarCedulaCliente").val(response.Cedula);
                    $("#editarTelefonoCliente").val(response.Telefono);
                    $("#editarDireccionCliente").val(response.Direccion);
                    $("#editarSexoCliente").val(response.Genero);
                    $("#editarCorreoCliente").val(response.Email || "");

                    // Mostrar el modal de edición
                    $("#modalEditarClientes").modal("show");
                }
            },
            error: function(xhr) {
                console.error("Error al obtener los datos:", xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al obtener los datos del cliente.'
                });
            }
        });
    });

    // Enviar datos del formulario de edición
    $("#formEditarCliente").submit(function(event) {
        event.preventDefault();

        var formData = $(this).serialize();
        console.log("Datos enviados para actualización:", formData);

        $.ajax({
            url: "../pages/Ctrl/actualizar_cliente.php", // Cambia el archivo PHP según tu estructura
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
                    text: 'Hubo un problema al actualizar el cliente.'
                });
            }
        });
    });
});
