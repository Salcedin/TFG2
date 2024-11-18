<?php

// Incluye la conexión a la base de datos
require_once '../private/conexion.php';

// Definir el número de centros a mostrar por página
$centrosPorPagina = 9;

// Obtener la página actual desde la URL, si no se especifica, usar la página 1
$paginaActual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
if ($paginaActual < 1) {
    $paginaActual = 1;
}

// Obtener el término de búsqueda si existe
$terminoBusqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

// Calcular el índice del primer registro de la página actual
$offset = ($paginaActual - 1) * $centrosPorPagina;

// Si hay una búsqueda, agregar una cláusula WHERE para filtrar por nombre de centro
if (!empty($terminoBusqueda)) {
    $query = "SELECT * FROM centros WHERE nombre_centro LIKE ? OR codigo_centro LIKE ? LIMIT $centrosPorPagina OFFSET $offset";
    $stmt = $conn->prepare($query);
    $searchTerm = "%$terminoBusqueda%";
    $stmt->bind_param('ss', $searchTerm, $searchTerm);
    $stmt->execute();
    $centros = $stmt->get_result();

    // Calcular el total de centros filtrados
    $totalCentrosQuery = $conn->prepare("SELECT COUNT(*) AS total FROM centros WHERE nombre_centro LIKE ? OR codigo_centro LIKE ?");
    $totalCentrosQuery->bind_param('ss', $searchTerm, $searchTerm);
    $totalCentrosQuery->execute();
    $totalCentros = $totalCentrosQuery->get_result()->fetch_assoc()['total'];
} else {
    // Si no hay búsqueda, mostrar todos los centros
    $centros = $conn->query("SELECT * FROM centros LIMIT $centrosPorPagina OFFSET $offset");

    // Calcular el número total de centros (para la paginación)
    $totalCentrosQuery = $conn->query("SELECT COUNT(*) AS total FROM centros");
    $totalCentros = $totalCentrosQuery->fetch_assoc()['total'];
}

// Calcular el número total de páginas
$totalPaginas = ceil($totalCentros / $centrosPorPagina);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoCentro</title>

    <!-- Enlace a Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/centros_styles.css" rel="stylesheet">

    <!-- Enlace a fuente de Google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

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
                    <li class="nav-item"><a href="universidades.php" class="nav-link text-light"
                            style="font-size: 24px;">Universidades</a></li>
                    <li class="nav-item"><a href="centros.php" class="nav-link text-light active"
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
                    <img src="img/tiktok.png" alt="TikTok" style="width: 35px; height: auto;">
                </a>
            </div>
        </header>

        <!-- Cuerpo de la página -->
        <div class="container text-center tituloCentros" id="h1">
            <h1 class="mb-4 fs-1 text-light">Información de centros</h1>
        </div>

        <!-- Barra de búsqueda -->
        <form class="mb-4" method="GET" action="centros.php" id="barra-busqueda">
            <div class="input-group">
                <input type="text" name="busqueda" class="form-control" placeholder="Buscar centro..."
                    value="<?php echo htmlspecialchars($terminoBusqueda); ?>">
                <button class="btn btn-primary" type="submit">Buscar</button>
            </div>
        </form>

        <div class="container fade-in-up" id="centros">
            <div class="row">
                <?php if ($centros->num_rows > 0): ?>
                    <?php while ($centro = $centros->fetch_assoc()) { ?>
                        <div class="col-md-4 d-flex">
                            <div class="card mb-4 flex-fill">
                                <a href="procesar_centro.php?nombre=<?php echo urlencode($centro['nombre_centro']); ?>"
                                    class="text-black" style="text-decoration: none;">
                                    <div class="card-body d-flex flex-column">
                                        <!-- Aquí se convierte el nombre en un enlace -->
                                        <h5 class="card-title">
                                            <?php echo $centro['nombre_centro']; ?>
                                        </h5>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-light fs-2">No se encontraron centros.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>


    <!-- Navegación de paginación -->
    <nav aria-label="Paginación de universidades" class="mt-4">
        <ul class="pagination justify-content-center">

            <!-- Botón "Primera" -->
            <li class="page-item <?php if ($paginaActual <= 1)
                echo 'disabled'; ?>">
                <a class="page-link"
                    href="?pagina=1&busqueda=<?php echo urlencode($terminoBusqueda); ?>&privada=<?php echo $filtroPrivada ? '1' : ''; ?>">
                    Primera
                </a>
            </li>

            <!-- Botón "Anterior" que retrocede 5 páginas con símbolo de flecha izquierda -->
            <li class="page-item <?php if ($paginaActual <= 5)
                echo 'disabled'; ?>">
                <a class="page-link"
                    href="?pagina=<?php echo max(1, $paginaActual - 5); ?>&busqueda=<?php echo urlencode($terminoBusqueda); ?>&privada=<?php echo $filtroPrivada ? '1' : ''; ?>">
                    &laquo;
                </a>
            </li>

            <?php
            // Calcular el rango de páginas a mostrar
            $inicio = max(1, $paginaActual - 2);
            $fin = min($totalPaginas, $paginaActual + 2);

            // Asegurar que siempre muestre 5 páginas cuando sea posible
            if ($fin - $inicio < 4) {
                if ($inicio == 1) {
                    $fin = min(5, $totalPaginas);
                } elseif ($fin == $totalPaginas) {
                    $inicio = max(1, $totalPaginas - 4);
                }
            }
            ?>

            <!-- Números de página dinámicos -->
            <?php for ($i = $inicio; $i <= $fin; $i++): ?>
                <li class="page-item <?php if ($paginaActual == $i)
                    echo 'active'; ?>">
                    <a class="page-link"
                        href="?pagina=<?php echo $i; ?>&busqueda=<?php echo urlencode($terminoBusqueda); ?>&privada=<?php echo $filtroPrivada ? '1' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Botón "Siguiente" que avanza 5 páginas con símbolo de flecha derecha -->
            <li class="page-item <?php if ($paginaActual >= $totalPaginas - 4)
                echo 'disabled'; ?>">
                <a class="page-link"
                    href="?pagina=<?php echo min($totalPaginas, $paginaActual + 5); ?>&busqueda=<?php echo urlencode($terminoBusqueda); ?>&privada=<?php echo $filtroPrivada ? '1' : ''; ?>">
                    &raquo;
                </a>
            </li>

            <!-- Botón "Última" -->
            <li class="page-item <?php if ($paginaActual >= $totalPaginas)
                echo 'disabled'; ?>">
                <a class="page-link"
                    href="?pagina=<?php echo $totalPaginas; ?>&busqueda=<?php echo urlencode($terminoBusqueda); ?>&privada=<?php echo $filtroPrivada ? '1' : ''; ?>">
                    Última
                </a>
            </li>
        </ul>
    </nav>

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

    <script src="js/chatbot.js"></script>

    <div class="footer">
        <div class="text-center p-3 text-light" style="background-color: rgba(0, 0, 0, 0.2);">
            <span class="footer-text">Contacta con nosotros ➜ 📞 633 78 80 85 // ✉️ InfoUni@hotmail.com</span>
            <br>
            <a href="contacto.php" class="text-light footer-link">Haznos una consulta</a>
        </div>
    </div>

</body>


</html>