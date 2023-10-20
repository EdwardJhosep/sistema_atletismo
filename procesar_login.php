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

    // Debes cifrar la contraseña antes de compararla con la base de datos.
    // Aquí, estamos utilizando texto plano con fines de demostración, pero en producción, utiliza una función segura de cifrado de contraseñas.
    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Consulta para verificar si el nombre de usuario y la contraseña coinciden
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";

    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Inicio de sesión exitoso
        echo "¡Inicio de sesión exitoso!";
    } else {
        // Inicio de sesión fallido
        echo "Inicio de sesión fallido. Por favor, verifica tu nombre de usuario y contraseña.";
    }
}

// Cierra la conexión a la base de datos
$conn->close();
?>
