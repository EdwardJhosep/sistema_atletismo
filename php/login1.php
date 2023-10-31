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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Verificar las credenciales en la base de datos
        $sql = "SELECT * FROM admin WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // Inicio de sesión exitoso
            $_SESSION['username'] = $username;
            header("Location: ../usuarios/users.php"); // Redirigir a la página de inicio del administrador
            exit();
        } else {
            // Credenciales incorrectas
            echo '<div class="error-message">Usuario o contraseña incorrectos</div>';
            echo '<button id="backButton">Aceptar</button>';
        }
    }
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
        window.location.href = '../login/admin.html';
    });
</script>
