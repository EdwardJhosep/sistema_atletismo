<?php
session_start();

// Comprueba si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $password = $_POST['password'];

        $servername = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $database = "atletismo";

        $conn = new mysqli($servername, $dbUsername, $dbPassword, $database);

        if ($conn->connect_error) {
            die("Error de conexión a la base de datos: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($user_id, $db_username, $db_password);
            $stmt->fetch();

            if (password_verify($password, $db_password)) {
                $_SESSION['user_id'] = $user_id;
                header("Location: ../usuarios/users.php");
                exit();
            } else {
                echo "Credenciales incorrectas.";
            }
        } else {
            echo "Usuario no encontrado.";
        }

        $stmt->close();
        $conn->close();
    } else {
        // Usuario no ha iniciado sesión y no se ha enviado el formulario, redirigir a login.html
        header("Location: ../login/admin.html");
        exit();
    }
} else {
    // Usuario ha iniciado sesión, redirigir a welcome.php
    header("Location: ../usuarios/users.php");
    exit();
}
?>
