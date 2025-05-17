<!DOCTYPE html>
<html lang="en">

<head>
   <!-- basic -->
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!-- mobile metas -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="viewport" content="initial-scale=1, maximum-scale=1">
   <!-- site metas -->
   <title>Farmacia Batahola</title>
   <meta name="keywords" content="">
   <meta name="description" content="">
   <meta name="author" content="">
   <!-- bootstrap css -->
   <link rel="stylesheet" href="../assets/css-html/bootstrap.min.css">
   <!-- style css -->
   <link rel="stylesheet" href="../assets/css-html/style.css">
   <!-- Responsive-->
   <link rel="stylesheet" href="../assets/css-html/responsive.css">
   <!-- fevicon -->
   <link rel="icon" href="../assets/images-html/LOGO_sinfondo.jpg" type="image/gif" />
   <!-- Scrollbar Custom CSS -->
   <link rel="stylesheet" href="../assets/css-html/jquery.mCustomScrollbar.min.css">
   <!-- Tweaks for older IEs-->
   <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
   <!-- owl stylesheets -->
   <link rel="stylesheet" href="../assets/css-html/owl.carousel.min.css">
   <link rel="stylesheet" href="../assets/css-html/owl.theme.default.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css"
      media="screen">

   <!-- Bootstrap 5 CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- Style de google fonts -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap" rel="stylesheet">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

   <!-- medicamento.css -->
   <link rel="stylesheet" href="../assets/css-html/medicamento.css?12345">

</head>

<body>

   <body>
      <!-- header section start -->
      <div class="header_section">
         <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <!-- Logo -->
            <div class="logo">
               <a href="index.php">
                  <img src="../assets/images-html/farmacia_batahola_sinfondo.jpg" width="180" height="auto"
                     alt="Logo Farmacia">
               </a>
            </div>

            <!-- Botón para móviles -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
               aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menú de navegación -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
               <ul class="navbar-nav mr-auto">
                  <li class="nav-item active">
                     <a class="nav-link" href="index.php">Inicio</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="medicamento.php">Productos</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="quienes_somos.php">Quiénes Somos</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="contact.php">Contáctanos</a>
                  </li>
               </ul>

               <!-- Botón de Login -->
               <ul class="navbar-nav">
                  <li class="nav-item">
                     <a class="btn login-btn" href="login.php" role="button">
                        <i class="fas fa-user"></i> Iniciar Sesión
                     </a>
                  </li>
               </ul>
            </div>
         </nav>
      </div>
      <!-- header section end -->

      <section class="quienes-somos-banner">
         <div class="contenido">
            <h2>¿Quiénes Somos?</h2>
            <p>
               Bienvenido a <strong>Farmacia Batahola</strong>, su mejor opción en salud y bienestar.
            </p>
            <p>
               Ofrecemos medicamentos, suplementos y productos de calidad, siempre con un trato humano y profesional.
            </p>
            <p>
               Nuestro compromiso es cuidar de su salud con responsabilidad y cariño.
            </p>
         </div>
      </section>

      <style>
         .poetsen-one-regular {
            font-family: "Poetsen One", sans-serif;
            font-weight: 400;
            font-style: normal;
         }

         body {
            font-family: "Poetsen One", sans-serif;
         }

         .login-btn:hover {
            background-color: #0d5c4a;
            /* más oscuro al pasar el mouse */
            color: #fff;
         }

         .quienes-somos-banner {
            position: relative;
            width: 100%;
            height: 600px;
            /* altura en desktop */
            background-image: url('../assets/images-html/farmacia_casa.jpeg');
            /* cambia esta ruta */
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding: 20px;
            background-color: #000;
         }

         .quienes-somos-banner::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1;
         }

         .quienes-somos-banner .contenido {
            position: relative;
            z-index: 2;
            max-width: 800px;
         }

         .quienes-somos-banner h2 {
            font-size: 48px;
            margin-bottom: 20px;
         }

         .quienes-somos-banner p {
            font-size: 20px;
            margin-bottom: 15px;
            line-height: 1.6;
         }

         /* 📱 Estilos responsive para pantallas pequeñas */
         @media (max-width: 768px) {
            .quienes-somos-banner {
               height: 400px;
               /* más bajo en celulares */
               background-size: contain;
               /* sigue viendo completa la imagen */
               padding: 10px;
            }

            .quienes-somos-banner h2 {
               font-size: 32px;
               /* título más pequeño */
            }

            .quienes-somos-banner p {
               font-size: 16px;
               /* texto más pequeño */
            }

            .quienes-somos-banner .contenido {
               max-width: 90%;
               /* más ancho en celulares */
            }
         }

         @media (max-width: 480px) {
            .quienes-somos-banner {
               height: 300px;
            }

            .quienes-somos-banner h2 {
               font-size: 28px;
            }

            .quienes-somos-banner p {
               font-size: 14px;
            }
         }
      </style>









      <!-- Botones flotantes usando imágenes propias -->
      <div
         style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 15px;">
         <a href="https://web.whatsapp.com/send?phone=50588688476&text=Hola,%20necesito%20información%20sobre%20los%20productos.
 " target="_blank"
            style="background-color: #25d366; padding: 12px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
            <img src="../assets/images-html/icon-whatsapp-normal-unscreen.gif" alt="WhatsApp"
               style="width: 30px; height: 30px;">
         </a>
      </div>

      <!-- footer section start -->
      <div class="footer_section layout_padding" style="background-color: #252525; color: white; padding: 40px 0;">
         <div class="container">

            <!-- Fila con Call Center, Correo y Google Maps -->
            <div class="row text-center text-md-start mb-4">

               <!-- Call Center -->
               <div class="col-md-4 mb-3">
                  <div
                     style="background-color: #2e2e2e; border-radius: 12px; padding: 20px 25px; height: 100px; display: flex; align-items: center; gap: 20px;">
                     <img src="../assets/images-html/cellphone-icon.png" alt="Call" width="40" style="flex-shrink: 0;">
                     <div style="display: flex; flex-direction: column; justify-content: center;">
                        <h6 style="color: #f1f1f1; margin: 0;">Call Center</h6>
                        <p style="font-size: 15px; margin: 0;">2222-2224</p>
                     </div>
                  </div>
               </div>

               <!-- Correo -->
               <div class="col-md-4 mb-3">
                  <div
                     style="background-color: #2e2e2e; border-radius: 12px; padding: 20px 25px; height: 100px; display: flex; align-items: center; gap: 20px;">
                     <img src="../assets/images-html/email-icon.png" alt="Correo" width="40" style="flex-shrink: 0;">
                     <div style="display: flex; flex-direction: column; justify-content: center;">
                        <h6 style="color: #f1f1f1; margin: 0;">Correo Electrónico</h6>
                        <p style="font-size: 15px; margin: 0;">callcenter@xolotlan.com.ni</p>
                     </div>
                  </div>
               </div>

               <!-- Google Maps -->
               <div class="col-md-4 mb-3">
                  <a href="https://maps.app.goo.gl/AgcqAMWLKtd8951U6" target="_blank"
                     style="text-decoration: none; display: block; width: 100%;">
                     <div
                        style="background-color: #2e2e2e; border-radius: 12px; padding: 20px 25px; height: 100px; display: flex; align-items: center; gap: 20px; color: inherit;">
                        <img src="../assets/images-html/location-icon.png" alt="Mapa" width="40"
                           style="flex-shrink: 0;">
                        <div style="display: flex; flex-direction: column; justify-content: center;">
                           <h6 style="color: #f1f1f1; margin: 0;">Sucursales</h6>
                           <p style="font-size: 15px; margin: 0; color: #ddd;">Visitar Google Map</p>
                        </div>
                     </div>
                  </a>
               </div>

            </div> <!-- ✅ cierre correcto de la fila -->

            <!-- Logo y descripción -->
            <div class="row">
               <div class="col-md-6 mb-4 text-center mx-auto">
                  <img src="../assets/images-html/farmacia_batahola_sinfondo.jpg" alt="Logo"
                     style="height: 50px; margin-bottom: 10px;">
                  <p class="mt-2" style="font-size: 14px; color: #ccc;">
                     SUPER FARMACIA XOLOTLAN S.A, opera continuamente desde el año 1953, hasta el día de hoy, siendo la
                     primera farmacia en desarrollar el servicio a domicilio.
                  </p>
               </div>
            </div>

            <!-- Redes sociales -->
            <div class="row mt-3">
               <div class="col text-center">
                  <h5 style="color: #f1f1f1;" class="mb-3">Redes Sociales</h5>
                  <div class="d-flex justify-content-center" style="gap: 30px;">
                     <a href="#"><img src="../assets/images-html/fb-icon.png" alt="Facebook"
                           style="width: 45px; height: 45px;"></a>
                     <a href="#"><img src="../assets/images-html/instagram-icon.png" alt="Instagram"
                           style="width: 45px; height: 45px;"></a>
                     <a href="https://web.whatsapp.com/send?phone=50588688476&text=Hola,%20necesito%20información%20sobre%20los%20productos."
                        target="_blank">
                        <img src="../assets/images-html/what_icon.png" alt="WhatsApp"
                           style="width: 45px; height: 45px;">
                     </a>
                  </div>
               </div>
            </div>

         </div>
      </div>
      <!-- footer section end -->



      <!-- copyright section start -->
      <div class="copyright_section"
         style="background-color: #1a1a1a; padding: 15px 0; margin-top: 0; position: relative; z-index: 999;">
         <div class="container">
            <p class="copyright_text" style="color: #ccc; margin: 0;">Farmacia Batahola Nicaragua © 2025. Todos los
               derechos reservados.</p>
         </div>
      </div>
      <!-- copyright section end -->

      <!-- Javascript files-->
  <script src="../assets/js-html/jquery.min.js"></script>
  <script src="../assets/js-html/popper.min.js"></script>
  <script src="../assets/js-html/bootstrap.bundle.min.js"></script>
  <script src="../assets/js-html/jquery-3.0.0.min.js"></script>
  <script src="../assets/js-html/plugin.js"></script>
  <!-- sidebar -->
  <script src="../assets/js-html/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="../assets/js-html/custom.js"></script>
  <!-- javascript -->
  <script src="../assets/js-html/owl.carousel.js"></script>
  <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>

  <!-- Bootstrap 5 JS (con Popper incluido) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

   </body>

</hphp