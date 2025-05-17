<?php
session_start();

// Si el usuario ya inició sesión, redirige directamente a inicio.php
if (isset($_SESSION['ID_Usuario'])) {
    header("Location: inicio.php");
    exit();
}

?>




<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmacia Batahola</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- fevicon -->
    <link rel="icon" href="../assets/images-html/LOGO_sinfondo.jpg" type="image/gif" />


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap" rel="stylesheet">

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>

<body>

    <style>
        /* Importación de la fuente */
        @import url('https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #e6f4f1;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Poetsen One", sans-serif;
            /* Aquí aplicas la nueva fuente */
        }

        .container {
            width: 900px;
            height: 500px;
            background: white;
            border-radius: 15px;
            display: flex;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .login-form {
            flex: 1;
            padding: 40px 30px;
            text-align: center;
            /* CENTRA todo */
        }

        .login-form h2 {
            color: #00a67e;
            margin-bottom: 10px;
            font-size: 24px;
        }

        .login-form p {
            color: gray;
            margin-bottom: 30px;
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
            text-align: left;
            /* Los inputs quedan alineados normales */
        }

        .input-icon {
            position: relative;
        }

        .input-icon input {
            width: 100%;
            padding: 12px 12px 12px 45px;
            border: 1px solid #ccc;
            border-radius: 12px;
            /* border radius MÁS BONITO */
            font-size: 16px;
        }

        .input-icon .icon {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #00a67e;
            font-size: 18px;
            pointer-events: none;
        }

        .input-icon input:focus {
            border-color: #00a67e;
            outline: none;
        }

        .input-icon input:focus+.icon,
        .input-icon:focus-within .icon {
            color: #007a5e;
        }

        .forgot-password {
            display: block;
            margin-top: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #00a67e;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .login-button {
            width: 70%;
            /* Más delgado */
            padding: 10px;
            background: #00a67e;
            color: white;
            border: none;
            border-radius: 25px;
            /* BOTÓN MÁS BONITO redondeado */
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.3s;
        }

        .login-button:hover {
            background: #007a5e;
        }

        .illustration {
            flex: 1;
            background: #b5e3da;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            position: relative;
            border-top-left-radius: 100px;
            border-bottom-left-radius: 100px;
        }

        .illustration img {
            width: 250px;
            margin-bottom: 20px;
        }

        .illustration .title {
            font-size: 22px;
            font-weight: bold;
            color: white;
        }

        .illustration .subtitle {
            font-size: 14px;
            color: white;
            opacity: 0.8;
            margin-top: 5px;
        }

        .profile-image {
            display: flex;
            justify-content: center;
            margin: 0 0 20px 0;
            /* Subir un poco más */
        }

        .profile-image img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            /* Quitamos el borde */
        }


      

        /* RESPONSIVE DESIGN */
        @media (max-width: 768px) {
            body {
                padding: 20px;
                height: auto;
            }

            .container {
                flex-direction: column;
                width: 100%;
                height: auto;
                border-radius: 15px;
            }

            .login-form {
                padding: 30px 20px;
                text-align: center;
            }

            .profile-image {
                margin: 10px 0;
            }

            .profile-image img {
                width: 70px;
                height: 70px;
            }

            .login-form h2 {
                font-size: 22px;
            }

            .login-form p {
                font-size: 14px;
            }

            .form-group input {
                padding: 10px 10px 10px 40px;
                font-size: 14px;
            }

            .input-icon .icon {
                font-size: 16px;
                left: 10px;
            }

            .login-button {
                width: 80%;
                margin: 20px auto 0 auto;
                display: block;
            }

            .illustration {
                background: #b5e3da;
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
                padding: 20px 0;
            }

            .illustration img {
                width: 150px;
            }

            .logo {
                width: 100px;
            }
        }

        /* Animación de fade-in y slide-up */
        @keyframes fadeSlideIn {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Aplica la animación al container */
        .container {
            animation: fadeSlideIn 1s ease-out;
        }

        .back-login {
            display: block;
            margin-top: 20px;
            font-size: 14px;
            color: #00a67e;
            text-decoration: none;
            text-align: center;
        }

        .back-login:hover {
            text-decoration: underline;
        }
    </style>



<div class="container">
    <div class="login-form">
        <div class="profile-image">
            <img src="../assets/images-html/LOGO_sinfondo.jpg" alt="Usuario">
        </div>

        <h2>Inicio de sesión</h2>
        <p>Ingrese su usuario y contraseña</p>

        <div class="form-group input-icon">
            <i class="fas fa-user icon"></i>
            <input type="text" id="usuario" placeholder="Ingrese su usuario">
        </div>

        <div class="form-group input-icon">
            <i class="fas fa-lock icon"></i>
            <input type="password" id="password" placeholder="Ingrese su contraseña">
        </div>

        <a href="olvidaste_contraseña.php" class="forgot-password">¿Olvidaste tu contraseña?</a>

        <button class="login-button" onclick="iniciarSesion()">Iniciar sesión</button>

        <a href="index.php" class="back-login">← Volver a la página principal</a>
    </div>

    <div class="illustration">
        <img src="../assets/images-html/farmacia_login-1.png" alt="Ilustración de Farmacia" style="width: 360px;">
        <img src="../assets/images-html/farmacia_batahola_sinfondo.jpg" alt="Logo" class="logo">
    </div>
</div>







<script src="../js/login.js?12346"></script>

</body>