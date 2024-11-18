<?php
// Datos de conexión a la base de datos
$servername = "127.0.0.1:3308";
$username = "root";
$password = ""; 
$dbname = "bd_universidades";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Configurar la codificación de caracteres
$conn->set_charset("utf8");

// Retornar la conexión
return $conn;
?>
