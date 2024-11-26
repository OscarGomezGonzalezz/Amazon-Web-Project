
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

export { fetchCartQuantity };