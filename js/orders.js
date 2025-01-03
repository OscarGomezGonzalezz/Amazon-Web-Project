document.addEventListener("DOMContentLoaded", function() {

    fetchCartQuantity();
    fetchOrders();
    
});
//We cant import it, since sameOrder() would stay unaccessible
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
function fetchOrders() {
        fetch('php/orders/get_orders.php')
            .then(response => response.json())
            .then(data => {
    
                console.log(data);
                if (data.error) {
                    console.error("Error fetching articles:", data.error);
                    return;
                }

                console.log(data.length);
                displayOrders(data); // Pass data to displayArticles
            })
            .catch(error => console.error("Fetch error:", error));
    }

function displayOrders(orders){
    
    if (Object.keys(orders).length > 0) {
    const ordersGrid = document.querySelector('.orders-grid'); // Ensure the container exists in your HTML
    ordersGrid.innerHTML = `
    <div class="page-title">Your Orders</div>`; // Clear existing content
    

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
          <button class="buy-again-button col-5" onclick="sameOrder(${order.order_id})">
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
}

function sameOrder(order_id){
    fetch('php/orders/sameOrder.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            order_id: order_id
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data && data.success){
            Swal.fire({
                title: "Success!",
                text: "Order has been successfully retaken.",
                icon: "success",
                confirmButtonText: "OK"
              });
            fetchOrders();
        } else{
            Swal.fire({
                title: "Error",
                text: data.message || "Failed to add products to the cart.",
                icon: "error",
                confirmButtonText: "Try Again"
            });
        }
    })
    .catch(error => console.error("Fetch error:", error))
}
