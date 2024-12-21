<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../db_connection.php';

session_start();



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = isset($_POST['firstName']) ? mysqli_real_escape_string($conn, trim($_POST['firstName'])) : '';
    $lastName = isset($_POST['lastName']) ? mysqli_real_escape_string($conn, trim($_POST['lastName'])) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, trim($_POST['email'])) : '';
    $address = isset($_POST['address']) ? mysqli_real_escape_string($conn, trim($_POST['address'])) : '';
    $country = isset($_POST['country']) ? mysqli_real_escape_string($conn, trim($_POST['country'])) : '';
    $state = isset($_POST['state']) ? mysqli_real_escape_string($conn, trim($_POST['state'])) : '';
    $zip = isset($_POST['zip']) ? mysqli_real_escape_string($conn, trim($_POST['zip'])) : '';
    $shippingMethod = isset($_POST['shippingMethod']) ? mysqli_real_escape_string($conn, trim($_POST['shippingMethod'])) : '';
    $dataProtection = isset($_POST['dataProtection']) && $_POST['dataProtection'] === 'on' ? true : false;
    $totalPrice = isset($_POST['totalPrice']) ? floatval(trim($_POST['totalPrice'])) : 0.00;

    //We have to transform the string format to an array valid in php
    $cartArticles = [];
    if (isset($_POST['cartArticles'])) {

        parse_str($_POST['cartArticles'], $cartArticles);

        if (is_array($cartArticles)) {
            echo "<pre>";
            print_r($cartArticles['cartArticles']); // Verify that it's an array
            echo "<pre>";
            
        } else {
            echo "<p style='color: red;'>Error: cartArticles is not a valid array.</p>";
        }
    } else {
        echo "<p style='color: red;'>Error: cartArticles is not set in POST data.</p>";
    }
    

    }

    $errors = [];

    if (empty($firstName)) $errors[] = 'First name is required.';
    if (empty($lastName)) $errors[] = 'Last name is required.';
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email address.';
    if (empty($address)) $errors[] = 'Address is required.';
    if (empty($country)) $errors[] = 'Country is required.';
    if (empty($state)) $errors[] = 'State is required.';
    if (empty($zip) || !preg_match('/^[0-9]{5}$/', $zip)) $errors[] = 'Invalid zip code.';
    if (empty($shippingMethod)) $errors[] = 'Shipping method is required.';
    if (!($dataProtection)) $errors[] = 'You must accept the data protection policy.';
    if ($totalPrice <= 0) $errors[] = 'Total price must be greater than zero.';
    if (empty($cartArticles)) $errors[] = 'Cart can not be empty';
   

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    } else {
        echo "<p style='color: green;'>Order Validated.\nNow, let´s create the order</p>";
            
        // We fetch user_id from the Users table based on the email
        $stmt = $conn->prepare("SELECT user_id FROM Users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($userId);
        $stmt->fetch();
        $stmt->close();
            
            // Check if user_id was found
        if ($userId) {
            $stmt = $conn->prepare("INSERT INTO Orders(user_id, first_name, last_name, email, address, shipping_method, total_price ) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssssd", $userId, $firstName, $lastName, $email, $address,$shippingMethod, $totalPrice );
            // Execute the statement
            if ($stmt->execute()) {

                echo "<p style='color: green;'>Order Created.\nNow, let´s create the order Items</p>";

                $orderId = $conn->insert_id; 
                if (!$orderId) {
                    echo "<p style='color: red;'>Error: Unable to retrieve the last order ID.</p>";
                }
                //cartArticles is passed as a nested array, so we have to access its nested array
                foreach ($cartArticles['cartArticles'] as $article) {
                    echo "<pre>";
                    print_r($article); // Verify that it's an array
                    echo "<pre>";
                    if (isset($article['name'], $article['quantity'], $article['price'], $article['image_url'])) {
                        
                        echo "<p style='color: green;'>Inserting Order Item ".$article['name']." </p>";
                        $stmt = $conn->prepare("INSERT INTO OrderItems(order_id, article_name, quantity, price, image_url) VALUES(?,?,?,?,?)");
                        $stmt->bind_param("isids", $orderId, $article['name'], $article['quantity'], $article['price'], $article['image_url']);
                        $stmt->execute();
                        $stmt->close();


                    
                    } else{
                        echo "<p style='color: red;'>Error creating order items details:</p>";
                    }
                }

                header('Location: ../../thanks.php');
                exit();

            } else {
                echo "<p style='color: red;'>Error creating order login details: " . $stmt->error . "</p>";
            } 
        } else{

            echo "<p style='color: red;'>User not found for the given email.</p>";
        }

       
    }
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
    //TODO alomejor que para cada articulo se enseñe el nombre y la cantidad
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

