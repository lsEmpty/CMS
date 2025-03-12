// script.js

document.getElementById('contact-form').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const form = new FormData(this);
    const submitButton = document.getElementById('submit-btn');
    const statusMessage = document.getElementById('status');
    
    submitButton.disabled = true;
    statusMessage.textContent = 'Enviando...';
    
    fetch('https://send-email-api-ezij.onrender.com', {
        method: 'POST',
        body: form
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            statusMessage.textContent = 'Mensaje enviado correctamente.';
            statusMessage.style.color = 'green';
        } else {
            statusMessage.textContent = 'Hubo un error. Intenta nuevamente.';
            statusMessage.style.color = 'red';
        }
        console.log(data)
    })
    .catch(error => {
        statusMessage.textContent = 'Error en el envío del mensaje.';
        statusMessage.style.color = 'red';
        console.log(error);
    })
    .finally(() => {
        submitButton.disabled = false;
    });
});
