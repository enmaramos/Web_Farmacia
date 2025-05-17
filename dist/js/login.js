let intentos = 3;

function iniciarSesion() {
    const usuarioInput = document.getElementById('usuario');
    const passwordInput = document.getElementById('password');
    const usuario = usuarioInput.value;
    const password = passwordInput.value;

    if (usuario === "" || password === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Campos vacíos',
            text: 'Por favor, complete todos los campos.'
        });
        return;
    }

    const datos = new FormData();
    datos.append('usuario', usuario);
    datos.append('password', password);

    fetch('../pages/Ctrl/validar_login.php', {
        method: 'POST',
        body: datos
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirecciona directamente
            window.location.href = 'inicio.php?bienvenida=1';
        } else {
            intentos--;

            Swal.fire({
                icon: 'error',
                title: 'Error de inicio de sesión',
                text: `${data.message}. Intentos restantes: ${intentos}`
            });

            // Limpiar campos
            usuarioInput.value = "";
            passwordInput.value = "";
            usuarioInput.focus();

            if (intentos <= 0) {
                Swal.fire({
                    title: '¿Tienes problemas para iniciar sesión?',
                    text: '¿Deseas recuperar tu usuario y contraseña?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, recuperar',
                    cancelButtonText: 'No, cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "olvidaste_contraseña.php";
                    } else {
                        document.querySelector(".login-button").disabled = true;
                    }
                });
            }
        }
    })
    .catch(error => {
        console.error("Error en la petición:", error);
        Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: 'Hubo un error al conectar con el servidor. Intenta de nuevo más tarde.'
        });
    });
}

// Manejo de teclas Enter
document.addEventListener("DOMContentLoaded", () => {
    const inputUsuario = document.getElementById("usuario");
    const inputPassword = document.getElementById("password");

    inputUsuario.addEventListener("keydown", (e) => {
        if (e.key === "Enter") {
            e.preventDefault();
            inputPassword.focus();
        }
    });

    inputPassword.addEventListener("keydown", (e) => {
        if (e.key === "Enter") {
            e.preventDefault();
            iniciarSesion();
        }
    });

    inputUsuario.focus();

    document.addEventListener("DOMContentLoaded", function () {
        // Detectar si se viene desde login.php usando document.referrer
        if (document.referrer.includes("login.php")) {
            // Reemplaza el historial para que no se pueda volver atrás
            history.pushState(null, "", window.location.href);
            window.addEventListener("popstate", function () {
                // Cuando detecte que el usuario intenta regresar, lo devuelve aquí
                history.pushState(null, "", window.location.href);
            });
        }
    });



});
                               