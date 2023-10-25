<?php
session_start();

// Comprueba si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/admin.html");
    exit();
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
