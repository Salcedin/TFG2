<?php
// Incluye la conexión a la base de datos
require_once '../private/conexion.php';

// Definir el número de universidades a mostrar por página
$universidadesPorPagina = 9;

// Obtener la página actual desde la URL, si no se especifica, usar la página 1
$paginaActual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
if ($paginaActual < 1) {
    $paginaActual = 1;
}

// Obtener el término de búsqueda si existe
$terminoBusqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

// Verificar si los checkboxes "Privada" y "Pública" están marcados
$filtroPrivada = isset($_GET['privada']) && $_GET['privada'] === '1';
$filtroPublica = isset($_GET['publica']) && $_GET['publica'] === '1';

// Calcular el índice del primer registro de la página actual
$offset = ($paginaActual - 1) * $universidadesPorPagina;

// Construir la consulta SQL en función del término de búsqueda y los filtros
$query = "SELECT * FROM universidades WHERE nombre_uni LIKE ?";
$filters = [];
if ($filtroPrivada) {
    $filters[] = "tipo = 'Privada'";
}
if ($filtroPublica) {
    $filters[] = "tipo = 'Pública'";
}
if (count($filters) > 0) {
    $query .= " AND (" . implode(" OR ", $filters) . ")";
}
$query .= " LIMIT $universidadesPorPagina OFFSET $offset";

$stmt = $conn->prepare($query);
$searchTerm = "%$terminoBusqueda%";
$stmt->bind_param('s', $searchTerm);
$stmt->execute();
$universidades = $stmt->get_result();

// Calcular el total de universidades filtradas
$totalUniversidadesQuery = "SELECT COUNT(*) AS total FROM universidades WHERE nombre_uni LIKE ?";
if (count($filters) > 0) {
    $totalUniversidadesQuery .= " AND (" . implode(" OR ", $filters) . ")";
}
$countStmt = $conn->prepare($totalUniversidadesQuery);
$countStmt->bind_param('s', $searchTerm);
$countStmt->execute();
$totalUniversidades = $countStmt->get_result()->fetch_assoc()['total'];

// Calcular el número total de páginas
$totalPaginas = ceil($totalUniversidades / $universidadesPorPagina);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoUni</title>

    <!-- Enlace a Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/universidades_styles.css" rel="stylesheet">

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
                    <li class="nav-item"><a href="universidades.php" class="nav-link text-light active"
                            style="font-size: 24px;">Universidades</a></li>
                    <li class="nav-item"><a href="centros.php" class="nav-link text-light"
                            style="font-size: 24px;">Centros</a></li>
                    <li class="nav-item"><a href="titulos.php" class="nav-link text-light"
                            style="font-size: 24px;">Títulos</a></li>
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
        <div class="container text-center tituloUniversidades" id="h1">
            <h1 class="mb-4 fs-1 text-light">Información de universidades</h1>
        </div>

        <!-- Barra de búsqueda -->
<form class="mb-4" method="GET" action="universidades.php" id="barra-busqueda">
    <div class="input-group">
        <input type="text" name="busqueda" class="form-control" placeholder="Buscar universidad..."
            value="<?php echo htmlspecialchars($terminoBusqueda); ?>">
        <button class="btn btn-primary" type="submit">Buscar</button>
    </div>

    <!-- Filtros de tipo de universidad (Privada y Pública) -->
<div class="d-flex mt-2 align-items-center">
    <div class="form-check me-3">
        <input 
            type="checkbox" 
            class="form-check-input" 
            name="privada" 
            value="1" 
            id="privadaCheckbox" 
            <?php if ($filtroPrivada) echo 'checked'; ?> 
            onclick="toggleCheckbox('privadaCheckbox', 'publicaCheckbox')"
        >
        <label class="form-check-label text-light" for="privadaCheckbox">Privada</label>
    </div>

    <div class="form-check">
        <input 
            type="checkbox" 
            class="form-check-input" 
            name="publica" 
            value="1" 
            id="publicaCheckbox"
            <?php if (isset($filtroPublica) && $filtroPublica) echo 'checked'; ?> 
            onclick="toggleCheckbox('publicaCheckbox', 'privadaCheckbox')"
        >
        <label class="form-check-label text-light" for="publicaCheckbox">Pública</label>
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

</body>
</form>

<!-- JavaScript para permitir solo un checkbox marcado -->
<script>
function toggleCheckbox(selectedId, otherId) {
    var selectedCheckbox = document.getElementById(selectedId);
    var otherCheckbox = document.getElementById(otherId);
    
    if (selectedCheckbox.checked) {
        otherCheckbox.checked = false;
    }
}
</script>

        <div class="container fade-in-up" id="universidades">
            <div class="row">
                <?php if ($universidades->num_rows > 0): ?>
                    <?php while ($universidad = $universidades->fetch_assoc()) { ?>
                        <div class="col-md-4 d-flex">
                            <div class="card mb-4 flex-fill">
                                <a href="procesar_universidad.php?nombre=<?php echo urlencode($universidad['nombre_uni']); ?>"
                                    class="text-black" style="text-decoration: none;">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">
                                            <?php echo $universidad['nombre_uni']; ?>
                                        </h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                <?php else: ?>
                    <div class="col-12">
                        <p class="text-light fs-2">No se encontraron universidades.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Navegación de paginación -->
        <nav aria-label="Paginación de universidades" class="mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php if ($paginaActual <= 1)
                    echo 'disabled'; ?>">
                    <a class="page-link"
                        href="?pagina=1&busqueda=<?php echo urlencode($terminoBusqueda); ?>&privada=<?php echo $filtroPrivada ? '1' : ''; ?>&publica=<?php echo $filtroPublica ? '1' : ''; ?>">
                        Primera
                    </a>
                </li>

                <li class="page-item <?php if ($paginaActual <= 5)
                    echo 'disabled'; ?>">
                    <a class="page-link"
                        href="?pagina=<?php echo max(1, $paginaActual - 5); ?>&busqueda=<?php echo urlencode($terminoBusqueda); ?>&privada=<?php echo $filtroPrivada ? '1' : ''; ?>&publica=<?php echo $filtroPublica ? '1' : ''; ?>">
                        &laquo;
                    </a>
                </li>

                <?php
                // Calcular el rango de páginas a mostrar
                $inicio = max(1, $paginaActual - 2);
                $fin = min($totalPaginas, $paginaActual + 2);

                if ($fin - $inicio < 4) {
                    if ($inicio == 1) {
                        $fin = min($inicio + 4, $totalPaginas);
                    } else {
                        $inicio = max($fin - 4, 1);
                    }
                }

                for ($i = $inicio; $i <= $fin; $i++): ?>
                    <li class="page-item <?php if ($i == $paginaActual)
                        echo 'active'; ?>">
                        <a class="page-link"
                            href="?pagina=<?php echo $i; ?>&busqueda=<?php echo urlencode($terminoBusqueda); ?>&privada=<?php echo $filtroPrivada ? '1' : ''; ?>&publica=<?php echo $filtroPublica ? '1' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?php if ($paginaActual >= $totalPaginas - 4)
                    echo 'disabled'; ?>">
                    <a class="page-link"
                        href="?pagina=<?php echo min($totalPaginas, $paginaActual + 5); ?>&busqueda=<?php echo urlencode($terminoBusqueda); ?>&privada=<?php echo $filtroPrivada ? '1' : ''; ?>&publica=<?php echo $filtroPublica ? '1' : ''; ?>">
                        &raquo;
                    </a>
                </li>
                <li class="page-item <?php if ($paginaActual >= $totalPaginas)
                    echo 'disabled'; ?>">
                    <a class="page-link"
                        href="?pagina=<?php echo $totalPaginas; ?>&busqueda=<?php echo urlencode($terminoBusqueda); ?>&privada=<?php echo $filtroPrivada ? '1' : ''; ?>&publica=<?php echo $filtroPublica ? '1' : ''; ?>">
                        Última
                    </a>
                </li>
            </ul>
        </nav>
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

    <!-- Footer -->
    <div class="footer">
        <div class="text-center p-3 text-light" style="background-color: rgba(0, 0, 0, 0.2);">
            <span class="footer-text">Contacta con nosotros ➜ 📞 633 78 80 85 // ✉️ InfoUni@hotmail.com</span>
            <br>
            <a href="contacto.php" class="text-light footer-link">Haznos una consulta</a>
        </div>
    </div>

</body>


</html>