<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // PHPMailer autoload
include ('./db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['email']) && !empty($_POST['email'])){

        $email = $_POST['email'];
        global $conn;

        // Check if email already exists
        $stmt = $conn->prepare("SELECT COUNT(*) FROM Users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        
        if ($count > 0) {
            echo json_encode(['success' => false, 'message' => 'Email is already registered.']);
            exit;
        }

        // Generate random password
        $length = 10;
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $uppercaseCharacters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = '';

        for ($i = 0; $i < $length - 1; $i++) {
            $password .= $characters[random_int(0, strlen($characters) - 1)];
        }

        // Ensure at least one uppercase character
        $password .= $uppercaseCharacters[random_int(0, strlen($uppercaseCharacters) - 1)];
        $password = str_shuffle($password);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into the database
        $stmt = $conn->prepare("INSERT INTO Users (email, password_hash) VALUES (?, ?)");
        $stmt->bind_param('ss', $email, $hashedPassword);
        $stmt->execute();
        $stmt->close();

        // Send email
        try {
            /*$mail = new PHPMailer(true);
            
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'esperoquefuncioneconsusmuerto@gmail.com';
            $mail->Password = 'ttqqskqmskdovzmu'; // It's recommended to use environment variables or a config file for sensitive data like passwords
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Set email sender and recipient
            $mail->setFrom('esperoquefuncioneconsusmuerto@gmail.com', 'Amazon Clone');
            $mail->addAddress($email);

            // Set email content
            $mail->isHTML(true);
            $mail->Subject = 'Successful Register - Amazon Clone';
            $mail->Body = "Welcome to Amazon Clone. Your temporary password is: <b>$password</b>. Please login and change your password.";

            // Send the email
            if (!$mail->send()) {
                throw new Exception('Mailer Error: ' . $mail->ErrorInfo);
            }*/

            echo json_encode(['success' => true, 'message' => 'Registration successful. Check your email for the temporary password.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Mailer Error: ' . $e->getMessage()]);
        }

        exit;

    } else {
        echo json_encode(['success' => false, 'message' => 'Please provide a valid email.']);
        exit;
    }
}
?>
