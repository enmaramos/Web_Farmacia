document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".eliminarProveedorBtn").forEach(button => {
        button.addEventListener("click", function () {
            let idProveedor = this.getAttribute("data-id");

            if (confirm("¿Estás seguro de dar de baja este proveedor?")) {
                fetch("../pages/Ctrl/baja_proveedor.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "id_proveedor=" + idProveedor
                })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    location.reload(); // Recargar la página después de la baja
                })
                .catch(error => console.error("Error:", error));
            }
        });
    });
});
