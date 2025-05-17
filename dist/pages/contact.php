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
                     <a class="nav-link" href="contacto.php">Contáctanos</a>
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



      <!-- estilos de la pagian  -->
      <style>
         /*estilos del boton de login y la fuente del body*/
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

         /*fin estilos del boton de login y la fuente del body*/

         .boletin-wrapper {
            background-color: #092379;
            padding: 50px 0;
            font-family: 'Poppins', sans-serif;
            position: relative;
            overflow: hidden;
            /* importante para que se vea bien en móvil */
         }

         .boletin-container {
            background-color: #aad2fc;
            border-radius: 10px;
            margin: 0 auto;
            padding: 40px 30px;
            max-width: 600px;
            /* más angosto, pegado al formulario */
            width: 100%;
            position: relative;
            z-index: 2;
            /* para que esté delante */
            text-align: center;
         }

         .boletin-texto h2 {
            font-size: 28px;
            font-weight: 800;
            color: #0a1c61;
            margin-bottom: 10px;
         }

         .boletin-texto p {
            color: gray;
            font-size: 15px;
            margin-bottom: 30px;
         }

         .boletin-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: center;
         }

         .boletin-form input {
            padding: 12px 20px;
            border-radius: 30px;
            border: none;
            width: 100%;
            max-width: 400px;
            font-size: 14px;
            outline: none;
         }

         .boletin-form button {
            background-color: #092379;
            color: white;
            border: none;
            border-radius: 30px;
            padding: 12px 25px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
         }

         .boletin-form button:hover {
            background-color: #0c2d9b;
         }

         /* Imagen afuera */
         .boletin-imagen {
            position: absolute;
            top: 50%;
            right: 50px;
            /* controlas cuanto sale del contenedor */
            transform: translateY(-50%) rotate(10deg);
            z-index: 10;
            /* ahora la imagen está ENCIMA */
         }

         .boletin-imagen img {
            width: 450px;
            /* imagen más grande */
            max-width: none;
         }


         @media (max-width: 768px) {
            .boletin-container {
               max-width: 90%;
            }

            .boletin-imagen {
               position: static;
               transform: rotate(0deg);
               margin-top: 20px;
               text-align: center;
            }

            .boletin-imagen img {
               width: 300px;
            }
         }
      </style>




      <div class="boletin-wrapper">
         <div class="boletin-container">
            <div class="boletin-texto">
               <h2>CONTÁCTANOS</h2>
               <p>Déjanos tus datos y el producto que te interesa</p>
               <form class="boletin-form" id="contacto-form">
                  <input type="text" name="nombre" id="nombre" placeholder="Nombre" required>
                  <input type="text" name="apellido" id="apellido" placeholder="Apellido" required>
                  <input type="text" name="producto" id="producto" placeholder="Producto de interés" required>
                  <button type="submit" id="btn-enviar">ENVIAR</button>
               </form>
            </div>
         </div>
         <div class="boletin-imagen">
            <img src="../assets/images-html/probioticos.png" alt="Producto Probiotics">
         </div>
      </div>

      <script>
         document.getElementById('contacto-form').addEventListener('submit', function (e) {
            e.preventDefault(); // Evitar envío normal

            const nombre = document.getElementById('nombre').value.trim();
            const apellido = document.getElementById('apellido').value.trim();
            const producto = document.getElementById('producto').value.trim();
            const botonEnviar = document.getElementById('btn-enviar');

            if (nombre === '' || apellido === '' || producto === '') {
               alert('Por favor, complete todos los campos antes de enviar.');
               return;
            }

            // Cambiar el texto del botón y desactivarlo
            botonEnviar.innerText = 'Enviando...';
            botonEnviar.disabled = true;
            botonEnviar.style.backgroundColor = '#999'; // color gris mientras envía
            botonEnviar.style.cursor = 'not-allowed';

            const mensaje = `Hola, soy ${nombre} ${apellido}, estoy interesado(a) en el producto: ${producto}. ¿Me podría enviar una cotización?`;
            const mensajeCodificado = encodeURIComponent(mensaje);
            const numeroWhatsApp = "50586499378";
            const url = `https://web.whatsapp.com/send?phone=${numeroWhatsApp}&text=${mensajeCodificado}`;

            // Abrir WhatsApp en nueva pestaña
            window.open(url, '_blank');

            // Refrescar la página después de 2 segundos
            setTimeout(function () {
               window.location.reload();
            }, 4000); // 2000 ms = 2 segundos para que de tiempo de abrir el WhatsApp
         });
      </script>







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
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
      <!-- javascript -->
      <script src="js/owl.carousel.js"></script>
      <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
   </body>

</html>