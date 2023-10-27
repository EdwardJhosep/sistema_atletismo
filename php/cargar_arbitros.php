<?php
session_start();

// Comprueba si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    // Si el usuario no ha iniciado sesión, redirige a la página de inicio de sesión
    header("Location: ../login/login.html");
    exit();
}

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
        echo "Contraseña de administrador incorrecta. No se pueden asignar horas personalizadas.";
    } else {
        // Realiza una consulta SQL para actualizar las horas personalizadas
        $sql = "UPDATE arbitros SET hora_inicio_personalizada = '$hora_inicio', hora_fin_personalizada = '$hora_cierre' WHERE arbitro_id = $arbitro_id";

        if ($conn->query($sql) === TRUE) {
            echo "Horas personalizadas asignadas con éxito.";
        } else {
            echo "Error al asignar las horas personalizadas: " . $conn->error;
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
    <title>Asignar Horas Personalizadas</title>
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
    </form>
</body>
</html>

<?php
// Cierra la conexión a la base de datos
$conn->close();
?>
