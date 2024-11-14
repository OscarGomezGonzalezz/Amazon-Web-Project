<?php
//This is implemented as AJAX, so we return the information as JSON
include 'db_connection.php';

session_start();

if (isset($_SESSION['userId'])) {//We access the user_id defined in login (this is possible thanks to work with sessions)
    $user_id = $_SESSION['userId'];
    // Query to fetch all articles
    $stmt = $conn->prepare("SELECT Cart.cart_id,Cart.user_id,Cart.article_id,Cart.quantity, Articles.name,Articles.price,
    Articles.image_url FROM Cart JOIN Articles ON Cart.article_id = Articles.article_id WHERE Cart.user_id = ?");
    $stmt -> bind_param("i",$user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $articles = [];

    if ($result->num_rows > 0) {
        // Fetch each row and add to the articles array
        while ($row = $result->fetch_assoc())//fetches the next row of the result as an associative array
        {
            $articles[] = $row;//adds each row to the articles assoc array
        }
    }

    // Return JSON response for AJAX
    header('Content-Type: application/json');
    echo json_encode($articles);

    // Close the connection
    $conn->close();
} else {
    echo json_encode(["error" => "User not logged in."]);

}
?>
