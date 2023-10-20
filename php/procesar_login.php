<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";  // Tu nombre de usuario de MySQL
$password = "";      // Tu contraseña de MySQL
$database = "atletismo";

// Crear una conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Manejar el envío del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["nombre_de_usuario"];
    $password = $_POST["contrasena"];

    // Consulta para verificar si el nombre de usuario y la contraseña coinciden en la tabla "profesores"
    $sqlProfesores = "SELECT * FROM profesores WHERE usuario = '$username' AND contrasena = '$password'";
    $resultProfesores = $conn->query($sqlProfesores);

    // Consulta para verificar si el nombre de usuario y la contraseña coinciden en la tabla "arbitros"
    $sqlArbitros = "SELECT * FROM arbitros WHERE usuario = '$username' AND contrasena = '$password'";
    $resultArbitros = $conn->query($sqlArbitros);

        // Consulta para verificar si el nombre de usuario y la contraseña coinciden en la tabla "arbitros"
        $sqlUsers = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $sqlUsers = $conn->query($sqlUsers);

    if ($resultProfesores->num_rows == 1) {
        // Inicio de sesión exitoso para profesores
        header("Location: ../usuarios/profesor.html");
    } elseif ($resultArbitros->num_rows == 1) {
        // Inicio de sesión exitoso para árbitros
        header("Location: ../usuarios/arbitro.html");

    } elseif ($sqlUsers->num_rows == 1) {
        // Inicio de sesión exitoso para árbitros
        header("Location: ../usuarios/users.html");
    } else {
        // Inicio de sesión fallido
        echo "Inicio de sesión fallido. Por favor, verifica tu nombre de usuario y contraseña.";
    }
}

// Cierra la conexión a la base de datos
$conn->close();
?>
