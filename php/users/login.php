<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include ('../db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Trim and sanitize user input
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : '';
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : '';//This password is already hashed in js

    //We have created this attribute in the db with the defect value: current_timestamp() so we need not to add 
    // it in the insert query
    //$loginTime = isset($_POST["login-time"]) ? trim($_POST["login-time"]) : '';

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

        global $conn; // Access the connection from the outer scope
        // Prepare and execute the query to get the stored hash from the database
        $stmt = $conn->prepare("SELECT password_hash FROM USERS WHERE email = ?"); 
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($storedHash);
        $stmt->fetch();
        $stmt->close();

        if ($storedHash && password_verify($password,$storedHash)) 
         {
            // Password is correct
            session_start();

            // We fetch user_id from the Users table based on the email
            $stmt = $conn->prepare("SELECT user_id FROM Users WHERE email = ?"); //PONIA USER_ID en minusculas
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($userId);
            $stmt->fetch();
            $stmt->close();
            
                // Check if user_id was found
            if ($userId) {

                $_SESSION['userId'] = $userId;
                // Verificar si debe cambiar la contraseña
                $stmt = $conn->prepare("SELECT must_change_password FROM Users WHERE user_id = ?");
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $stmt->bind_result($mustChangePassword);
                $stmt->fetch();
                $stmt->close();

                if ($mustChangePassword) {
                    header("Location: ../../change_password.php");
                    exit();
                }

                //insert login details into DB
                $stmt = $conn->prepare("INSERT INTO LoginLogs(user_id, screen_resolution, os) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $userId, $screenResolution, $os); // user_id is an integer, so we use "i" for user_id
                    // Execute the statement
                if ($stmt->execute()) {

                }else {
                echo "<p style='color: red;'>Error logging login details: " . $stmt->error . "</p>";
                } 

                $stmt->close();
                //Set user as online
                $stmt = $conn->prepare("UPDATE Users SET is_online = 1 WHERE user_id = ?");
                $stmt->bind_param("i", $_SESSION['userId']);
                $stmt->execute();

                $stmt->close();
                header("Location: ../../homepage.php");
                exit(); // Ensure no further code is executed

                }
            else {
                echo "<p style='color: red;'>User not found for the given email.</p>";
                }
        } else {
            // Password is incorrect
            echo "<p style='color: red;'>Invalid email or password.</p>";
        }
    }
    }
?>
