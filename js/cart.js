
document.addEventListener("DOMContentLoaded", function() {

fetchTotalPrice();
fetchCartQuantity2();
fetchArticles();

});
function fetchCartQuantity2() {
    fetch("php/cart/get_cart_quantity.php")
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json(); // Parse the JSON from the response
        })
        .then(data => {
            if(data && data.user_cart_quantity !== undefined && data.user_cart_quantity !== null){
            document.getElementById("js-cart-quantity").innerHTML = data.user_cart_quantity;
            document.getElementById("js-cart-quantity2").innerHTML = data.user_cart_quantity;
            
            }
        })
        .catch(error => {
            console.error("Fetch error:", error);
        });
}
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
        document.getElementById("js-total-cart-price").innerHTML = `${data.total_cart_price.toFixed(2)} $`;//We set the final price to 2 decimals
        
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
    const articlesGrid = document.querySelector('.articles-grid');
    articlesGrid.innerHTML = ''; // Clear previous articles

    articles.forEach(article => {
        const articleCol = document.createElement('div');
        
        // Generate each article card
        articleCol.innerHTML = `
      
        <!-- Main container for the cart-->
        <div id="cartItem" class="row">

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
                        <button class="btn btn-outline-secondary" onclick="deleteArticle(${article.article_id})">+</button>

                   <button class="btn btn-danger m-2" onclick="deleteArticle(${article.article_id})">DELETE</button>
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
        const quantityInput = articleCol.querySelector(`#quantity-${article.article_id}`);
        quantityInput.addEventListener('change', (event) => {
            const newQuantity = parseInt(event.target.value, 10);
            if (newQuantity >= 1) {
                
                updateCart(article.article_id, newQuantity); // Update the cart with the new quantity
                
                setTimeout(() => {
                    location.reload(); // Reload the page to refresh the cart data
                    hideSpinner();
                }, 500); // Add a delay before reloading to ensure the cart updates properly
                
                
            } else {
                // Reset the input value to the previous quantity if invalid
                event.target.value = article.quantity;
                alert("Quantity must be at least 1.");
            }
        });
    });
}

function updateCart(article_id, quantity) {
     fetch('php/cart/update_articles_cart.php', {
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
        console.log(data);
        showSpinner();
        if (data.status === "success") {
            fetchCartQuantity2(); // Update cart quantity display
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
        setTimeout(() => {
            location.reload(); // Reload the page to refresh the cart data
        }, 500);
}

function decrementQuantity(article_id) {
    const quantityInput = document.getElementById(`quantity-${article_id}`);
    if (parseInt(quantityInput.value) >= 1) {
        quantityInput.value = parseInt(quantityInput.value) - 1;
        if(quantityInput.value == 0) {
            console.log('deleting article');
            deleteArticle(article_id);
        }
        updateCart(article_id, quantityInput.value);
        setTimeout(() => {
            location.reload(); // Reload the page to refresh the cart data
        }, 500);
        };
    
}
function deleteArticle(article_id){
    fetch('php/cart/delete_article.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `article_id=${article_id}`
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        showSpinner();
        if(data.success == true){
            console.log("Article successfully deleted");
            document.getElementById("cartItem").innerHTML='';
            setTimeout(() => {
                location.reload(); // Reload the page to refresh the cart data
                hideSpinner();
            }, 500); // Add a delay before reloading to ensure the cart updates properly
            

        }
        else{
            console.log("Error deleting article");
        }
    })
    .catch()

}
//hacer metodo para borrar el producto si el valor del input llega a 0 o si se pulsa el boton delete

function showSpinner() {
    document.getElementById('loading-spinner').style.display = 'block';
    document.getElementById('loading-overlay').style.display = 'block';
}

function hideSpinner() {
    document.getElementById('loading-spinner').style.display = 'none';
    document.getElementById('loading-overlay').style.display = 'none';
}







