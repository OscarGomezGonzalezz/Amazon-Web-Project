<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['order_id']) && !empty($_POST['order_id'])) {
        $orderId = $_POST['order_id'];

            $stmt = $conn->prepare('SELECT * FROM Orders WHERE order_id = ?');
            $stmt -> bind_param('i', $orderId);
            $stmt->execute();
            $result = $stmt->get_result();

            //we verify the requested order actually exists
            if ($result->num_rows > 0) {

                $insertOrderQuery = 'INSERT INTO Orders (user_id, first_name, last_name, email, address, shipping_method, total_price) 
                                     SELECT user_id, first_name, last_name, email, address, shipping_method, total_price 
                                     FROM Orders WHERE order_id = ?';
                $stmt = $conn->prepare($insertOrderQuery);
                $stmt -> bind_param('i', $orderId);
                $stmt->execute();

                $newOrderId = $conn->insert_id; 
                if (!$newOrderId) {
                    echo "<p style='color: red;'>Error: Unable to retrieve the last order ID.</p>";
                }

                $copyItemsQuery = 'INSERT INTO OrderItems(order_id, article_name, quantity, price, image_url) 
                                   SELECT ?, article_name, quantity, price, image_url 
                                   FROM OrderItems WHERE order_id = ?';
                $stmt = $conn->prepare($copyItemsQuery);
                $stmt -> bind_param('ii', $newOrderId, $orderId);
                $stmt->execute();
                $stmt->close();

                // Return a success message
                echo json_encode(['success' => true, 'newOrderId' => $newOrderId]);
            } else {
                // If the order doesn't exist
                echo json_encode(['error' => 'Order not found']);
            }
        
    } else {
        echo json_encode(['error' => 'Order ID is required']);
    }
}
?>
