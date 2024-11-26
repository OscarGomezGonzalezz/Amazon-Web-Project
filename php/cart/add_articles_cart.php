<?php
include '../db_connection.php';
session_start();
header('Content-Type: application/json'); // Set header for JSON response

// Initialize an array to store the response
$response = ["status" => "error", "message" => "Make sure you are logged in"];


//IF THE USER IS NOT LOGGED IN, IT WILL RETURN AN ERROR
if (isset($_POST['article_id']) && isset($_POST['quantity'])&& isset($_SESSION['userId'])) {
    $article_id = intval($_POST['article_id']);
    $quantity = intval($_POST['quantity']);
    $user_id = $_SESSION['userId'];

    // Check if the article is already in the cart
    $stmt = $conn->prepare("SELECT quantity FROM cart WHERE article_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $article_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $existingItem = $result->fetch_assoc();
    $stmt->close();


    if ($existingItem) {
        //If it exists, we updload its quantity
        $newQuantity = $existingItem['quantity'] + $quantity;
        $updateStmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE article_id = ? AND user_id = ?");
        $updateStmt->bind_param("iii", $newQuantity, $article_id, $user_id);
        $updateSuccess = $updateStmt->execute();
        $updateStmt->close();
        if ($updateSuccess) {
            $response = ["status" => "success", "message" => "Item quantity updated in cart"];
        } else {
            $response = ["status" => "error", "message" => "Failed to update item quantity in cart"];
        }
    } else {
        // If item does not exist, insert a new row
        $insertStmt = $conn->prepare("INSERT INTO cart (user_id, article_id, quantity) VALUES (?, ?, ?)");
        $insertStmt->bind_param("iii", $user_id, $article_id, $quantity);
        $insertSuccess = $insertStmt->execute();
        $insertStmt->close();
        if ($insertSuccess) {
            $response = ["status" => "success", "message" => "Item added to cart successfully"];
        } else {
            $response = ["status" => "error", "message" => "Failed to add item to cart"];
        }
    }
}
    echo json_encode($response);

?>
