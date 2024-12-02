<?php
echo "Llegué al archivo PHP"; 
header('Content-Type: application/json');

// Conexión a la base de datos
try {
    $pdo = new PDO('mysql:host=localhost;dbname=amazonDB', 'root', 'password1234');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la conexión a la base de datos']);
    exit;
}

// Verificar si el correo ya existe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decodificar el JSON enviado en el cuerpo de la solicitud
    $data = json_decode(file_get_contents('php://input'), true);

    // Obtener el correo electrónico
    $email = $data['email'] ?? '';  // Si no se encuentra, será una cadena vacía
    
    // Validar que el correo no esté vacío
    if (empty($email)) {
        echo json_encode(['error' => 'El correo electrónico no puede estar vacío']);
        exit;
    }

    // Preparar la consulta para verificar si el correo existe
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $exists = $stmt->fetchColumn() > 0;

    // Responder con el resultado en formato JSON
    echo json_encode(['exists' => $exists]);
} else {
    // Si el método no es POST, devolver un error 405
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}
?>
