<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="/bbro/public/css/styles.css">
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <img src="/bbro/public/img/logo.png" alt="Logo de Big Bro" class="logo">
            <h2>Iniciar sesión - Usuarios</h2>
            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
            <form method="post">
                <input type="text" name="nombre_usuario" placeholder="Nombre de usuario" required>
                <input type="password" name="contrasena" placeholder="Contraseña" required>
                <a href="/bbro/login" class="user-access">Acceso Administrador</a>
                <button type="submit">Iniciar sesión</button>
                <a href="#" class="forgot-password">¿Olvidó su contraseña?</a>
            </form>
        </div>
    </div>
</body>
</html>