<?php
$host = 'localhost'; // or your database server
$username = 'root';
$password = 'password1234';
$database = 'amazonDB';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else {
    echo "<p>Connected successfully</p>";
}
?>
