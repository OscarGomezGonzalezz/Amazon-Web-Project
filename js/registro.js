document.addEventListener("DOMContentLoaded", function () {
    const emailInput = document.getElementById("email");
    const feedback = document.getElementById("emailFeedback");
    const registerForm = document.getElementById("registerForm");

    // Validación del email y AJAX para verificar si ya existe
    emailInput.addEventListener("input", function () {
        const email = this.value;
        
        if (email.includes("@")) {
            fetch('./php/check_email.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: `email=${encodeURIComponent(email)}`
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
                feedback.textContent = "Error en la verificación del correo.";
                feedback.style.color = "red";
            });
        } else {
            feedback.textContent = "Por favor ingresa un correo válido.";
            feedback.style.color = "orange";
        }
    });

    // Prevenir envío del formulario si el email no es válido
    registerForm.addEventListener("submit", function (e) {
        e.preventDefault(); // Evitar el envío por defecto del formulario
        const email = emailInput.value.trim();
        
        if (!email || !email.includes("@")) {
            alert("Por favor ingresa un correo electrónico válido.");
            return;
        }

        // Si el correo es válido, enviar los datos al backend para procesarlo
        fetch('./php/register.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: `email=${encodeURIComponent(email)}`
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message); // Muestra el mensaje de éxito o error
            if (data.success) {
                window.location.href = "login.html"; // Redirigir al login si el registro es exitoso
            }
        })
        .catch(error => {
            console.error("Error en la solicitud:", error);
            alert("Hubo un problema con el registro.");
        });
    });
});
