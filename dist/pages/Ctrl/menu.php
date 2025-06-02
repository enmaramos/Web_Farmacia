<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>



<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        <!-- Menu -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
                <a href="index.html" class="app-brand-link d-flex align-items-center">
                    <!-- Logo a la izquierda -->
                    <span class="app-brand-logo demo me-2">
                        <img src="/Web_Farmacia/dist/assets/img/LOGO_sinfondo.jpg" alt="Logo" width="50" height="50">
                    </span>

                    <!-- Texto a la derecha del logo -->
                    <span class="app-brand-text demo menu-text fw-bolder d-flex flex-column">
                        <span style="font-size: 1.15rem; text-transform: none;">Farmacia</span>
                        <span style="font-size: 1.75rem; text-transform: none;">Batahola</span>
                    </span>
                </a>

                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                </a>
            </div>





            <div class="menu-inner-shadow"></div>
            <ul class="menu-inner py-1">
                <!-- Dashboard común para todos -->
                <li class="menu-item active">
                    <a href="/Web_Farmacia/dist/pages/inicio.php" class="menu-link">
                        <i class="fas fa-home"></i>
                        <div data-i18n="Analytics">Inicio</div>
                    </a>
                </li>

                <!-- Menú completo para Administradores -->
                <?php if ($_SESSION['ID_Rol'] == 1): ?>
                    <!-- Ventas -->
                    <li class="menu-header small text-uppercase"><span class="menu-header-text">Ventas</span></li>
                    <li class="menu-item">
                        <a href="/Web_Farmacia/dist/pages/caja.php" class="menu-link">
                            <i class="fas fa-cash-register"></i>
                            <div data-i18n="Boxicons">Gestion de Caja</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/Web_Farmacia/dist/pages/facturacion.php" class="menu-link">
                            <i class='bx bx-receipt'></i>
                            <div data-i18n="Boxicons">Facturación</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/Web_Farmacia/dist/pages/facturacion_diaria.php" class="menu-link">
                            <i class="fas fa-file-invoice"></i>
                            <div data-i18n="Boxicons">Facturas Diarias</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/Web_Farmacia/dist/pages/cliente.php" class="menu-link">
                            <i class="fas fa-user"></i>
                            <div data-i18n="Boxicons">Clientes</div>
                        </a>
                    </li>

                    <!-- Administración -->
                    <li class="menu-header small text-uppercase"><span class="menu-header-text">Administración</span></li>
                    <li class="menu-item">
                        <a href="/Web_Farmacia/dist/pages/empleado.php" class="menu-link">
                            <i class="fas fa-user-tie"></i>
                            <div data-i18n="Boxicons">Empleados</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/Web_Farmacia/dist/pages/usuarios.php" class="menu-link">
                            <i class="fas fa-users"></i>
                            <div data-i18n="Basic">Usuarios</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/Web_Farmacia/dist/pages/proveedores.php" class="menu-link">
                            <i class="fas fa-truck"></i>
                            <div data-i18n="Boxicons">Proveedores</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/Web_Farmacia/dist/pages/categoria.php" class="menu-link">
                            <i class="fas fa-tags"></i>
                            <div data-i18n="Boxicons">Categorías</div>
                        </a>
                    </li>

                    <!-- Forms & Tables -->
                    <li class="menu-header small text-uppercase"><span class="menu-header-text">Bodega</span></li>
                    <li class="menu-item">
                        <a href="/Web_Farmacia/dist/pages/productos.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bxs-capsule"></i>
                            <div data-i18n="Tables">Productos</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="tables-basic.html" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-table"></i>
                            <div data-i18n="Tables">Historial de Ventas</div>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Menú solo para Vendedores -->
                <?php if ($_SESSION['ID_Rol'] == 2): ?>
                    <li class="menu-header small text-uppercase"><span class="menu-header-text">Ventas</span></li>
                    <li class="menu-item">
                        <a href="/Web_Farmacia/dist/pages/caja.php" class="menu-link">
                            <i class="fas fa-cash-register"></i>
                            <div data-i18n="Boxicons">Gestion de Caja</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/Web_Farmacia/dist/pages/facturacion.php" class="menu-link">
                            <i class='bx bx-receipt'></i>
                            <div data-i18n="Boxicons">Facturación</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/Web_Farmacia/dist/pages/cliente.php" class="menu-link">
                            <i class="fas fa-user"></i>
                            <div data-i18n="Boxicons">Clientes</div>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Menú solo para Bodegueros -->
                <?php if ($_SESSION['ID_Rol'] == 3): ?>
                    <li class="menu-header small text-uppercase"><span class="menu-header-text">Bodega</span></li>
                    <li class="menu-item">
                        <a href="/Web_Farmacia/dist/pages/productos.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bxs-capsule"></i>
                            <div data-i18n="Tables">Productos</div>
                        </a>
                    </li>

                      <li class="menu-item">
                        <a href="tables-basic.html" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-table"></i>
                            <div data-i18n="Tables">Historial de Ventas</div>
                        </a>
                    </li>
                <?php endif; ?>



                <!-- Misc 
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Misc</span></li>
            <li class="menu-item">
              <a
                href="https://github.com/themeselection/sneat-html-admin-template-free/issues"
                target="_blank"
                class="menu-link"
              >
                <i class="menu-icon tf-icons bx bx-support"></i>
                <div data-i18n="Support">Support</div>
              </a>
            </li>
            <li class="menu-item">
              <a
                href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
                target="_blank"
                class="menu-link"
              >
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Documentation">Documentation</div>
              </a>
            </li>-->
            </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">


            <!-- Navbar -->

            <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                id="layout-navbar">
                <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                        <i class="bx bx-menu bx-sm"></i>
                    </a>
                </div>

                <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                    <!-- Search -->
                    <div class="navbar-nav align-items-center">
                        <?php
                        // Obtén el nombre del archivo actual
                        $pagina_actual = basename($_SERVER['PHP_SELF']);

                        // Define un array con los nombres de las páginas
                        $titulos_paginas = [
                            'inicio.php' => 'Inicio',
                            'caja.php' => 'Gestión de Caja',
                            'facturacion.php' => 'Facturación',
                            'cliente.php' => 'Clientes',
                            'empleado.php' => 'Empleados',
                            'usuarios.php' => 'Usuarios',
                            'proveedores.php' => 'Proveedores',
                            'categoria.php' => 'Categorías',
                            'tables-basic.html' => 'Tablas',
                            'icons-boxicons.html' => 'Historial Facturación'
                        ];

                        // Verifica si existe un título asignado para la página actual
                        $titulo_pagina = isset($titulos_paginas[$pagina_actual]) ? $titulos_paginas[$pagina_actual] : 'Página';
                        ?>

                        <!-- Mostrar el nombre de la página actual -->
                        <h4 class="mb-0 text-primary fw-bold"><?php echo $titulo_pagina; ?></h4>
                    </div>
                    <!-- /Search -->

                    <ul class="navbar-nav flex-row align-items-center ms-auto">
                        <!-- User -->
                        <li class="nav-item navbar-dropdown dropdown-user dropdown">
                            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                <div class="avatar avatar-online">
                                    <img id="img-perfil-chico" src="<?php echo '../../dist/pages/uploads/' . $_SESSION['Imagen']; ?>" alt style="width: 34px;" class="h-auto rounded-circle" />
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar avatar-online">
                                                    <img id="img-perfil-grande" src="<?php echo '../../dist/pages/uploads/' . $_SESSION['Imagen']; ?>" alt class="w-px-40 h-auto rounded-circle" />
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <span class="fw-semibold d-block"><?php echo $_SESSION['Nombre_Usuario']; ?></span>
                                                <small class="text-muted"><?php echo $_SESSION['Nombre_Rol']; ?></small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalPerfilUsuario">
                                        <i class="bx bx-user me-2"></i>
                                        <span class="align-middle">Mi perfil</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="bx bx-cog me-2"></i>
                                        <span class="align-middle">Configuración</span>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="Ctrl/cerrar_sesion.php">
                                        <i class="bx bx-power-off me-2"></i>
                                        <span class="align-middle">Cerrar sesión</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!--/ User -->

                    </ul>
                </div>
            </nav>

            <!-- / Navbar -->


            <!-- Modal Perfil de Usuario -->
            <div class="modal fade" id="modalPerfilUsuario" tabindex="-1" aria-labelledby="modalPerfilUsuarioLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <!-- Cabecera -->
                        <div class="modal-header" style="background-color: #17d5bb; color: #2e2e2e;">
                            <h5 class="modal-title" id="modalPerfilUsuarioLabel">
                                <i class='bx bx-user'></i> Perfil del Usuario
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>

                        <!-- Formulario -->
                        <form id="formActualizarUsuario" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="row g-3 justify-content-center">

                                    <!-- Imagen -->
                                    <div class="col-md-12 text-center position-relative">
                                        <label for="fotoPerfil" class="form-label d-block">Foto de Perfil</label>

                                        <img src="<?php echo '../../dist/pages/uploads/' . $_SESSION['Imagen']; ?>"
                                            id="previewImagen"
                                            alt="Foto del Usuario"
                                            class="rounded-circle shadow border border-3 border-info"
                                            style="width: 140px; height: 140px; object-fit: cover; cursor: pointer;"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Haz clic para cambiar la foto">

                                        <input type="file" id="fotoPerfil" name="Imagen" accept="image/*" class="d-none">
                                        <input type="hidden" name="ImagenActual" value="<?php echo $_SESSION['Imagen']; ?>">
                                    </div>

                                    <!-- ID del usuario oculto -->
                                    <input type="hidden" name="ID_Usuario" value="<?php echo $_SESSION['ID_Usuario']; ?>">

                                    <!-- Nombre de usuario -->
                                    <div class="col-md-6">
                                        <label for="nombreUsuario" class="form-label">Nombre de Usuario</label>
                                        <input type="text" class="form-control" id="nombreUsuario" name="Nombre_Usuario" value="<?php echo $_SESSION['Nombre_Usuario']; ?>" readonly>
                                    </div>

                                    <!-- Contraseña -->
                                    <div class="col-md-6 position-relative">
                                        <label for="nuevaContrasena" class="form-label">Contraseña</label>
                                        <div class="input-group">
                                            <input
                                                type="password"
                                                class="form-control"
                                                id="nuevaContrasena"
                                                name="Password"
                                                placeholder="Nueva contraseña">

                                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordBtn">
                                                <i class="bx bx-show" id="iconoOjo"></i>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Pie -->
                            <div class="modal-footer bg-light">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const imagen = document.getElementById('previewImagen');
                    const inputImagen = document.getElementById('fotoPerfil');
                    const iconoOjo = document.getElementById('iconoOjo');
                    const passwordInput = document.getElementById('nuevaContrasena');

                    // Imagen clic
                    imagen.addEventListener('click', () => inputImagen.click());

                    inputImagen.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            imagen.src = URL.createObjectURL(file);
                        }
                    });

                    // Mostrar/ocultar contraseña
                    document.getElementById('togglePasswordBtn').addEventListener('click', function() {
                        if (passwordInput.type === "password") {
                            passwordInput.type = "text";
                            iconoOjo.classList.replace('bx-show', 'bx-hide');
                        } else {
                            passwordInput.type = "password";
                            iconoOjo.classList.replace('bx-hide', 'bx-show');
                        }
                    });

                    // Envío del formulario
                    document.getElementById('formActualizarUsuario').addEventListener('submit', function(e) {
                        e.preventDefault();

                        const formData = new FormData(this);

                        fetch('../../dist/pages/Ctrl/actualizar_perfil.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(res => res.text())
                            .then(data => {
                                const respuesta = data.trim();

                                if (respuesta === "Usuario actualizado correctamente.") {
                                    Swal.fire({
                                        icon: 'success',
                                        title: '¡Éxito!',
                                        text: 'Usuario actualizado correctamente.',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });

                                    // Cerrar modal (si está abierto)
                                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalPerfilUsuario'));
                                    if (modal) modal.hide();

                                    // Actualizar imagen en tiempo real si se subió una nueva
                                    const imagenArchivo = inputImagen.files[0];
                                    if (imagenArchivo) {
                                        const nuevaRuta = `../../dist/pages/uploads/${imagenArchivo.name}?t=${Date.now()}`;
                                        setTimeout(() => {
                                            const imgChico = document.getElementById('img-perfil-chico');
                                            const imgGrande = document.getElementById('img-perfil-grande');
                                            if (imgChico) imgChico.src = nuevaRuta;
                                            if (imgGrande) imgGrande.src = nuevaRuta;
                                        }, 200);
                                    }

                                    // Recargar para actualizar nombre de usuario o imagen si es necesario
                                    setTimeout(() => location.reload(), 2500);

                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: respuesta
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error de red',
                                    text: 'Ocurrió un error al actualizar el perfil.'
                                });
                            });
                    });
                });
            </script>