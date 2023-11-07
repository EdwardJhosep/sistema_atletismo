<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "atletismo";

// Crear una conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Establecer la zona horaria a Perú
date_default_timezone_set('America/Lima');

// Verificar si el usuario ha iniciado sesión
session_start();
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];

    // Realiza una consulta SQL para obtener la hora de cierre del árbitro relacionado con el usuario que ha iniciado sesión
    $sql = "SELECT hora_fin_personalizada FROM arbitros WHERE usuario = '$usuario'"; // Reemplaza 'usuario' por el campo que identifica al usuario en la tabla de árbitros

    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $horaCierre = strtotime($row['hora_fin_personalizada']); // Convierte la hora a un timestamp
        echo json_encode(['horaCierre' => $horaCierre]);
    } else {
        echo json_encode(['error' => 'Árbitro no encontrado']);
    }
} else {
    echo json_encode(['error' => 'Usuario no ha iniciado sesión']);
}

// Cierra la conexión a la base de datos
$conn->close();
?>
