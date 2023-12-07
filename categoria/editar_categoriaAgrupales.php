<?php
session_start();

if (isset($_POST['logout'])) {
    // Destruir la sesión primero
    session_destroy();

    // Luego, redirigir al usuario a la página de inicio de sesión
    header("Location: ../login/login.html");
    exit();
}

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.html");
    exit();
}

// Conexión a la base de datos (reemplazar con tus propios datos)
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

// Función para agregar atleta de relevo por DNI, nivel, tabla y fecha de competencia
function agregarRelevo($dni1, $dni2, $dni3, $dni4, $nivel, $tabla, $fecha_competencia) {
    global $conn;

    // Buscar atletas por DNI en la tabla atletas
    $query_buscar_atletas = "SELECT * FROM atletas WHERE dni IN ('$dni1', '$dni2', '$dni3', '$dni4')";
    $result_buscar_atletas = $conn->query($query_buscar_atletas);

    if ($result_buscar_atletas && $result_buscar_atletas->num_rows == 4) {
        $atletas = [];
        while ($row_atleta = $result_buscar_atletas->fetch_assoc()) {
            $atletas[] = [
                'id' => $row_atleta['id'],
                'nombre' => $row_atleta['nombre'],
                'dni' => $row_atleta['dni'],
                'nivel' => $nivel
            ];
        }

        // Verificar si los atletas pertenecen al mismo nivel
        $niveles = array_unique(array_column($atletas, 'nivel'));
        if (count($niveles) == 1 && isset($niveles[0])) {
            $nivel_atletas = $niveles[0];

            // Verificar si ya existe el relevo en la tabla y nivel especificados
            $query_verificar_relevo = "SELECT * FROM $tabla WHERE 
                DNI_Atleta1 = '$dni1' AND DNI_Atleta2 = '$dni2' AND 
                DNI_Atleta3 = '$dni3' AND DNI_Atleta4 = '$dni4' AND 
                Nivel = '$nivel_atletas'";

            $result_verificar_relevo = $conn->query($query_verificar_relevo);

            if ($result_verificar_relevo && $result_verificar_relevo->num_rows == 0) {
                // Insertar nuevo resultado de relevo en la tabla seleccionada con la fecha de competencia
                $query_insertar_resultado = "INSERT INTO $tabla (
                    ID_Atleta1, DNI_Atleta1, ID_Atleta2, DNI_Atleta2, 
                    ID_Atleta3, DNI_Atleta3, ID_Atleta4, DNI_Atleta4, 
                    Resultado, Lugar, Serie, Pista, Nivel, Fecha_Competencia
                ) VALUES (
                    '{$atletas[0]['id']}', '{$atletas[0]['dni']}', '{$atletas[1]['id']}', '{$atletas[1]['dni']}', 
                    '{$atletas[2]['id']}', '{$atletas[2]['dni']}', '{$atletas[3]['id']}', '{$atletas[3]['dni']}', 
                    '0.0', 0, 0, '', '$nivel_atletas', '$fecha_competencia'
                )";

                $result_insertar_resultado = $conn->query($query_insertar_resultado);

                if ($result_insertar_resultado) {
                    echo "Se agregó el relevo con DNI: $dni1, $dni2, $dni3, $dni4 y Nivel: $nivel_atletas a la tabla $tabla.<br>";
                } else {
                    echo "Error al agregar el relevo: " . $conn->error . "<br>";
                }
            } else {
                echo "El relevo ya existe en el nivel $nivel_atletas de la tabla $tabla.<br>";
            }
        } else {
            echo "Los atletas deben pertenecer al mismo nivel (DISTRITAL, PROVINCIAL, REGIONAL).<br>";
        }
    } else {
        echo "No se encontraron los atletas necesarios en la tabla atletas.<br>";
    }
}

// Función para agregar resultados de tetratlón por DNI, nivel, tabla y fecha de competencia
function agregarTetratlon($dni, $nivel, $tabla, $fecha_competencia) {
    global $conn;

    // Verificar si el DNI ya existe en la tabla de resultados de tetratlón para el mismo nivel
    $query_verificar_dni_nivel = "SELECT * FROM $tabla WHERE DNI_Atleta = '$dni' AND Nivel = '$nivel'";
    $result_verificar_dni_nivel = $conn->query($query_verificar_dni_nivel);

    if ($result_verificar_dni_nivel && $result_verificar_dni_nivel->num_rows > 0) {
        echo "El DNI $dni ya tiene resultados para el nivel $nivel.<br>";
        return; // Detener la ejecución de la función si ya tiene resultados para el mismo nivel
    }

    // Buscar atleta por DNI en la tabla atletas
    $query_buscar_atleta = "SELECT * FROM atletas WHERE dni = '$dni'";
    $result_buscar_atleta = $conn->query($query_buscar_atleta);

    if ($result_buscar_atleta && $result_buscar_atleta->num_rows > 0) {
        $row_atleta = $result_buscar_atleta->fetch_assoc();
        $id_atleta = $row_atleta["id"];

        // Insertar nuevo resultado de tetratlón en la tabla seleccionada con la fecha de competencia
        $query_insertar_resultado = "INSERT INTO $tabla (
            ID_Atleta, DNI_Atleta, Nivel, Fecha_Competencia
        ) VALUES (
            '$id_atleta', '$dni', '$nivel', '$fecha_competencia'
        )";

        $result_insertar_resultado = $conn->query($query_insertar_resultado);

        if ($result_insertar_resultado) {
            echo "Se agregaron los resultados del tetratlón con DNI: $dni a la tabla $tabla.<br>";
        } else {
            echo "Error al agregar los resultados del tetratlón: " . $conn->error . "<br>";
        }
    } else {
        echo "No se encontró un atleta con DNI: $dni en la tabla atletas.<br>";
    }
}

// ... (Otras funciones permanecen sin cambios)

// Verificar si se envió el formulario para agregar resultados de relevo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dni1"]) && isset($_POST["dni2"]) && isset($_POST["dni3"]) && isset($_POST["dni4"]) && isset($_POST["nivel_relevo"]) && isset($_POST["tabla_relevo"]) && isset($_POST["fecha_competencia"])) {
    $dni1_ingresado = $_POST["dni1"];
    $dni2_ingresado = $_POST["dni2"];
    $dni3_ingresado = $_POST["dni3"];
    $dni4_ingresado = $_POST["dni4"];
    $nivel_relevo_ingresado = $_POST["nivel_relevo"];
    $tabla_relevo_seleccionada = $_POST["tabla_relevo"];
    $fecha_competencia = $_POST["fecha_competencia"];

    agregarRelevo($dni1_ingresado, $dni2_ingresado, $dni3_ingresado, $dni4_ingresado, $nivel_relevo_ingresado, $tabla_relevo_seleccionada, $fecha_competencia);
}
// Verificar si se envió el formulario para agregar resultados de tetratlón
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dni_tetratlon"]) && isset($_POST["nivel_tetratlon"]) && isset($_POST["tabla_tetratlon"]) && isset($_POST["fecha_competencia_tetratlon"])) {
    $dni_tetratlon_ingresado = $_POST["dni_tetratlon"];
    $nivel_tetratlon_ingresado = $_POST["nivel_tetratlon"];
    $tabla_tetratlon_seleccionada = $_POST["tabla_tetratlon"];
    $fecha_competencia_tetratlon = $_POST["fecha_competencia_tetratlon"];

    agregarTetratlon($dni_tetratlon_ingresado, $nivel_tetratlon_ingresado, $tabla_tetratlon_seleccionada, $fecha_competencia_tetratlon);
}

// Eliminar resultado de Relevo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar_relevo_id"])) {
    $eliminar_relevo_id = $_POST["eliminar_relevo_id"];
    
    // Realiza la lógica para eliminar el resultado de relevos con el ID proporcionado
    $query_eliminar_relevo = "DELETE FROM Resultados_Relevo4x50Metros_CA WHERE ID_Atleta1 = $eliminar_relevo_id";
    $result_eliminar_relevo = $conn->query($query_eliminar_relevo);

    if ($result_eliminar_relevo) {
        echo "Resultado de relevo eliminado correctamente.";
    } else {
        echo "Error al eliminar resultado de relevo: " . $conn->error;
    }
}

// Eliminar resultado de Tetratlón
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar_tetratlon_id"])) {
    $eliminar_tetratlon_id = $_POST["eliminar_tetratlon_id"];
    
    // Realiza la lógica para eliminar el resultado de tetratlón con el ID proporcionado
    $query_eliminar_tetratlon = "DELETE FROM Resultados_Tetratlon_CA WHERE ID_Atleta = $eliminar_tetratlon_id";
    $result_eliminar_tetratlon = $conn->query($query_eliminar_tetratlon);

    if ($result_eliminar_tetratlon) {
        echo "Resultado de tetratlón eliminado correctamente.";
    } else {
        echo "Error al eliminar resultado de tetratlón: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<link rel="icon" href="https://www.shutterstock.com/image-vector/initial-letter-ap-logo-design-260nw-2343832111.jpg" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tu Título</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Include jQuery, Popper.js, and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
        body {
            padding-top: 56px;
            font-family: 'Helvetica', sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 20px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            margin-bottom: 1rem;
            color: #495057;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table th,
        table td {
            padding: 12px;
            border: 1px solid #dee2e6;
            text-align: center;
        }

        th {
            background-color: #f8f9fa;
            border-radius: 4px 4px 0 0;
        }

        tbody tr:hover {
            background-color: #f5f5f5;
        }

        .resultados,
        .cuadro-resultados {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 15px;
        }

        .resultados h2,
        .cuadro-resultados h2 {
            margin-bottom: 10px;
        }

        .cuadro-resultados hr {
            height: 1px;
            margin: 5px 0;
            border: none;
            background-color: #ccc;
        }

        .row {
            margin-bottom: 10px;
        }

        /* Customize your additional styles below */

        /* Example: Make buttons slightly rounded */
        .btn {
            border-radius: 4px;
        }

        /* Example: Add some margin to the top of buttons */
        .mt-3,
        .mt-4 {
            margin-top: 15px;
        }

        /* Example: Adjust font size for smaller screens */
        @media (max-width: 768px) {
            .col-md-2 {
                font-size: 10px;
            }
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
    table {
            width: 100%;
            margin-bottom: 1rem;
            color: #495057;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            padding: 12px;
            border: 1px solid #dee2e6;
            text-align: center;
        }

        th {
            background-color: #f8f9fa;
            border-radius: 4px 4px 0 0;
        }

        tbody tr:hover {
            background-color: #f5f5f5;
        }

        /* Estilo para la sección de resultados */
        .resultados {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Estilo para los botones de eliminar */
        .btn-eliminar {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }
    </style>
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
    <div id="container" class="content">
        <h2>RECUERDA QUE PASADO EL TIEMPO SE TE ECHARA DE LA SESIÓN</h2>
        <p>Tiempo restante : <span id="contador"></span></p>
    </div>
    <div class="text-center">
    <a class="btn btn-secondary mt-3" href="../usuarios/arbitro.php" style="background-color: green; border-color: green; color: white;">Volver al menú </a>
</div>
<div class="container">
        <h2 class="mb-4">Agregar Relevo 4 x 50 Metros</h2>
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="mb-4">
            <div class="form-row">
                <div class="col-md-3">
                    <label for="dni1">DNI Atleta 1:</label>
                    <input type="text" id="dni1" name="dni1" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label for="dni2">DNI Atleta 2:</label>
                    <input type="text" id="dni2" name="dni2" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label for="dni3">DNI Atleta 3:</label>
                    <input type="text" id="dni3" name="dni3" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label for="dni4">DNI Atleta 4:</label>
                    <input type="text" id="dni4" name="dni4" class="form-control" required>
                </div>

                <div class="col-md-3">
                    <label for="nivel_relevo">Seleccione Etapa:</label>
                    <select id="nivel_relevo" name="nivel_relevo" class="form-control" required>
                        <option value="DISTRITAL">DISTRITAL</option>
                        <option value="PROVINCIAL">PROVINCIAL</option>
                        <option value="REGIONAL">REGIONAL</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="tabla_relevo">Seleccione La Categoria:</label>
                    <select id="tabla_relevo" name="tabla_relevo" class="form-control" required>
                        <option value="Resultados_Relevo4x50Metros_CA">Relevo 4 x 50 Metros</option>
                        <!-- Agregar opciones para otras categorías de relevo si es necesario -->
                    </select>
                </div>
                <div class="col-md-3">
    <label for="fecha_competencia_relevo">Fecha de Competencia:</label>
    <input type="date" id="fecha_competencia_relevo" name="fecha_competencia" class="form-control" required>
</div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary mt-4">Agregar Relevo</button>
                </div>
            </div>
        </form>
    <div class="cuadro-resultados">
        <h2 class="mb-4">Agregar Tetratlón</h2>
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="mb-4">
            <div class="form-row">
                <div class="col-md-4">
                <label for="dni_tetratlon">Ingrese DNI Atleta:</label>
                    <input type="text" id="dni_tetratlon" name="dni_tetratlon" class="form-control" required>
                </div>

                <div class="col-md-3">
                    <label for="nivel_tetratlon">Seleccione Etapa:</label>
                    <select id="nivel_tetratlon" name="nivel_tetratlon" class="form-control" required>
                        <option value="DISTRITAL">DISTRITAL</option>
                        <option value="PROVINCIAL">PROVINCIAL</option>
                        <option value="REGIONAL">REGIONAL</option>
                        <!-- Agregar más opciones según sea necesario -->
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="tabla_tetratlon">Seleccione La Categoria:</label>
                    <select id="tabla_tetratlon" name="tabla_tetratlon" class="form-control" required>
                        <option value="Resultados_Tetratlon_CA">Tetratlón</option>
                        <!-- Agregar más opciones según sea necesario -->
                    </select>
                </div>
                <div class="col-md-3">
    <label for="fecha_competencia_tetratlon">Fecha de Competencia:</label>
    <input type="date" id="fecha_competencia_tetratlon" name="fecha_competencia_tetratlon" class="form-control" required>
</div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary mt-4">Agregar Tetratlón</button>
                </div>
            </div>
        </form>
    </div>

 <!-- ... (Resto del contenido permanece sin cambios) ... -->


 <div class="cuadro-resultados" style='color: black;'>
    <h2>Resultados Relevo 4 x 50 Metros</h2>
    
    <?php
    $query_resultados_relevo = "SELECT * FROM Resultados_Relevo4x50Metros_CA";
    $result_resultados_relevo = $conn->query($query_resultados_relevo);

    $resultados_por_nivel_relevo = array();

    if ($result_resultados_relevo->num_rows > 0) {
        while ($row_relevo = $result_resultados_relevo->fetch_assoc()) {
            $nivel_relevo = $row_relevo['Nivel'];

            if (!isset($resultados_por_nivel_relevo[$nivel_relevo])) {
                $resultados_por_nivel_relevo[$nivel_relevo] = array();
            }

            $resultados_por_nivel_relevo[$nivel_relevo][] = $row_relevo;
        }
    }

    // Display results grouped by Nivel
    foreach ($resultados_por_nivel_relevo as $nivel_relevo => $resultados_relevo) {
        echo "<h3>Nivel: $nivel_relevo</h3>";

        echo "<form method='post' action='{$_SERVER["PHP_SELF"]}'>";
        foreach ($resultados_relevo as $row_relevo) {
            // Display individual results as before
            echo "<div class='row'>";
            echo "<div class='col-md-2'>DNI Atleta 1: " . $row_relevo['DNI_Atleta1'] . "</div>";
            echo "<div class='col-md-2'>DNI Atleta 2: " . $row_relevo['DNI_Atleta2'] . "</div>";
            echo "<div class='col-md-2'>DNI Atleta 3: " . $row_relevo['DNI_Atleta3'] . "</div>";
            echo "<div class='col-md-2'>DNI Atleta 4: " . $row_relevo['DNI_Atleta4'] . "</div>";
            echo "<div class='col-md-2'>Etapa: <BR>" . $row_relevo['Nivel'] . "</div>";
            echo "<div class='col-md-2'>Categoria: Relevo 4 x 50 Metros</div>";
            echo "<div class='col-md-2'>";
            echo "<button type='submit' class='btn btn-danger' name='eliminar_relevo_id' value='{$row_relevo['ID_Atleta1']}'>Eliminar</button>";
            echo "</div>";
            echo "</div>";
            echo "<hr>"; 
        }
        echo "</form>";
    }

    ?>
</div>

<!-- ... (Resto del contenido permanece sin cambios) ... -->

<div class="resultados" style='color: black;'>
    <h2>Resultados Tetratlón</h2>
    <!-- Asegúrate de que el formulario tenga un método POST y un campo oculto "eliminar_tetratlon_id" cuando se desee eliminar un resultado -->
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
    
    <?php
    $query_resultados_tetratlon = "SELECT * FROM Resultados_Tetratlon_CA";
    $result_resultados_tetratlon = $conn->query($query_resultados_tetratlon);

    $resultados_por_nivel_tetratlon = array();

    if ($result_resultados_tetratlon->num_rows > 0) {
        while ($row_tetratlon = $result_resultados_tetratlon->fetch_assoc()) {
            $nivel_tetratlon = $row_tetratlon['Nivel'];

            if (!isset($resultados_por_nivel_tetratlon[$nivel_tetratlon])) {
                $resultados_por_nivel_tetratlon[$nivel_tetratlon] = array();
            }

            $resultados_por_nivel_tetratlon[$nivel_tetratlon][] = $row_tetratlon;
        }
    }

    // Display results grouped by Nivel
    foreach ($resultados_por_nivel_tetratlon as $nivel_tetratlon => $resultados_tetratlon) {
        echo "<h3>Nivel: $nivel_tetratlon</h3>";

        foreach ($resultados_tetratlon as $row_tetratlon) {
            // Display individual results as before
            echo "<hr>";
            echo "<div class='athlete-container'>";
            echo "<div class='row'>";
            echo "<div style='width: 8%; display: inline-block;'>DNI Atleta:<br> " . $row_tetratlon['DNI_Atleta'] . "</div>";
            echo "<div style='width: 9%; display: inline-block;'>Vallas 60m: <br>" . $row_tetratlon['Vallas_60m_Dia1'] . "</div>";
            echo "<div style='width: 13%; display: inline-block;'>Lugar Vallas 60m:<br> " . $row_tetratlon['Vallas_60m_Lugar_Dia1'] . "</div>";
            echo "<div style='width: 9%; display: inline-block;'>Salto Largo:<br> " . $row_tetratlon['SaltoLargo_Dia2'] . "</div>";
            echo "<div style='width: 13%; display: inline-block;'>Lugar Salto Largo:<br> " . $row_tetratlon['SaltoLargo_Lugar_Dia2'] . "</div>";
            echo "<div style='width: 11%; display: inline-block;'>Distancia 600m:<br> " . $row_tetratlon['Distancia_600m_Dia2'] . "</div>";
            echo "<div style='width: 15%; display: inline-block;'>Lugar Distancia 600m:<br> " . $row_tetratlon['Distancia_600m_Lugar_Dia2'] . "</div>";
            echo "<div style='width: 10%; display: inline-block;'>Etapa: <br>" . $row_tetratlon['Nivel'] . "</div>";
            echo "<div style='width: 11%; display: inline-block;'>Categoria: <br>Tetratlón</div>";
            echo "<div style='width: 10%; display: inline-block;'>";
            echo "<br>";
            echo "<button type='submit' class='btn btn-danger' name='eliminar_tetratlon_id' value='{$row_tetratlon['ID_Atleta']}'>Eliminar</button>";
            echo "</div>";
            echo "</div>";
            echo "<hr>";
            echo "</div>";
        }
    }

?>


    </form>
</div>
</div>

</body>
</html>
