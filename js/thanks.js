function fetchLastOrder() {
    fetch('php/orders/get_last_order.php')
        .then(response => response.json())
        .then(data => {

            console.log(data);
            if (data.error) {
                console.error("Error fetching articles:", data.error);
                return;
            }
            document.getElementById("orderNumber").innerHTML = data.order_id;
            document.getElementById("address").innerHTML = data.address;
            document.getElementById("totalPrice").innerHTML = data.total_price;
        })
        .catch(error => console.error("Fetch error:", error));
}

document.addEventListener("DOMContentLoaded", function(){
    fetchLastOrder();
})