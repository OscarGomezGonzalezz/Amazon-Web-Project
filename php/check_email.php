<?php
// Conexión a la base de datos
$pdo = new PDO('mysql:host=localhost;dbname=amazonDB', 'root', 'password1234');

// Obtener el correo del parámetro de la URL
$email = $_GET['email'];
// Consultar si el correo ya existe
$stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
$stmt->execute(['email' => $email]);
$exists = $stmt->fetchColumn() > 0;
// Devolver el resultado en formato JSON
echo json_encode(['exists' => $exists]);
?>
