<?php
session_start();

// We verify if the user is logged in
if (!isset($_SESSION['userId'])) {
    
    header("Location: login.html");//in case he does not, we redirige him to login page
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Thank You</title>

    <!-- CSS files for styling -->
    <link rel="stylesheet" href="../../css/bootstrap.css" />
    <link rel="stylesheet" href="./styles/thanks.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    <div class="thank-you-container">
      <!-- Thank you message -->
      <h1 class="thank-you-header">Thank You for Your Purchase!</h1>
      <p class="thank-you-message">
        Your order has been successfully placed. You will receive a confirmation email shortly.
      </p>

      <!-- Order details -->
      <div class="order-summary">
        <h2>Order Summary</h2>
        <p>Order Number: <span>#12345</span></p>
        <p>Estimated Delivery: <span>3-5 Business Days</span></p>
      </div>

      <!-- Call to actions -->
      <div class="thank-you-actions">
        <button onclick="window.location.href='home.html'" class="btn btn-primary">
          Continue Shopping
        </button>
        <button onclick="window.location.href='orders.php'" class="btn btn-secondary">
          View My Orders
        </button>
      </div>
    </div>

    <!-- Scripts -->
    <script
      src="https://kit.fontawesome.com/6e6ca3a608.js"
      crossorigin="anonymous"
    ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
