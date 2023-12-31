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

// Conexión a la base de datos (reemplaza con tus propios datos)
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "atletismo";

// Crear conexión
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

function agregarAtleta($dni, $nivel, $tabla, $fecha_competencia) {
    global $conn;

    // Verificar si el atleta ya tiene registros en la tabla y nivel especificados
    $query_verificar_atleta = "SELECT * FROM $tabla WHERE DNI_Atleta = '$dni' AND Nivel = '$nivel'";
    $result_verificar_atleta = $conn->query($query_verificar_atleta);

    if ($result_verificar_atleta && $result_verificar_atleta->num_rows > 0) {
        echo "El atleta con DNI: $dni ya tiene registros en el nivel $nivel.<br>";
    } else {
        // Buscar atleta por DNI en la tabla atletas
        $query_buscar_atleta_general = "SELECT * FROM atletas WHERE dni = '$dni'";
        $result_buscar_atleta_general = $conn->query($query_buscar_atleta_general);

        if ($result_buscar_atleta_general && $result_buscar_atleta_general->num_rows > 0) {
            $row_atleta = $result_buscar_atleta_general->fetch_assoc();
            $id_atleta = $row_atleta["id"];
            $nombre_atleta = $row_atleta["nombre"];

            // Insertar nuevo resultado en la tabla seleccionada
            $query_insertar_resultado = "INSERT INTO $tabla (ID_Atleta, DNI_Atleta, Resultado, Lugar, Serie, Pista, Nivel, Fecha_Competencia)
                                         VALUES ('$id_atleta', '$dni', 0.0, 0, 0, '', '$nivel', '$fecha_competencia')";
            $result_insertar_resultado = $conn->query($query_insertar_resultado);

            if ($result_insertar_resultado) {
                echo "Se agregó el atleta con ID: $id_atleta, Nombre: $nombre_atleta, DNI: $dni, Nivel: $nivel y Fecha de Competencia: $fecha_competencia a la tabla $tabla.<br>";
            } else {
                echo "Error al agregar el resultado: " . $conn->error . "<br>";
            }
        } else {
            echo "No se encontró un atleta con DNI: $dni en la tabla atletas.<br>";
        }
    }
}



// Función para eliminar atleta por DNI y tabla
function eliminarAtleta($dni, $tabla, $nivel) {
    global $conn;

    // Eliminar resultados de la tabla seleccionada por DNI y Nivel
    $query_eliminar_resultados = "DELETE FROM $tabla WHERE DNI_Atleta = '$dni' AND Nivel = '$nivel'";
    $result_eliminar_resultados = $conn->query($query_eliminar_resultados);

    if ($result_eliminar_resultados) {
        echo "Se eliminaron los resultados del atleta con DNI: $dni en el nivel $nivel de la tabla $tabla.<br>";
    } else {
        echo "Error al eliminar los resultados: " . $conn->error . "<br>";
    }
}

function mostrarResultadosConFiltro($tabla, $nivel) {
    global $conn;

    $query_resultados = "SELECT * FROM $tabla WHERE Nivel = '$nivel'";
    $result_resultados = $conn->query($query_resultados);

    if ($result_resultados) {
        if ($result_resultados->num_rows > 0) {
            echo "<table class='table'>
                    <thead>
                        <tr>
                            <th>DNI_Atleta</th>
                            <th>Nombre_Atleta</th>
                            <th>Resultado</th>
                            <th>Lugar</th>
                            <th>Serie</th>
                            <th>Pista</th>
                            <th>Etapa</th>
                            <th>fecha_competencia</th>
                        </tr>
                    </thead>
                    <tbody>";

            while ($row = $result_resultados->fetch_assoc()) {
                // Obtener el nombre y el ID del atleta usando el DNI
                $dni_atleta = $row["DNI_Atleta"];
                $query_atleta_info = "SELECT id, nombre FROM atletas WHERE dni = '$dni_atleta'";
                $result_atleta_info = $conn->query($query_atleta_info);

                // Verificar si la consulta de información del atleta fue exitosa
                if ($result_atleta_info && $result_atleta_info->num_rows > 0) {
                    $atleta_info = $result_atleta_info->fetch_assoc();
                    $id_atleta = $atleta_info["id"];
                    $nombre_atleta = $atleta_info["nombre"];
                } else {
                    $id_atleta = "Desconocido";
                    $nombre_atleta = "Desconocido";
                }

                // Imprimir cada fila como una fila de la tabla
                echo "<tr>
                        <td>" . $dni_atleta . "</td>
                        <td>" . $nombre_atleta . "</td>
                        <td>" . $row["Resultado"] . "</td>
                        <td>" . $row["Lugar"] . "</td>
                        <td>" . $row["Serie"] . "</td>
                        <td>" . $row["Pista"] . "</td>
                        <td>" . $row["Nivel"] . "</td>
                        <td>" . $row["fecha_competencia"] . "</td>
                    </tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<p>No se encontraron resultados en la tabla $tabla.</p>";
        }
    } else {
        echo "<p>Error en la consulta: " . $conn->error . "</p>";
    }
}

// Verificar si se envió el formulario de agregar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dni"]) && isset($_POST["nivel"]) && isset($_POST["tabla"])) {
    // Obtener el DNI, el nivel, la tabla y la fecha del formulario
    $dni_ingresado = $_POST["dni"];
    $nivel_ingresado = $_POST["nivel"];
    $tabla_seleccionada = $_POST["tabla"];
    $fecha = $_POST["fecha_competencia"];

    // Llamar a la función para agregar atleta
    agregarAtleta($dni_ingresado, $nivel_ingresado, $tabla_seleccionada, $fecha);
}

// Verificar si se envió el formulario de eliminar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar_dni"]) && isset($_POST["tabla_eliminar"]) && isset($_POST["nivel_eliminar"])) {
    // Obtener el DNI, la tabla y el nivel a eliminar del formulario
    $dni_eliminar = $_POST["eliminar_dni"];
    $tabla_eliminar = $_POST["tabla_eliminar"];
    $nivel_eliminar = $_POST["nivel_eliminar"];

    // Llamar a la función para eliminar atleta con el nivel
    eliminarAtleta($dni_eliminar, $tabla_eliminar, $nivel_eliminar);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }

        .container {
            margin-top: 20px;
        }

        table {
            margin-top: 20px;
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
    </style>
    <title>Atletismo</title>
    <link rel="icon" href="https://www.shutterstock.com/image-vector/initial-letter-ap-logo-design-260nw-2343832111.jpg" type="image/png">
</head>
<body>
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

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var respuesta = JSON.parse(xhr.responseText);
            var horaCierre = respuesta.horaCierre;
            iniciarContador(horaCierre);
        }
        // Resto de tu código JavaScript aquí
    };

    window.onfocus = function () {
        // Esta función se ejecutará cuando la ventana vuelva a estar en foco

        // Recarga la página
        window.location.reload();
    };
</script>
<div id="container" class="content">
    <h2>RECUERDA QUE PASADO EL TIEMPO SE TE ECHARA DE LA SESIÓN</h2>
    <p>Tiempo restante : <span id="contador"></span></p>
</div>
<div class="text-center">
    <a class="btn btn-secondary mt-3" href="../usuarios/arbitro.php" style="background-color: green; border-color: green; color: white;">Volver al menú </a>
</div>

<div class="container">
    <h2 class="mb-4">Agregar Atleta</h2>

    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="mb-4">
        <div class="form-row">
            <div class="col-md-4">
                <label for="dni">Ingrese DNI:</label>
                <input type="text" id="dni" name="dni" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label for="nivel">Seleccione Etapa:</label>
                <select id="nivel" name="nivel" class="form-control" required>
                    <option value="DISTRITAL">DISTRITAL</option>
                    <option value="PROVINCIAL">PROVINCIAL</option>
                    <option value="REGIONAL">REGIONAL</option>
                </select>
            </div>

            <div class="col-md-4">
                <label for="tabla">Seleccione La Categoria:</label>
                <select id="tabla" name="tabla" class="form-control" required>
                    <option value="Resultados_600MetrosPlanos_CA">600MetrosPlanos</option>
                    <option value="Resultados_60MetrosVallas_CA">60MetrosVallas</option>
                    <option value="Resultados_60Metros_CA">60Metros</option>
                    <option value="Resultados_LanzamientoPelota_CA">LanzamientoPelota</option>
                    <option value="Resultados_SaltoLargo_CA">SaltoLargo</option>
                    <option value="Resultados_SaltoAlto_CA">SaltoAlto</option>
                </select>
            </div>

            <div class="col-md-4">
    <label for="fecha_competencia">Seleccione la Fecha de la competencia:</label>
    <input type="date" id="fecha_competencia" name="fecha_competencia" class="form-control" required>
</div>




            <div class="col-md-4">
                <button type="submit" class="btn btn-primary mt-4">Agregar Información</button>
            </div>
        </div>
    </form>
    <br>
    <h1>Eliminar atletas de las competencias </h1>
    <br><br>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="mb-4">
        <div class="form-row">
            <div class="col-md-4">
                <label for="eliminar_dni">Ingrese DNI a eliminar:</label>
                <input type="text" id="eliminar_dni" name="eliminar_dni" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label for="tabla_eliminar">Seleccione La Categoria para Eliminar:</label>
                <select id="tabla_eliminar" name="tabla_eliminar" class="form-control" required>
                <option value="Resultados_600MetrosPlanos_CA">600MetrosPlanos</option>
                    <option value="Resultados_60MetrosVallas_CA">60MetrosVallas</option>
                    <option value="Resultados_60Metros_CA">60Metros</option>
                    <option value="Resultados_LanzamientoPelota_CA">LanzamientoPelota</option>
                    <option value="Resultados_SaltoLargo_CA">SaltoLargo</option>
                    <option value="Resultados_SaltoAlto_CA">SaltoAlto</option>
                </select>
            </div>

            <!-- Dentro del formulario de eliminación -->
            <div class="col-md-4">
                <label for="nivel_eliminar">Seleccione Etapa:</label>
                <select id="nivel_eliminar" name="nivel_eliminar" class="form-control" required>
                    <option value="DISTRITAL">DISTRITAL</option>
                    <option value="PROVINCIAL">PROVINCIAL</option>
                    <option value="REGIONAL">REGIONAL</option>
                </select>
            </div>

            <div class="col-md-4">
                <button type="submit" class="btn btn-danger mt-4">Eliminar Atleta</button>
            </div>
        </div>
    </form>
    <br><br>
    <div class="text-center">
        <a class="btn btn-secondary mt-3" href="../categoria/editar_categoriaAgrupales.php"> Agregar Tetratlón, Relevo 4 x 50 Metros </a>
    </div>
    <br><br><br><br>
    <h1>Mostrar información de las competencias</h1>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="mb-4">
        <div class="form-row">
            <div class="col-md-4">
                <label for="tabla_mostrar">Seleccione Tabla para Mostrar:</label>
                <select id="tabla_mostrar" name="tabla_mostrar" class="form-control" required>
                    <option value="Resultados_600MetrosPlanos_CA">600MetrosPlanos</option>
                    <option value="Resultados_60MetrosVallas_CA">60MetrosVallas</option>
                    <option value="Resultados_60Metros_CA">60Metros</option>
                    <option value="Resultados_LanzamientoPelota_CA">LanzamientoPelota</option>
                    <option value="Resultados_SaltoLargo_CA">SaltoLargo</option>
                    <option value="Resultados_SaltoAlto_CA">SaltoAlto</option>
                </select>
            </div>

            <div class="col-md-4">
                <label for="nivel_mostrar">Seleccione Etapa:</label>
                <select id="nivel_mostrar" name="nivel_mostrar" class="form-control" required>
                    <option value="DISTRITAL">DISTRITAL</option>
                    <option value="PROVINCIAL">PROVINCIAL</option>
                    <option value="REGIONAL">REGIONAL</option>
                </select>
            </div>

            <div class="col-md-4">
                <button type="submit" class="btn btn-success mt-4">Mostrar Resultados</button>
            </div>
        </div>
    </form>

    <br>
    <br>
    <br>
    <?php
    // Verificar si se envió el formulario de mostrar resultados
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tabla_mostrar"]) && isset($_POST["nivel_mostrar"])) {
        // Obtener la tabla y el nivel a mostrar del formulario
        $tabla_mostrar = $_POST["tabla_mostrar"];
        $nivel_mostrar = $_POST["nivel_mostrar"];

        // Llamar a la función para mostrar resultados con filtro por nivel
        mostrarResultadosConFiltro($tabla_mostrar, $nivel_mostrar);
    }
    ?>
</div>

</body>
</html>

                   
