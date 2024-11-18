<?php
// Incluye la conexión a la base de datos
require_once '../private/conexion.php';

// Obtener el nombre del título desde la URL
$nombreTitulo = isset($_GET['nombre']) ? $_GET['nombre'] : '';

// Consultar la base de datos para obtener los detalles del título
$query = $conn->prepare("SELECT * FROM titulos WHERE nombre_titulo = ?");
$query->bind_param('s', $nombreTitulo);
$query->execute();
$result = $query->get_result();
$titulo = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoUni - <?php echo htmlspecialchars($nombreTitulo); ?></title>

    <!-- Enlace a Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

    <!-- Enlace a fuente de Google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Enlace a Bootstrap JS (incluye Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* Estilo para el footer */
        html,
        body {
            height: 100%;
            display: flex;
            flex-direction: column;
            margin: 0;
        }

        .container {
            flex: 1;
        }

        .footer {
            text-align: center;
        }
    </style>

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
                    <li class="nav-item"><a href="universidades.php" class="nav-link text-light"
                            style="font-size: 24px;">Universidades</a></li>
                    <li class="nav-item"><a href="centros.php" class="nav-link text-light"
                            style="font-size: 24px;">Centros</a></li>
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
    </div>

    <body>
        <div class="container fade-in-up">
            <div class="container mt-5">
                <h1 class="text-center fs-1 mb-4 text-light" id="h1">
                    <?php echo htmlspecialchars($nombreTitulo); ?>
                </h1>

                <?php if ($titulo): ?>
                    <table class="table table-hover align-middle text-center text-white">
                            <thead class="table-dark">
                            <tr>
                                <th>Nombre Título</th>
                                <th>Código Título</th>
                                <th>Código Centro</th>
                                <th>Código Universidad</th>
                                <th>Nivel Académico</th>
                                <th>Estado</th>
                                <th>Extinguida</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo htmlspecialchars($titulo['nombre_titulo']); ?></td>
                                <td><?php echo htmlspecialchars($titulo['codigo_titulos']); ?></td>
                                <td>
                                    <a href="centros.php?busqueda=<?php echo urlencode($titulo['codigo_centro']); ?>"
                                        style="text-decoration: none; color:white">
                                        <?php echo htmlspecialchars($titulo['codigo_centro']); ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="universidades.php?busqueda=<?php echo urlencode($titulo['codigo_universidad']); ?>"
                                        style="text-decoration: none; color:white">
                                        <?php echo htmlspecialchars($titulo['codigo_universidad']); ?>
                                    </a>
                                </td>


                                <td><?php echo htmlspecialchars($titulo['nivel_academico']); ?></td>
                                <td><?php echo htmlspecialchars($titulo['estado']); ?></td>
                                <td><?php echo htmlspecialchars($titulo['extinguida'] ? 'Sí' : 'No'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No se encontraron detalles para este título.</p>
                <?php endif; ?>
            </div>

            <!-- Botón volver atrás -->
            <a href="titulos.php" class="btn btn-primary atras-btn"
                style="display: block; width: fit-content; margin: 20px auto;">Volver atrás</a>

            <br><br>
            <!-- Buscar otra universidad -->
            <div class="container text-center">
                <h1 class="mb-4 fs-1 text-light">¿Quieres buscar otro título?</h1>

                <!-- Barra de búsqueda para buscar otra universidad -->
                <form class="mb-4" method="GET" action="titulos.php">
                    <div class="input-group">
                        <input type="text" name="busqueda" class="form-control" placeholder="Buscar título...">
                        <button class="btn btn-primary" type="submit">Buscar</button>
                    </div>
                </form>
                <img src="img/logo_uni.jpg" alt="Logo" style="width: 300px; height: auto;">
            </div>
        </div>
        </main>
        </div>

        <div class="footer">
            <div class="text-center p-3 text-light" style="background-color: rgba(0, 0, 0, 0.2);">
                <span class="footer-text">Contacta con nosotros ➜ 📞 633 78 80 85 // ✉️ InfoUni@hotmail.com</span>
                <br>
                <a href="contacto.php" class="text-light footer-link">Haznos una consulta</a>
            </div>
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

        <script src="js/chatbot.js"></script>

    </body>

</html>