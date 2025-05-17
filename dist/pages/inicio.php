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
window.addEventListener('pageshow', function (event) {
    if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
        // Aquí puedes hacer una validación adicional con PHP si deseas
        window.location.href = 'login.php';
    }
});
</script>

<?php include_once "Ctrl/footer.php"; ?>
