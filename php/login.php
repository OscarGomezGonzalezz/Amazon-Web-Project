<?php
//If JavaScript validation passes, the form submits to login.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = trim($_POST["email"]);
  $password = trim($_POST["password"]);
  $errors = [];

  // Validate email
  if (empty($email)) {
    $errors[] = "Email is required.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
  }

  // Validate password
  if (empty($password)) {
    $errors[] = "Password is required.";
  }

  // If there are errors, display them
  if (!empty($errors)) {
    foreach ($errors as $error) {
      echo "<p style='color: red;'>$error</p>";
    }
  } else {
    // If validation passes, proceed with login logic
    // Example: Authentication, database check, etc.
    echo "<p>Login successful</p>";
  }
}
?>
