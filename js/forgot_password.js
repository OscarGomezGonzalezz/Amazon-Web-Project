document.addEventListener("DOMContentLoaded", function () {
    const emailInput = document.getElementById("email");
    const feedback = document.getElementById("emailFeedback");
    const registerForm = document.getElementById("registerForm");

    emailInput.addEventListener("input", function () {
        const email = this.value.trim();

        if (email.includes("@")) {
            fetch("./php/check_email.php", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ email: email })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        feedback.textContent = "Email exists.";
                        feedback.style.color = "green";
                    } else {
                        feedback.textContent = "Email doesnt exists.";
                        feedback.style.color = "red";
                    }
                })
                .catch(error => {
                    console.error("Error en la solicitud:", error);
                    feedback.textContent = "Error verificando el correo.";
                    feedback.style.color = "red";
                });
        } else {
            feedback.textContent = "Please write a valid email.";
            feedback.style.color = "orange";
        }
    });

    registerForm.addEventListener("submit", function (e) {
        e.preventDefault();
        const email = emailInput.value.trim();

        if (!email || !email.includes("@")) {
            feedback.textContent= "Please write a valid email.";
            feedback.style.color = "red";
            return;
        }

        fetch('./php/forgot_password.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded' //TODO 
                // habria que cambiar a json?
            },
            body: new URLSearchParams({
                email: email
            })
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    window.location.href = "login.html";
                }
            })
            .catch(error => {
                console.error("Error in the forgot_password:", error);
               
            });
    });
});