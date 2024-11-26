import {fetchCartQuantity} from './common/fetchCartQuantity.js';

document.addEventListener("DOMContentLoaded", function() {

  fetchTotalPrice();
  fetchArticles();
  fetchCartQuantity();
  resetValidCode();
});

let totalPrice = 0;

function fetchTotalPrice() {
  fetch("php/cart/get_cart_total_price.php")
    .then(response => {
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.json(); // Parse the JSON from the response
    })
    .then(data => {
      if(data){
        console.log(data.total_cart_price);
        totalPrice = parseFloat(data.total_cart_price);
        document.getElementById("js-total-cart-price").innerHTML = `${data.total_cart_price.toFixed(2)} $`;//We set the final price to 2 decimal
      }
    })
    .catch(error => {
          console.error("Fetch error:", error);
    });
}

function fetchArticles() {
  fetch('php/cart/get_cart_articles.php')
    .then(response => response.json())
    .then(data => {
      console.log(data);
      if (data.error) {
        console.error("Error fetching articles:", data.error);
        return;
      }
      displayArticles(data); // Pass data to displayArticles
      })
    .catch(error => console.error("Fetch error:", error));
}

function displayArticles(articles) {
  const articlesList = document.querySelector('.list-articles');
  articlesList.innerHTML = ''; // Clear previous articles

  articles.forEach(article => {
      const articleCol = document.createElement('div');
      
      // Generate a unique id for each article's quantity span
      const quantitySpanId = `article-quantity-${article.article_id}`;
      
      // Generate each article card
      articleCol.innerHTML = `
      <li class="list-articles list-group-item d-flex justify-content-between lh-sm">
          <div>
            <h6 class="my-0">${article.name}</h6>
            <div class="text-muted"><span id="${quantitySpanId}">Loading...</span> x</div>
          </div>
          <span class="text-muted">${article.price} $</span>
      </li>
      `;
      
      // Fetch the article's quantity and update the corresponding span
      fetchArticleQuantity(article.article_id, quantitySpanId);
      articlesList.appendChild(articleCol);
  });
}

function fetchArticleQuantity(article_id, quantitySpanId) {
  fetch('php/cart/get_article_quantity.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: new URLSearchParams({
          article_id: article_id
      })
  })
  .then(response => {
      if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.json(); // Parse the JSON from the response
  })
  .then(data => {
      console.log(data);
      if (data && data.article_quantity !== undefined && data.article_quantity !== null) {
          document.getElementById(quantitySpanId).innerHTML = data.article_quantity;
      } else {
          document.getElementById(quantitySpanId).innerHTML = "N/A";
      }
  })
  .catch(error => {
      console.error("Fetch error:", error);
      document.getElementById(quantitySpanId).innerHTML = "Error";
  });
}

//########## LOGIC FOR THE PROMO CODE ##########

document.getElementById("promo-form").addEventListener("submit", function(event){

  event.preventDefault();
  const promoCode = document.getElementById('promo-code-input').value.trim();
 
  applyPromoCode(promoCode);//AJAX call
})

function resetValidCode() {
  fetch('php/promoCode/resetValidCode.php', {
      method: 'POST',  // Cambié PATCH a POST para hacer la solicitud más adecuada
      headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
      }
  })
  .then(response => response.json())  // Convertir la respuesta en formato JSON
  .then(data => {
      if (data.status === "success") {
          console.log("Promo codes successfully reset.");  // Mostrar mensaje de éxito
      } else {
          console.error("Error: " + data.message);  // Mostrar mensaje de error si no se pudo resetear
      }
  })
  .catch(error => console.error("Error resetting promo codes:", error));  // Mostrar errores en la consola
}

function applyPromoCode(code) {
  fetch('php/promoCode/validate_promo_code.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: new URLSearchParams({ promo_code: code })
  })
  .then(response => response.json())
  .then(data => {
    console.log(data);
    if (data.status === 'success') {

      document.getElementById('error-code').innerHTML = '';//clean the error message
      const promoCodeElement = document.getElementById('promo-code');
      const promoCodeName = document.getElementById('promo-code-name');
      const promoDiscount = document.getElementById('promo-discount');

      promoCodeName.textContent = data.promo_code;
      promoDiscount.textContent = `-$${data.discount_amount}`;

      const currentBasePrice = document.getElementById("js-total-cart-price").innerHTML;
      const priceParts = currentBasePrice.split(' ');
      let numericPrice = parseFloat(priceParts[0]);//we get the number without the $ element
      numericPrice -= data.discount_amount;

      //console.log(numericPrice);
      document.getElementById("js-total-cart-price").innerHTML = numericPrice;
      // show the cuppon
      promoCodeElement.style.display = 'flex';

    } else {
      document.getElementById('error-code').innerHTML = "Please, introduce a valid promo code or another one never used before";

    }
  })
  .catch(error => {
    console.error('Error:', error);
  });
}

const shippingRadios = document.querySelectorAll('input[name="shippingMethod"]');

//we change the price each time we change the shipping method
shippingRadios.forEach(function(radio) {
      radio.addEventListener('change', handleShippingMethodChange);
  });

function handleShippingMethodChange(event) {
  
  let shippingCosts = 0;

  const selectedShippingMethod = event.target.value;
  if(selectedShippingMethod){
    console.log(selectedShippingMethod);
    
    switch (selectedShippingMethod){
      case 'DHL Express':
        shippingCosts = 44;
        break;
  
      case 'DHL':
        shippingCosts = 19;
        break;
  
      case 'DPD':
        shippingCosts = 0;
        break;
      default:
        shippingCosts = 0;
        break;
      }
    }
    const finalPrice = totalPrice + shippingCosts;
    document.getElementById("js-total-cart-price").innerHTML = `${finalPrice.toFixed(2)} $`;

    document.getElementById("js-shipping-costs").innerHTML = `${shippingCosts}$`;
    
  
  }

