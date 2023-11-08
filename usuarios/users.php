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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://www.shutterstock.com/image-vector/initial-letter-ap-logo-design-260nw-2343832111.jpg" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5; /* Cambia el color de fondo según tus preferencias */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start; /* Alinea el contenido en la parte superior */
            height: 100vh;
        }

        h1 {
            text-align: center;
            padding: 20px;
        }

        button {
            background-color: #007BFF; /* Cambia el color de fondo del botón según tus preferencias */
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            margin: 10px;
        }

        button:hover {
            background-color: #0056b3; /* Cambia el color cuando pasas el cursor por encima */
        }

        /* Estilo para el modal de confirmación */
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
    </style>
</head>
<body>
    <h1>Panel de Administrador</h1>
    <a href="../php/cargar_arbitros.php"><button>Cargar Árbitros</button></a>
    <a href="../php/agregararbitro.php"><button>agregar arbitro</button></a>
    <!-- Agrega un botón para abrir el modal de confirmación -->
    <button id="openModal" style="background-color: #FF0000; color: #fff;">Cerrar Sesión</button>

    <!-- Modal de confirmación de cierre de sesión -->
    <div id="myModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.7); z-index: 1;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff; padding: 20px; border-radius: 5px;">
            <p>¿Estás seguro de que deseas cerrar sesión?</p>
            <form method="post">
                <button type="submit" name="logout" style="background-color: #FF0000; color: #fff;">Sí, cerrar sesión</button>
                <button id="closeModal">Cancelar</button>
            </form>
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
