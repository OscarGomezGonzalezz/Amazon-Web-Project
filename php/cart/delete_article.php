<?php
// delete_article.php
include '../db_connection.php'; // Include your database connection

// Set the content type to JSON
header('Content-Type: application/json');

$response = json_encode(['success' => false, 'message' => 'Unknown error']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if article_id is set in the POST request
    if (isset($_POST['article_id'])) {
        $articleId = $_POST['article_id'];

        // Validate the input (make sure it's an integer)
        if (filter_var($articleId, FILTER_VALIDATE_INT)) {
            // Prepare the DELETE SQL statement
            $stmt = $conn->prepare("DELETE FROM Cart WHERE article_id = ?");
            $stmt->bind_param("i", $articleId);

            // Execute the statement
            if ($stmt->execute()) {
                // If successful, return a success response
                $response = json_encode(['success' => true, 'message' => 'Article deleted successfully']);
            } else {
                // If there's an error, return a failure response
                $response = json_encode(['success' => false, 'message' => 'Error deleting article']);
            }

            $stmt->close();
        } else {
            $response = json_encode(['success' => false, 'message' => 'Invalid article ID']);
        }
    } else {
        $response = json_encode(['success' => false, 'message' => 'No article ID provided']);
    }
}

echo $response;

$conn->close();
?>
