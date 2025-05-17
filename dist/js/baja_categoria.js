document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.eliminarCategoriaBtn').forEach(function (boton) {
        boton.addEventListener('click', function () {
            const idCategoria = this.dataset.id;

            if (confirm('¿Estás seguro de que deseas dar de baja esta categoría?')) {
                fetch('../pages/Ctrl/baja_categoria.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'id=' + encodeURIComponent(idCategoria)
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        // Opcional: recargar tabla o eliminar fila visualmente
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un error en el proceso.');
                });
            }
        });
    });
});
