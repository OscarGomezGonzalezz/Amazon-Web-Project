<?php
//This is implemented as AJAX, so we return the information as JSON
include '../db_connection.php';

session_start();

if(isset($_SESSION['userId'])){

    $user_id = $_SESSION['userId'];

    $stmt = $conn->prepare("SELECT SUM(
        CASE 
            WHEN Cart.quantity >= 16 THEN Articles.price * Cart.quantity * 0.84  -- 16% discount
            WHEN Cart.quantity >= 8 THEN Articles.price * Cart.quantity * 0.92  -- 8% discount
            ELSE Articles.price * Cart.quantity
        END)
        AS total_cart_price FROM Cart JOIN Articles ON Cart.article_id = Articles.article_id WHERE Cart.user_id = ?");
    $stmt -> bind_param('i', $user_id);
    $stmt -> execute();
    $result = $stmt -> get_result();

    if ($row = $result->fetch_assoc())//attempts to fetch one row from the result set
    {
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "No activity found for this user."]);
    }

    $stmt->close();
    $conn->close();

} else {
    echo json_encode(["error" => "User not logged in."]);

}
?>
