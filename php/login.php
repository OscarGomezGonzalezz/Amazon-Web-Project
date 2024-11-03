<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Trim and sanitize user input
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : '';
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : '';//This password is already hashed in js
    $loginTime = isset($_POST["login-time"]) ? trim($_POST["login-time"]) : '';
    $screenResolution = isset($_POST["screen-resolution"]) ? trim($_POST["screen-resolution"]) : '';
    $os = isset($_POST["os"]) ? trim($_POST["os"]) : '';
    $errors = [];


    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (strlen($email) <= 5) {
        $errors[] = "Email must be more than 5 characters.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    } else {
        // password is hashed with SHA-512, and we have to compare it with the hash stored in the database
        $storedHash = getStoredHashForEmail($email);

        if ($storedHash && hash_equals($storedHash, $password)) {
            // Password is correct
            echo "<p>Login successful</p>";
            logLoginDetails($email, $loginTime, $screenResolution, $os);
        } else {
            // Password is incorrect
            echo "<p style='color: red;'>Invalid email or password.</p>";
        }
    }

    function getStoredHashForEmail($email) {
        // TODO: REPLACE THIS WITH REAL DATA FROM THE DATABASE
        $DBEmail = "";
        $DBHash = hash('sha512', "Password1234"); // This should match the hash of the actual password
    
        return $email === $DBEmail ? $DBHash : null;
    }
    function logLoginDetails($email, $loginTime, $screenResolution, $os) {
        // TODO: SAVE THIS LOGIN INFO INTO THE DATABASE
        $logEntry = "Email: $email\nTime: $loginTime\nResolution: $screenResolution\nOS: $os\n\n";
    }
}
?>
