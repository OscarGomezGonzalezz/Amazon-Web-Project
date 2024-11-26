<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Start a session to store error messages if needed
session_start();

// Array to store validation errors
$errors = [];

// Retrieve form data
$firstName = isset($_POST['firstName']) ? trim($_POST['firstName']) : '';
$lastName = isset($_POST['lastName']) ? trim($_POST['lastName']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$address = isset($_POST['address']) ? trim($_POST['address']) : '';
$country = isset($_POST['country']) ? trim($_POST['country']) : '';
$state = isset($_POST['state']) ? trim($_POST['state']) : '';
$zip = isset($_POST['zip']) ? trim($_POST['zip']) : '';
$shippingMethod = isset($_POST['shippingMethod']) ? trim($_POST['shippingMethod']) : '';
$dataProtection = isset($_POST['dataProtection']) ? $_POST['dataProtection'] : null;

// First Name validation
if (empty($firstName)) {
    $errors['firstName'] = 'First name is required.';
}

// Last Name validation
if (empty($lastName)) {
    $errors['lastName'] = 'Last name is required.';
}

// Email validation (optional)
if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Please provide a valid email address.';
}

// Address validation
if (empty($address)) {
    $errors['address'] = 'Address is required.';
}

// Country validation
if (empty($country)) {
    $errors['country'] = 'Country is required.';
}

// State validation
if (empty($state)) {
    $errors['state'] = 'State is required.';
}

// Zip validation
if (empty($zip)) {
    $errors['zip'] = 'Zip code is required.';
} elseif (!preg_match('/^[0-9]{5}$/', $zip)) {
    $errors['zip'] = 'Please provide a valid 5-digit zip code.';
}

// Shipping Method validation
if (empty($shippingMethod)) {
    $errors['shippingMethod'] = 'Please select a shipping method.';
}

// Data protection checkbox validation
if (empty($dataProtection)) {
    $errors['dataProtection'] = 'You must accept the data protection policy.';
}

// If there are errors, store them in the session and redirect back to the form
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    // Optionally, redirect back to the form with the error messages
    header('Location: ../checkout.html');
    exit();
} else{
    header('Location: ../thanks.html');
}


// Here, you would typically process the order, e.g., save the data to a database or perform other actions
?>
