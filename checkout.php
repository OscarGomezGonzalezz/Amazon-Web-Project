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
    <title>Checkout</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS files for this page -->
     <link rel="stylesheet" href="../../css/bootstrap.css">
     <link rel="stylesheet" href="./styles/cart.css">
     <link rel="stylesheet" href="./styles/checkoutHeader.css">
     <link rel="stylesheet" href="./styles/checkout.css">
     <link rel="stylesheet" href="./styles/common/login.css">

  </head>
  <body>

    <!-- TODO: Style everything with CSS -->
    <div class="header d-flex row align-items-center">
      <!-- Amazon Icon for going home -->
      <div class="columna">
        <a href="home.html" class="">
          <i class="fa-brands fa-amazon fa-3x"></i>
        </a>
      </div>
      <!--Process order-->
      <div class="columna2">
        <h1>Process order</h1>
      </div>
      <!--Redirection to both returns & orders and checkout pages-->
      <div class="columna">
        <i class="fa-solid fa-lock"></i>
      </div>
    </div>

    <div class="row g-3 m-4">
      <div class="col-md-6 col-lg-5 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Your cart</span>
          <span id="js-cart-quantity" class="badge bg-primary rounded-pill">0</span>
        </h4>
        <ul class="list-group mb-3">
          <div class="list-articles">
         
          </div>

          <!--We manually translate d-flex to the style added, for then changing the display to flex/none-->
          <li id="promo-code" class="list-group-item justify-content-between bg-light" style="display: none; justify-content: space-between;">
            <div class="text-success">
              <h6 class="my-0">Promo code</h6>
              <small id="promo-code-name">EXAMPLECODE</small>
            </div>
            <span id="promo-discount" class="text-success">$5</span>
          </li>

          <li class="list-group-item d-flex justify-content-between">
            <div>Shipping Costs: </div>
            <span id="js-shipping-costs" class="text-muted">0$</span>
          </li>

          <li class="list-group-item d-flex justify-content-between">
            <strong>Total (USD)</strong>
            <span id="js-total-cart-price" >$0</span>
          </li>
        </ul>

        <form class="card p-2" id="promo-form" >
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Promo code" id="promo-code-input">
            <button type="submit" class="btn btn-secondary" id="redeemButton">Redeem</button>
          </div>
        </form>
        <div id="error-code" style="color: red;"> </div>
      </div>



      <div class="cont-left col-md-5 col-lg-6">
        <h4 class="mb-3">Shipping address</h4>
        
        <form id="checkout-form" action="php/orders/createOrder.php" method="post" novalidate>
          <div class="row g-3">
            
            <div class="col-sm-5">
              <label for="firstName" class="form-label">First name</label>
              <input 
                type="text" 
                class="form-control" 
                id="firstName" 
                name="firstName" 
                required>
              <div class="invalid-feedback" id="firstName-error"></div>
            </div>
      
            <div class="col-sm-5">
              <label for="lastName" class="form-label">Last name</label>
              <input 
                type="text" 
                class="form-control" 
                id="lastName" 
                name="lastName" 
                required>
              <div class="invalid-feedback" id="lastName-error"></div>
            </div>
      
            <div class="col-10">
              <label for="email" class="form-label">Email</label>
              <input 
                type="email" 
                class="form-control" 
                id="email" 
                name="email"
                required>
              <div class="invalid-feedback" id="email-error"></div>
            </div>
      
            <div class="col-10">
              <label for="address" class="form-label">Address</label>
              <input 
                type="text" 
                class="form-control" 
                id="address" 
                name="address"
                required>
              <div class="invalid-feedback" id="address-error"></div>
            </div>
      
            <div class="col-md-4">
              <label for="country" class="form-label">Country</label>
              <select 
                class="form-select" 
                id="country" 
                name="country" 
                required>
                <option value="">Choose...</option>
                <option value="United States">United States</option>
              </select>
              <div class="invalid-feedback" id="country-error"></div>
            </div>
      
            <div class="col-md-3">
              <label for="state" class="form-label">State</label>
              <select 
                class="form-select" 
                id="state" 
                name="state" 
                required>
                <option value="">Choose...</option>
                <option value="California">California</option>
              </select>
              <div class="invalid-feedback" id="state-error"></div>
            </div>
      
            <div class="col-md-3">
              <label for="zip" class="form-label">Zip</label>
              <input 
                type="text" 
                class="form-control" 
                id="zip" 
                name="zip" 
                required>
              <div class="invalid-feedback" id="zip-error"></div>
            </div>
          </div>
      
          <hr class="my-3">
      
          <h4 class="mb-3">Shipping Method</h4>
          <div class="my-3">
            <div class="form-check">
              <input 
                id="dpd" 
                name="shippingMethod" 
                type="radio" 
                class="form-check-input" 
                value="DPD" 
                required>
              <label class="form-check-label" for="dpd">DPD <span style="color: green;">(FREE)</span></label>
            </div>
            <div class="form-check">
              <input 
                id="dhl" 
                name="shippingMethod" 
                type="radio" 
                class="form-check-input" 
                value="DHL"
                required>
              <label class="form-check-label" for="dhl">DHL <span style="color: green;">(+19$)</span></label>
            </div>
            <div class="form-check">
              <input 
                id="dhlExpress" 
                name="shippingMethod" 
                type="radio" 
                class="form-check-input" 
                value="DHL Express"
                required>
              <label class="form-check-label" for="dhlExpress">DHL Express <span style="color: green;">(+44$)</span></label>
            </div>
          </div>
          <div class="invalid-feedback" id="shippingMethod-error"></div>
      
          <hr class="my-3">
      
          <div class="form-check">
            <input 
              type="checkbox" 
              class="form-check-input" 
              id="dataProtection" 
              name="dataProtection" 
              required>
            <label class="form-check-label" for="dataProtection">Accept data protection</label>
          </div>
          <div class="invalid-feedback" id="dataProtection-error"></div>

          <button id="pay-btn" type="submit" class="login-btn" style="margin-top: 20px;">Pay</button>
      
          <input type="hidden" name="totalPrice" id="totalPrice">
          <input type="hidden" name="cartArticles" id="cartArticles">

        </form>
      </div>      
    </div>



  <!-- source for using Font Awesome (Icons Library)-->
  <script src="https://kit.fontawesome.com/6e6ca3a608.js" crossorigin="anonymous"></script>
    <!-- Link to the JavaScript file -->
    <script type="module" src="./js/checkout.js"></script>

    <script src="./js/validation/validateCheckout.js"></script>

  </body>
</html>
