<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos
    $db_host = "localhost"; // Cambia a tu servidor de base de datos
    $db_user = "root"; // Cambia a tu nombre de usuario
    $db_pass = ""; // Cambia a tu contraseña
    $db_name = "atletismo"; // Cambia al nombre de tu base de datos
    
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    
    // Recibir datos del formulario
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    
    // Consulta para verificar el inicio de sesión
    $sql = "SELECT * FROM arbitros WHERE usuario = '$usuario' AND contrasena = '$contrasena'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        // Inicio de sesión exitoso
        $_SESSION['usuario'] = $usuario;
        header("Location: ../usuarios/arbitro.php"); // Redirige al panel de control o página de inicio después del inicio de sesión
    } else {
        // Inicio de sesión fallido
        echo '<div class="error-message">Inicio de sesión fallido. Verifica tus credenciales.</div>';
        echo '<button id="backButton">Aceptar</button>';
    }
    
    $conn->close();
}
?>

<!-- Agrega este código CSS y JavaScript en tu HTML para el diseño y el botón de Aceptar -->

<style>
    .error-message {
        background-color: #f44336;
        color: white;
        text-align: center;
        padding: 10px;
        border-radius: 5px;
    }
    
    #backButton {
        display: block;
        margin: 20px auto;
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
</style>

<script>
    document.getElementById('backButton').addEventListener('click', function() {
        // Redirige de vuelta al formulario de inicio de sesión
        window.location.href = '../login/login.html';
    });
</script>
