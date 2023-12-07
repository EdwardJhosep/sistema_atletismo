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

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}

function agregarAtletaPentatlon($dni, $nivel, $fechaCompetencia = null) {
    global $conn;

    // Verificar si el DNI ya está registrado en DISTRITAL, PROVINCIAL o REGIONAL
    $query_verificar_dni = "SELECT * FROM Resultados_Pentatlon_CB WHERE DNI_Atleta = '$dni' AND Nivel IN ('DISTRITAL', 'PROVINCIAL', 'REGIONAL')";
    $result_verificar_dni = $conn->query($query_verificar_dni);

    if ($result_verificar_dni && $result_verificar_dni->num_rows > 0) {
        echo "El atleta con DNI: $dni ya está registrado en la categoría DISTRITAL, PROVINCIAL o REGIONAL.<br>";
    } else {
        // Verificar si el DNI ya está registrado en Resultados_Pentatlon_CB
        $query_verificar_atleta = "SELECT * FROM Resultados_Pentatlon_CB WHERE DNI_Atleta = '$dni'";
        $result_verificar_atleta = $conn->query($query_verificar_atleta);

        if ($result_verificar_atleta && $result_verificar_atleta->num_rows == 0) {
            // El DNI no está registrado en ninguna categoría, se procede a agregarlo a PENTATLÓN
            $query_buscar_atleta = "SELECT * FROM atletas WHERE dni = '$dni'";
            $result_buscar_atleta = $conn->query($query_buscar_atleta);

            if ($result_buscar_atleta && $result_buscar_atleta->num_rows > 0) {
                $row_atleta = $result_buscar_atleta->fetch_assoc();
                $id_atleta = $row_atleta["id"];

                // Si no se proporciona una fecha de competencia, usa la fecha actual
                $fechaCompetencia = $fechaCompetencia ? $fechaCompetencia : date("Y-m-d");

                $query_insertar_resultado = "INSERT INTO Resultados_Pentatlon_CB (ID_Atleta, DNI_Atleta, 80mConVallas_Dia1, ImpulsionBala_Dia1, SaltoLargo_Dia1, SaltoAlto_Dia2, Distancia_600m_Dia2, Nivel, Fecha_Competencia)
                                             VALUES ('$id_atleta', '$dni', 0.0, 0.0, 0.0, 0.0, 0.0, '$nivel', '$fechaCompetencia')";
                $result_insertar_resultado = $conn->query($query_insertar_resultado);

                if ($result_insertar_resultado) {
                    echo "Se agregó el atleta con ID: $id_atleta, DNI: $dni, Nivel: $nivel y Fecha de Competencia: $fechaCompetencia a la tabla Resultados_Pentatlon_CB.<br>";
                } else {
                    echo "Error al agregar el resultado: " . $conn->error . "<br>";
                }
            } else {
                echo "No se encontró un atleta con DNI: $dni en la tabla atletas.<br>";
            }
        } else {
            echo "El atleta con DNI: $dni ya está registrado en la categoría PENTATLÓN.<br>";
        }
    }
}

// Función para agregar atleta a la tabla de Hexatlón
function agregarAtletaHexatlon($dni, $nivel, $fechaCompetencia = null) {
    global $conn;

    // Verificar si el DNI ya está registrado en DISTRITAL, PROVINCIAL o REGIONAL
    $query_verificar_dni = "SELECT * FROM Resultados_Hexatlon_CB WHERE DNI_Atleta = '$dni' AND Nivel IN ('DISTRITAL', 'PROVINCIAL', 'REGIONAL')";
    $result_verificar_dni = $conn->query($query_verificar_dni);

    if ($result_verificar_dni && $result_verificar_dni->num_rows > 0) {
        echo "El atleta con DNI: $dni ya está registrado en la categoría DISTRITAL, PROVINCIAL o REGIONAL.<br>";
    } else {
        // Verificar si el DNI ya está registrado en Resultados_Hexatlon_CB
        $query_verificar_atleta = "SELECT * FROM Resultados_Hexatlon_CB WHERE DNI_Atleta = '$dni'";
        $result_verificar_atleta = $conn->query($query_verificar_atleta);

        if ($result_verificar_atleta && $result_verificar_atleta->num_rows == 0) {
            // El DNI no está registrado en ninguna categoría, se procede a agregarlo a HEXATLÓN
            $query_buscar_atleta = "SELECT * FROM atletas WHERE dni = '$dni'";
            $result_buscar_atleta = $conn->query($query_buscar_atleta);

            if ($result_buscar_atleta && $result_buscar_atleta->num_rows > 0) {
                $row_atleta = $result_buscar_atleta->fetch_assoc();
                $id_atleta = $row_atleta["id"];

                // Si no se proporciona una fecha de competencia, usa la fecha actual
                $fechaCompetencia = $fechaCompetencia ? $fechaCompetencia : date("Y-m-d");

                $query_insertar_resultado = "INSERT INTO Resultados_Hexatlon_CB (ID_Atleta, DNI_Atleta, 100mConVallas_Dia1, ImpulsionBala_Dia1, SaltoLargo_Dia1, LanzamientoJabalina_Dia2, SaltoAlto_Dia2, Distancia_800m_Dia2, Nivel, Fecha_Competencia)
                                             VALUES ('$id_atleta', '$dni', 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, '$nivel', '$fechaCompetencia')";
                $result_insertar_resultado = $conn->query($query_insertar_resultado);

                if ($result_insertar_resultado) {
                    echo "Se agregó el atleta con ID: $id_atleta, DNI: $dni y Nivel: $nivel a la tabla Resultados_Hexatlon_CB.<br>";
                } else {
                    echo "Error al agregar el resultado: " . $conn->error . "<br>";
                }
            } else {
                echo "No se encontró un atleta con DNI: $dni en la tabla atletas.<br>";
            }
        } else {
            echo "El atleta con DNI: $dni ya está registrado en la categoría HEXATLÓN.<br>";
        }
    }
}

// Función para agregar equipo de relevo de 5 atletas por DNI, nivel y tabla
function agregarEquipoRelevo5x80Metros($dni1, $dni2, $dni3, $dni4, $dni5, $nivel, $tabla, $fechaCompetencia = null) {
    global $conn;

    // Buscar atletas por DNI en la tabla atletas
    $query_buscar_atletas = "SELECT * FROM atletas WHERE dni IN ('$dni1', '$dni2', '$dni3', '$dni4', '$dni5')";
    $result_buscar_atletas = $conn->query($query_buscar_atletas);

    if ($result_buscar_atletas && $result_buscar_atletas->num_rows == 5) {
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
                DNI_Atleta5 = '$dni5' AND Nivel = '$nivel_atletas'";

            $result_verificar_relevo = $conn->query($query_verificar_relevo);

            if ($result_verificar_relevo && $result_verificar_relevo->num_rows == 0) {
                // Si no se proporciona una fecha de competencia, usa la fecha actual
                $fechaCompetencia = $fechaCompetencia ? $fechaCompetencia : date("Y-m-d");

                // Insertar nuevo resultado de relevo en la tabla seleccionada
                $query_insertar_resultado = "INSERT INTO $tabla (
                    ID_Atleta1, DNI_Atleta1, ID_Atleta2, DNI_Atleta2, 
                    ID_Atleta3, DNI_Atleta3, ID_Atleta4, DNI_Atleta4, 
                    ID_Atleta5, DNI_Atleta5, Resultado, Lugar, Serie, Pista, Nivel, Fecha_Competencia
                ) VALUES (
                    '{$atletas[0]['id']}', '{$atletas[0]['dni']}', '{$atletas[1]['id']}', '{$atletas[1]['dni']}', 
                    '{$atletas[2]['id']}', '{$atletas[2]['dni']}', '{$atletas[3]['id']}', '{$atletas[3]['dni']}', 
                    '{$atletas[4]['id']}', '{$atletas[4]['dni']}', '0.0', 0, 0, '', '$nivel_atletas', '$fechaCompetencia'
                )";

                $result_insertar_resultado = $conn->query($query_insertar_resultado);

                if ($result_insertar_resultado) {
                    echo "Se agregó el equipo de relevo con DNI: $dni1, $dni2, $dni3, $dni4, $dni5, Nivel: $nivel_atletas y Fecha de Competencia: $fechaCompetencia a la tabla $tabla.<br>";
                } else {
                    echo "Error al agregar el equipo de relevo: " . $conn->error . "<br>";
                }
            } else {
                echo "El equipo de relevo ya existe en el nivel $nivel_atletas de la tabla $tabla.<br>";
            }
        } else {
            echo "Los atletas deben pertenecer al mismo nivel (DISTRITAL, PROVINCIAL, REGIONAL).<br>";
        }
    } else {
        echo "No se encontraron los atletas necesarios en la tabla atletas.<br>";
    }
}




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los datos del formulario
    $nivel = isset($_POST["nivel"]) ? $_POST["nivel"] : "";
    $dni = isset($_POST["dni"]) ? $_POST["dni"] : "";

    // Valida y sanitiza la entrada si es necesario

    // Consulta para eliminar resultados de Pentatlón
    $query_eliminar_pentatlon = "DELETE FROM Resultados_Pentatlon_CB WHERE DNI_Atleta = '$dni' AND Nivel = '$nivel'";
    $result_eliminar_pentatlon = $conn->query($query_eliminar_pentatlon);

    // Consulta para eliminar resultados de Hexatlón
    $query_eliminar_hexatlon = "DELETE FROM Resultados_Hexatlon_CB WHERE DNI_Atleta = '$dni' AND Nivel = '$nivel'";
    $result_eliminar_hexatlon = $conn->query($query_eliminar_hexatlon);

    // Consulta para eliminar resultados de Relevo 5x80 Metros
    $query_eliminar_relevo = "DELETE FROM Resultados_Relevo5x80Metros_CB WHERE
        DNI_Atleta1 = '$dni' OR
        DNI_Atleta2 = '$dni' OR
        DNI_Atleta3 = '$dni' OR
        DNI_Atleta4 = '$dni' OR
        DNI_Atleta5 = '$dni' AND Nivel = '$nivel'";
    $result_eliminar_relevo = $conn->query($query_eliminar_relevo);

    if ($result_eliminar_pentatlon && $result_eliminar_hexatlon && $result_eliminar_relevo) {
        echo "Resultados exitoso: $dni y Nivel: $nivel.";
    } else {
        echo "Error al eliminar resultados: " . $conn->error;
        echo "Pentatlón: " . $conn->error . "<br>";
        echo "Hexatlón: " . $conn->error . "<br>";
        echo "Relevo: " . $conn->error . "<br>";
    }
    
}

// Verificar si se envió el formulario de agregar resultados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["tipo"])) {
        $tipo = $_POST["tipo"];

        if ($tipo == "pentatlon") {
            $dni = $_POST["dni"];
            $nivel = $_POST["nivel"];
            agregarAtletaPentatlon($dni, $nivel);
        } elseif ($tipo == "hexatlon") {
            $dni = $_POST["dni"];
            $nivel = $_POST["nivel"];
            agregarAtletaHexatlon($dni, $nivel);
        } elseif ($tipo == "relevo") {
            $dni1 = $_POST["dni1"];
            $dni2 = $_POST["dni2"];
            $dni3 = $_POST["dni3"];
            $dni4 = $_POST["dni4"];
            $dni5 = $_POST["dni5"];
            $nivel = $_POST["nivel"];

            try {
                agregarEquipoRelevo5x80Metros($dni1, $dni2, $dni3, $dni4, $dni5, $nivel, "resultados_relevo5x80metros_cb");
                echo "";
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
}

.container {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    color: #007bff;
}

label {
    font-weight: bold;
}

.form-control {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    margin-bottom: 15px;
    box-sizing: border-box;
    border: 1px solid #ced4da;
    border-radius: 4px;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
    cursor: pointer;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

/* Estilo adicional para casillas de Relevo 5 x 80 Metros */
#casillasRelevo input {
    margin-bottom: 5px;
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
    };

    window.onfocus = function() {
        // Esta función se ejecutará cuando la ventana vuelva a estar en foco

        // Recarga la página
        window.location.reload();
    };
</script>

<div class="container text-center">
    <h1 class="mb-4">CATEGORÍA B</h1>
    <div class="alert alert-warning">
        <h2>RECUERDA QUE PASADO EL TIEMPO SE TE ECHARÁ DE LA SESIÓN</h2>
        <p>Tiempo restante: <span id="contador"></span></p>
    </div>
    <div class="text-center">
    <a class="btn btn-secondary mt-3" href="../usuarios/arbitro.php" style="background-color: green; border-color: green; color: white;">Volver al menú </a>
</div>
</div>

<div class="container">
    <h2 class="mb-4">Agregar Atleta o Equipo</h2>

    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="mb-4">
        <div class="form-row">
            <div class="col-md-4" id="campoDNI">
                <label for="dni">Ingrese DNI:</label>
                <input type="text" name="dni" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="nivel">Seleccione Nivel:</label>
                <select name="nivel" class="form-control" required>
                    <option value="DISTRITAL">DISTRITAL</option>
                    <option value="REGIONAL">REGIONAL</option>
                    <option value="PROVINCIAL">PROVINCIAL</option>
                </select>
            </div>
        </div>

        <div class="form-row mt-3">
            <div class="col">
                <label for="tipo">Seleccione Tipo:</label>
                <select name="tipo" id="tipo" class="form-control" required>
                    <option value="pentatlon">Pentatlón</option>
                    <option value="hexatlon">Hexatlón</option>
                    <option value="relevo">Relevo 5 x 80 Metros</option>
                </select>
            </div>
        </div>
        <!-- Casillas adicionales para DNI de atletas en caso de Relevo 5 x 80 Metros -->
        <div class="form-row mt-3" id="casillasRelevo" style="display:none;">
            <div class="col-md-12">
                <label>DNI Atletas:</label>
            </div>
            <div class="col-md-3">
                <label for="dni1">Atleta 1:</label>
                <input type="text" name="dni1" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="dni2">Atleta 2:</label>
                <input type="text" name="dni2" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="dni3">Atleta 3:</label>
                <input type="text" name="dni3" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="dni4">Atleta 4:</label>
                <input type="text" name="dni4" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="dni5">Atleta 5:</label>
                <input type="text" name="dni5" class="form-control">
            </div>
        </div>
        <div class="form-row mt-3">
    <div class="col-md-4">
        <label for="fecha_competencia">Fecha de Competencia:</label>
        <input type="date" name="fecha_competencia" class="form-control">
    </div>
</div>
        <div class="form-row mt-3">
            <div class="col">
                <button type="submit" class="btn btn-primary">Agregar</button>
            </div>
        </div>
    </form>
</div>
 <!-- Agregar enlaces a Bootstrap JS y Popper.js al final del body para un mejor rendimiento -->
 <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Script JavaScript para mostrar/ocultar casillas de DNI y campo DNI según el tipo seleccionado -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tipo = document.getElementById('tipo');
            var casillasRelevo = document.getElementById('casillasRelevo');
            var campoDNI = document.getElementById('campoDNI');

            // Mostrar u ocultar campos al cargar la página
            toggleCampos();

            // Evento para cambiar la visibilidad de los campos al cambiar el tipo
            tipo.addEventListener('change', function () {
                toggleCampos();
            });

            function toggleCampos() {
                if (tipo.value === 'relevo') {
                    casillasRelevo.style.display = 'flex';
                    campoDNI.style.display = 'none';
                    // Desactivar validación del campo DNI
                    document.querySelector('#campoDNI input').removeAttribute('required');
                } else {
                    casillasRelevo.style.display = 'none';
                    campoDNI.style.display = 'block';
                    // Activar validación del campo DNI
                    document.querySelector('#campoDNI input').setAttribute('required', 'required');
                }
            }
        });
    </script>
    
    <div class="container">
        <h2 class="mb-4">Eliminar Resultados</h2>

        <form method="post" action="editar_categoriaBgrupales.php">
            <div class="form-group">
                <label for="nivel">Selecciona Nivel:</label>
                <select name="nivel" class="form-control" required>
                    <option value="DISTRITAL">DISTRITAL</option>
                    <option value="PROVINCIAL">PROVINCIAL</option>
                    <option value="REGIONAL">REGIONAL</option>
                </select>
            </div>

            <div class="form-group">
                <label for="tabla">Selecciona Tabla:</label>
                <select name="tabla" class="form-control" required>
                    <option value="Resultados_Pentatlon_CB">Resultados Pentatlón</option>
                    <option value="Resultados_Hexatlon_CB">Resultados Hexatlón</option>
                    <option value="Resultados_Relevo5x80Metros_CB">Resultados Relevo 5 x 80 Metros</option>
                </select>
            </div>

            <div class="form-group">
                <label for="dni">DNI del Atleta:</label>
                <input type="text" name="dni" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-danger">Eliminar Resultados</button>
        </form>
    </div>
</form>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados Deportivos</title>
    <!-- Enlace a Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mb-4">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="tabla">Seleccionar Tabla:</label>
                <select name="tabla" id="tabla" class="form-control">
                    <option value="relevo">Resultados Relevo</option>
                    <option value="pentatlon">Resultados Pentatlón</option>
                    <option value="hexatlon">Resultados Hexatlón</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="nivel">Seleccionar Nivel:</label>
                <select name="nivel" id="nivel" class="form-control">
                    <option value="DISTRITAL">DISTRITAL</option>
                    <option value="REGIONAL">REGIONAL</option>
                    <option value="PROVINCIAL">PROVINCIAL</option>
                </select>
            </div>
            <div class="form-group col-md-2">
                <button type="submit" name="mostrar" class="btn btn-primary">Mostrar Resultados</button>
            </div>
        </div>
    </form>

    <?php
function mostrarFila($row) {
    echo "<tr>";
    foreach ($row as $valor) {
        echo "<td>$valor</td>";
    }
    echo "</tr>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mostrar"])) {
    $tabla_seleccionada = $_POST["tabla"];
    $nivel_seleccionado = $_POST["nivel"];

    switch ($tabla_seleccionada) {
        case "relevo":
            $sql = "SELECT * FROM resultados_relevo5x80metros_cb WHERE Nivel = '$nivel_seleccionado'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<h2 class='mt-4'>Resultados Relevo ($nivel_seleccionado)</h2>";
                echo "<div class='table-responsive'>";
                echo "<table class='table table-bordered'>";
                echo "<thead class='thead-light'><tr><th>ID_Atleta1</th><th>DNI_Atleta1</th><th>ID_Atleta2</th><th>DNI_Atleta2</th><th>ID_Atleta3</th><th>DNI_Atleta3</th><th>ID_Atleta4</th><th>DNI_Atleta4</th><th>ID_Atleta5</th><th>DNI_Atleta5</th><th>Resultado</th><th>Lugar</th><th>Serie</th><th>Pista</th><th>Nivel</th><th>Anio</th><th>Fecha_Registro</th><th>Fecha_Competencia</th></tr></thead><tbody>";
                while ($row = $result->fetch_assoc()) {
                    mostrarFila($row);
                }
                echo "</tbody></table>";
                echo "</div>";
            } else {
                echo "<p class='mt-3'>No hay resultados en el nivel $nivel_seleccionado.</p>";
            }
            break;

        case "pentatlon":
            $sql = "SELECT * FROM resultados_pentatlon_cb WHERE Nivel = '$nivel_seleccionado'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<h2 class='mt-4'>Resultados Pentatlón ($nivel_seleccionado)</h2>";
                echo "<div class='table-responsive'>";
                echo "<table class='table table-bordered'>";
                echo "<thead class='thead-light'><tr><th>ID_Atleta</th><th>DNI_Atleta</th><th>80mConVallas_Dia1</th><th>ImpulsionBala_Dia1</th><th>SaltoLargo_Dia1</th><th>SaltoAlto_Dia2</th><th>Distancia_600m_Dia2</th><th>Nivel</th><th>Anio</th><th>Fecha_Registro</th><th>Fecha_Competencia</th></tr></thead><tbody>";
                while ($row = $result->fetch_assoc()) {
                    mostrarFila($row);
                }
                echo "</tbody></table>";
                echo "</div>";
            } else {
                echo "<p class='mt-3'>No hay resultados en el nivel $nivel_seleccionado.</p>";
            }
            break;

        case "hexatlon":
            $sql = "SELECT * FROM resultados_hexatlon_cb WHERE Nivel = '$nivel_seleccionado'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<h2 class='mt-4'>Resultados Hexatlón ($nivel_seleccionado)</h2>";
                echo "<div class='table-responsive'>";
                echo "<table class='table table-bordered'>";
                echo "<thead class='thead-light'><tr><th>ID_Atleta</th><th>DNI_Atleta</th><th>100mConVallas_Dia1</th><th>ImpulsionBala_Dia1</th><th>SaltoLargo_Dia1</th><th>LanzamientoJabalina_Dia2</th><th>SaltoAlto_Dia2</th><th>Distancia_800m_Dia2</th><th>Nivel</th><th>Anio</th><th>Fecha_Registro</th><th>Fecha_Competencia</th></thead><tbody>";
                while ($row = $result->fetch_assoc()) {
                    mostrarFila($row);
                }
                echo "</tbody></table>";
                echo "</div>";
            } else {
                echo "<p class='mt-3'>No hay resultados en el nivel $nivel_seleccionado.</p>";
            }
            break;

        default:
            echo "<p class='mt-3'>Tabla no válida.</p>";
    }
}
?>

</div>

<!-- Enlace a Bootstrap JS y jQuery (opcional) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
