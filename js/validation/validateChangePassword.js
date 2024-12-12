const passForm = document.getElementById("change_password_form");
const errorMessage = document.getElementById("error-message");

passForm.addEventListener("submit", function(event) {

    const password = document.getElementById("new_password").value;

    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{9,}$/;
    if (!passwordRegex.test(password)) {
        event.preventDefault();
        errorMessage.textContent = "Password must be at least 9 characters long and contain one uppercase letter, one lowercase letter, and one number.";
        return;
  }
  
});