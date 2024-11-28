<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Asegúrate de tener PHPMailer en tu proyecto

header('Content-Type: application/json');

// Conexión a la base de datos
try {
    $pdo = new PDO('mysql:host=localhost;dbname=amazonDB', 'root', 'password1234');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    
    if (empty($email)) {
        echo json_encode(['success' => false, 'message' => 'El correo no puede estar vacío']);
        exit;
    }

    // Verificar si el correo ya está registrado
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    if ($stmt->fetchColumn() > 0) {
        echo json_encode(['success' => false, 'message' => 'El correo ya está registrado']);
        exit;
    }

    // Generar contraseña aleatoria
    $password = bin2hex(random_bytes(4)); // Generar una contraseña aleatoria
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Guardar la contraseña de manera segura

    // Insertar usuario en la base de datos
    $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
    $stmt->execute(['email' => $email, 'password' => $hashedPassword]);

    // Enviar correo con la contraseña
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'esperoquefuncioneconsusmuerto@gmail.com';
        $mail->Password = 'esperoquefuncioneconsusmuerto1!'; // Usa el App Password si tienes activada la verificación en dos pasos
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('esperoquefuncioneconsusmuerto@gmail.com', 'Amazon Clone');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Bienvenido a Amazon Clone';
        $mail->Body    = "¡Hola! Has sido registrado con éxito. Tu contraseña es: $password";

        $mail->send();
        echo json_encode(['success' => true, 'message' => 'Registro exitoso. Revisa tu correo para tu contraseña.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al enviar el correo: ' . $mail->ErrorInfo]);
    }
}
?>
