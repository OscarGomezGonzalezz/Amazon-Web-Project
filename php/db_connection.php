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
    $conn->set_charset("utf8mb4");


    //If we echo this, when we parse as a json the get_online_users response, as we include this file in the get one
    // the response will first contain this echo, which does not coincide with a JSON response, reporting an error
    
    //echo "<p>Connected successfully</p>";
}
?>
