
import { fetchCartQuantity } from './common/fetchCartQuantity.js';


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
function fetchArticles() {
    fetch('php/get_articles.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error("Error fetching articles:", data.error);
                return;
            }
            allArticles = data;
            displayArticles(data); // Pass data to displayArticles
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
    fetch('php/add_articles_cart.php', {
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


