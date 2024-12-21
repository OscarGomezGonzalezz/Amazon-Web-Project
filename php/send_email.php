

<?php
// Incluir PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Asegúrate de que Composer haya instalado PHPMailer

// Datos de ejemplo (reemplaza con tus variables dinámicas)
$orderNumber = $orderId;
$itemName = $article['name'];
$itemQuantity =  $article['quantity'];
$shippingCost = $shippingMethod;
$totalAmount = $totalPrice;
$customerEmail = $email; // Reemplaza por el correo del cliente

// Crear la instancia de PHPMailer
$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; 
    $mail->SMTPAuth = true;
    $mail->Username = 'esperoquefuncioneconsusmuerto@gmail.com'; // Tu correo
    $mail->Password = 'ttqqskqmskdovzmu'; // Tu contraseña
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Configuración del correo
    $mail->setFrom('esperoquefuncioneconsusmuerto@gmail.com', 'Amazon Clone');
    $mail->addAddress($customerEmail);

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Order Confirmation #' . $orderNumber;

    // Contenido del correo (HTML)
    $mail->Body = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Order Confirmation</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }
            .email-container {
                max-width: 600px;
                margin: 20px auto;
                background: #fff;
                border: 1px solid #ddd;
                border-radius: 8px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                overflow: hidden;
            }
            .header {
                background-color: #0073e6;
                color: white;
                padding: 20px;
                text-align: center;
            }
            .header h1 {
                margin: 0;
            }
            .content {
                padding: 20px;
            }
            .content h2 {
                margin-top: 0;
            }
            .order-details {
                margin-top: 20px;
            }
            .order-details table {
                width: 100%;
                border-collapse: collapse;
            }
            .order-details th, .order-details td {
                border: 1px solid #ddd;
                padding: 10px;
                text-align: left;
            }
            .order-details th {
                background-color: #f9f9f9;
            }
            .footer {
                background-color: #f9f9f9;
                color: #555;
                text-align: center;
                padding: 10px;
                font-size: 14px;
            }
        </style>
    </head>
    <body>
        <div class='email-container'>
            <div class='header'>
                <h1>Thank You for Your Order!</h1>
            </div>
            <div class='content'>
                <h2>Order Confirmation</h2>
                <p>Dear Customer,</p>
                <p>Thank you for your purchase! Below are the details of your order:</p>
                <div class='order-details'>
                    <h3>Order Details</h3>
                    <table>
                        <tr>
                            <th>Order Number</th>
                            <td>$orderNumber</td>
                        </tr>
                        <tr>
                            <th>Item Name</th>
                            <td>$itemName</td>
                        </tr>
                        <tr>
                            <th>Item Quantity</th>
                            <td>$itemQuantity</td>
                        </tr>
                        <tr>
                            <th>Shipping</th>
                            <td>$$shippingCost</td>
                        </tr>
                        <tr>
                            <th>Total Amount</th>
                            <td>$$totalAmount</td>
                        </tr>
                    </table>
                </div>
                <p>If you have any questions, feel free to contact us at <a href='mailto:support@example.com'>support@example.com</a>.</p>
            </div>
            <div class='footer'>
                &copy; 2024 Your Company. All Rights Reserved.
            </div>
        </div>
    </body>
    </html>";

    // Enviar el correo
    $mail->send();
    echo 'Confirmation email sent successfully!';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
