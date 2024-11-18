<?php
// Incluye la conexión a la base de datos
require_once '../private/conexion.php';

// Obtener el nombre de la universidad desde la URL
$nombreUniversidad = isset($_GET['nombre']) ? $_GET['nombre'] : '';

// Preparar la consulta para obtener los datos de la universidad
$query = "SELECT * FROM universidades WHERE nombre_uni = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $nombreUniversidad);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontró la universidad
if ($result->num_rows > 0) {
    $universidad = $result->fetch_assoc();
} else {
    $universidad = null; // No se encontró la universidad
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoUni - <?php echo htmlspecialchars($nombreUniversidad); ?></title>

    <!-- Enlace a Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

    <!-- Enlace a Bootstrap JS (incluye Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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
            <!-- Datos de la universidad -->
            <div class="container fade-in-up">
                <div class="container mt-5">
                    <h1 class="text-center fs-1 mb-4 text-light" id="h1">Detalles de la Universidad -
                        <?php echo htmlspecialchars($nombreUniversidad); ?>
                    </h1>

                    <?php if ($universidad): ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Código Universidad</th>
                                    <th>Nombre</th>
                                    <th>Código Postal</th>
                                    <th>Tipo</th>
                                    <th>URL</th>
                                    <th>Comunidad Autónoma</th>
                                    <th>Localidad</th>
                                    <th>Municipio</th>
                                    <th>Provincia</th>
                                    <th>Domicilio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo !empty($universidad['codigo_universidad']) ? htmlspecialchars($universidad['codigo_universidad']) : 'No disponible'; ?>
                                    </td>
                                    <td><?php echo !empty($universidad['nombre_uni']) ? htmlspecialchars($universidad['nombre_uni']) : 'No disponible'; ?>
                                    </td>
                                    <td><?php echo !empty($universidad['cp']) ? htmlspecialchars($universidad['cp']) : 'No disponible'; ?>
                                    </td>
                                    <td><?php echo !empty($universidad['tipo']) ? htmlspecialchars($universidad['tipo']) : 'No disponible'; ?>
                                    </td>
                                    <td><?php echo !empty($universidad['url']) ? htmlspecialchars($universidad['url']) : 'No disponible'; ?>
                                    </td>
                                    <td><?php echo !empty($universidad['ca']) ? htmlspecialchars($universidad['ca']) : 'No disponible'; ?>
                                    </td>
                                    <td><?php echo !empty($universidad['localidad']) ? htmlspecialchars($universidad['localidad']) : 'No disponible'; ?>
                                    </td>
                                    <td><?php echo !empty($universidad['municipio']) ? htmlspecialchars($universidad['municipio']) : 'No disponible'; ?>
                                    </td>
                                    <td><?php echo !empty($universidad['provincia']) ? htmlspecialchars($universidad['provincia']) : 'No disponible'; ?>
                                    </td>
                                    <td><?php echo !empty($universidad['domicilio']) ? htmlspecialchars($universidad['domicilio']) : 'No disponible'; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    <?php else: ?>
                        <div class="alert alert-danger" role="alert">
                            No se encontró información para la universidad solicitada.
                        </div>
                    <?php endif; ?>
                    <!-- Botón volver atrás -->
                    <a href="universidades.php" class="btn btn-primary"
                        style="display: block; width: fit-content; margin: 20px auto;">Volver</a>
                </div>
                <br><br>
                <!-- Buscar otra universidad -->
                <div class="container text-center">
                    <h1 class="mb-4 fs-1 text-light">¿Quieres buscar otra universidad?</h1>

                    <!-- Barra de búsqueda para buscar otra universidad -->
                    <form class="mb-4" method="GET" action="universidades.php">
                        <div class="input-group">
                            <input type="text" name="busqueda" class="form-control" placeholder="Buscar universidad...">
                            <button class="btn btn-primary" type="submit">Buscar</button>
                        </div>
                    </form>
                    <img src="img/logo_uni.jpg" alt="Logo" style="width: 300px; height: auto;">
                </div>
        </main>

        <footer>
            <div class="text-center p-3 text-light" style="background-color: rgba(0, 0, 0, 0.2);">
                Contacta con nosotros ➜ Telefono: 633 78 80 85 // Correo electrónico: InfoUni@hotmail.com
            </div>
        </footer>

    </body>

</div>

</html>