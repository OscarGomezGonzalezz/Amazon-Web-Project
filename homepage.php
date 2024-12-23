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
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS files for this page -->
     <link rel="stylesheet" href="../../css/bootstrap.css">
     <link rel="stylesheet" href="./styles/homepage.css">
     <link rel="stylesheet" href="./styles/common/articles.css">

  </head>
  <body>

    <div class="header container-fluid row align-items-center">

      <!-- Amazon Icon for going home -->
      <div class="header-left-section col container-fluid">
        <a href="home.html" class="">
          <i class="fa-brands fa-amazon fa-3x"></i>
        </a>
      </div>

      <!--Welcome message-->
      <div class="header-middle-section col">
       <h3>Welcome again. You were last online 
        <span id="js-last-activity">dd.mm.yyyy</span> 
       </h3>
      </div>


      
      <!--Redirection to both returns & orders and checkout pages-->
      <div class="header-right-section col row align-items-center">

        <a class="login-link header-link col" href="php/users/logout.php">

          <!--We separate both words for then styling them differently-->
          <span class="hello-text">Hello,</span>
          <span class="login-text">Log out</span>
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
    
    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <!--The next slides will automatically receive the active class as you click on the indicators.-->
            <img src="./images/carousel/1.jpg" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="./images/carousel/2.jpg" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="./images/carousel/3.jpg" class="d-block w-100" alt="...">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class="row">
        <button class="products-btn col-6 offset-3" onclick="window.location.href='home.html'">Go check our products!</button>
    </div>


  
  <!-- source for using Font Awesome (Icons Library)-->
  <script src="https://kit.fontawesome.com/6e6ca3a608.js" crossorigin="anonymous"></script>
  <!-- Link to JavaScript for Product Display and Search -->
  <script type="module" src="js/homepage.js"></script>
  <script type="module" src="js/common/fetchCartQuantity.js"></script>
  <!--We had already imported bootstrap for css, but NO for js-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
