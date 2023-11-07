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
            color: #fff;
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
            font-size: 24px;
            color: #333;
        }

        p {
            font-size: 16px;
            color: #666;
        }

        /* Estilo para el texto "Tiempo restante" */
        #contador {
            text-align: right; /* Alinea el texto a la derecha */
            font-size: 16px; /* Tamaño de fuente */
            color: #333; /* Color del texto */
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
</style>
</head>
<body>
<header>
        <h1>PANEL DEL ARBITRO</h1>
    </header>
    <div id="container" class="content">
        <h2>Árbitros:</h2>
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
</body>
</html>
