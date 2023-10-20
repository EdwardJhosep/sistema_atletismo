<?php
// Configuración de la base de datos
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

// Consulta para obtener los datos de la tabla "arbitros"
$sql = "SELECT * FROM arbitros";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Árbitros:</h2>";
    echo "<table border='1'>";
    echo "<tr><th>arbitro_id</th><th>nombre</th><th>apellido</th><th>correo_electronico</th><th>usuario</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["arbitro_id"] . "</td>";
        echo "<td>" . $row["nombre"] . "</td>";
        echo "<td>" . $row["apellido"] . "</td>";
        echo "<td>" . $row["correo_electronico"] . "</td>";
        echo "<td>" . $row["usuario"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No se encontraron datos de árbitros.";
}

// Cierra la conexión a la base de datos
$conn->close();
?>
