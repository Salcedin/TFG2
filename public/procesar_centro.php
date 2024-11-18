<?php
// Incluye la conexión a la base de datos
require_once '../private/conexion.php';

// Obtener el nombre del centro desde la URL
$nombreCentro = isset($_GET['nombre']) ? $_GET['nombre'] : '';

// Consultar la base de datos para obtener los detalles del centro
$query = $conn->prepare("SELECT * FROM centros WHERE nombre_centro = ?");
$query->bind_param('s', $nombreCentro);
$query->execute();
$result = $query->get_result();
$centro = $result->fetch_assoc();

// Función para mostrar "No disponible" si el valor está vacío
function mostrarValor($valor)
{
    return !empty($valor) ? htmlspecialchars($valor) : 'No disponible';
}

// Función para añadir el esquema http:// a las URLs que no lo tienen
function corregirUrl($url)
{
    if (!empty($url)) {
        // Verifica si la URL ya tiene http:// o https://
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            // Si no tiene, agrega http://
            return "http://$url";
        }
        return $url; // Si ya tiene esquema, devolver la URL tal como está
    }
    return ''; // Devuelve vacío si no hay URL
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoUni - <?php echo htmlspecialchars($nombreCentro); ?></title>

    <!-- Enlace a Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/procesar_centro.css" rel="stylesheet">

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

<div id="root">

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
                    <a href="https://www.instagram.com/danidesokupaoficial/?hl=es" class="text-light me-3"
                        target="_blank">
                        <img src="img/instagram.png" alt="Instagram" style="width: 35px; height: auto;">
                    </a>
                    <a href="https://www.tiktok.com/@fersispa" class="text-light me-3" target="_blank">
                        <img src="img/tiktok.png" alt="Instagram" style="width: 35px; height: auto;">
                    </a>
                </div>
            </header>
        </div>

        <main>
            <div class="container mt-5 fade-in-up">
                <h1 class="text-center fs-1 mb-4 text-light" id="h1">
                    <?php echo htmlspecialchars($nombreCentro); ?>
                </h1>

                <?php if ($centro): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center text-white">
                            <thead class="table-dark">
                                <tr>
                                    <th>Código Centro</th>
                                    <th>Tipo</th>
                                    <th>Naturaleza</th>
                                    <th>Boletín</th>
                                    <th>Fax</th>
                                    <th>Teléfono 1</th>
                                    <th>Teléfono 2</th>
                                    <th>Comunidad Autónoma</th>
                                    <th>Localidad</th>
                                    <th>Municipio</th>
                                    <th>Provincia</th>
                                    <th>Domicilio</th>
                                    <th>URL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <?php
                                        $codigoCentro = mostrarValor($centro['codigo_centro']);
                                        if ($codigoCentro !== 'No disponible') {
                                            // Crear un enlace con el código del centro como búsqueda
                                            echo '<a href="centros.php?busqueda=' . urlencode($codigoCentro) . '" style="text-decoration: none; color: white;">' . $codigoCentro . '</a>';
                                        } else {
                                            echo $codigoCentro;
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo mostrarValor($centro['tipo']); ?></td>
                                    <td><?php echo mostrarValor($centro['naturaleza']); ?></td>
                                    <td><?php echo mostrarValor($centro['boletin']); ?></td>
                                    <td><?php echo mostrarValor($centro['fax']); ?></td>
                                    <td><?php echo mostrarValor($centro['telefono1']); ?></td>
                                    <td><?php echo mostrarValor($centro['telefono2']); ?></td>
                                    <td><?php echo mostrarValor($centro['ca']); ?></td>
                                    <td>
                                        <?php
                                        $localidad = mostrarValor($centro['localidad']);
                                        if ($localidad !== 'No disponible') {
                                            echo '<a href="https://www.google.com/maps/search/' . urlencode($localidad) . '" target="_blank" style="text-decoration: none; color: white;">' . $localidad . '</a>';
                                        } else {
                                            echo $localidad;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $municipio = mostrarValor($centro['municipio']);
                                        if ($municipio !== 'No disponible') {
                                            echo '<a href="https://www.google.com/maps/search/' . urlencode($municipio) . '" target="_blank" style="text-decoration: none; color: white;">' . $municipio . '</a>';
                                        } else {
                                            echo $municipio;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $provincia = mostrarValor($centro['provincia']);
                                        if ($provincia !== 'No disponible') {
                                            echo '<a href="https://www.google.com/maps/search/' . urlencode($provincia) . '" target="_blank" style="text-decoration: none; color: white;">' . $provincia . '</a>';
                                        } else {
                                            echo $provincia;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $domicilio = mostrarValor($centro['domicilio']);
                                        if ($domicilio !== 'No disponible') {
                                            echo '<a href="https://www.google.com/maps/search/' . urlencode($domicilio) . '" target="_blank" style="text-decoration: none; color: white;">' . $domicilio . '</a>';
                                        } else {
                                            echo $domicilio;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        // Comprobar si la URL está disponible y crear el enlace o mostrar "No disponible"
                                        $url = $centro['url'];
                                        if (!empty($url)): ?>
                                            <a href="<?php echo corregirUrl($url); ?>" target="_blank"
                                                style="color: white;"><?php echo mostrarValor($url); ?></a>
                                        <?php else: ?>
                                            <?php echo 'No disponible'; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                            </tbody>



                        </table>
                    </div>
                <?php else: ?>
                    <p>No se encontraron detalles para este centro.</p>
                <?php endif; ?>

                <!-- Botón volver atrás -->
                <a href="centros.php" class="btn btn-primary atras-btn"
                    style="display: block; width: fit-content; margin: 20px auto;">Volver atrás</a>

                <br><br>
                <!-- Buscar otro centro -->
                <div class="container text-center">
                    <h1 class="mb-4 fs-1 text-light">¿Quieres buscar otro centro?</h1>

                    <!-- Barra de búsqueda para buscar otro centro -->
                    <form class="mb-4" method="GET" action="centros.php">
                        <div class="input-group">
                            <input type="text" name="busqueda" class="form-control" placeholder="Buscar centro...">
                            <button class="btn btn-primary" type="submit">Buscar</button>
                        </div>
                    </form>
                    <img src="img/logo_uni.jpg" alt="Logo" style="width: 300px; height: auto;">
                </div>
            </div>
        </main>

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
</div>

</script>

</html>