<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (empty($_POST["firstName"])) {
        $errors["firstName"] = "First name is required.";
    } else {
        $firstName = htmlspecialchars($_POST["firstName"]); // Prevent XSS
    }

    // Retrieve and validate last name
    if (empty($_POST["lastName"])) {
        $errors["lastName"] = "Last name is required.";
    } else {
        $lastName = htmlspecialchars($_POST["lastName"]);
    }

    // Retrieve and validate username
    if (empty($_POST["username"])) {
        $errors["username"] = "Username is required.";
    } else {
        $username = htmlspecialchars($_POST["username"]);
    }

    // Retrieve and validate email (optional)
    if (!empty($_POST["email"]) && !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Please provide a valid email address.";
    } else {
        $email = htmlspecialchars($_POST["email"]);
    }

    // Retrieve and validate address
    if (empty($_POST["address"])) {
        $errors["address"] = "Address is required.";
    } else {
        $address = htmlspecialchars($_POST["address"]);
    }

    // Retrieve and validate country
    if (empty($_POST["country"])) {
        $errors["country"] = "Country is required.";
    } else {
        $country = htmlspecialchars($_POST["country"]);
    }

    // Retrieve and validate state
    if (empty($_POST["state"])) {
        $errors["state"] = "State is required.";
    } else {
        $state = htmlspecialchars($_POST["state"]);
    }

    // Retrieve and validate zip
    if (empty($_POST["zip"])) {
        $errors["zip"] = "Zip code is required.";
    } elseif (!preg_match("/^[0-9]{5}$/", $_POST["zip"])) {
        $errors["zip"] = "Please provide a valid 5-digit zip code.";
    } else {
        $zip = htmlspecialchars($_POST["zip"]);
    }

    // Validate credit card details
    if (empty($_POST["cc-name"])) {
        $errors["cc-name"] = "Name on card is required.";
    }
    if (empty($_POST["cc-number"]) || !preg_match("/^[0-9]{16}$/", $_POST["cc-number"])) {
        $errors["cc-number"] = "Please provide a valid 16-digit credit card number.";
    }
    if (empty($_POST["cc-expiration"])) {
        $errors["cc-expiration"] = "Expiration date is required.";
    }
    if (empty($_POST["cc-cvv"]) || !preg_match("/^[0-9]{3}$/", $_POST["cc-cvv"])) {
        $errors["cc-cvv"] = "Please provide a valid 3-digit CVV.";
    }
    }
    if (empty($errors)) {
        // Process the data (e.g., save to database, send confirmation email)
        echo "<h3>Order successfully placed!</h3>";
        // Redirect or show success message
        header("Location: thanks.html");
        exit();
    }
?>
