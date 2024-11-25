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
     <link rel="stylesheet" href="./styles/login.css">

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
          <span class="badge bg-primary rounded-pill">3</span>
        </h4>
        <ul class="list-group mb-3">
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">Product name</h6>
              <small class="text-muted">Brief description</small>
            </div>
            <span class="text-muted">$12</span>
          </li>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">Second product</h6>
              <small class="text-muted">Brief description</small>
            </div>
            <span class="text-muted">$8</span>
          </li>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">Third item</h6>
              <small class="text-muted">Brief description</small>
            </div>
            <span class="text-muted">$5</span>
          </li>
          <li class="list-group-item d-flex justify-content-between bg-light">
            <div class="text-success">
              <h6 class="my-0">Promo code</h6>
              <small>EXAMPLECODE</small>
            </div>
            <span class="text-success">−$5</span>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <span>Total (USD)</span>
            <strong>$20</strong>
          </li>
        </ul>

        <form class="card p-2">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Promo code">
            <button type="submit" class="btn btn-secondary" id="redeemButton">Redeem</button>
          </div>
        </form>
      </div>
      
      <div class="cont-left col-md-5 col-lg-6">
        <h4 class="mb-3">Shipping address</h4>
        
        <form id="checkout-form" action="php/process_checkout.php" method="post" novalidate>
          <div class="row g-3">
            <div class="col-sm-5">
              <label for="firstName" class="form-label">First name</label>
              <input 
                type="text" 
                class="form-control" 
                id="firstName" 
                name="firstName" 
                required>
              <div class="invalid-feedback" id="js-invalid-feedback">
                Valid first name is required.
              </div>
            </div>

            <div class="col-sm-5">
              <label for="lastName" class="form-label">Last name</label>
              <input 
                type="text" 
                class="form-control" 
                id="lastName" 
                name="lastName" 
                required>
              <div class="invalid-feedback" id="js-invalid-feedback">
                Valid last name is required.
              </div>
            </div>

            <div class="col-10">
              <label for="username" class="form-label">Username</label>
              <div class="input-group has-validation">
                <span class="input-group-text">@</span>
                <input 
                  type="text" 
                  class="form-control" 
                  id="username" 
                  name="username" 
                  value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" 
                  required>
                <div class="invalid-feedback" id="js-invalid-feedback">
                  Your username is required.
                </div>
              </div>
            </div>

            <div class="col-10">
              <label for="email" class="form-label">Email <span class="text-muted">(Optional)</span></label>
              <input 
                type="email" 
                class="form-control" 
                id="email" 
                name="email" 
                value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
              <div class="invalid-feedback" id="js-invalid-feedback">
                Please enter a valid email address for shipping updates.
              </div>
            </div>

            <div class="col-10">
              <label for="address" class="form-label">Address</label>
              <input 
                type="text" 
                class="form-control" 
                id="address" 
                name="address" 
                value="<?php echo htmlspecialchars($_POST['address'] ?? ''); ?>" 
                required>
              <div class="invalid-feedback" id="js-invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>

            <div class="col-10">
              <label for="address2" class="form-label">Address 2 <span class="text-muted">(Optional)</span></label>
              <input 
                type="text" 
                class="form-control" 
                id="address2" 
                name="address2" 
                value="<?php echo htmlspecialchars($_POST['address2'] ?? ''); ?>">
            </div>

            <div class="col-md-4">
              <label for="country" class="form-label">Country</label>
              <select 
                class="form-select" 
                id="country" 
                name="country" 
                required>
                <option value="">Choose...</option>
                <option value="United States" 
                  <?php echo (isset($_POST['country']) && $_POST['country'] === 'United States') ? 'selected' : ''; ?>>United States</option>
              </select>
              <div class="invalid-feedback" id="js-invalid-feedback">
                Please select a valid country.
              </div>
            </div>

            <div class="col-md-3">
              <label for="state" class="form-label">State</label>
              <select 
                class="form-select" 
                id="state" 
                name="state" 
                required>
                <option value="">Choose...</option>
                <option value="California" 
                  <?php echo (isset($_POST['state']) && $_POST['state'] === 'California') ? 'selected' : ''; ?>>California</option>
              </select>
              <div class="invalid-feedback" id="js-invalid-feedback">
                Please provide a valid state.
              </div>
            </div>

            <div class="col-md-3">
              <label for="zip" class="form-label">Zip</label>
              <input 
                type="text" 
                class="form-control" 
                id="zip" 
                name="zip" 
                value="<?php echo htmlspecialchars($_POST['zip'] ?? ''); ?>" 
                required>
              <div class="invalid-feedback" id="js-invalid-feedback">
                Zip code required.
              </div>
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
                <?php echo (isset($_POST['shippingMethod']) && $_POST['shippingMethod'] === 'DPD') ? 'checked' : ''; ?> 
                required>
              <label class="form-check-label" for="dpd">DPD</label>
            </div>
            <div class="form-check">
              <input 
                id="dhl" 
                name="shippingMethod" 
                type="radio" 
                class="form-check-input" 
                value="DHL" 
                <?php echo (isset($_POST['shippingMethod']) && $_POST['shippingMethod'] === 'DHL') ? 'checked' : ''; ?>>
              <label class="form-check-label" for="dhl">DHL</label>
            </div>
            <div class="form-check">
              <input 
                id="dhlExpress" 
                name="shippingMethod" 
                type="radio" 
                class="form-check-input" 
                value="DHL Express" 
                <?php echo (isset($_POST['shippingMethod']) && $_POST['shippingMethod'] === 'DHL Express') ? 'checked' : ''; ?>>
              <label class="form-check-label" for="dhlExpress">DHL Express</label>
            </div>
          </div>

          <hr class="my-3">

          <h4 class="mb-3">Payment</h4>
          <div class="row gy-3">
            <div class="col-md-5">
              <label for="cc-name" class="form-label">Name on card</label>
              <input 
                type="text" 
                class="form-control" 
                id="cc-name" 
                name="ccName" 
                value="<?php echo htmlspecialchars($_POST['ccName'] ?? ''); ?>" 
                required>
              <small class="text-muted">Full name as displayed on card</small>
              <div class="invalid-feedback" id="js-invalid-feedback">
                Name on card is required
              </div>
            </div>

            <div class="col-md-5">
              <label for="cc-number" class="form-label">Credit card number</label>
              <input 
                type="text" 
                class="form-control" 
                id="cc-number" 
                name="ccNumber" 
                value="<?php echo htmlspecialchars($_POST['ccNumber'] ?? ''); ?>" 
                required>
              <div class="invalid-feedback" id="js-invalid-feedback">
                Credit card number is required
              </div>
            </div>

            <div class="col-md-3">
              <label for="cc-expiration" class="form-label">Expiration</label>
              <input 
                type="text" 
                class="form-control" 
                id="cc-expiration" 
                name="ccExpiration" 
                value="<?php echo htmlspecialchars($_POST['ccExpiration'] ?? ''); ?>" 
                required>
              <div class="invalid-feedback" id="js-invalid-feedback">
                Expiration date required
              </div>
            </div>

            <div class="col-md-3">
              <label for="cc-cvv" class="form-label">CVV</label>
              <input 
                type="text" 
                class="form-control" 
                id="cc-cvv" 
                name="ccCvv" 
                value="<?php echo htmlspecialchars($_POST['ccCvv'] ?? ''); ?>" 
                required>
              <div class="invalid-feedback" id="js-invalid-feedback">
                Security code required
              </div>
            </div>
          </div>

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
          <hr class="my-3">
          <button type="submit" class="login-btn">Process your order</button>

        </form>
      </div>
    </div>



  <!-- source for using Font Awesome (Icons Library)-->
  <script src="https://kit.fontawesome.com/6e6ca3a608.js" crossorigin="anonymous"></script>
    <!-- Link to the JavaScript file -->
    <script src="./js/checkout.js"></script>
  </body>
</html>
