<?php
//This is implemented as AJAX, so we return the information as JSON
include 'db_connection.php';

// Query to fetch all articles
$result = $conn->query("SELECT * FROM Articles");

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
?>
