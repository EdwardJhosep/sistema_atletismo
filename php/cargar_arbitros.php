<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/admin.html");
    exit();
}

if (isset($_POST['logout'])) {
    // Destruye la sesión primero
    session_destroy();

    // Luego, redirige al usuario a la página de inicio de sesión
    header("Location: ../login/admin.html");
    exit();
}
?>
<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "atletismo";

// Contraseña de administrador (reemplaza 'contrasena_admin1' y 'contrasena_admin2' con tus contraseñas reales)
$contrasena_admin1 = '123';
$contrasena_admin2 = 'edward@75902205';

// Crear una conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recopila los datos del formulario
    $arbitro_id = $_POST['arbitro'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_cierre = $_POST['hora_cierre'];
    $contrasena = $_POST['contrasena_admin'];

    // Verificar la contraseña del administrador
    if ($contrasena != $contrasena_admin1 && $contrasena != $contrasena_admin2) {
        echo "<div class='error'>Contraseña de administrador incorrecta. No se pueden asignar horas personalizadas.</div>";
    } else {
        // Realiza una consulta SQL para actualizar las horas personalizadas
        $sql = "UPDATE arbitros SET hora_inicio_personalizada = '$hora_inicio', hora_fin_personalizada = '$hora_cierre' WHERE arbitro_id = $arbitro_id";

        if ($conn->query($sql) === TRUE) {
            echo "<div class='success'>Horas personalizadas asignadas con éxito.</div>";
        } else {
            echo "<div class='error'>Error al asignar las horas personalizadas: " . $conn->error . "</div>";
        }
    }
}

// Obtén la lista de árbitros para mostrar en el formulario
$sql = "SELECT arbitro_id, nombre, apellido FROM arbitros";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="https://www.shutterstock.com/image-vector/initial-letter-ap-logo-design-260nw-2343832111.jpg" type="image/png">
    <title>Asignar Horas Personalizadas</title>
    <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h2 {
            text-align: center;
        }

        /* Estilos para el formulario */
        form {
            width: 80%; /* Ancho del formulario */
            max-width: 600px; /* Ancho máximo en dispositivos móviles */
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Estilo para el botón de enviar */
        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Estilo para el botón de Volver */
        a {
            text-decoration: none;
            background-color: #FF0000;
            color: #fff;
        }

        a:hover {
            background-color: #CC0000;
        }

        /* Estilos para los mensajes de éxito y error */
        .success, .error {
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-top: 10px;
        }

        .success {
            background-color: #4CAF50;
        }

        .error {
            background-color: #FF0000;
        }
        
    </style>
</head>
<body>
    <h2>Árbitros:</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="p-4">
        <div class="form-group">
            <label for="arbitro">Árbitro:</label>
            <select class="form-control" name="arbitro">
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['arbitro_id'] . "'>" . $row['nombre'] . " " . $row['apellido'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="hora_inicio">Hora de inicio personalizada:</label>
            <input type="datetime-local" class="form-control" name="hora_inicio">
        </div>
        <div class="form-group">
            <label for "hora_cierre">Hora de cierre personalizada:</label>
            <input type="datetime-local" class="form-control" name="hora_cierre">
        </div>
        <!-- Campo de contraseña del administrador -->
        <div class="form-group">
            <label for="contrasena_admin">Contraseña de administrador:</label>
            <input type="password" class="form-control" name="contrasena_admin">
        </div>
        <button type="submit" class="btn btn-primary">Asignar Horas</button>
        <a href="../usuarios/users.php" class="btn btn-danger">Volver</a>
    </form>
    <!-- Enlace a Bootstrap JS (opcional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


<?php
// Cierra la conexión a la base de datos
$conn->close();
?>
