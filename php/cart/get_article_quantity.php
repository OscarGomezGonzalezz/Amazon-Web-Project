<?php
// This script handles AJAX requests and returns JSON responses
include '../db_connection.php';

session_start();

$response = ["status" => "error", "message" => "Make sure you are logged in"];

if (isset($_SESSION['userId']) && isset($_POST['article_id'])) {
    $user_id = $_SESSION['userId'];
    $article_id = intval($_POST['article_id']);

    $stmt = $conn->prepare("SELECT quantity AS article_quantity FROM Cart WHERE user_id = ? AND article_id = ?");
    $stmt->bind_param('ii', $user_id, $article_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $response = [
            "status" => "success",
            "article_quantity" => $row['article_quantity']
        ];
    } else {
        $response = [
            "status" => "error",
            "message" => "Article not found in the cart"
        ];
    }

    $stmt->close();
} else {
    $response['message'] = "Invalid request. Missing required parameters.";
}

echo json_encode($response);
?>
