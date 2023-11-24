<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Formulario Atletas</title>
    <style>
        /* Estilo personalizado para el contenedor del formulario */
        .form-container {
            max-width: 400px;
            margin: auto;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 50px;
        }

        /* Ajustes adicionales para el tamaño del botón y el margen inferior */
        .btn-primary {
            width: 100%;
            font-size: 1rem;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<script>
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "../php/obtener_hora_cierre.php", true);
        xhr.send();

        function iniciarContador(horaCierre) {
            var ahora = Math.floor(Date.now() / 1000);
            var tiempoSesion = horaCierre - ahora;

            function actualizarContador() {
                var minutos = Math.floor(tiempoSesion / 60);
                var segundos = tiempoSesion % 60;

                document.getElementById("contador").innerHTML = minutos + "m " + segundos + "s";

                if (tiempoSesion <= 0) {
                    window.location.href = "../index.html";
                } else {
                    tiempoSesion--;
                    setTimeout(actualizarContador, 1000);
                }
            }

            actualizarContador();
        }

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var respuesta = JSON.parse(xhr.responseText);
                var horaCierre = respuesta.horaCierre;
                iniciarContador(horaCierre);
            }

            window.onfocus = function () {
                window.location.reload();
            };
        };
    </script>

    <div class="container">
        <div class="jumbotron text-center">
            <h1 class="display-4">CATEGORIA B</h1>
            <h2>RECUERDA QUE PASADO EL TIEMPO SE TE ECHARA DE LA SESIÓN</h2>
            <p>Tiempo restante: <span id="contador"></span></p>
        </div>

        <div class="text-center">
    <a class="btn btn-secondary mt-3" href="../usuarios/arbitro.php" style="background-color: green; border-color: green; color: white;">Volver al menú </a>
</div>
<div class="container">
    <div class="form-container">
    <h2 class="mb-4">Agregar Atleta</h2>
    <form action="agregaratleta.php" method="post">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" class="form-control" id="apellido" name="apellido" required>
        </div>
        <div class="form-group">
            <label for="genero">Género:</label>
            <select class="form-control" id="genero" name="genero" required>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
            </select>
        </div>
        <div class="form-group">
            <label for="dni">DNI:</label>
            <input type="text" class="form-control" id="dni" name="dni" required>
        </div>
        <div class="form-group">
            <label for="pais">País:</label>
            <input type="text" class="form-control" id="pais" name="pais">
        </div>
        <div class="form-group">
            <label for="departamento">Departamento:</label>
            <input type="text" class="form-control" id="departamento" name="departamento">
        </div>
        <div class="form-group">
            <label for="provincia">Provincia:</label>
            <input type="text" class="form-control" id="provincia" name="provincia">
        </div>
        <div class="form-group">
            <label for="distrito">Distrito:</label>
            <input type="text" class="form-control" id="distrito" name="distrito" required>
        </div>
        <div class="form-group">
            <label for="nacimiento">Fecha de Nacimiento:</label>
            <input type="date" class="form-control" id="nacimiento" name="nacimiento">
        </div>
        <div class="form-group">
            <label for="institucion">Institución:</label>
            <input type="text" class="form-control" id="institucion" name="institucion">
        </div>
        <button type="submit" class="btn btn-primary">Agregar Atleta</button>
    </form>
    </div>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establecer conexión a la base de datos (reemplaza los valores según tu configuración)
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "atletismo";

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    // Recuperar datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $genero = $_POST['genero'];
    $dni = $_POST['dni'];
    $pais = $_POST['pais'];
    $departamento = $_POST['departamento'];
    $provincia = $_POST['provincia'];
    $distrito = $_POST['distrito'];
    $nacimiento = $_POST['nacimiento'];
    $institucion = $_POST['institucion'];

    // Verificar si el DNI ya existe en la base de datos
    $verificar_dni = "SELECT * FROM atletas WHERE dni = '$dni'";
    $result = $conn->query($verificar_dni);

    if ($result->num_rows > 0) {
        echo "<p class='mt-3 alert alert-danger'>Error: El DNI ya existe en la base de datos.</p>";
    } else {
        // Insertar datos en la tabla "atletas"
        $sql = "INSERT INTO atletas (nombre, apellido, genero, dni, pais, departamento, provincia, distrito, nacimiento, institucion) 
                VALUES ('$nombre', '$apellido', '$genero', '$dni', '$pais', '$departamento', '$provincia', '$distrito', '$nacimiento', '$institucion')";

        if ($conn->query($sql) === TRUE) {
            echo "<p class='mt-3 alert alert-success'>Atleta agregado con éxito</p>";
        } else {
            echo "<p class='mt-3 alert alert-danger'>Error al agregar atleta: " . $conn->error . "</p>";
        }
    }

    // Cerrar conexión
    $conn->close();
}
?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>