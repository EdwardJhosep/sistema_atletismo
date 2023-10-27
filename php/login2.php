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
    $sql = "SELECT * FROM profesores WHERE usuario = '$usuario' AND contrasena = '$contrasena'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        // Inicio de sesión exitoso
        $_SESSION['usuario'] = $usuario;
        header("Location: ../usuarios/profesor.php"); // Redirige al panel de control o página de inicio después del inicio de sesión
    } else {
        // Inicio de sesión fallido
        echo "Inicio de sesión fallido. Verifica tus credenciales.";
    }
    
    $conn->close();
}
?>
