<?php
session_start();

if (!isset($_SESSION['userId'])) {
    
    header("Location: login.html");
    exit(); 
}?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="styles/changePassword.css">

    <link rel="stylesheet" href="../../css/bootstrap.css">
</head>
<body>
    <div class="password-container">
        <h1>Change Password</h1>
        <form action="php/process_change_password.php" method="post">
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <button type="submit">Change Password</button>
        </form>
        <div class="footer">© 2024, AmazonClone.com</div>
    </div>
</body>
</html>
