
document.addEventListener("DOMContentLoaded", function() {

fetchCartQuantity();
fetchArticles();

});
function fetchCartQuantity() {
    fetch("php/get_cart_quantity.php")
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json(); // Parse the JSON from the response
        })
        .then(data => {
            if(data && data.user_cart_quantity !== undefined && data.user_cart_quantity !== null){
            console.log(data);
            document.getElementById("js-cart-quantity").innerHTML = data.user_cart_quantity;
            document.getElementById("js-cart-quantity2").innerHTML = data.user_cart_quantity;
            
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
            calculateTotalPrice(data);
        })
        .catch(error => console.error("Fetch error:", error));
}
function displayArticles(articles) {
    const articlesGrid = document.querySelector('.articles-grid');
    articlesGrid.innerHTML = ''; // Clear previous articles

    articles.forEach(article => {
        const articleCol = document.createElement('div');
        
        // Generate each article card
        articleCol.innerHTML = `
      
        <!-- Main container for the cart-->
        <div class="row">

          <!-- Cart -->
          <div class="col-lg-11 mb-2 border p-3">
            <div class="d-flex">
              <!--Remember: Child elements of a container with d-flex are aligned in a 
              horizontal row (this can be changed to a column with flex-column).-->
              <img class="product-image img-fluid col-lg-3" src="${article.image_url}" alt="${article.name}" width="100" height="100">

              <div class="ms-3 col-lg-7">
                <h5 class="card-title">${article.name}</h5>
                
                <div class="d-flex flex-column align-items-start mt-2">
                  <span class="stock mb-2">In Stock</span>

                  <div class="quantity-controls d-flex align-items-center mb-3">
                        <button class="btn btn-outline-secondary" onclick="decrementQuantity(${article.article_id})">-</button>
                        <input class="form-control mx-2 text-center" style="width: 60px;" type="number" id="quantity-${article.article_id}" value="${article.quantity}" min="1">
                        <button class="btn btn-outline-secondary" onclick="incrementQuantity(${article.article_id})">+</button>
                    </div>
                </div>
              </div>

              <!-- Product price -->
              <p class="card-text">Price: ${article.price}$</p>
            </div>
          </div>
        </div>
            
        `;
        
        articlesGrid.appendChild(articleCol);
    });
}

function updateCart(article_id, quantity) {
    fetch('php/update_articles_cart.php', {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: JSON.stringify({
            article_id: article_id,
            quantity: quantity
        })
    })
    .then(response => 
        response.json()
        )
    .then(data => {
        console.log(data); // Display success message

        if (data.status === "success") {
            fetchCartQuantity(); // Update cart quantity display
        } else {
            console.error(data.message); // Display error messag
        }
    })
    .catch(error => console.error("Error adding to cart:", error));
}
// Functions to handle quantity increment and decrement
function incrementQuantity(article_id) {
    const quantityInput = document.getElementById(`quantity-${article_id}`);

        quantityInput.value = parseInt(quantityInput.value) + 1;
        updateCart(article_id, quantityInput.value);
    

}

function decrementQuantity(article_id) {
    const quantityInput = document.getElementById(`quantity-${article_id}`);
    if (parseInt(quantityInput.value) > 1) {
        quantityInput.value = parseInt(quantityInput.value) - 1;
        updateCart(article_id, quantityInput.value);
    }
}



function calculateTotalPrice(articles){

    let totalPrice = 0;

    if(articles){
        totalPrice = articles.reduce((sum, article) => {

            if(article.quantity >= 16) return sum + (article.price * article.quantity * 0.84);
            else if(article.quantity >= 8) return sum + (article.price * article.quantity * 0.92);
            else { return sum + (article.price * article.quantity); }
        }, 0);
        
    }
    document.getElementById('payment-summary-money').innerHTML = `${totalPrice.toFixed(2)} $`;//We set the final price to 2 decimals
}


