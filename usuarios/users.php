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

$img = "campana.png"; // Imagen por defecto

// Conectar a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Consulta SQL para verificar si hay alguna fila en la tabla
$sql = "SELECT * FROM solicitud_reset LIMIT 1";
$result = $conn->query($sql);

// Verificar si hay resultados y cambiar la imagen si es necesario
if ($result === FALSE) {
    die("Error en la consulta SQL: " . $conn->error);
}

if ($result->num_rows > 0) {
    $img = "notificacion.png";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://www.shutterstock.com/image-vector/initial-letter-ap-logo-design-260nw-2343832111.jpg" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <!-- Incluye la hoja de estilo de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
            height: 100vh;
        }

        h1 {
            text-align: center;
            padding: 20px;
        }

        button {
            cursor: pointer;
            margin: 10px;
        }

        #header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 20px;
        }

        #header img {
            width: 30px; /* Tamaño más pequeño según tus necesidades */
            margin-left: auto; /* Mueve la imagen al lado derecho */
            margin-right: 10px; /* Espacio a la derecha de la imagen */
            cursor: pointer;
        }

        #myModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1;
        }

        #myModal > div {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
        }
        .btn-container {
        margin-top: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div id="header" class="d-flex justify-content-between align-items-center">
                    <a href="../php/notificaciones.php"><img src="../img/<?php echo $img; ?>" alt=""></a>
                    <!-- Agrega la nueva imagen que redirige a mensaje.php -->
                    <a href="../php/mensaje.php"><img src="../img/chat.png" alt="Mensaje"></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Panel de Administrador</h1>
            </div>
        </div>

        <div class="row">
    <div class="col-12">
        <div class="btn-container text-center"> <!-- Nuevo contenedor para los botones -->
            <a href="../php/cargar_arbitros.php"><button class="btn btn-primary">Cargar Árbitros</button></a>
            <a href="../php/agregararbitro.php"><button class="btn btn-primary">Agregar Árbitro</button></a>
            <a href="../php/editar_arbitro.php"><button class="btn btn-primary">Editar Árbitro</button></a>

            <!-- Mejora el diseño del botón de cerrar sesión -->
            <button id="openModal" class="btn btn-danger" style="margin-top: 20px;">Cerrar Sesión</button>
        </div>
    </div>
</div>

        <!-- Modal de confirmación de cierre de sesión -->
        <div id="myModal">
            <div>
                <p>¿Estás seguro de que deseas cerrar sesión?</p>
                <form method="post">
                    <button type="submit" name="logout" class="btn btn-danger" style="margin-right: 10px;">Sí, cerrar sesión</button>
                    <button id="closeModal" class="btn btn-primary">Cancelar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Incluye la biblioteca de Bootstrap JS y Popper.js (necesarios para algunos componentes de Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        var openModal = document.getElementById('openModal');
        var closeModal = document.getElementById('closeModal');
        var modal = document.getElementById('myModal');

        openModal.addEventListener('click', function () {
            modal.style.display = 'block';
        });

        closeModal.addEventListener('click', function () {
            modal.style.display = 'none';
        });
    </script>
</body>
</html>
