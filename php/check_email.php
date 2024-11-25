<?php
header('Content-Type: application/json');

// Conexión a la base de datos
try {
    $pdo = new PDO('mysql:host=localhost;dbname=amazonDB', 'root1', 'password1234');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la conexión a la base de datos']);
    exit;
}

// Verificar si el correo ya existe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    
    if (empty($email)) {
        echo json_encode(['error' => 'El correo electrónico no puede estar vacío']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $exists = $stmt->fetchColumn() > 0;

    echo json_encode(['exists' => $exists]);
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}
?>
