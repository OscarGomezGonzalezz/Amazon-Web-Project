//We have to acces DOM this way to solve undefined values problem, since the page need to be fully charged
const loginForm = document.getElementById("login-form");
const errorMessage = document.getElementById("error-message");

loginForm.addEventListener("submit", function(event) {
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value;

    //console.log("Email value:", email); // Debugging
    //console.log("Password value:", password); // Debugging

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

    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{9,}$/;
    if (!passwordRegex.test(password)) {
        event.preventDefault();
        errorMessage.textContent = "Password must be at least 9 characters long and contain one uppercase letter, one lowercase letter, and one number.";
        return;
  }
  
  //Screen resolution
  document.getElementById("screen-resolution").value = `${window.screen.width}x${window.screen.height}`;

  // Detect Operating System
  function getOS() {
      //userAgentData is undefined in Safari, so we will use userAgent although it is a bigger string
      const agent = navigator.userAgent;
      if (agent.includes("Windows")) return "Windows";
      if (agent.includes("Macintosh")) return "MacOS";
      if (agent.includes("Linux")) return "Linux";
      if (agent.includes("Android")) return "Android";
      if (agent.includes("like Mac")) return "iOS";
      return "Other";
  }
  document.getElementById("os").value = getOS();

});