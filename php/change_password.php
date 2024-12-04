<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ./users/login.php");
    exit;
}

// El usuario está autenticado, puedes mostrar la página de cambio de contraseña
//echo "Cambiar contraseña para el usuario ID: " . $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1 {
            font-size: 24px;
            color: #333;
            text-align: center;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #555;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            display: block;
            width: 100%;
            background-color: #ff9900;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            margin-top: 20px;
            cursor: pointer;
        }
        button:hover {
            background-color: #e68a00;
        }
        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cambiar Contraseña</h1>
        <form action="process_change_password.php" method="post">
            <label for="new_password">Nueva Contraseña:</label>
            <input type="password" id="new_password" name="new_password" required>
            <label for="confirm_password">Confirmar Contraseña:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <button type="submit">Cambiar Contraseña</button>
        </form>
        <div class="footer">© 2024, AmazonClone.com</div>
    </div>
</body>
</html>
