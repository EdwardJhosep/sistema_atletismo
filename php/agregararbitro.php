<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login2.html");
    exit();
}

if (isset($_POST['logout'])) {
    // Destruye la sesión primero
    session_destroy();

    // Luego, redirige al usuario a la página de inicio de sesión
    header("Location: ../login/login2.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos
    $db_host = "localhost"; // Cambia a tu servidor de base de datos
    $db_user = "root"; // Cambia a tu nombre de usuario
    $db_pass = ""; // Cambia a tu contraseña
    $db_name = "atletismo"; // Cambia al nombre de tu base de datos

    // Crea la conexión a la base de datos
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Verifica la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Consulta para obtener el último número de usuario en la tabla "arbitros"
    $sql = "SELECT MAX(usuario) AS max_usuario FROM arbitros";
    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        // Incrementa el último número de usuario en 1 para el nuevo árbitro
        $usuario = $row['max_usuario'] + 1;

        // Recopila otros datos del formulario
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $dni = $_POST['dni'];
        $contrasena = $_POST['contrasena'];
        $nivel = $_POST['nivel'];

        // Prepara la consulta SQL para insertar un nuevo árbitro
        $sql = "INSERT INTO arbitros (nombre, apellido, dni, usuario, contrasena) VALUES (?, ?, ?, ?, ?)";

        // Prepara la declaración
        if ($stmt = $conn->prepare($sql)) {
            // Vincula los parámetros y establece sus valores
            $stmt->bind_param("sssss", $nombre, $apellido, $dni, $usuario, $contrasena,$nivel);

            // Ejecuta la consulta
            if ($stmt->execute()) {
                echo "Árbitro agregado con éxito. Nuevo usuario: " . $usuario;
            } else {
                echo "Error al agregar árbitro: " . $conn->error;
            }

            // Cierra la declaración
            $stmt->close();
        }
    } else {
        echo "Error al obtener el último usuario.";
    }

    // Cierra la conexión a la base de datos
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Profesor</title>
    <!-- Agregar el enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2 class="mt-4">Agregar profesor</h2>
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
            <label for="contrasena">Contraseña:</label>
            <input type="password" class="form-control" name="contrasena" required>
        </div>

        <div class="form-group">
            <label for="nivel">Nivel:</label>
            <input type="nivel" class="form-control" name="nivel" required>
        </div>

        <button type="submit" class="btn btn-primary">Agregar Profesor</button>
    </form>
    <a class="btn btn-secondary mt-3" href="../usuarios/users.php">Volver</a>
</div>

<!-- Agregar el enlace a Bootstrap JS y jQuery (opcional) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
