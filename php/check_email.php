<?php
header('Content-Type: application/json'); // Configura el tipo de contenido para JSON

// Configuración de la conexión a la base de datos
try {
    $pdo = new PDO('mysql:host=localhost;dbname=amazonDB', 'root1', 'pasword1234');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error de conexión a la base de datos']);
    exit;
}

// Comprobación del método de solicitud
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';

    // Verificar si el correo electrónico está vacío
    if (empty($email)) {
        echo json_encode(['error' => 'El campo de correo no puede estar vacío']);
        exit;
    }

    // Consulta para verificar si el correo ya existe en la base de datos
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $exists = $stmt->fetchColumn() > 0;

    // Devolver resultado en formato JSON
    echo json_encode(['exists' => $exists]);
} else {
    // Si el método no es POST, responder con un error 405
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}
?>
