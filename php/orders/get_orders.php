<?php
include '../db_connection.php';

session_start();

if (isset($_SESSION['userId'])) {//We access the user_id defined in login (this is possible thanks to work with sessions)
    $user_id = $_SESSION['userId'];
    // Query to fetch all articles
    $stmt = $conn->prepare("SELECT Orders.order_id, Orders.total_price, OrderItems.article_name, OrderItems.quantity, OrderItems.price, OrderItems.image_url FROM Orders JOIN OrderItems ON Orders.order_id = OrderItems.order_id WHERE Orders.user_id = ?");
    $stmt -> bind_param("i",$user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $orders = [];

    if ($result->num_rows > 0) {
        // Fetch each row and add to the articles array
        while ($row = $result->fetch_assoc())//fetches the next row of the result as an associative array
        {
            $orderId = $row['order_id'];
            // If the order_id doesn't exist in the Orders, initialize it
            if (!isset($orders[$orderId])) {
                $orders[$orderId] = [
                    'order_id' => $orderId,
                    'total_price' => $row['total_price'],
                    'items' => []
                ];
            }
            //We add the order´s items
            $orders[$orderId]['items'][] = [
                'article_name' => $row['article_name'],
                'quantity' => $row['quantity'],
                'price' => $row['price'],
                'image_url' => $row['image_url']
            ];
        }
    }

    // Return JSON response for AJAX
    header('Content-Type: application/json');
    echo json_encode($orders);

    // Close the connection
    $conn->close();
} else {
    echo json_encode(["error" => "User not logged in."]);

}
?>
