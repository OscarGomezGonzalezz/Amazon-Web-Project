<?php
//This is implemented as AJAX, so we return the information as JSON
include 'db_connection.php';


$result = $conn->query("SELECT COUNT(*) AS online_users_count FROM Users WHERE is_online = 1");
$row = $result->fetch_assoc();
echo json_encode($row);

$conn->close();
?>
