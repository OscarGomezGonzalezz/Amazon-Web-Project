<?php
session_start();

// We verify if the user is logged in
if (!isset($_SESSION['userId'])) {
    
    header("Location: login.html");//in case he does not, we redirige him to login page
    exit(); 
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Shopping Cart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS files for this page -->
     <link rel="stylesheet" href="../../css/bootstrap.css">
     <link rel="stylesheet" href="./styles/cart.css">
     <link rel="stylesheet" href="./styles/common/header.css">

  </head>
  <body>
    <!-- TODO: Style everything with CSS -->
    <div class="header container-fluid row align-items-center">

      <!-- Amazon Icon for going home -->
      <div class="header-left-section col container-fluid">
        <a href="home.html" class="">
          <i class="fa-brands fa-amazon fa-3x"></i>
        </a>
      </div>

      <!-- Search bar -->
      <div class="header-middle-section col d-flex">
        <input class="search-bar" type="text" placeholder="Search">
        <button class="search-button">
          <i class="fa-solid fa-magnifying-glass fa-lg"></i>
        </button>
      </div>

      <!-- Redirection to both returns & orders and checkout pages -->
      <div class="header-right-section col row align-items-center">
        <a id="login-link"class="login-link header-link col" href="login.html">
          <span class="hello-text">Hello,</span>
          <span class="login-text">Log in</span>
        </a>
        <a class="orders-link header-link col" href="orders.php">
          <span class="returns-text">Returns</span>
          <span class="orders-text">& Orders</span>
        </a>
        <!-- Redirection to cart page -->
        <a class="cart-link header-link col" href="shopping-cart.php">
          <img class="cart-icon" src="./images/cart-icon.png">
          <div class="cart-quantity" id="js-cart-quantity">0</div>
          <div class="cart-text">Cart</div>
        </a>   
      </div>
    </div>

    <div class="container main d-flex">
      <div class="row">
        <div class="page-title col-12 mb-1">
          <h1>Cest</h1>
        </div>
        <div class="articles-grid row">
          <p style="font-size: 18px">Not articles added yet</p>
        </div>
      </div>

       <!-- Order Subtotal -->
      <div class="col-lg-4" id="payment-summary"hidden>
        <div class="payment-summary border p-3">
          <div class="payment-summary-row total-row d-flex justify-content-between">
            <div>Subtotal (<span id="js-cart-quantity2">0</span> Products):</div>
            <div>$ <span id="js-total-cart-price">0.00</span></div>
          </div>
          <a href="checkout.php">
          <button class="place-order-button btn w-100 mt-3">Process your order</button>
          </a>
        </div>
      </div>
    </div>

    <!-- Spinner container, initially hidden -->
    <div id="loading-spinner" style="display:none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);">
      <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
      </div>
    </div>

    <div id="loading-overlay" style="display:none;"></div>
    <script src="./js/cart.js"></script>
    <script src="./js/common/checkUserStatus.js"></script>
     <!-- source for using Font Awesome (Icons Library) -->
     <script src="https://kit.fontawesome.com/6e6ca3a608.js" crossorigin="anonymous"></script>

     <!-- source for using Font Awesome (Icons Library) -->
  </body>
</html>
