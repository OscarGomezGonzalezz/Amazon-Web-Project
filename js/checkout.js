import {fetchCartQuantity} from './common/fetchCartQuantity.js';

document.getElementById('checkout-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission
    
    const form = event.target;
    const errors = {};
  
    // Validate first name
    const firstName = form.firstName.value.trim();
    if (!firstName) {
      errors.firstName = 'First name is required.';
    }
  
    // Validate last name
    const lastName = form.lastName.value.trim();
    if (!lastName) {
      errors.lastName = 'Last name is required.';
    }
  
    // Validate email
    const email = form.email.value.trim();
    if (email && !/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/.test(email)) {
      errors.email = 'Please provide a valid email address.';
    }
  
    // Validate address
    const address = form.address.value.trim();
    if (!address) {
      errors.address = 'Address is required.';
    }
  
    // Validate country
    const country = form.country.value.trim();
    if (!country) {
      errors.country = 'Country is required.';
    }
  
    // Validate state
    const state = form.state.value.trim();
    if (!state) {
      errors.state = 'State is required.';
    }
  
    // Validate zip code
    const zip = form.zip.value.trim();
    if (!zip) {
      errors.zip = 'Zip code is required.';
    } else if (!/^[0-9]{5}$/.test(zip)) {
      errors.zip = 'Please provide a valid 5-digit zip code.';
    }
  
    // Validate shipping method
    const shippingMethod = form.shippingMethod.value;
    if (!shippingMethod) {
        errors.shippingMethod = 'Please select a shipping method.';
        const inputs = document.querySelectorAll('[name="shippingMethod"]');
        inputs.forEach(input => input.classList.add('is-invalid')); // Agrega clase a todos los radios
      } else {
        const inputs = document.querySelectorAll('[name="shippingMethod"]');
        inputs.forEach(input => input.classList.remove('is-invalid')); // Elimina clase si es válido
      }
  
    // Validate data protection checkbox
    const dataProtection = form.dataProtection.checked;
    if (!dataProtection || dataProtection == '') {
      errors.dataProtection = 'You must accept data protection.';
    }
  
    // Handle errors and display messages
    const errorFields = ['firstName', 'lastName', 'email', 'address', 'country', 'state', 'zip', 'shippingMethod', 'dataProtection'];
    errorFields.forEach(field => {
      const errorElement = document.getElementById(`${field}-error`);
      const inputElement = document.getElementById(field);
  
      if (errors[field]) {
        errorElement.textContent = errors[field];
        if (inputElement) {
          inputElement.classList.add('is-invalid');
        }
      } else {
        if (errorElement) errorElement.textContent = '';
        if (inputElement) inputElement.classList.remove('is-invalid');
      }
    });
  
    // If no errors, submit the form
    if (Object.keys(errors).length === 0) {
      form.submit();
    }
  });
  document.addEventListener("DOMContentLoaded", function() {

    fetchTotalPrice();
    fetchArticles();
    fetchCartQuantity();
    });
    function fetchTotalPrice() {
      fetch("php/get_cart_total_price.php")
      .then(response => {
          if (!response.ok) {
              throw new Error(`HTTP error! status: ${response.status}`);
          }
          return response.json(); // Parse the JSON from the response
      })
      .then(data => {
          if(data){
          console.log(data.total_cart_price);
          document.getElementById("js-total-cart-price").innerHTML = `${data.total_cart_price.toFixed(2)} $`;//We set the final price to 2 decimals
          
          }
      })
      .catch(error => {
          console.error("Fetch error:", error);
      });
  }
  function fetchArticles() {
    fetch('php/get_cart_articles.php')
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

function fetchArticleQuantity(article_id, quantitySpanId) {
  fetch('php/get_article_quantity.php', {
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
          <span class="text-muted">$${article.price}</span>
      </li>
      `;
      
      // Fetch the article's quantity and update the corresponding span
      fetchArticleQuantity(article.article_id, quantitySpanId);
      articlesList.appendChild(articleCol);
  });
}

document.getElementById("promo-form").addEventListener("submit", function(event){

  event.preventDefault();
  const promoCode = document.getElementById('promo-code-input').value.trim();
 
  applyPromoCode(promoCode);//AJAX call


})
function applyPromoCode(code) {
  fetch('php/validate_promo_code.php', {
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

      const currentprice = document.getElementById("js-total-cart-price").innerHTML;
      const priceParts = currentprice.split(' ');
      let numericPrice = parseFloat(priceParts[0]);//we get the number without the $ element
      numericPrice -= data.discount_amount;

      //console.log(numericPrice);
      document.getElementById("js-total-cart-price").innerHTML = numericPrice;
      // show the cuppon
      promoCodeElement.style.display = 'flex';

    } else {
      document.getElementById('error-code').innerHTML = "Please, introduce a valid promo code";

    }
  })
  .catch(error => {
    console.error('Error:', error);
  });
}
