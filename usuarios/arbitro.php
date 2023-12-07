<?php
session_start();

if (isset($_POST['logout'])) {
    // Destruye la sesión primero
    session_destroy();

    // Luego, redirige al usuario a la página de inicio de sesión
    header("Location: ../login/login.html");
    exit();
}

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.html");
    exit();
}

// Obtener el arbitro_id de la sesión actual
$arbitro_id = obtenerArbitroIdPorUsuario($_SESSION['usuario']);

// Función para obtener el arbitro_id por usuario
function obtenerArbitroIdPorUsuario($usuario) {
    // Agrega la lógica necesaria para obtener el arbitro_id según el usuario
    // Puedes usar la misma lógica que usaste en el inicio de sesión
    // Aquí estoy asumiendo que tu tabla de arbitros tiene una columna arbitro_id
    // y que esta función devuelve el arbitro_id correspondiente al usuario actual
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "atletismo";
    
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "SELECT arbitro_id FROM arbitros WHERE usuario = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->bind_result($arbitro_id);
        $stmt->fetch();
        $stmt->close();
        $conn->close();

        return $arbitro_id;
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
        $conn->close();
        return null;
    }
}

// Inicializar la variable $mensaje
$mensaje = null;

// Realizar la consulta a la tabla mensaje con el arbitro_id
if ($arbitro_id !== null) {
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "atletismo";

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql_mensaje = "SELECT * FROM mensaje WHERE arbitro_id = ? ORDER BY fecha_envio DESC LIMIT 1";
    if ($stmt_mensaje = $conn->prepare($sql_mensaje)) {
        $stmt_mensaje->bind_param("i", $arbitro_id);
        $stmt_mensaje->execute();
        $result_mensaje = $stmt_mensaje->get_result();

        if ($result_mensaje->num_rows > 0) {
            $mensaje = $result_mensaje->fetch_assoc();
        }

        $stmt_mensaje->close();
        $conn->close();
    } else {
        echo "Error en la preparación de la consulta de mensaje: " . $conn->error;
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>PANEL DEL ARBITRO</title>
    <link rel="icon" href="https://www.shutterstock.com/image-vector/initial-letter-ap-logo-design-260nw-2343832111.jpg" type="image/png">
    <script>
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "../php/obtener_hora_cierre.php", true);
        xhr.send();

        function iniciarContador(horaCierre) {
            var ahora = Math.floor(Date.now() / 1000); // Timestamp actual
            var tiempoSesion = horaCierre - ahora;

            function actualizarContador() {
                var minutos = Math.floor(tiempoSesion / 60);
                var segundos = tiempoSesion % 60;

                document.getElementById("contador").innerHTML = minutos + "m " + segundos + "s";

                if (tiempoSesion <= 0) {
                    // Redirige al árbitro al index.html u otra acción de cierre de sesión
                    window.location.href = "../index.html";
                } else {
                    tiempoSesion--;
                    setTimeout(actualizarContador, 1000);
                }

            }

            actualizarContador();
        }

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var respuesta = JSON.parse(xhr.responseText);
                var horaCierre = respuesta.horaCierre;
                iniciarContador(horaCierre);
            }
            // Resto de tu código JavaScript aquí

window.onfocus = function() {
    // Esta función se ejecutará cuando la ventana vuelva a estar en foco

    // Recarga la página
    window.location.reload();
};

        };
    </script>
    <style>
       body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        #container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Estilos para encabezado */
        header {
            background-color: #333;
            color: #333;
            padding: 10px 0;
            text-align: center;
        }

        header h1 {
            font-size: 32px;
        }

        /* Estilos para el contenido principal */
        .content {
            background-color: #fff;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Estilos para el texto */
        h2 {
            text-align: center;
            color: #333;
        }

        p {
            font-size: 16px;
            color: #333;
        }

        #container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        margin-top: 20px;
    }

    h2 {
        color: #333;
    }

    #contador {
        font-size: 24px;
        color: #DF0101;
    }

        /* Estilo para el botón principal */
        button {
            padding: 10px 20px;
            background-color: #DF0101;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #FA5858;
        }

        /* Estilo para el botón de cancelar */
        #closeModal {
            background-color: #0074cc;
        }

        /* Estilo para el modal de confirmación */
        #myModal div {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #DF0101;
            padding: 20px;
            border-radius: 5px;
        }

        /* Estilos para los elementos de texto en el modal */
        #myModal p {
            font-size: 18px;
            color: #333;
        }
        #container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            font-size: 32px;
            color: #FFFFFF;
            text-align: center;
        }
        .mensaje {
        background-color: #7EB8FC; /* Azul */
        border: 1px solid #00568c; /* Un tono más oscuro de azul */
        padding: 15px;
        border-radius: 5px;
        margin-top: 10px;
    }

    .mensaje-texto {
        font-size: 16px;
        color: #000000; /* Texto en blanco para mayor contraste */
    }

    .mensaje-fecha {
        font-size: 14px;
        color: #FF0000; /* Color de texto más claro */
    }

    .no-mensaje {
        font-size: 18px;
        color: #0074cc; /* Azul */
        margin-top: 10px;
    }

</style>
</head>
<body>
<header>
    
        <h1>PANEL DEL ARBITRO</h1>
    </header>
    <br><br>
    <div id="container" class="content">
    <h2>Mensajes</h2>
    <?php if ($mensaje !== null) : ?>
        <div class="mensaje">
            <p class="mensaje-texto"><strong>ADMIN:</strong> <?php echo $mensaje['mensaje']; ?></p>
            <p class="mensaje-fecha"><strong>Fecha de Envío:</strong> <?php echo $mensaje['fecha_envio']; ?></p>
        </div>
    <?php else : ?>
        <p class="no-mensaje">No hay mensajes disponibles.</p>
    <?php endif; ?>
</div>
<br>
    <div id="container" class="content">
        <h2>RECUERDA QUE PASADO EL TIEMPO SE TE ECHARA DE LA SESIÓN</h2>
        <p>Tiempo restante : <span id="contador"></span></p>
        <!-- Agrega un botón para abrir el modal de confirmación -->
        <button id="openModal">Cerrar Sesión</button>
        <!-- Modal de confirmación de cierre de sesión -->
        <div id="myModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.7); z-index: 1;">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff; padding: 20px; border-radius: 5px;">
                <p>¿Estás seguro de que deseas cerrar sesión?</p>
                <form method="post">
                    <button type="submit" name="logout">Sí, cerrar sesión</button>
                    <button id="closeModal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // JavaScript para abrir y cerrar el modal
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
    <!-- Agrega este código donde deseas colocar el botón de filtrar -->
    <BR>
    <div id="container" class="content">
    <h2>Agrega resultados</h2>
    <a href="../editar/aditarCA.php"><button style="background-color: #0FA29B; border-color: #0FA29B;">agregar Categoría A</button></a>
    <a href="../editar/aditarCB.php"><button style="background-color: #0FA29B; border-color: #0FA29B;">agregar Categoría B</button></a>
    <a href="../editar/aditarCC.php"><button style="background-color: #0FA29B; border-color: #0FA29B;">agregar Categoría C</button></a>
</div>
<BR>
<div id="container" class="content">
    <h2>Agrega atleta a las competencias</h2>
    <a href="../categoria/editar_categoriaA.php"><button style="background-color: green; border-color: green;">Editar Categoría A</button></a>
    <a href="../categoria/editar_categoriaB.php"><button style="background-color: green; border-color: green;">Editar Categoría B</button></a>
    <a href="../categoria/editar_categoriaC.php"><button style="background-color: green; border-color: green;">Editar Categoría C</button></a>
</div>
<br>
<br>
<div id="container" class="content">
    <h2>Agrega atleta</h2>
    <a href="../categoria/agregaratleta.php"><button style="background-color: blue; border-color: blue;">AGREGAR ATLETA</button></a>
</div>
</body>
</html>