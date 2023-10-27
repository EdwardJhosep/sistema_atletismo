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

    // Obtener datos del formulario
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Consulta para verificar el inicio de sesión (sin seguridad de contraseñas)
    $query = "SELECT * FROM arbitros WHERE usuario = '$usuario' AND contrasena = '$contrasena'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Inicio de sesión exitoso, ahora verifica la hora personalizada
        $row = $result->fetch_assoc();
        $hora_inicio_personalizada = $row['hora_inicio_personalizada'];
        $hora_fin_personalizada = $row['hora_fin_personalizada'];

        // Configurar la zona horaria a Perú
        date_default_timezone_set('America/Lima');

        // Obtén la hora actual en la zona horaria de Perú
        $hora_actual_peru = date('Y-m-d H:i:s');

        if ($hora_actual_peru >= $hora_inicio_personalizada && $hora_actual_peru <= $hora_fin_personalizada) {
            // El árbitro está dentro de su horario personalizado en la zona horaria de Perú
            header("Location: ../usuarios/arbitro.php");
            exit;
        } else {
            // Fuera del horario personalizado
            echo "No estás autorizado para iniciar sesión en este momento.";
        }
    } else {
        // Inicio de sesión fallido
        echo "Usuario o contraseña incorrectos. Por favor, intenta de nuevo.";
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
}
?>
