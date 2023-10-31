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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h2 {
            text-align: center;
        }

        form {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        select,
        input[type="datetime-local"],
        input[type="password"],
        input[type="submit"] {
            display: block;
            margin: 10px 0;
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        a {
            display: inline-block;
            text-decoration: none;
            background-color: #FF0000;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            margin-right: 10px;
        }

        a:hover {
            background-color: #CC0000;
        }

        .success {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-top: 10px;
        }

        .error {
            background-color: #FF0000;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>Árbitros:</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <select name="arbitro">
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['arbitro_id'] . "'>" . $row['nombre'] . " " . $row['apellido'] . "</option>";
            }
            ?>
        </select>
        <label for="hora_inicio">Hora de inicio personalizada:</label>
        <input type="datetime-local" name="hora_inicio">
        <label for="hora_cierre">Hora de cierre personalizada:</label>
        <input type="datetime-local" name="hora_cierre">
        
        <!-- Campo de contraseña del administrador -->
        <label for="contrasena_admin">Contraseña de administrador:</label>
        <input type="password" name="contrasena_admin">
        
        <input type="submit" value="Asignar Horas">
        <a href="../usuarios/users.php">Volver</a>
    </form>
</body>
</html>

<?php
// Cierra la conexión a la base de datos
$conn->close();
?>
