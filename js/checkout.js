// Access DOM elements
const checkoutForm = document.getElementById("checkout-form");
const errorMessage = document.getElementById("js-invalid-feedback");

// Event listener for form submission
checkoutForm.addEventListener("submit", function (event) {
    event.preventDefault();

    errorMessage.textContent = ""; // Clear previous error messages

    const firstName = document.getElementById("firstName").value.trim();
    const lastName = document.getElementById("lastName").value.trim();
    const username = document.getElementById("username").value.trim();
    const email = document.getElementById("email").value.trim();
    const address = document.getElementById("address").value.trim();
    const country = document.getElementById("country").value;
    const state = document.getElementById("state").value;
    const zip = document.getElementById("zip").value.trim();
    const shippingMethod = document.querySelector("input[name='shippingMethod']:checked");
    const ccName = document.getElementById("cc-name").value.trim();
    const ccNumber = document.getElementById("cc-number").value.trim();
    const ccExpiration = document.getElementById("cc-expiration").value.trim();
    const ccCvv = document.getElementById("cc-cvv").value.trim();
    const dataProtection = document.getElementById("dataProtection").checked;

    // Helper function to display error and prevent submission
    function showError(message) {
        errorMessage.textContent = message;
    }
    console.log("First name:", firstName);

    // Validation rules
    if (!firstName || lastName == "") {
        errorMessage.textContent = "First name and Last name are required.";
        return;
    }

    if (!username) {
        showError("Username is required.");
        return;
    }

    if (!email) {
        showError("Email is required.");
        return;
    }

    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailRegex.test(email)) {
        showError("Please enter a valid email address.");
        return;
    }

    if (!address) {
        showError("Address is required.");
        return;
    }

    if (!country) {
        showError("Please select a valid country.");
        return;
    }

    if (!state) {
        showError("Please select a valid state.");
        return;
    }

    if (!zip) {
        showError("Zip code is required.");
        return;
    }

    if (!shippingMethod) {
        showError("Please select a shipping method.");
        return;
    }

    if (!ccName) {
        showError("Name on card is required.");
        return;
    }

    if (!ccNumber || !/^\d{16}$/.test(ccNumber)) {
        showError("Please enter a valid 16-digit credit card number.");
        return;
    }

    if (!ccExpiration || !/^\d{2}\/\d{2}$/.test(ccExpiration)) {
        showError("Expiration date must be in MM/YY format.");
        return;
    }

    if (!ccCvv || !/^\d{3}$/.test(ccCvv)) {
        showError("CVV must be a 3-digit number.");
        return;
    }

    if (!dataProtection) {
        showError("You must accept the data protection terms.");
        return;
    }

    // If no errors, form will submit
    console.log("Form validated successfully!");
    // Optionally, you can submit the form here after successful validation
});
