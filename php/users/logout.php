<?php
session_start();
include '../db_connection.php';

if (isset($_SESSION['userId'])) {//We access the user_id defined in login (this is possible thanks to work with sessions)
    $user_id = $_SESSION['userId'];

    // Set the user as offline in the Users table
    $stmt = $conn->prepare("UPDATE Users SET is_online = 0 WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    session_destroy();//We remove the data created for the session´s user
    echo "Logged out successfully.";
}

// Redirect to the home page
header("Location: ../../home.html"); 
exit();
?>
