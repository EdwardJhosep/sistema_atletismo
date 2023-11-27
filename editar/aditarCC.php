
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Edición</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .btn-custom {
            background-color: red;
            border-color: red;
            color: white;
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
            <h1 class="display-4">CATEGORIA C</h1>
            <h2>RECUERDA QUE PASADO EL TIEMPO SE TE ECHARA DE LA SESIÓN</h2>
            <p>Tiempo restante: <span id="contador"></span></p>
        </div>
        <div class="text-center">
    <a class="btn btn-secondary mt-3" href="../usuarios/arbitro.php" style="background-color: green; border-color: green; color: white;">Volver al menú </a>
</div>
<div class="text-center">
    <a class="btn btn-secondary mt-3" href="resultados_relevo4x50metros_cc.php" style="background-color: blue; border-color: blue; color: white;">Agregar resultados a resultados_relevo4x50metros_cc</a>
</div>
<div class='text-center mt-3'>
    <a href='javascript:history.go(-1)' class='btn btn-secondary btn-custom' style="background-color: emerald; border-color: emerald; color: emerald;">Volver Atrás</a>
</div>
<br><br>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
session_start();

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
    $nivelEditar = $_POST['nivel']; // Nuevo campo para almacenar el nivel

    // Obtener los datos del formulario de edición
    $editar_idAtletas = $_POST['editar_idAtleta'];
    $datosActualizados = $_POST['datosActualizados'];

    // Iterar sobre los ID de Atleta y datos actualizados
    foreach ($editar_idAtletas as $key => $idAtletaEditar) {
        // Construir la consulta de actualización solo para la fila específica y el nivel actual
        $update_query = "UPDATE $tablaEditar SET ";
        foreach ($datosActualizados as $campo => $valores) {
            $valor = $valores[$key];
            $update_query .= "$campo = '$valor', ";
        }
        $update_query = rtrim($update_query, ", ");
        $update_query .= " WHERE ID_Atleta = $idAtletaEditar AND Nivel = '$nivelEditar'";

        // Ejecutar la consulta de actualización
        if ($conn->query($update_query) !== TRUE) {
            $mensaje = "Error al guardar la edición: " . $conn->error;
            break; // Detener el bucle si hay un error
        }
    }

    if (!isset($mensaje)) {
        $mensaje = "Ediciones guardadas correctamente.";
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

            .btn-custom {
                background-color: #dc3545;
                border-color: #dc3545;
                color: white;
            }

            .form-container {
                max-width: 400px;
                margin: 0 auto;
            }

            .form-group {
                margin-bottom: 20px;
            }

            label {
                display: block;
                margin-bottom: 5px;
            }

            select, input {
                width: 100%;
                padding: 8px;
                box-sizing: border-box;
            }
        </style>
    </head>
    <body>";

    if ($mensaje) {
        echo "<div class='alert alert-info' role='alert'>$mensaje</div>";
    }

    if ($result->num_rows > 0) {
        echo "<div class='container form-container'>
            <form action='' method='post'>
                <div class='form-group'>
                    <label for='editar_tabla'>Seleccione la tabla a editar:</label>
                    <select name='editar_tabla' id='editar_tabla' class='form-control'>";

        while ($row = $result->fetch_row()) {
            $tabla = $row[0];
            if (in_array(substr($tabla, -2), ['cc']) && $tabla !== 'resultados_relevo5x80metros_cc') {
                echo "<option value='$tabla'>$tabla</option>";
            }
        }

        echo "</select>
                </div>";

        // Agregar campo para seleccionar el nivel
        echo "<div class='form-group'>
                    <label for='nivel'>Seleccione el nivel:</label>
                    <select name='nivel' id='nivel' class='form-control'>
                        <option value='DISTRITAL'>DISTRITAL</option>
                        <option value='PROVINCIAL'>PROVINCIAL</option>
                        <option value='REGIONAL'>REGIONAL</option>
                    </select>
                </div>";

        echo "<input type='submit' name='seleccionar_tabla' value='Seleccionar' class='btn btn-primary btn-custom'>
            </form>
        </div>";
    } else {
        echo "<div class='container mt-5'>
            <p>No se encontraron tablas en la base de datos</p>
        </div>";
    }

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

            .btn-custom {
                background-color: red;
                border-color: red;
                color: white;
            }
        </style>
    </head>
    <body>";

    echo "<div class='container mt-5'>
        <h2>Tabla seleccionada: $tabla - Nivel: $nivel</h2>";

    $select_query = "SELECT * FROM $tabla WHERE Nivel = '$nivel'";
    $result = $conn->query($select_query);

    if ($result->num_rows > 0) {
        echo "<form action='' method='post'>";
        echo "<input type='hidden' name='editar_tabla' value='$tabla'>";
        echo "<input type='hidden' name='nivel' value='$nivel'>"; // Pasar el nivel como campo oculto

        while ($fila = $result->fetch_assoc()) {
            echo "<input type='hidden' name='editar_idAtleta[]' value='{$fila['ID_Atleta']}'>"; // Utiliza un array para los ID_Atleta

            foreach ($fila as $campo => $valor) {
                // Agregar readonly a los campos que no deben ser editables
                $readonly = ($campo == 'ID_Atleta' || $campo == 'DNI_Atleta' || $campo == 'Nivel') ? 'readonly' : '';
                echo "<div class='mb-3'>
                    <label for='$campo' class='form-label'>$campo:</label>
                    <input type='text' name='datosActualizados[$campo][]' value='$valor' $readonly class='form-control'>
                   

                </div>";
       
            }          echo "<hr style='height: 9px; color: blue; background-color: red;'>";

        }

        echo "<input type='submit' name='guardar_edicion' value='Guardar Todo' class='btn btn-primary btn-custom'>";
        echo "</form>";
        
    } else {
        echo "<p>No hay datos en la tabla $tabla para el nivel seleccionado</p>";
    }

    echo "<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
    </body>
    </html>";
}
?>
