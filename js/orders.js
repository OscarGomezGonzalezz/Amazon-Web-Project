import {fetchCartQuantity} from './common/fetchCartQuantity.js';

document.addEventListener("DOMContentLoaded", function() {
fetchCartQuantity();
fetchTotalPrice();
    
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
