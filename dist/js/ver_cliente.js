$(".VerClientesBtn").click(function() {
    var clienteId = $(this).data("id");
    console.log("Cliente ID enviado para ver:", clienteId); // Verifica el ID aquí

    $.ajax({
        url: "../pages/Ctrl/obtener_cliente.php", // Asegúrate de que este archivo exista
        type: "POST",
        data: { clienteId: clienteId },
        dataType: "json",
        success: function(response) {
            console.log("Respuesta del servidor:", response); // Verifica la respuesta aquí

            if (response.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.error
                });
            } else {
                console.log("Datos recibidos:", response);

                if(response.Nombre && response.Apellido && response.Cedula) {
                    // Llenar el modal con los datos del cliente
                    $("#nombreClienteVer").val(response.Nombre);
                    $("#apellidoClienteVer").val(response.Apellido);
                    $("#cedulaClienteVer").val(response.Cedula);
                    $("#telefonoClienteVer").val(response.Telefono);
                    $("#direccionClienteVer").val(response.Direccion || "No disponible");
                    $("#sexoClienteVer").val(response.Genero);
                    $("#emailClienteVer").val(response.Email);
                } else {
                    console.log("Datos incompletos recibidos:", response);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Faltan algunos datos del cliente.'
                    });
                }

                // Mostrar el modal de ver cliente
                $("#modalVerClientes").modal("show");
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
