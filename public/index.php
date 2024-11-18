<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>InfoUni</title>

  <!-- Enlace a fuente de Google fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  
  <!-- Enlace a Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/styles.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- Enlace a Bootstrap JS (incluye Popper.js) -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/idiomas.js"></script>
</head>

<body class="css-selector">
  <div class="container">
    <header class="d-flex flex-wrap justify-content-between align-items-center py-3 mb-4 border-bottom">
      <a href="index.php" class="d-flex align-items-center text-decoration-none">
        <span class="fs-2 text-light">InfoUni</span>
      </a>

      <!-- Navegación centrada -->
      <div class="mx-auto">
        <ul class="nav nav-pills justify-content-center">
          <li class="nav-item">
            <a href="universidades.php" class="nav-link text-light" style="font-size: 24px;" id="universidades-link">
              Universidades
            </a>
          </li>
          <li class="nav-item">
            <a href="centros.php" class="nav-link text-light" style="font-size: 24px;" id="centros-link">
              Centros
            </a>
          </li>
          <li class="nav-item">
            <a href="titulos.php" class="nav-link text-light" style="font-size: 24px;" id="titulos-link">
              Títulos
            </a>
          </li>
        </ul>
      </div>


      <!-- Enlaces a redes sociales -->
      <div class="social-links d-flex">
        <a href="https://www.facebook.com/lavozdetomelloso/?locale=es_ES" class="text-light me-3" target="_blank">
          <img src="img/facebook.png" alt="Facebook" style="width: 35px; height: auto;">
        </a>
        <a href="https://x.com/ElonMusk" class="text-light me-3" target="_blank">
          <img src="img/x.png" alt="Twitter" style="width: 35px; height: auto;">
        </a>
        <a href="https://www.instagram.com/club.desokupa/?hl=es" class="text-light me-3" target="_blank">
          <img src="img/instagram.png" alt="Instagram" style="width: 35px; height: auto;">
        </a>
        <a href="https://www.tiktok.com/@fersispa" class="text-light me-3" target="_blank">
          <img src="img/tiktok.png" alt="Instagram" style="width: 35px; height: auto;">
        </a>
      </div>
      <div class="language-selector">
        <label for="language">Idioma:</label>
        <select id="language" onchange="changeLanguage()">
          <option value="es">Español</option>
          <option value="en">Inglés</option>
          <option value="fr">Francés</option>
        </select>
      </div>
    </header>
  </div>

  <div class="container text-center fade-in-up" id="h1">
    <h1 class="mb-4 fs-1 main-heading">Toda la información sobre Universidades a tu alcance</h1>
    <img src="img/logo.png" alt="logo" class="img-fluid" style="max-width: 420px;">
  </div>

  <!-- Cuerpo de la página -->
  <div class="container fade-in-up">
    <div class="container text-center">
      <div class="row">
        <div class="col">
          <img src="img/handshake.svg" alt="" class="img-fluid" style="max-width: 8%;">
          <h2 class="fw-semibold objetivo">¿Cuál es nuestro objetivo?</h2>
          <p class="fs-5 textoObjetivo">Nuestro objetivo es centralizar toda la información de universidades españolas,
            haciendo que
            sea
            más accesible y fácil de encontrar.</p>
        </div>

        <div class="col vertical-separator">
          <img src="img/check.svg" alt="" class="img-fluid" style="max-width: 8%;">
          <h2 class="fw-semibold elegirnos">¿Por qué elegirnos?</h2>
          <p class="fs-5 textoElegirnos">Por nuestra rapidez. Toda la información que necesites la obtendrás más rápido
            desde nuestro
            portal.</p>
        </div>
      </div>
    </div>

    <br><br>
    <!-- Galeria de fotos -->
    <section>
      <a href="universidades.php">
        <img id="universidad-img" src="img/universidad.png" alt="universidades">
      </a>
      <a href="centros.php">
        <img id="centro-img" src="img/centro.png" alt="centros">
      </a>
      <a href="titulos.php">
        <img id="titulo-img" src="img/titulo.png" alt="titulos">
      </a>
    </section>

  </div>


  <!-- Chatbot Icon -->
  <div id="chatbot-icon" class="chatbot-icon" onclick="toggleChat()">
    <img src="img/chatbot.png" alt="Chat" style="width: 75px; height: 75px;">
    <!-- Cambia la ruta de la imagen aquí -->
  </div>

  <!-- Chatbot -->
  <div id="chatbot" class="chatbot-container" style="display: none;">
    <div class="chatbot-header">
      <h5>Chatbot</h5>
      <button id="close-chat" class="close-chat" onclick="toggleChat()">&times;</button>
    </div>
    <div class="chatbot-body">
      <div class="message bot-message">¡Hola! ¿Cómo puedo ayudarte hoy?</div>
    </div>
    <div class="chatbot-footer">
      <button class="quick-reply" onclick="sendMessage('¿Cuáles son los requisitos de admisión?')">¿Cuáles son
        los
        requisitos de admisión?</button>
      <button class="quick-reply" onclick="sendMessage('¿Cómo puedo contactar a la universidad?')">¿Cómo puedo
        contactar
        a la universidad?</button>
      <button class="quick-reply" onclick="sendMessage('¿La información está actualizada?')">¿La información
        está
        actualizada?</button>
      <button class="quick-reply"
        onclick="sendMessage('Me gustaría ayudar a desarrollar la plataforma en futuras actualizaciones, ¿cómo puedo hacerlo?')">Me
        gustaría ayudar a desarrollar la plataforma en futuras actualizaciones, ¿cómo puedo
        hacerlo?</button>
    </div>
  </div>

  <!-- Chatbot -->
  <script src="js/chatbot.js"></script>

</body>

<br><br>

<div class="footer">
  <div class="text-center p-3 text-light" style="background-color: rgba(0, 0, 0, 0.2);">
    <span class="footer-text">Contacta con nosotros ➜ 📞 633 78 80 85 // ✉️ InfoUni@hotmail.com</span>
    <br>
    <a href="contacto.php" class="text-light footer-link">Haznos una consulta</a>
  </div>
</div>


</html>