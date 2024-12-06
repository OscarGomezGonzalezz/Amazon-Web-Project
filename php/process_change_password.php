<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require './db_connection.php';

if (!isset($_SESSION['userId'])) {
    header("Location: ./users/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['userId'];
    echo "Sesión activa. User ID: " . $user_id;
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($new_password !== $confirm_password) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    global $conn;
    // Actualizar la contraseña y desactivar `must_change_password`
    $stmt = $conn->prepare("UPDATE Users SET password_hash = ?, must_change_password = 0 WHERE user_id = ?");
    $stmt->bind_param("si", $hashed_password, $user_id);

    if ($stmt->execute()) {
        header("Location: ../homepage.php");
        exit;
    } else {
        echo "Error al actualizar la contraseña.";
    }

    $stmt->close();
}
?>
