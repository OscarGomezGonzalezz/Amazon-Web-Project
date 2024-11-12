<?php
include 'db_connection.php'; // Include the database connection
session_start();
header('Content-Type: application/json'); // Set header for JSON response

// Initialize an array to store the response
$response = ["status" => "error", "message" => "Unknown error occurred"];

// Check if required parameters are set
if (isset($_POST['article_id']) && isset($_POST['quantity'])&& isset($_SESSION['userId'])) {
    $article_id = intval($_POST['article_id']);
    $quantity = intval($_POST['quantity']);
    $user_id = $_SESSION['userId'];

    // Check if the `addToCart` function executes successfully
    if (addToCart($article_id,$user_id, $quantity)) {
        $response = ["status" => "success", "message" => "Item added to cart successfully"];
    } else {
        $response = ["status" => "error", "message" => "Failed to add item to cart"];
    }
} else {
    // Return error response if parameters are missing
    $response = ["status" => "error", "message" => "Missing article_id or quantity"];
}

// Output the response as JSON

function addToCart($article_id, $user_id, $quantity) {
    global $conn; // Access the database connection

    // Check if the article is already in the cart
    $stmt = $conn->prepare("SELECT quantity FROM cart WHERE article_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $article_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $existingItem = $result->fetch_assoc();
    $stmt->close();

    // If item exists, update the quantity
    if ($existingItem) {
        $newQuantity = $existingItem['quantity'] + $quantity;
        $updateStmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE article_id = ? AND user_id = ?");
        $updateStmt->bind_param("iii", $newQuantity, $article_id, $user_id);
        $updateSuccess = $updateStmt->execute();
        $updateStmt->close();
        return $updateSuccess;
    } else {
        // If item does not exist, insert a new row
        $insertStmt = $conn->prepare("INSERT INTO cart (user_id, article_id, quantity) VALUES (?, ?, ?)");
        $insertStmt->bind_param("iii", $user_id, $article_id, $quantity);
        $insertSuccess = $insertStmt->execute();
        $insertStmt->close();
        return $insertSuccess;
    }
}


echo json_encode($response);

?>
