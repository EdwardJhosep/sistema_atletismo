<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/admin.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "atletismo";

// Conectar a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Verificar si se ha enviado una solicitud de eliminación
if (isset($_POST['eliminar_solicitud'])) {
    $solicitud_id = $_POST['eliminar_solicitud'];

    // Realizar la eliminación en la base de datos
    $sql_eliminar = "DELETE FROM solicitud_reset WHERE solicitud_id = '$solicitud_id'";
    if ($conn->query($sql_eliminar) === TRUE) {
        echo json_encode(["success" => true]);
        exit();
    } else {
        echo json_encode(["error" => "Error al eliminar la fila: " . $conn->error]);
        exit();
    }
}

// Consulta SQL para obtener la información completa de la tabla solicitud_reset
$sql = "SELECT * FROM solicitud_reset";
$result = $conn->query($sql);

// Verificar si hay resultados
if ($result === FALSE) {
    die("Error en la consulta SQL: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://www.shutterstock.com/image-vector/initial-letter-ap-logo-design-260nw-2343832111.jpg" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificaciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: #fff;
        }

        button {
            background-color: #FF0000;
            color: #fff;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #CC0000;
        }
    </style>
</head>
<body>

    <h1>Notificaciones</h1>
    <br><br><br>
<a href="../usuarios/users.php" style="background-color: #FF0000; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;" onmouseover="this.style.backgroundColor='#CC0000'" onmouseout="this.style.backgroundColor='#FF0000'">Volver</a>
<br><br><br>

    <?php
    if ($result->num_rows > 0) {
        echo '<table>';
        echo '<tr>';
        echo '<th>Solicitud ID</th>';
        echo '<th>Teléfono</th>';
        echo '<th>Fecha de Solicitud</th>';
        echo '<th>DNI</th>';
        echo '<th>Acciones</th>';
        echo '</tr>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['solicitud_id'] . '</td>';
            echo '<td>' . $row['telefono'] . '</td>';
            echo '<td>' . $row['fecha_solicitud'] . '</td>';
            echo '<td>' . $row['dni'] . '</td>';
            echo '<td><button onclick="eliminarFila(' . $row['solicitud_id'] . ')">Eliminar</button></td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo '<p>No hay notificaciones.</p>';
    }

    $conn->close();
    ?>

    <script>
        function eliminarFila(solicitudId) {
            var confirmacion = confirm('¿Estás seguro de eliminar esta solicitud?');

            if (confirmacion) {
                // Realizar una solicitud AJAX para eliminar la fila en el servidor
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(this.responseText);
                        if (response.success) {
                            // Recargar la página después de la eliminación exitosa
                            location.reload();
                        } else {
                            alert('Error al eliminar la fila: ' + response.error);
                        }
                    }
                };
                xhttp.open('POST', '../php/notificaciones.php', true);
                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp.send('eliminar_solicitud=' + solicitudId);
            }
        }
    </script>
</body>
</html>
