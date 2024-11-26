async function checkUserStatus() {
    try {
      const response = await fetch('php/is_online.php');
      const data = await response.json();

      if (data.is_online === 1) {
        // If user is online, show Logout
        document.getElementById('login-link').innerHTML = `
          <span class="hello-text">Hello,</span>
          <span class="login-text">Log out</span>
        `;
        document.querySelector('.login-link').setAttribute('href', 'php/logout.php'); // Redirect to logout page
      } else {
        // If user is not online, show Login
        document.getElementById('login-link').innerHTML = `
          <span class="hello-text">Hello,</span>
          <span class="login-text">Log in</span>
        `;
        document.querySelector('.login-link').setAttribute('href', 'login.html'); // Redirect to login page
      }
    } catch (error) {
      console.error('Error fetching user status:', error);
    }
  }

  window.onload = checkUserStatus;