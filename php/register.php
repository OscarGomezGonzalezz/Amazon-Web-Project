<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // PHPMailer autoload

header('Content-Type: application/json');

// Configuración de errores
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log.log');

// Conexión a la base de datos
try {
    $pdo = new PDO('mysql:host=localhost;dbname=amazonDB', 'root', 'password1234');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Error en la base de datos: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rawInput = file_get_contents("php://input");
    $input = json_decode($rawInput, true);

    $email = $input['email'] ?? '';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Por favor ingresa un correo electrónico válido.']);
        exit;
    }

    // Verificar duplicados
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    if ($stmt->fetchColumn() > 0) {
        echo json_encode(['success' => false, 'message' => 'El correo ya está registrado.']);
        exit;
    }
    // Generar contraseña aleatoria con al menos una mayúscula
function generatePassword($length = 10) {
    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $uppercaseCharacters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $password = '';

    // Generar una parte de la contraseña con caracteres al azar
    for ($i = 0; $i < $length - 1; $i++) {
        $password .= $characters[random_int(0, strlen($characters) - 1)];
    }

    // Asegurar que tenga al menos una mayúscula
    $password .= $uppercaseCharacters[random_int(0, strlen($uppercaseCharacters) - 1)];

    // Mezclar los caracteres para aleatoriedad
    return str_shuffle($password);
}

// Usar la función para generar la contraseña
$password = generatePassword();
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);


    // Insertar usuario en la base de datos con el estado de "primera vez"
    $id=1;
    try {
        $stmt = $pdo->prepare("INSERT INTO users (user_id,email,password_hash) VALUES ($id,:email,:password)");
        $stmt->execute(['email' => $email, 'password' => $hashedPassword]); //REVISAR ESTA LINEA
        $id=$id +1; //CUIDADO CON ESTA; LINEA
    } catch (PDOException $e) {
        error_log("Error al registrar usuario: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error al registrar el usuario.']);
        exit;
    }

    // Enviar email de confirmación con contraseña
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'esperoquefuncioneconsusmuerto@gmail.com';
        $mail->Password = 'ttqqskqmskdovzmu';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('esperoquefuncioneconsusmuerto@gmail.com', 'Amazon Clone');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Registro Exitoso - Amazon Clone';
        $mail->Body = "Bienvenido a Amazon Clone. Tu contraseña temporal es: <b>$password</b>. 
                       Por favor inicia sesión y cambia tu contraseña.";

        $mail->send();
        echo json_encode(['success' => true, 'message' => 'Registro exitoso. Revisa tu correo para la contraseña temporal.']);
    } catch (Exception $e) {
        error_log("Error al enviar el correo: " . $mail->ErrorInfo);
        echo json_encode(['success' => false, 'message' => 'Error al enviar el correo de confirmación.']);
    }
}
?>
