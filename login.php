<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Inicio de Sesión con Iconos y Logotipo</title>
    <!-- Enlace al CSS de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace a Font Awesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/login.css">
    <!-- Estilos personalizados -->
    <style>
        @font-face {
            font-family: 'Rockwell';
            src: url('./fuentes/ROCK.TTF') format('truetype');
            font-weight: 300; 
            font-style: normal;
        }
        .login {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(0deg, rgb(115, 12, 10), rgba(115, 12, 10, 0.57));
            font-family: 'Rockwell';
        }
        .login-form {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            border-radius: 15px;
            background-color: #ffffff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .login-form h3 {
            margin-bottom: 20px;
            font-weight: bold;
            color: #333;
            padding-top: 4rem;
        }
        .form-control {
            border-radius: 30px !important;
            padding: 10px 20px !important;
        }
        .input-group-text {
            background: none !important;
            border: none !important;
            padding-left: 0 !important;
        }
        .btn-primary {
            background-color: rgb(115, 12, 10) !important;
            border: none !important;
            border-radius: 30px !important;
            padding: 10px 20px !important;
            font-weight: bold !important;
            transition: background 0.3s ease !important;
        }
        .btn-primary:hover {
            background: rgb(244, 142, 31) !important;
        }
        .forgot-password {
            display: block;
            margin-top: 10px;
            text-align: center;
            color: rgb(244, 142, 31);
            text-decoration: none;
        }
        .forgot-password:hover {
            text-decoration: underline;
        }
        .logo-login {
            height: 300px;
            width: 200px;
            object-fit: contain;
        }
    </style>
</head>
<body>
    <section class="login">
        <div class="login-form text-center">
            <img src="./assets/img/galeria/innova.png" alt="Logo Colegio San Mateo" class="logo-login">
            <h3>Inicia Sesión</h3>
            <form action="panel.php" method="post">
                <div class="mb-3 input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" name="user" class="form-control" id="username" placeholder="Usuario" required>
                </div>
                <div class="mb-3 input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn">Ingresar</button>
                </div>
                <a href="forgot_password.php" class="forgot-password">¿Olvidaste tu contraseña?</a>
            </form>
        </div>
    </section>
    <!-- Enlace al JavaScript de Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
