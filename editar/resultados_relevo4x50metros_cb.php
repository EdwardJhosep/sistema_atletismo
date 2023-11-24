<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            <a class="btn btn-secondary mt-3" href="../usuarios/arbitro.php"
                style="background-color: red; border-color: red; color: white;">Volver</a>
        </div>
        <div class='text-center mt-3'>
    <a href='javascript:history.go(-1)' class='btn btn-secondary btn-custom' style="background-color: emerald; border-color: emerald; color: emerald;">Volver Atrás</a>
</div>
    </div>
</body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

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

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "atletismo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_POST['seleccionar_tabla'])) {
    // Si se selecciona la tabla, mostrar el formulario de edición para esa tabla
    $tablaSeleccionada = $_POST['editar_tabla'];
    $nivelSeleccionado = $_POST['nivel']; // Nuevo campo para almacenar el nivel
    mostrarFormularioEdicion($conn, $tablaSeleccionada, $nivelSeleccionado);
} elseif (isset($_POST['guardar_edicion'])) {
    // Si se envía el formulario de edición, procesar la edición y mostrar el resultado
    $tablaEditar = $_POST['editar_tabla'];
    $idAtletaEditar = $_POST['editar_idAtleta'];
    $nivelEditar = $_POST['nivel']; // Nuevo campo para almacenar el nivel

    // Obtener los datos del formulario de edición
    $datosActualizados = [];
    foreach ($_POST as $campo => $valor) {
        if ($campo !== 'editar_tabla' && $campo !== 'editar_idAtleta' && $campo !== 'guardar_edicion' && $campo !== 'nivel') {
            $datosActualizados[$campo] = $valor;
        }
    }

    // Construir la consulta de actualización solo para la fila específica y el nivel actual
    $update_query = "UPDATE $tablaEditar SET ";
    foreach ($datosActualizados as $campo => $valor) {
        $update_query .= "$campo = '$valor', ";
    }
    $update_query = rtrim($update_query, ", ");
    $update_query .= " WHERE ID_Atleta1 = $idAtletaEditar AND Nivel = '$nivelEditar'";

    // Ejecutar la consulta de actualización
    if ($conn->query($update_query) === TRUE) {
        $mensaje = "Edición guardada correctamente.";
    } else {
        $mensaje = "Error al guardar la edición: " . $conn->error;
    }

    // Mostrar formulario para seleccionar la tabla a editar
    mostrarFormularioSeleccion($conn, $mensaje);
} else {
    // Mostrar formulario para seleccionar la tabla y el nivel a editar
    mostrarFormularioSeleccion($conn);
}

function mostrarFormularioSeleccion($conn, $mensaje = "") {
    $sql = "SHOW TABLES";
    $result = $conn->query($sql);

    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Your Web App</title>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css'>
        <style>
            body {
                background-color: #f8f9fa;
            }

            .container {
                margin-top: 50px;
            }
        </style>
    </head>
    <body>";

    echo "<div class='container mt-5'>
            <div class='card'>
                <div class='card-body'>";

    if ($mensaje) {
        echo "<div class='alert alert-info' role='alert'>$mensaje</div>";
    }

    if ($result->num_rows > 0) {
        echo "<form action='' method='post'>
                    <label for='editar_tabla'>Seleccione la tabla a editar:</label>
                    <select name='editar_tabla' id='editar_tabla' class='form-select mb-3'>";
        
        while ($row = $result->fetch_row()) {
            $tabla = $row[0];
            if ($tabla === 'resultados_relevo5x80metros_cb') {
                echo "<option value='$tabla'>$tabla</option>";
            }
        }

        echo "</select>";

        // Agregar campo para seleccionar el nivel
        echo "<label for='nivel'>Seleccione el nivel:</label>
                <select name='nivel' id='nivel' class='form-select mb-3'>
                    <option value='DISTRITAL'>DISTRITAL</option>
                    <option value='PROVINCIAL'>PROVINCIAL</option>
                    <option value='REGIONAL'>REGIONAL</option>
                </select>";

        echo "<input type='submit' name='seleccionar_tabla' value='Seleccionar' class='btn btn-primary'>
            </form>";
    } else {
        echo "<p>No se encontraron tablas en la base de datos</p>";
    }

    echo "</div>
        </div>
    </div>";

    echo "<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
    </body>
    </html>";

    $conn->close();
}


function mostrarFormularioEdicion($conn, $tabla, $nivel) {
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Your Web App</title>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css'>
        <style>
            body {
                background-color: #f8f9fa;
            }

            .container {
                margin-top: 50px;
            }
        </style>
    </head>
    <body>";

    $select_query = "SELECT * FROM $tabla WHERE Nivel = '$nivel'";
    $result = $conn->query($select_query);

    if ($result->num_rows > 0) {
        echo "<div class='container mt-5'>";
        $groupCounter = 1; // Counter for group titles
        while ($fila = $result->fetch_assoc()) {
            echo "<div class='card mb-3'>
                    <div class='card-body'>
                        <h2 class='card-title'>Grupo $groupCounter: Tabla seleccionada: $tabla - Nivel: $nivel</h2>";
            $groupCounter++;

            echo "<form action='' method='post'>";
            echo "<input type='hidden' name='editar_tabla' value='$tabla'>";
            echo "<input type='hidden' name='editar_idAtleta' value='{$fila['ID_Atleta1']}'>";
            echo "<input type='hidden' name='nivel' value='$nivel'>"; // Pasar el nivel como campo oculto

            // Mostrar los DNI de los 4 atletas
            for ($i = 1; $i <= 5; $i++) {
                $dniCampo = "DNI_Atleta$i";
                echo "DNI Atleta $i: {$fila[$dniCampo]}<br>";
            }

            // Mostrar los campos a completar
            echo "Resultado: <input type='text' name='Resultado' value='{$fila['Resultado']}' class='form-control mb-3'><br>";
            echo "Lugar: <input type='text' name='Lugar' value='{$fila['Lugar']}' class='form-control mb-3'><br>";
            echo "Serie: <input type='text' name='Serie' value='{$fila['Serie']}' class='form-control mb-3'><br>";
            echo "Pista: <input type='text' name='Pista' value='{$fila['Pista']}' class='form-control mb-3'><br>";
            echo "Nivel: <input type='text' name='Nivel' value='{$fila['Nivel']}' readonly class='form-control mb-3'><br>";

            echo "<input type='submit' name='guardar_edicion' value='Guardar' class='btn btn-primary'>
                </form>";

            echo "</div>
                </div>";
        }
        echo "</div>";
    } else {
        echo "<p>No hay datos en la tabla $tabla para el nivel seleccionado</p>";
    }

    echo "<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
    </body>
    </html>";
}
?>
