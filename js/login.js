document.addEventListener("DOMContentLoaded", function() {

    fetchActiveUsers();
    setInterval(fetchActiveUsers, 10000);
});

  //Fetch implements AJAX more effectively than XML old request
  function fetchActiveUsers() {
    fetch("php/users/get_online_users.php")
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json(); // Parse the JSON from the response
        })
        .then(data => {
            document.getElementById("online-users-count").innerHTML = data.online_users_count;
            console.log(data.online_users_count);
        })
        .catch(error => {
            console.error("Fetch error:", error);
        });
};
