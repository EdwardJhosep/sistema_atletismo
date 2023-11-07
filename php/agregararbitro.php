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

        // Prepara la consulta SQL para insertar un nuevo árbitro
        $sql = "INSERT INTO arbitros (nombre, apellido, dni, usuario, contrasena) VALUES (?, ?, ?, ?, ?)";

        // Prepara la declaración
        if ($stmt = $conn->prepare($sql)) {
            // Vincula los parámetros y establece sus valores
            $stmt->bind_param("sssss", $nombre, $apellido, $dni, $usuario, $contrasena);

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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            overflow: hidden;
        }

        form {
            background: #fff;
            padding: 20px;
            border: 1px solid #d1d1d1;
            border-radius: 5px;
            margin: 20px 0;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin: 10px 0;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            background: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background: #555;
        }

        .btn-volver {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            border-radius: 3px;
        }

        .btn-volver:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <h2>Agregar profesor</h2>
    <form action="agregararbitro.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" required><br>

        <label for="dni">DNI:</label>
        <input type="text" name="dni" required><br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required><br>

        <input type="submit" value="Agregar Árbitro">
        <a class="btn-volver" href="../usuarios/users.php">Volver</a>
    </form>
</body>
</html>