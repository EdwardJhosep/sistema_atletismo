
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

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "atletismo";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener arbitros para el select
$sql = "SELECT arbitro_id, dni, nombre, apellido FROM arbitros";
$result = $conn->query($sql);
$arbitros = [];
while ($row = $result->fetch_assoc()) {
    $arbitros[] = $row;
}

// Agregar nuevo mensaje al array cuando se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['newMessage'])) {
    $newMessage = $_POST['newMessage'];
    $selectedArbitroID = isset($_POST['arbitro_id']) ? $_POST['arbitro_id'] : null;
    
    // Insertar el mensaje en la base de datos
    $insertSql = "INSERT INTO mensaje (arbitro_id, mensaje, fecha_envio) VALUES (?, ?, current_timestamp())";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("ss", $selectedArbitroID, $newMessage);
    
    if ($stmt->execute()) {
        echo "Mensaje enviado correctamente";
    } else {
        echo "Error al enviar el mensaje: " . $stmt->error;
    }
    
    $stmt->close();
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
        }

        h1 {
            text-align: center;
            padding: 20px;
        }

        #message-container {
            max-width: 600px;
            width: 100%;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .message {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 6px;
            background-color: #e6e6e6;
            transition: background-color 0.3s ease-in-out;
        }

        .message:hover {
            background-color: #dcdcdc;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
            animation: slideInUp 0.5s ease-in-out;
        }

        @keyframes slideInUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        label {
            margin-bottom: 5px;
        }

        select, input {
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border-color 0.3s ease-in-out;
        }

        select:focus, input:focus {
            border-color: #007bff;
        }

        button {
            cursor: pointer;
            padding: 8px 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            transition: background-color 0.3s ease-in-out;
        }

        button:hover {
            background-color: #0056b3;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .page-item {
            margin: 0 5px;
        }
    </style>
</head>
<body>
    <h1>Mensajes</h1>
    <br>
<a href="../usuarios/users.php" style="background-color: #FF0000; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;" onmouseover="this.style.backgroundColor='#CC0000'" onmouseout="this.style.backgroundColor='#FF0000'">Volver</a>
<br>
    <div id="message-container" class="container">
        <?php
        // Obtener mensajes de la base de datos
        $messagesPerPage = 5; // Número de mensajes por página
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($currentPage - 1) * $messagesPerPage;

        $messagesSql = "SELECT * FROM mensaje LIMIT $messagesPerPage OFFSET $offset";
        $messagesResult = $conn->query($messagesSql);
        while ($messageRow = $messagesResult->fetch_assoc()) {
            echo '<div class="message"><strong>' . $messageRow['arbitro_id'] . ':</strong> ' . $messageRow['mensaje'] . '</div>';
        }
        ?>
    </div>

    <!-- Barra de navegación -->
    <nav aria-label="Page navigation" class="pagination">
        <ul class="pagination">
            <?php
            // Calcular el número total de páginas
            $totalMessagesSql = "SELECT COUNT(*) as total FROM mensaje";
            $totalMessagesResult = $conn->query($totalMessagesSql);
            $totalMessages = $totalMessagesResult->fetch_assoc()['total'];
            $totalPages = ceil($totalMessages / $messagesPerPage);

            // Mostrar enlaces de paginación
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<li class="page-item ' . ($i == $currentPage ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
            }
            ?>
        </ul>
    </nav>


    <form method="post" action="" class="container">
        <div class="form-group">
            <label for="arbitroSelect">Selecciona Arbitro:</label>
            <select id="arbitroSelect" name="arbitro_id" class="form-control">
                <?php
                // Mostrar opciones de arbitros en el select
                foreach ($arbitros as $arbitro) {
                    echo '<option value="' . $arbitro['arbitro_id'] . '">' . $arbitro['dni'] . ' - ' . $arbitro['nombre'] . ' ' . $arbitro['apellido'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group">
    <label for="messageInput">Escribe un mensaje:</label>
    <textarea id="messageInput" name="newMessage" rows="4" required class="form-control"></textarea>
</div>
<button type="submit" class="btn btn-primary">Enviar</button>

    </form>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
