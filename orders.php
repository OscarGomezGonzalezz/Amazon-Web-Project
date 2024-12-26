<?php
// Inicia la sesión
session_start();

// Verifica si el usuario está logueado
if (!isset($_SESSION['userId'])) {
    // Si no está logueado, redirige al login
    header("Location: login.html");
    exit(); // Asegura que no se siga ejecutando el código después de la redirección
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

     <!-- CSS files for this page -->
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="styles/orders.css">
    <link rel="stylesheet" href="styles/common/header.css">

  </head>
  <body>
    <!--Same header as the home page-->

    <!-- All search bar-->
    <div class="header container-fluid row align-items-center">

      <!-- Amazon Icon for going home -->
      <div class="header-left-section col container-fluid">
        <a href="home.html" class="">
          <i class="fa-brands fa-amazon fa-3x"></i>
        </a>
      </div>

      <!--Search bar-->
      <div class="header-middle-section col d-flex">
        <input class="search-bar" type="text" placeholder="Search">
        <button class="search-button">
          <i class="fa-solid fa-magnifying-glass fa-lg"></i>
        </button>
      </div>
      <!--Redirection to both returns & orders and  pages-->
      <div class="header-right-section col row align-items-center">
        <a id="login-link" class="login-link header-link col" href="login.html">
          <!--We separate both words for then styling them differently-->
          <span class="hello-text">Hello,</span>
          <span class="login-text">Log in</span>
        </a>
        <a class="orders-link header-link col" href="orders.php">
          <!--We separate both words for then styling them differently-->
          <span class="returns-text">Returns</span>
          <span class="orders-text">& Orders</span>
        </a>
        <!--Redirection to cart page-->
        <a class="cart-link header-link col" href="shopping-cart.php">
          <!--The FA icon is not valid for this feature-->
          <img class="cart-icon" src="./images/cart-icon.png">
           <!--We add more details to the icon-->
          <div class="cart-quantity" id="js-cart-quantity">0</div>
          <div class="cart-text">Cart</div>
        </a>   
      </div>
    </div>
      <!-- main -->
    <div class="main">

      <div class="orders-grid">

        <h1>No Orders Placed Yet</h1>
        <p>Your order history will appear here once you've made some purchases. Explore our products and start shopping.</p>
        <div class="row">
        <button class="products-btn " onclick="window.location.href='home.html'">Go check our products!</button>
    </div>

      </div>
    </div>

    <script src="https://kit.fontawesome.com/6e6ca3a608.js" crossorigin="anonymous"></script>

    <script src="./js/common/checkUserStatus.js"></script>
    <script src="./js/orders.js"></script>

    <!--Sweet alert-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  </body>
</html>
