// Al cargar la página, restablecer el estado del chatbot y el historial de mensajes
window.onload = function () {

    // Restaurar el historial de mensajes
    const chatbotBody = document.querySelector(".chatbot-body");

    // Desplazar la barra de scroll hacia abajo para mostrar el último mensaje
    chatbotBody.scrollTop = chatbotBody.scrollHeight;
}

// Función para enviar un mensaje
function sendMessage(question) {
    const messageContainer = document.createElement("div");
    messageContainer.classList.add("message");
    messageContainer.textContent = question;
    document.querySelector(".chatbot-body").appendChild(messageContainer);

    scrollToBottom(); // Llama a la función para hacer scroll hacia abajo

    respond(question);

    // Desplazar la barra de scroll hacia abajo para mostrar el último mensaje
    const chatbotBody = document.querySelector(".chatbot-body");
    chatbotBody.scrollTop = chatbotBody.scrollHeight;
}

// Función para responder a las preguntas
function respond(question) {
    let response;
    switch (question) {
        case '¿Cuáles son los requisitos de admisión?':
            response = 'Los requisitos de admisión varían según la universidad, pero generalmente incluyen un título de secundaria y pruebas de ingreso.';
            break;
        case '¿Cómo puedo contactar a la universidad?':
            response = 'Puedes contactar a las universidades a través de sus sitios web oficiales. Encuentra la URL en nuestra sección de universidades.';
            break;
        case '¿La información está actualizada?':
            response = 'Sí, nos esforzamos por mantener la información actualizada. Siempre tendrás la información de cada universidad, centro o título más reciente.';
            break;
        case 'Me gustaría ayudar a desarrollar la plataforma en futuras actualizaciones, ¿cómo puedo hacerlo?':
            response = '¡Nos encantaría tener tu ayuda! Por favor, envíanos un correo electrónico a InfoUni@hotmail.com o envianos una consulta (parte inferior de la web) para más información.';
            break;
        default:
            response = 'Lo siento, no tengo esa información.';
            break;
    }

    const botMessageContainer = document.createElement("div");
    botMessageContainer.classList.add("message", "bot-message");
    botMessageContainer.textContent = response;
    document.querySelector(".chatbot-body").appendChild(botMessageContainer);


    // Desplazar la barra de scroll hacia abajo para mostrar el último mensaje
    const chatbotBody = document.querySelector(".chatbot-body");
    chatbotBody.scrollTop = chatbotBody.scrollHeight;
}

// Función para mostrar/ocultar el chatbot
function toggleChat() {
    const chatbot = document.getElementById("chatbot");
    const icon = document.getElementById("chatbot-icon");

    if (chatbot.style.display === "none") {
        chatbot.style.display = "flex";
        setTimeout(() => {
            chatbot.classList.add("show");
        }, 10);
        icon.style.display = "none";
    } else {
        chatbot.classList.remove("show");
        setTimeout(() => {
            chatbot.style.display = "none";
        }, 300);
        icon.style.display = "flex";
    }
}

// Función para hacer scroll hasta el último mensaje
function scrollToBottom() {
    const chatbotBody = document.querySelector(".chatbot-body");
    chatbotBody.scrollTop = chatbotBody.scrollHeight;
}

// Cerrar el chatbot
document.getElementById("close-chat").onclick = function () {
    toggleChat();
};
