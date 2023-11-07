<?php
session_start();

if (isset($_POST['logout'])) {
    // Destruye la sesión primero
    session_destroy();

    // Luego, redirige al usuario a la página de inicio de sesión
    header("Location: ../login/login2.html");
    exit();
}

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login2.html");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://www.shutterstock.com/image-vector/initial-letter-ap-logo-design-260nw-2343832111.jpg" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
            body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }

    h1 {
        font-size: 24px;
        text-align: center;
    }

    button {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        margin-top: 20px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    /* Estilos para el modal de confirmación */
    #myModal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #myModal div {
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        text-align: center;
    }

    #myModal p {
        font-size: 16px;
        margin: 0 0 20px;
    }

    #myModal button {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
        margin: 0 10px;
    }

    #myModal button:hover {
        background-color: #0056b3;
    }
    </style>
</head>
<body>
    <h1>hola profesor</h1>
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
