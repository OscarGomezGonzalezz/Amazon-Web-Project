document.addEventListener("DOMContentLoaded", function () {
    const emailInput = document.getElementById("email");
    const feedback = document.getElementById("emailFeedback");

    emailInput.addEventListener("input", function () {
        const email = this.value;

        if (email.includes("@")) {
            // Realizar una solicitud AJAX para verificar si el correo ya existe
            fetch(`./php/check_email.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `email=${encodeURIComponent(email)}`
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Error en la solicitud: " + response.status);
                }
                return response.json();
            })
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
                feedback.textContent = "Error en la verificación del correo.";
                feedback.style.color = "red";
            });
        } else {
            feedback.textContent = "Por favor ingresa un correo válido.";
            feedback.style.color = "orange";
        }
    });
});
