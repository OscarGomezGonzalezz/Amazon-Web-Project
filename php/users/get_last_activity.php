<?php
//This is implemented as AJAX, so we return the information as JSON
include '../db_connection.php';

session_start();

if (isset($_SESSION['userId'])) {//We access the user_id defined in login (this is possible thanks to work with sessions)
    $user_id = $_SESSION['userId'];

    $stmt = $conn->prepare("SELECT last_activity FROM Users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
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
