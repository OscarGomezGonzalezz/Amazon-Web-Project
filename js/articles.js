let allArticles = []; // Global variable to store all articles for then filter them if the search bar is used


document.addEventListener("DOMContentLoaded", function() {

fetchArticles();
fetchCartQuantity();


document.getElementById("searchButton").addEventListener("click", function() {
    const searchQuery = document.getElementById("searchInput").value.trim().toLowerCase();
    filterAndDisplayArticles(searchQuery);
});
// Event listener for pressing Enter key in the search input
document.getElementById("searchInput").addEventListener("keydown", function(event) {
    if (event.key === "Enter") {  // Check if the pressed key is Enter
        const searchQuery = document.getElementById("searchInput").value.trim().toLowerCase();
        filterAndDisplayArticles(searchQuery);
    }
});

})
//WE CANT IMPORT THIS FUNCTION SINCE THE SCOPE OF THE SCRIPT IS ALTERED AND INCR/DECR/ADD FUNCTIONS WOULD NOT BE ACCESSIBLE
function fetchCartQuantity() {
    fetch("php/cart/get_cart_quantity.php")
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
            
            }
        })
        .catch(error => {
            console.error("Fetch error:", error);
        });
}
function fetchArticles() {
    console.log("Fetching articles from the server...");

    fetch('php/cart/get_articles.php')
        .then(response => {
            console.log("Response received:", response);

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            return response.text(); // Leer como texto primero para depuración
        })
        .then(responseText => {
            console.log("Raw response text:", responseText); // Depurar la respuesta cruda

            if (!responseText) {
                throw new Error("Empty response from server");
            }

            // Intenta convertir la respuesta a JSON
            const data = JSON.parse(responseText);
            console.log("Parsed JSON data:", data);

            if (data.error) {
                console.error("Error fetching articles:", data.error);
                return;
            }

            allArticles = data;
            displayArticles(data); // Muestra los artículos en la página
        })
        .catch(error => console.error("Fetch error:", error));
}


// Filter and display articles based on the search query
function filterAndDisplayArticles(searchQuery) {
    const filteredArticles = allArticles.filter(article =>
        article.name.toLowerCase().includes(searchQuery) // Check if article name contains search query
    );
    displayArticles(filteredArticles); // Display only the filtered articles
}

// Function to display articles in the HTML
function displayArticles(articles) {
    const articlesGrid = document.querySelector('.articles-grid');
    articlesGrid.innerHTML = ''; // Clear previous articles

    articles.forEach(article => {
        const articleCol = document.createElement('div');
        articleCol.classList.add('col-12', 'col-md-6', 'col-lg-4', 'mb-4');
        
        // Generate each article card
        articleCol.innerHTML = `
            <div class="card h-100">
                <div class="card-img-wrapper">
                <img src="${article.image_url}" class="card-img" alt="${article.name}">
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">${article.name}</h5>
                    <p class="card-text">Price: ${article.price}$</p>
                    
                    <!-- Quantity controls -->
                    <div class="quantity-controls d-flex align-items-center mb-3">
                        <button class="btn btn-outline-secondary" onclick="decrementQuantity(${article.article_id})">-</button>
                        <input class="form-control mx-2 text-center" style="width: 60px;" type="number" id="quantity-${article.article_id}" value="1" min="1">
                        <button class="btn btn-outline-secondary" onclick="incrementQuantity(${article.article_id})">+</button>
                    </div>

                    <!-- Add to Cart Button -->
                    <button class="btn btn-primary mt-auto" onclick="addToCart(${article.article_id})">Add to Cart</button>
                </div>
            </div>
        `;
        
        articlesGrid.appendChild(articleCol);
    });
}

// Functions to handle quantity increment and decrement
function incrementQuantity(article_id) {
    const quantityInput = document.getElementById(`quantity-${article_id}`);
    quantityInput.value = parseInt(quantityInput.value) + 1;
}

function decrementQuantity(article_id) {
    const quantityInput = document.getElementById(`quantity-${article_id}`);
    if (parseInt(quantityInput.value) > 1) {
        quantityInput.value = parseInt(quantityInput.value) - 1;
    }
}

// Add an item to the cart
function addToCart(article_id) {
    const quantity = document.getElementById(`quantity-${article_id}`).value;
    fetch('php/cart/add_articles_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `article_id=${article_id}&quantity=${quantity}`
    })
    .then(response => 
        response.json()
        )
    .then(data => {
        console.log(data); // Display success message

        if (data.status === "success") {
            Swal.fire({
                title: "Success!",
                text: "Products have been added successfully.",
                icon: "success",
                confirmButtonText: "OK"
              });
            console.log(`Adding article with ID: ${article_id} and quantity: ${quantity}`);
            
            fetchCartQuantity(); // Update cart quantity display
        } else {
            Swal.fire({
                title: "Error",
                text: data.message || "Failed to add products to the cart.",
                icon: "error",
                confirmButtonText: "Try Again"
            });
            console.error(data.message); // Display error messag
        }
    })
    .catch(error => console.error("Error adding to cart:", error));
}


