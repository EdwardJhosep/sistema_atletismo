<?php
// Configuración de la base de datos
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recopila los datos del formulario
    $arbitro_id = $_POST['arbitro'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_cierre = $_POST['hora_cierre'];

    // Realiza una consulta SQL para actualizar las horas personalizadas
    $sql = "UPDATE arbitros SET hora_inicio_personalizada = '$hora_inicio', hora_fin_personalizada = '$hora_cierre' WHERE arbitro_id = $arbitro_id";

    if ($conn->query($sql) === TRUE) {
        echo "Horas personalizadas asignadas con éxito.";
    } else {
        echo "Error al asignar las horas personalizadas: " . $conn->error;
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
        <input type="submit" value="Asignar Horas">
    </form>
</body>
</html>


<?php
// Cierra la conexión a la base de datos
$conn->close();
?>
