<?php
session_start();
include('db_connection.php');  // Include your database connection

// Check if the user is logged in and fetch the user data from the database
if (isset($_SESSION['userId'])) {
    $user_id = $_SESSION['userId'];
    
    // Query to check if the user is online
    $query = "SELECT is_online FROM Users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($is_online);
    $stmt->fetch();
    echo json_encode(['is_online' => $is_online]);
} else {
    echo json_encode(['is_online' => 0]); // Not logged in
}
?>
