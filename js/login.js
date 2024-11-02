document.addEventListener("DOMContentLoaded", function() {
  //We have to acces DOM this way to solve undefined values problem, since the page need to be fully charged
  const loginForm = document.getElementById("login-form");
  const errorMessage = document.getElementById("error-message");

  loginForm.addEventListener("submit", function(event) {
      const email = document.getElementById("email").value.trim();
      const password = document.getElementById("password").value;

      console.log("Email value:", email); // Debugging
      console.log("Password value:", password); // Debugging

      // Basic validation
      if (!email || !password) {
          event.preventDefault();
          errorMessage.textContent = "Please fill in all fields.";
          return;
      }

      // Validate email length
      if (email.length <= 5) {
          event.preventDefault();
          errorMessage.textContent = "Email must be more than 5 characters.";
          return;
      }

      //as we indicate in html that both email and password are required, it returns us a
      //built-in error report coming from the browser, before the error reporting made by us

      // Email format validation
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
          event.preventDefault();
          errorMessage.textContent = "Please enter a valid email address.";
          return;
      }
  });
});
