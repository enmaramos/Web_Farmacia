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

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap" rel="stylesheet">

</head>

<body>
   <!-- header section start -->
   <div class="header_section">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
         <div class="logo"><a href="index.php"><img src="../assets/images-html/farmacia_batahola_sinfondo.jpg"
                  width="180" height="auto"> </a></div>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>
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

     
            <ul class="navbar-nav">
               <li class="nav-item">
                  <a class="btn login-btn" href="login.php" role="button">
                     <i class="fas fa-user"></i> Iniciar Sesión
                  </a>
               </li>
            </ul>
         </div>


      </nav>
      <!-- header section end -->

      <!-- imagen del banner -->
      <style>
         .poetsen-one-regular {
            font-family: "Poetsen One", sans-serif;
            font-weight: 400;
            font-style: normal;
         }

         body {
            font-family: "Poetsen One", sans-serif;
         }

         

         .banner {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            /* El contenido se alinea a la izquierda */
            padding: 50px 10%;
            background-image: url(../assets/images-html/banner_famacia.png);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 95vh;
            color: white;
            /* Para que el texto contraste con la imagen */
            flex-wrap: wrap;
         }

         .banner-content {
            flex: 1;
            max-width: 50%;
         }

         .banner-content h1 {
            font-size: 50px;
            font-weight: bold;
            color: #1b1b1b;
            margin-bottom: 20px;
         }

         .banner-content h1 span {
            color: #00d4b5;
         }

         .banner-buttons a {
            display: inline-block;
            margin-right: 15px;
            padding: 12px 24px;
            font-weight: bold;
            border-radius: 6px;
            text-decoration: none;
            transition: background-color 0.3s ease;
         }

         .btn-contacto {
            background-color: #00d4b5;
            color: white;
         }

         .btn-contacto:hover {
            background-color: #009f8a;
         }

         .btn-productos {
            background-color: #333;
            color: white;
         }

         .btn-productos:hover {
            background-color: #111111;
         }

         .login-btn:hover {
            background-color: #0d5c4a;
            /* más oscuro al pasar el mouse */
            color: #fff;
         }
      </style>
      <!-- /imagen del banner -->

      <!-- banner section start -->
      <section class="banner">
         <div class="banner-content">
            <h1><span>Bienestar para tu familia</span><br>salud para tu vida</h1>
            <div class="banner-buttons">
               <a href="contact.php" class="btn-contacto">Contáctanos</a>
               <a href="medicamento.php" class="btn-productos">Ver Productos</a>
            </div>
         </div>
      </section>

      <!-- banner section end -->

   </div>
   <!-- banner section end -->

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
                  <img src="../assets/images-html/location-icon.png" alt="Mapa" width="40" style="flex-shrink: 0;">
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
                  <img src="../assets/images-html/what_icon.png" alt="WhatsApp" style="width: 45px; height: 45px;">
               </a>
            </div>
         </div>
      </div>
 
   </div>
 </div>
 <!-- footer section end -->


 <!-- copyright section start -->
<div class="copyright_section" style="background-color: #1a1a1a; padding: 15px 0; margin-top: 0; position: relative; z-index: 999;">
   <div class="container">
     <p class="copyright_text" style="color: #ccc; margin: 0;">Farmacia Batahola Nicaragua © 2025. Todos los derechos reservados.</p>
   </div>
</div>
<!-- copyright section end -->

   <!-- copyright section end -->
   <!-- Javascript files-->
   <script src="../assets/js-html/jquery.min.js"></script>
   <script src="../assets/js-html/popper.min.js"></script>
   <script src="../assets/js-html/bootstrap.bundle.min.js"></script>
   <script src="../assets/js-html/jquery-3.0.0.min.js"></script>
   <script src="../assets/js/plugin.js"></script>
   <!-- sidebar -->
   <script src="../assets/js-html/jquery.mCustomScrollbar.concat.min.js"></script>
   <script src="../assets/js-html/custom.js"></script>
   <!-- javascript -->
   <script src="../assets/js-html/owl.carousel.js"></script>
   <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
</body>

</html>