import {fetchCartQuantity} from './common/fetchCartQuantity.js';

document.addEventListener("DOMContentLoaded", function() {

    fetchCartQuantity();
    fetchOrders();
    
});
function fetchOrders() {
        fetch('php/orders/get_orders.php')
            .then(response => response.json())
            .then(data => {
    
                console.log(data);
                if (data.error) {
                    console.error("Error fetching articles:", data.error);
                    return;
                }
                displayOrders(data); // Pass data to displayArticles
            })
            .catch(error => console.error("Fetch error:", error));
    }

function displayOrders(orders){
    const ordersGrid = document.querySelector('.orders-grid'); // Ensure the container exists in your HTML
    ordersGrid.innerHTML = ''; // Clear existing content

    const ordersArray = Object.values(orders);
    console.log(ordersArray);

    ordersArray.forEach(order => {
        // Create a container for each order
        const orderDiv = document.createElement('div');
        orderDiv.className = 'order-header';

        orderDiv.innerHTML = `
          <div class="order-header-left-section col-5">
            <div class="order-total">
              <div class="order-header-label">Total:</div>
              <div>$ <span id="js-total-cart-price">${order.total_price}</span></div>
            </div>
          </div>
          <div class="order-header-right-section col-5">
            <div class="order-header-label">Order ID:</div>
            <div>${order.order_id}</div>
          </div>
          <div class="order-header-btn">
          <button class="buy-again-button col-5">
          <i class="fa-solid fa-arrows-rotate"></i>
          <span class="buy-again-txt">Same order again</span>
          </button>
          </div>
        `;
        ordersGrid.appendChild(orderDiv);

        // Create the order details grid
        const orderDetailsGrid = document.createElement('div');
        orderDetailsGrid.className = 'order-details-grid';

        order.items.forEach(item => {
            

            orderDetailsGrid.innerHTML += `
            <div class="item-grid">
              <div class="product-image-container">
                <img src="${item.image_url}" alt="${item.article_name}">
              </div>
              <div class="product-details">
                <div class="product-name">${item.article_name}</div>
                <div class="product-id">Price: ${item.price} $</div>
                <div class="product-quantity">Quantity: ${item.quantity}</div>
              </div>
            </div>
            `;
        });

        ordersGrid.appendChild(orderDetailsGrid);
    });
}