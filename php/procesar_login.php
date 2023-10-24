<?php
// Configuración de la zona horaria en Lima
date_default_timezone_set('America/Lima');

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

    // Consulta para verificar si el nombre de usuario y la contraseña coinciden en la tabla "users"
    $sqlUsers = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $resultUsers = $conn->query($sqlUsers);

    if ($resultProfesores->num_rows == 1) {
        // Inicio de sesión exitoso para profesores
        session_start();  // Iniciar la sesión

        // Generar un token de sesión único
        $token = bin2hex(random_bytes(32)); // Puedes ajustar la longitud del token

        // Almacenar el token en una variable de sesión
        $_SESSION['session_token'] = $token;

        $_SESSION['loggedin'] = true;  // Establecer una variable de sesión
        header("Location: ../usuarios/profesor.html");
    } elseif ($resultArbitros->num_rows == 1) {
        $rowArbitro = $resultArbitros->fetch_assoc();
        $horaInicio = $rowArbitro["hora_inicio_personalizada"];
        $horaCierre = $rowArbitro["hora_fin_personalizada"];
        $horaActual = date("Y-m-d H:i:s"); // Formato "año-mes-día hora:minuto:segundo"

        if ($horaActual >= $horaInicio && $horaActual <= $horaCierre) {
            // Inicio de sesión exitoso para árbitros dentro del rango de tiempo
            session_start();  // Iniciar la sesión

            // Generar un token de sesión único
            $token = bin2hex(random_bytes(32)); // Puedes ajustar la longitud del token

            // Almacenar el token en una variable de sesión
            $_SESSION['session_token'] = $token;

            $_SESSION['loggedin'] = true;  // Establecer una variable de sesión
            header("Location: ../usuarios/arbitro.html");
        } else {
            // Fuera del rango de tiempo
            echo "Acceso restringido en este momento. Las horas personalizadas son de $horaInicio a $horaCierre.";
        }
    } elseif ($resultUsers->num_rows == 1) {
        // Inicio de sesión exitoso para usuarios
        session_start();  // Iniciar la sesión

        // Generar un token de sesión único
        $token = bin2hex(random_bytes(32)); // Puedes ajustar la longitud del token

        // Almacenar el token en una variable de sesión
        $_SESSION['session_token'] = $token;

        $_SESSION['loggedin'] = true;  // Establecer una variable de sesión
        header("Location: ../usuarios/users.php");
    } else {
        // Inicio de sesión fallido
        echo "Inicio de sesión fallido. Por favor, verifica tu nombre de usuario y contraseña.";
    }
}

// Cierra la conexión a la base de datos
$conn->close();
?>
