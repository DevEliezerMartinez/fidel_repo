<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./assets/css/global.css">

    <link rel="stylesheet" href="./assets/css/login.css">
</head>

<body>
    <div class="main_login">
        <div class="login-container">
            <img src="https://img.icons8.com/ios-filled/100/000000/user-male-circle.png" alt="User Icon">
            <div class="form-group">
                <label for="username">Usuario o correo electrónico</label>
                <input type="text" id="username" placeholder="Ingrese su usuario">
            </div>
            <div class="form-group password-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" placeholder="Ingrese su contraseña">
                <span class="toggle-password" onclick="togglePassword()">👁️</span>
            </div>
            <button class="login-btn">Iniciar sesión</button>
        </div>
    </div>
    <footer><img src="./assets/img/Logos/logo_blanco.png" alt=""></footer>

    <script>
        document.querySelector('.login-btn').addEventListener('click', function() {
            window.location.href = 'adminEventos.php';
        });
    </script>
</body>

</html>