<?php
// Iniciar la sesión
session_start();

// Verificar si la variable de sesión 'loggedin' no está establecida o es falsa
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirigir al usuario al inicio de sesión si no está autenticado
    header("Location: ../index.html");
    exit;
}

// Verificar el token de sesión
if (isset($_SESSION['session_token']) && isset($_POST['session_token']) && $_SESSION['session_token'] === $_POST['session_token']) {
    // El token de sesión coincide, lo que significa que la sesión es válida
    // Resto del contenido de la página restringida
} else {
    // El token de sesión no coincide, redirigir al inicio de sesión
    header("Location: ../index.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
</head>
<body>
    <h1>Panel de Administrador</h1>
    <a href="../php/cargar_arbitros.php"><button>Cargar Árbitros</button></a>
</body>
</html>
