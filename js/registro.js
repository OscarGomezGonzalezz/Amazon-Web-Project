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
                        feedback.textContent = "El correo ya está registrado.";
                        feedback.style.color = "red";
                    } else {
                        feedback.textContent = "El correo está disponible.";
                        feedback.style.color = "green";
                    }
                })
                .catch(error => {
                    console.error("Error en la solicitud:", error);
                    feedback.textContent = "Error verificando el correo.";
                    feedback.style.color = "red";
                });
        } else {
            feedback.textContent = "Por favor ingresa un correo válido.";
            feedback.style.color = "orange";
        }
    });

    registerForm.addEventListener("submit", function (e) {
        e.preventDefault();
        const email = emailInput.value.trim();

        if (!email || !email.includes("@")) {
            alert("Por favor ingresa un correo electrónico válido.");
            return;
        }

        fetch('./php/register.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email: email })
        })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    window.location.href = "login.html";
                }
            })
            .catch(error => {
                console.error("Error en el registro:", error);
                alert("Hubo un problema con el registro.");
            });
    });
});
