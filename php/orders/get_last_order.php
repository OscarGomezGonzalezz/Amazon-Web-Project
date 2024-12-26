<?php
include '../db_connection.php';

session_start();

if (isset($_SESSION['userId'])) {//We access the user_id defined in login (this is possible thanks to work with sessions)
    $user_id = $_SESSION['userId'];
    // Query to fetch all articles
    $stmt = $conn->prepare("SELECT order_id, total_price, address FROM Orders WHERE user_id = ? ORDER BY order_id DESC LIMIT 1");
    $stmt -> bind_param("i",$user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {


        $row = $result->fetch_assoc(); 
        $orderId = $row['order_id'];
        $totalPrice = $row['total_price'];
        $address = $row['address'];

        echo json_encode(['order_id' => $orderId, "total_price" => $totalPrice, "address" => $address]);
        exit();
        
    }

    // Return JSON response for AJAX
    header('Content-Type: application/json');
    echo json_encode(["error" => "Order not found"]);
    exit();

    // Close the connection
    $conn->close();
} else {
    echo json_encode(["error" => "User not logged in."]);
    exit();

}
?>
