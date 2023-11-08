<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.html");
    exit();
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../login/login.html");
    exit();
}

$error_message = ''; // Variable para almacenar mensajes de error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "atletismo";

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $dni = $_POST['dni'];

    $sql_check = "SELECT dni FROM arbitros WHERE dni = ?";
    
    if ($stmt_check = $conn->prepare($sql_check)) {
        $stmt_check->bind_param("s", $dni);
        $stmt_check->execute();
        $stmt_check->store_result();
        
        if ($stmt_check->num_rows > 0) {
            $error_message = "El DNI ingresado ya existe . No se pudo agregar al árbitro.";
        } else {
            $usuario = ''; // Variable para almacenar el nuevo usuario

            $sql_max_user = "SELECT MAX(usuario) AS max_usuario FROM arbitros";
            $result_max_user = $conn->query($sql_max_user);

            if ($result_max_user && $row_max_user = $result_max_user->fetch_assoc()) {
                $usuario = $row_max_user['max_usuario'] + 1;

                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $contrasena = $_POST['contrasena'];
                $contrasena_hasheada = password_hash($contrasena, PASSWORD_BCRYPT);
                $nivel = $_POST['nivel'];

                $sql_insert = "INSERT INTO arbitros (nombre, apellido, dni, usuario, contrasena, nivel) VALUES (?, ?, ?, ?, ?, ?)";

                if ($stmt_insert = $conn->prepare($sql_insert)) {
                    $stmt_insert->bind_param("ssisss", $nombre, $apellido, $dni, $usuario, $contrasena_hasheada, $nivel);

                    if ($stmt_insert->execute()) {
                        $error_message = "Árbitro agregado con éxito. Nuevo usuario: " . $usuario;
                    } else {
                        $error_message = "Error al agregar árbitro: " . $conn->error;
                    }

                    $stmt_insert->close();
                } else {
                    $error_message = "Error en la preparación de la consulta: " . $conn->error;
                }
            } else {
                $error_message = "Error al obtener el último usuario.";
            }
        }
        
        $stmt_check->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Profesor</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2 class="mt-4">Agregar profesor</h2>
    <?php
    if (!empty($error_message)) {
        echo '<div class="alert alert-danger">' . $error_message . '</div>';
    }
    ?>
    <form action="agregararbitro.php" method="POST">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" name="nombre" required>
        </div>

        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" class="form-control" name="apellido" required>
        </div>

        <div class="form-group">
            <label for="dni">DNI:</label>
            <input type="text" class="form-control" name="dni" required>
        </div>

        <div class="form-group">
            <label for ="contrasena">Contraseña:</label>
            <input type="password" class="form-control" name="contrasena" required>
        </div>

        <div class="form-group">
            <label for="nivel">Nivel:</label>
            <input type="text" class="form-control" name ="nivel" required>
        </div>

        <button type="submit" class="btn btn-primary">Agregar Profesor</button>
    </form>
    <a class="btn btn-secondary mt-3" href="../usuarios/users.php">Volver</a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
