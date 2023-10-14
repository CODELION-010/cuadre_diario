<?php
session_start();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión o Registrarse</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <form action="login_procesar.php" method="post">
        <!-- Campos de inicio de sesión (email y contraseña) -->
        <label for="email">Correo Electrónico:</label>
        <input type="email" name="email" id="email" required>
        
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" id="contrasena" required>
        
        <button type="submit">Iniciar Sesión</button>

    </form>
</body>
</html>

