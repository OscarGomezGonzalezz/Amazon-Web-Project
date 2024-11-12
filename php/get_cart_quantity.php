<?php
//This is implemented as AJAX, so we return the information as JSON
include 'db_connection.php';

session_start();

if(isset($_SESSION['userId'])){

    $user_id = $_SESSION['userId'];

    $stmt = $conn->prepare("SELECT SUM(quantity) AS user_cart_quantity FROM Cart WHERE user_id = ?");
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
