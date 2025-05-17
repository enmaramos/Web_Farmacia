document.addEventListener("DOMContentLoaded", function () {
    // Seleccionamos todos los botones de "Ver"
    document.querySelectorAll("[data-bs-target='#modalVerUsuario']").forEach(button => {
        button.addEventListener("click", function () {
            let userId = this.getAttribute("data-id"); // Obtener el ID del usuario

            // Realizar la petición AJAX a obtener_usuario.php
            fetch("../pages/Ctrl/obtener_usuario.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "userId=" + userId
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    // Rellenar los campos del modal con los datos recibidos
                    document.getElementById("nombreUsuarioVer").value = data.Nombre_Usuario;
                    
                    // Verifica si la imagen está disponible
                    let imgPath = data.Imagen ? "../../dist/pages/uploads/" + data.Imagen : "../../dist/pages/uploads/default.jpg";
                    document.getElementById("imagenUsuarioVer").src = imgPath;

                    document.getElementById("passwordUsuarioVer").value = data.Password;
                    document.getElementById("vendedorUsuarioVer").value = data.Nombre_Vendedor; // Muestra el nombre completo del vendedor
                    document.getElementById("estadoUsuarioVerInput").value = data.estado_usuario == 1 ? "Activo" : "Inactivo";
                    document.getElementById("fechaCreacionUsuarioVer").value = data.Fecha_Creacion;
                    document.getElementById("ultimoAccesoUsuarioVer").value = data.Ultimo_Acceso ? data.Ultimo_Acceso : "No disponible";
                }
            })
            .catch(error => console.error("Error al obtener datos del usuario:", error));
        });
    });
});
