<?php
include '../db_connection.php';
session_start();
header('Content-Type: application/json'); // Set header for JSON response

// Initialize an array to store the response
$response = ["status" => "error", "message" => "Make sure you are logged in"];

// Check if the user is logged in
if (isset($_SESSION['userId'])) {
    // Get the raw PATCH data
    $input = json_decode(file_get_contents("php://input"), true);

    // Check if 'article_id' and 'quantity' are set in the input data
    if (isset($input['article_id']) && isset($input['quantity'])) {
        $article_id = intval($input['article_id']);
        $quantity = intval($input['quantity']);
        $user_id = $_SESSION['userId'];

        $updateStmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE article_id = ? AND user_id = ?");
        $updateStmt->bind_param("iii", $quantity, $article_id, $user_id);
        $updateSuccess = $updateStmt->execute();
        $updateStmt->close();

        if ($updateSuccess) {
            $response = ["status" => "success", "message" => "Item quantity updated in cart"];
        } else {
            $response = ["status" => "error", "message" => "Failed to update item quantity in cart"];
        }
    } else {
        $response["message"] = "Invalid input data";
    }
}

// Output the response as JSON
echo json_encode($response);

?>
