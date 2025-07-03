<?php
session_start();

// Validar sesión y redirigir si no hay sesión activa
if (!isset($_SESSION['ID_Usuario'])) {
    header("Location: login.php");
    exit();
}

include_once "Ctrl/head.php";
?>
<?php include_once "Ctrl/menu.php"; ?>

<div class="contenedor">
    <img src="/Web_Farmacia/dist/assets/img/farmacia_batahola_sinfondo.jpg" alt="Logo">
</div>

<?php
// SweetAlert de bienvenida
if (isset($_GET['bienvenida']) && $_GET['bienvenida'] == '1' && isset($_SESSION['Nombre_Usuario'])) {
    $usuario = $_SESSION['Nombre_Usuario'];
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: '¡Bienvenido!',
                text: 'Hola $usuario, has iniciado sesión correctamente.',
                icon: 'success',
                confirmButtonText: 'Continuar'
            });

            if (window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete('bienvenida');
                window.history.replaceState({}, document.title, url.pathname);
            }
        });
    </script>";
}
?>

<script>
    // Verificar si se vuelve atrás y redirigir directamente al login sin parpadeo
    window.addEventListener('pageshow', function(event) {
        if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
            // Aquí puedes hacer una validación adicional con PHP si deseas
            window.location.href = 'login.php';
        }
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch("../pages/Ctrl/verificar_respaldo_automatico.php")
            .then(res => res.json())
            .then(data => {
                if (data.estado === "exito") {
                    Swal.fire({
                        title: '¡Respaldo automático realizado!',
                        text: 'Archivo: ' + data.archivo,
                        icon: 'success',
                        timer: 3500
                    });
                } else if (data.estado === "fallido") {
                    Swal.fire({
                        title: 'Error al crear respaldo automático',
                        icon: 'error',
                        timer: 3500
                    });
                }
                // si estado es no_hora o ya_existe, no mostrar nada
            })
            .catch(err => console.error("Error al verificar respaldo automático:", err));
    });
</script>


<?php include_once "Ctrl/footer.php"; ?>