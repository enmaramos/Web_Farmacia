<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmacia Batahola</title>
      <!-- fevicon -->
   <link rel="icon" href="../assets/images-html/LOGO_sinfondo.jpg" type="image/gif" />
   <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-...tu_integridad..." crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>


    <style>
        body {
          background-color: #e6f4f1;
          display: flex;
          align-items: center;
          justify-content: center;
          height: 100vh;
          font-family: "Poetsen One", sans-serif;
        }
    
        .forgot-container {
          width: 100%;
          max-width: 400px;
          padding: 20px;
        }
    
        .forgot-card {
          background: #ffffff;
          border-radius: 20px;
          padding: 40px 30px;
          box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
          text-align: center;
          overflow: hidden;
        }
    
        .profile-image-small {
          margin-bottom: 20px;
        }
    
        .profile-image-small img {
          width: 100px;
          height: 100px;
          border-radius: 12px;
         
        }
    
        .forgot-card h2 {
          color: #00a67e;
          font-size: 24px;
          margin-bottom: 10px;
        }
    
        .forgot-card p {
          color: gray;
          font-size: 16px;
          margin-bottom: 30px;
        }
    
        .input-icon {
          position: relative;
          margin-bottom: 20px;
        }
    
        .input-icon input {
          width: 100%;
          padding: 12px 15px 12px 45px;
          border: 1px solid #ccc;
          border-radius: 12px;
          font-size: 16px;
          transition: border-color 0.3s;
          box-sizing: border-box;
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
    
        .login-button {
          width: 100%;
          padding: 12px;
          background: #00a67e;
          color: white;
          border: none;
          border-radius: 12px;
          font-size: 16px;
          cursor: pointer;
          transition: background-color 0.3s ease;
        }
    
        .login-button:hover {
          background-color: #007a5e;
        }
    
        .back-login {
          display: block;
          margin-top: 20px;
          font-size: 14px;
          color: #00a67e;
          text-decoration: none;
        }
    
        .back-login:hover {
          text-decoration: underline;
        }
      </style>
    </head>
    <body>
    
      <div class="forgot-container">
        <div class="forgot-card">
          <div class="profile-image-small">
            <img src="../assets/images-html/LOGO_sinfondo.jpg" alt="Usuario">
          </div>
    
          <h2>¿Olvidaste tu contraseña?</h2>
          <p>Ingresa tu correo electrónico para recuperar tu acceso.</p>
    
          <div class="form-group input-icon">
            <i class="fas fa-envelope icon"></i>  <!-- Icono de sobre/correo -->
            <input type="email" placeholder="Correo electrónico">
        </div>
    
          <button class="login-button">Enviar instrucciones</button>
    
          <a href="login.php" class="back-login">← Volver al inicio de sesión</a>
        </div>
      </div>




</body>

</html>