document.addEventListener('DOMContentLoaded', function () {
    const dropArea = document.getElementById('dropArea');
    const fileInput = document.getElementById('imagenUsuarioInput');
    const previewImg = document.getElementById('previewImagenUsuario');
    const textoSubida = document.getElementById('textoSubida');
    const imagenActualInput = document.getElementById('imagenActualUsuario');

    let imagenSeleccionada = null;

    // Zona Drag & Drop
    dropArea.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', function () {
        if (fileInput.files.length > 0) {
            imagenSeleccionada = fileInput.files[0];
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImg.src = e.target.result;
                previewImg.style.display = 'block';
                textoSubida.style.display = 'none';
            };
            reader.readAsDataURL(imagenSeleccionada);
        }
    });

    // Cargar datos al abrir modal
    document.addEventListener('click', function (e) {
        if (e.target.closest('.btn-warning')) {
            const btn = e.target.closest('.btn-warning');
            const userId = btn.getAttribute('data-id');

            const formData = new FormData();
            formData.append('userId', userId);

            fetch('../pages/Ctrl/obtener_usuario.php', {
                method: 'POST',
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        document.getElementById('nombreUsuarioEditar').value = data.Nombre_Usuario;
                        document.getElementById('passwordUsuarioEditar').value = data.Password;
                        imagenActualInput.value = data.Imagen;

                        // Imagen previa
                        if (data.Imagen) {
                            previewImg.src = '/Web_Farmacia/dist/pages/uploads/' + data.Imagen;
                            previewImg.style.display = 'block';
                            textoSubida.style.display = 'none';
                        } else {
                            previewImg.style.display = 'none';
                            textoSubida.style.display = 'block';
                        }

                        document.getElementById('btnActualizarUsuario').setAttribute('data-id', data.ID_Usuario);
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Error al obtener los datos del usuario.');
                });
        }
    });

    // Actualizar usuario
    document.getElementById('btnActualizarUsuario').addEventListener('click', function () {
        const userId = this.getAttribute('data-id');
        const nombre = document.getElementById('nombreUsuarioEditar').value;
        const password = document.getElementById('passwordUsuarioEditar').value;
        const imagenActual = imagenActualInput.value;

        const formData = new FormData();
        formData.append('ID_Usuario', userId);
        formData.append('Nombre_Usuario', nombre);
        formData.append('Password', password);

        if (imagenSeleccionada) {
            formData.append('Imagen', imagenSeleccionada);
        } else {
            formData.append('Imagen', imagenActual); // ← Aquí la clave
        }

        fetch('../pages/Ctrl/actualizar_usuario.php', {
            method: 'POST',
            body: formData
        })
            .then(res => res.text())
            .then(response => {
                alert(response);
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarUsuario'));
                modal.hide();
                location.reload(); // ← Refrescar la página
            })
            .catch(err => {
                console.error(err);
                alert('Error al actualizar el usuario.');
            });
    });
});
