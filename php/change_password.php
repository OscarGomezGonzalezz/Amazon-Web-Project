<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: ./users/login.php");
    exit;
}

// El usuario está autenticado, puedes mostrar la página de cambio de contraseña
echo "Cambiar contraseña para el usuario ID: " . $_SESSION['userId'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar Contraseña</title>
</head>
<body>
    <h1>Cambiar Contraseña</h1>
    <form action="process_change_password.php" method="post">
        <label for="new_password">Nueva Contraseña:</label>
        <input type="password" id="new_password" name="new_password" required>
        <label for="confirm_password">Confirmar Contraseña:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <button type="submit">Cambiar Contraseña</button>
    </form>
</body>
</html>
