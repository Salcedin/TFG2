<?php
// Incluye la conexión a la base de datos
require_once '../private/conexion.php';

// Verifica si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoge los datos del formulario
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $consulta = $_POST['consulta'];

    // Prepara la consulta SQL
    $sql = "INSERT INTO consultas (nombre, apellidos, email, consulta) VALUES (?, ?, ?, ?)";

    // Usa una declaración preparada para evitar inyecciones SQL
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssss", $nombre, $apellidos, $email, $consulta);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            echo "<script>alert('Consulta enviada con éxito. Le responderemos lo antes posible.'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Error al enviar la consulta. Por favor, intenta de nuevo.'); window.location.href='index.php';</script>";
        }

        // Cierra la declaración
        $stmt->close();
    } else {
        echo "<script>alert('Error en la preparación de la consulta.'); window.location.href='index.php';</script>";
    }

    // Cierra la conexión
    $conn->close();
}
?>

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
    <link href="css/universidades_styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Enlace a Bootstrap JS (incluye Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

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
                    <li class="nav-item"><a href="universidades.php" class="nav-link text-light active"
                            style="font-size: 24px;">Universidades</a></li>
                    <li class="nav-item"><a href="centros.php" class="nav-link text-light"
                            style="font-size: 24px;">Centros</a>
                    </li>
                    <li class="nav-item"><a href="titulos.php" class="nav-link text-light"
                            style="font-size: 24px;">Títulos</a>
                    </li>
                </ul>
            </div>

            <!-- Enlaces a redes sociales -->
            <div class="social-links d-flex">
                <a href="https://www.facebook.com/lavozdetomelloso/?locale=es_ES" class="text-light me-3"
                    target="_blank">
                    <img src="img/facebook.png" alt="Facebook" style="width: 35px; height: auto;">
                </a>
                <a href="https://x.com/WillyrexYT" class="text-light me-3" target="_blank">
                    <img src="img/x.png" alt="Twitter" style="width: 35px; height: auto;">
                </a>
                <a href="https://www.instagram.com/danidesokupaoficial/?hl=es" class="text-light me-3" target="_blank">
                    <img src="img/instagram.png" alt="Instagram" style="width: 35px; height: auto;">
                </a>
                <a href="https://www.tiktok.com/@fersispa" class="text-light me-3" target="_blank">
                    <img src="img/tiktok.png" alt="Instagram" style="width: 35px; height: auto;">
                </a>
            </div>
        </header>

        <!-- Cuerpo de la página -->
        <div class="row my-5">
            <div class="col-md-8 offset-md-2">
                <h2 class="text-light">Haznos una consulta</h2>
                <form action="contacto.php" method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label text-light">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellidos" class="form-label text-light">Apellidos</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label text-light">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="consulta" class="form-label text-light">Consulta</label>
                        <textarea class="form-control" id="consulta" name="consulta" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Chatbot Icon -->
    <div id="chatbot-icon" class="chatbot-icon" onclick="toggleChat()">
        <img src="img/chatbot.png" alt="Chat" style="width: 75px; height: 75px;">
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
            <button class="quick-reply" onclick="sendMessage('¿Cuáles son los requisitos de admisión?')">¿Cuáles son los
                requisitos de admisión?</button>
            <button class="quick-reply" onclick="sendMessage('¿Cómo puedo contactar a la universidad?')">¿Cómo puedo
                contactar
                a la universidad?</button>
            <button class="quick-reply" onclick="sendMessage('¿La información está actualizada?')">¿La información está
                actualizada?</button>
            <button class="quick-reply"
                onclick="sendMessage('Me gustaría ayudar a desarrollar la plataforma en futuras actualizaciones, ¿cómo puedo hacerlo?')">Me
                gustaría ayudar a desarrollar la plataforma en futuras actualizaciones, ¿cómo puedo hacerlo?</button>
        </div>
    </div>

    <!-- Chatbot -->
    <script src="js/chatbot.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="footer">
        <div class="text-center p-3 text-light" style="background-color: rgba(0, 0, 0, 0.2);">
            <span class="footer-text">Contacta con nosotros ➜ 📞 633 78 80 85 // ✉️ InfoUni@hotmail.com</span>
            <br>
            <a href="contacto.php" class="text-light footer-link">Haznos una consulta</a>
        </div>
    </div>


</body>

</html>