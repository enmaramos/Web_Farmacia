$(".VerProveedorBtn").click(function () {
    var proveedorId = $(this).data("id");
    console.log("Proveedor ID enviado para ver:", proveedorId); // Verifica el ID aquí

    $.ajax({
        url: "../pages/Ctrl/obtener_proveedor.php",
        type: "POST",
        data: { proveedorId: proveedorId },
        dataType: "json",
        success: function (response) {
            console.log("Respuesta del servidor:", response); // Verifica la respuesta aquí

            if (response.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.error
                });
            } else {
                console.log("Datos recibidos:", response);

                if (response.Nombre && response.RUC) {
                    // Llenar el modal con los datos del proveedor
                    $("#nombreProveedorVer").val(response.Nombre);
                    $("#laboratorioProveedorVer").val(response.Laboratorio || "No disponible");
                    $("#direccionProveedorVer").val(response.Direccion || "No disponible");
                    $("#telefonoProveedorVer").val(response.Telefono || "No disponible");
                    $("#emailProveedorVer").val(response.Email || "No disponible");
                    $("#rucProveedorVer").val(response.RUC);

                    // Mostrar el modal de ver proveedor
                    $("#modalVerProveedor").modal("show");
                } else {
                    console.log("Datos incompletos recibidos:", response);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Faltan algunos datos del proveedor.'
                    });
                }
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
