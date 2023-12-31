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
    
    // Consulta para obtener la contraseña hash asociada al usuario
    $sql = "SELECT contrasena FROM arbitros WHERE usuario = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->bind_result($contrasena_hash);
        $stmt->fetch();
        $stmt->close();
        
        if (password_verify($contrasena, $contrasena_hash)) {
            // Contraseña correcta, inicio de sesión exitoso
            $_SESSION['usuario'] = $usuario;

            // Obtener el ID del árbitro
            $sql_id = "SELECT arbitro_id FROM arbitros WHERE usuario = ?";
            if ($stmt_id = $conn->prepare($sql_id)) {
                $stmt_id->bind_param("s", $usuario);
                $stmt_id->execute();
                $stmt_id->bind_result($arbitro_id);
                $stmt_id->fetch();
                $stmt_id->close();

                // Redirigir a arbitro.php con el ID del árbitro
                header("Location: ../usuarios/arbitro.php?id=" . $arbitro_id);
            } else {
                echo "Error en la preparación de la consulta para obtener el ID: " . $conn->error;
            }
        } else {
            // Contraseña incorrecta, inicio de sesión fallido
            echo '<div class="error-message">Inicio de sesión fallido. Verifica tus credenciales.</div>';
            echo '<button id="backButton">Aceptar</button>';
        }
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
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
