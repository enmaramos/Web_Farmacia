$(".VerVendedorBtn").click(function() {
    var vendedorId = $(this).data("id");
    console.log("Vendedor ID enviado para ver:", vendedorId); // Verifica el ID aquí

    $.ajax({
        url: "../pages/Ctrl/obtener_empleado.php",
        type: "POST",
        data: { vendedorId: vendedorId },
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

                if(response.Nombre && response.Apellido && response.N_Cedula) {
                    // Llenar el modal con los datos del vendedor
                    $("#nombreVendedorVer").val(response.Nombre);
                    $("#apellidoVendedorVer").val(response.Apellido);
                    $("#cedulaVendedorVer").val(response.N_Cedula);
                    $("#telefonoVendedorVer").val(response.Telefono);
                    $("#direccionVendedorVer").val(response.Direccion || "No disponible");
                    $("#sexoVendedorVer").val(response.Sexo === 'H' ? 'Masculino' : 'Femenino');
                    $("#emailVendedorVer").val(response.Email);
                    if (response.ID_Rol == 1) {
                        $("#rolVendedorVer").val('Administrador');
                    } else if (response.ID_Rol == 2) {
                        $("#rolVendedorVer").val('Vendedor');
                    } else if (response.ID_Rol == 3) {
                        $("#rolVendedorVer").val('Bodeguero');
                    } else {
                        $("#rolVendedorVer").val('Rol desconocido');  // En caso de que haya otro ID de rol
                    }
                    
                } else {
                    console.log("Datos incompletos recibidos:", response);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Faltan algunos datos del empleado.'
                    });
                }

                // Mostrar el modal de ver detalles
                $("#modalVerVendedor").modal("show");
            }
        },
        error: function(xhr) {
            console.error("Error al obtener los datos:", xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al obtener los datos del empleado.'
            });
        }
    });
});
