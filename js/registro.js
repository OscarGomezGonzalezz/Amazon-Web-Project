document.getElementById("email").addEventListener("input", function () {
    const email = this.value;
    const feedback = document.getElementById("emailFeedback");

    if (email.includes("@")) {
        // Realizar una solicitud AJAX para verificar si el correo ya existe
        fetch(`check_email.php?email=${encodeURIComponent(email)}`)
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                feedback.textContent = "El correo ya está registrado.";
                feedback.style.color = "red";
            }else {
                feedback.textContent = "El correo está disponible.";
                feedback.style.color = "green";
                }
            });
    }else {
    feedback.textContent = "Por favor ingresa un correo válido.";
    feedback.style.color = "orange";
    }
});
