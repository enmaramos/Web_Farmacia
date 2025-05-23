document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".eliminarClientesBtn").forEach(button => {
        button.addEventListener("click", function() {
            let idCliente = this.getAttribute("data-id");

            if (confirm("¿Estás seguro de dar de baja este cliente?")) {
                fetch("../pages/Ctrl/baja_cliente.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "id_cliente=" + idCliente
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
