<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "atletismo";
    
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Recuperar datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta para verificar el inicio de sesión
    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Inicio de sesión exitoso
        $_SESSION['username'] = $username;
        header("location: ../usuarios/users.php");
    } else {
        // Inicio de sesión fallido
        echo "Nombre de usuario o contraseña incorrectos.";
    }

    $conn->close();
}
?>
