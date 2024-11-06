<?php
// Configuración de la base de datos
$dsn = 'mysql:host=localhost;dbname=amazonDB';
$username = 'root1';
$password = 'password1234';

try {
    // Conexión a la base de datos
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar si el formulario fue enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'] ?? '';

        // Validar que el correo no esté vacío
        if (empty($email)) {
            echo json_encode(['success' => false, 'message' => 'El campo de correo no puede estar vacío.']);
            exit;
        }

        // Validar si el correo ya existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        if ($stmt->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'message' => 'Error: el usuario ya está registrado.']);
            exit;
        }

        // Generar una contraseña aleatoria
        $password = bin2hex(random_bytes(4)); // Contraseña de 8 caracteres
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insertar el nuevo usuario en la base de datos
        $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
        $stmt->execute(['email' => $email, 'password' => $hashedPassword]);

        // Enviar la contraseña al correo del usuario
        $to = $email;
        $subject = "Confirmación de Registro";
        $message = "¡Bienvenido! Su cuenta ha sido registrada. Su contraseña es: $password";
        $headers = "From: no-reply@tudominio.com";
        mail($to, $subject, $message, $headers);

        echo json_encode(['success' => true, 'message' => 'Registro exitoso. Su contraseña ha sido enviada a su correo.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
}
?>
