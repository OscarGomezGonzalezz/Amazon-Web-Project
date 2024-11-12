<?php
//This is implemented as AJAX, so we return the information as JSON
include 'db_connection.php';


$result = $conn->query("SELECT SUM(quantity) AS total_quantity FROM Cart");
$row = $result->fetch_assoc();
echo json_encode($row);

$conn->close();
?>
