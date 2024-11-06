
function fetchArticles() {
    fetch('php/get_articles.php')
        .then(response => response.json())
        .then(data => {
            console.log(data); // Check if data is an array and properly structured
            if (data.error) {
                console.error("Error fetching articles:", data.error);
                return;
            }
            displayArticles(data); // Pass data to displayArticles
        })
        .catch(error => console.error("Fetch error:", error));
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
                <img src="${article.image_url}" class="card-img-top" alt="${article.name}">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">${article.name}</h5>
                    <p class="card-text">Price: ${article.price}$</p>
                    
                    <!-- Quantity controls -->
                    <div class="quantity-controls d-flex align-items-center mb-3">
                        <button class="btn btn-outline-secondary" onclick="decrementQuantity(${article.id})">-</button>
                        <input class="form-control mx-2 text-center" style="width: 60px;" type="number" id="quantity-${article.id}" value="1" min="1">
                        <button class="btn btn-outline-secondary" onclick="incrementQuantity(${article.id})">+</button>
                    </div>

                    <!-- Add to Cart Button -->
                    <button class="btn btn-primary mt-auto" onclick="addToCart(${article.id})">Add to Cart</button>
                </div>
            </div>
        `;
        
        articlesGrid.appendChild(articleCol);
    });
}

// Functions to handle quantity increment and decrement
function incrementQuantity(id) {
    const quantityInput = document.getElementById(`quantity-${id}`);
    quantityInput.value = parseInt(quantityInput.value) + 1;
}

function decrementQuantity(id) {
    const quantityInput = document.getElementById(`quantity-${id}`);
    if (parseInt(quantityInput.value) > 1) {
        quantityInput.value = parseInt(quantityInput.value) - 1;
    }
}

// Placeholder function to add item to the cart
function addToCart(id) {
    const quantityInput = document.getElementById(`quantity-${id}`);
    const quantity = quantityInput.value;
    console.log(`Added to cart: Product ID ${id}, Quantity: ${quantity}`);
    // TODO: Implement cart functionality
}

// Fetch articles on page load
window.onload = fetchArticles;
