<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../db_connection.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['order_id']) && !empty($_POST['order_id'])) {
        $orderId = $_POST['order_id'];

        $stmt = $conn->prepare('SELECT * FROM Orders WHERE order_id = ?');
        $stmt->bind_param('i', $orderId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verify the requested order actually exists
        if ($result->num_rows > 0) {
            $originalOrder = $result->fetch_assoc();

            // Duplicate the order
            $insertOrderQuery = 'INSERT INTO Orders (user_id, first_name, last_name, email, address, shipping_method, total_price) 
                                 SELECT user_id, first_name, last_name, email, address, shipping_method, total_price 
                                 FROM Orders WHERE order_id = ?';
            $stmt = $conn->prepare($insertOrderQuery);
            $stmt->bind_param('i', $orderId);
            $stmt->execute();

            $newOrderId = $conn->insert_id;
            if (!$newOrderId) {
                echo "<p style='color: red;'>Error: Unable to retrieve the new order ID.</p>";
                exit();
            }

            // Duplicate the order items
            $copyItemsQuery = 'INSERT INTO OrderItems(order_id, article_name, quantity, price, image_url) 
                               SELECT ?, article_name, quantity, price, image_url 
                               FROM OrderItems WHERE order_id = ?';
            $stmt = $conn->prepare($copyItemsQuery);
            $stmt->bind_param('ii', $newOrderId, $orderId);
            $stmt->execute();
            $stmt->close();

            // Fetch order items for the email
            $itemsQuery = 'SELECT article_name, quantity, price FROM OrderItems WHERE order_id = ?';
            $stmt = $conn->prepare($itemsQuery);
            $stmt->bind_param('i', $newOrderId);
            $stmt->execute();
            $itemsResult = $stmt->get_result();

            $orderItemsHtml = '';
            while ($item = $itemsResult->fetch_assoc()) {
                $orderItemsHtml .= "
                <tr>
                    <td>{$item['article_name']}</td>
                    <td>{$item['quantity']}</td>
                    <td>\${$item['price']}</td>
                </tr>";
            }
            $stmt->close();

            // Send confirmation email
            $email = $originalOrder['email'];
            $shippingMethod = $originalOrder['shipping_method'];
            $totalPrice = $originalOrder['total_price'];

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'esperoquefuncioneconsusmuerto@gmail.com';
                $mail->Password = 'ttqqskqmskdovzmu';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('your-email@example.com', 'Amazon Clone');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Order Confirmation #' . $newOrderId;
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
                                            <td>$newOrderId</td>
                                        </tr>
                                        <tr>
                                            <th>Shipping Method</th>
                                            <td>$shippingMethod</td>
                                        </tr>
                                        <tr>
                                            <th>Total Amount</th>
                                            <td>\$$totalPrice</td>
                                        </tr>
                                    </table>
                                    <h3>Items in Your Order</h3>
                                    <table>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                        </tr>
                                        $orderItemsHtml
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

                $mail->send();
                echo json_encode(['success' => true, 'newOrderId' => $newOrderId, 'message' => 'Confirmation email sent successfully!']);
            } catch (Exception $e) {
                echo json_encode(['error' => 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo]);
            }
        } else {
            echo json_encode(['error' => 'Order not found']);
        }
    } else {
        echo json_encode(['error' => 'Order ID is required']);
    }
}
?>
