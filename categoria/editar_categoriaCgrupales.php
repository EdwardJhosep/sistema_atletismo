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
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para agregar resultados de relevo 4x100 metros
function agregarRelevo4x100Metros($dni1, $dni2, $dni3, $dni4, $nivel, $tabla) {
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
                // Insertar nuevo resultado de relevo en la tabla seleccionada
                $query_insertar_resultado = "INSERT INTO $tabla (
                    ID_Atleta1, DNI_Atleta1, ID_Atleta2, DNI_Atleta2, 
                    ID_Atleta3, DNI_Atleta3, ID_Atleta4, DNI_Atleta4, 
                    Resultado, Lugar, Serie, Pista, Nivel
                ) VALUES (
                    '{$atletas[0]['id']}', '{$atletas[0]['dni']}', '{$atletas[1]['id']}', '{$atletas[1]['dni']}', 
                    '{$atletas[2]['id']}', '{$atletas[2]['dni']}', '{$atletas[3]['id']}', '{$atletas[3]['dni']}', 
                    '0.0', 0, 0, '', '$nivel_atletas'
                )";

                $result_insertar_resultado = $conn->query($query_insertar_resultado);

                if ($result_insertar_resultado) {
                    echo "Se agregó el relevo 4x100 metros con DNI: $dni1, $dni2, $dni3, $dni4 y Nivel: $nivel_atletas a la tabla $tabla.<br>";
                } else {
                    echo "Error al agregar el relevo 4x100 metros: " . $conn->error . "<br>";
                }
            } else {
                echo "El relevo 4x100 metros ya existe en el nivel $nivel_atletas de la tabla $tabla.<br>";
            }
        } else {
            echo "Los atletas deben pertenecer al mismo nivel (DISTRITAL, PROVINCIAL, REGIONAL).<br>";
        }
    } else {
        echo "No se encontraron los atletas necesarios en la tabla atletas.<br>";
    }
}

// Función para eliminar atletas por grupo
function eliminarAtletasPorGrupo($dni, $nivel, $tabla) {
    global $conn;

    // Eliminar atletas del grupo en el nivel especificado
    $query_eliminar_atletas = "DELETE FROM $tabla WHERE 
        (DNI_Atleta1 = '$dni' OR DNI_Atleta2 = '$dni' OR 
        DNI_Atleta3 = '$dni' OR DNI_Atleta4 = '$dni') AND 
        Nivel = '$nivel'";

    $result_eliminar_atletas = $conn->query($query_eliminar_atletas);

    if ($result_eliminar_atletas) {
        echo "Se eliminaron los atletas del grupo con DNI: $dni y Nivel: $nivel de la tabla $tabla.<br>";
    } else {
        echo "Error al eliminar atletas: " . $conn->error . "<br>";
    }
}


// Verificar si se envió el formulario para agregar resultados de relevo 4x100 metros
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dni1_4x100"]) && isset($_POST["dni2_4x100"]) && isset($_POST["dni3_4x100"]) && isset($_POST["dni4_4x100"]) && isset($_POST["nivel_4x100"])) {
    $dni1_4x100_ingresado = $_POST["dni1_4x100"];
    $dni2_4x100_ingresado = $_POST["dni2_4x100"];
    $dni3_4x100_ingresado = $_POST["dni3_4x100"];
    $dni4_4x100_ingresado = $_POST["dni4_4x100"];
    $nivel_4x100_ingresado = $_POST["nivel_4x100"];
    $tabla_4x100_seleccionada = "resultados_relevo4x100metros_cc";

    agregarRelevo4x100Metros($dni1_4x100_ingresado, $dni2_4x100_ingresado, $dni3_4x100_ingresado, $dni4_4x100_ingresado, $nivel_4x100_ingresado, $tabla_4x100_seleccionada);
}

// Verificar si se envió el formulario para eliminar atletas por grupo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dni_eliminar_grupo"]) && isset($_POST["nivel_eliminar_grupo"])) {
    $dni_eliminar_grupo = $_POST["dni_eliminar_grupo"];
    $nivel_eliminar_grupo = $_POST["nivel_eliminar_grupo"];
    $tabla_eliminar_grupo = "resultados_relevo4x100metros_cc";

    eliminarAtletasPorGrupo($dni_eliminar_grupo, $nivel_eliminar_grupo, $tabla_eliminar_grupo);
}
// Función para agregar resultados de Hexatlón
function agregarResultadosHexatlon($dni, $nivel, $tabla) {
    global $conn;

    // Verificar si ya existen resultados para el atleta en el Hexatlón y nivel especificados
    $query_verificar_resultados = "SELECT * FROM $tabla WHERE DNI_Atleta = '$dni' AND Nivel = '$nivel'";
    $result_verificar_resultados = $conn->query($query_verificar_resultados);

    if ($result_verificar_resultados && $result_verificar_resultados->num_rows == 0) {
        // Insertar nuevos resultados del Hexatlón en la tabla seleccionada
        $query_insertar_resultados = "INSERT INTO $tabla (
            ID_Atleta, DNI_Atleta, Nivel
        ) VALUES (
            NULL, '$dni', '$nivel'
        )";

        $result_insertar_resultados = $conn->query($query_insertar_resultados);

        if ($result_insertar_resultados) {
            echo "Se agregaron los resultados del Hexatlón para el DNI: $dni y Nivel: $nivel a la tabla $tabla.<br>";
        } else {
            echo "Error al agregar los resultados del Hexatlón: " . $conn->error . "<br>";
        }
    } else {
        echo "Los resultados del Hexatlón ya existen para el DNI: $dni y Nivel: $nivel en la tabla $tabla.<br>";
    }
}

// Función para eliminar resultados de Hexatlón por grupo (elimina todos los atletas del mismo nivel)
function eliminarResultadosHexatlonPorGrupo($dni, $nivel, $tabla) {
    global $conn;

    // Eliminar resultados del Hexatlón para todos los atletas del mismo nivel
    $query_eliminar_resultados = "DELETE FROM $tabla WHERE Nivel = '$nivel'";
    $result_eliminar_resultados = $conn->query($query_eliminar_resultados);

    if ($result_eliminar_resultados) {
        echo "Se eliminaron los resultados del Hexatlón para el Nivel: $nivel en la tabla $tabla.<br>";
    } else {
        echo "Error al eliminar los resultados del Hexatlón: " . $conn->error . "<br>";
    }
}

// Verificar si se envió el formulario para agregar resultados de Hexatlón
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dni_hexatlon"]) && isset($_POST["nivel_hexatlon"])) {
    $dni_hexatlon_ingresado = $_POST["dni_hexatlon"];
    $nivel_hexatlon_ingresado = $_POST["nivel_hexatlon"];
    $tabla_hexatlon_seleccionada = "resultados_hexatlon_cc";

    agregarResultadosHexatlon($dni_hexatlon_ingresado, $nivel_hexatlon_ingresado, $tabla_hexatlon_seleccionada);
}

// Verificar si se envió el formulario para eliminar resultados de Hexatlón por grupo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dni_grupo_eliminar_hexatlon"]) && isset($_POST["nivel_grupo_eliminar_hexatlon"])) {
    $dni_grupo_eliminar_hexatlon_ingresado = $_POST["dni_grupo_eliminar_hexatlon"];
    $nivel_grupo_eliminar_hexatlon_ingresado = $_POST["nivel_grupo_eliminar_hexatlon"];
    $tabla_hexatlon_seleccionada = "resultados_hexatlon_cc";

    eliminarResultadosHexatlonPorGrupo($dni_grupo_eliminar_hexatlon_ingresado, $nivel_grupo_eliminar_hexatlon_ingresado, $tabla_hexatlon_seleccionada);
}
// Función para agregar atletas de pentatlón
function agregarAtletaPentatlon($dni, $nivel, $tabla) {
    global $conn;

    // Verificar si ya existe el atleta en la tabla y nivel especificados
    $query_verificar_atleta = "SELECT * FROM $tabla WHERE DNI_Atleta = '$dni' AND Nivel = '$nivel'";
    $result_verificar_atleta = $conn->query($query_verificar_atleta);

    if ($result_verificar_atleta && $result_verificar_atleta->num_rows == 0) {
        // Insertar nuevo atleta en la tabla seleccionada
        $query_insertar_atleta = "INSERT INTO $tabla (DNI_Atleta, Nivel) VALUES ('$dni', '$nivel')";
        $result_insertar_atleta = $conn->query($query_insertar_atleta);

        if ($result_insertar_atleta) {
            echo "Se agregó el atleta con DNI: $dni y Nivel: $nivel a la tabla $tabla.<br>";
        } else {
            echo "Error al agregar el atleta: " . $conn->error . "<br>";
        }
    } else {
        echo "El atleta ya existe en el nivel $nivel de la tabla $tabla.<br>";
    }
}

// Función para eliminar atletas de pentatlón
function eliminarAtletasPentatlon($dni, $nivel, $tabla) {
    global $conn;

    // Eliminar atletas de la tabla seleccionada con el DNI y nivel especificados
    $query_eliminar_atletas = "DELETE FROM $tabla WHERE DNI_Atleta = '$dni' AND Nivel = '$nivel'";
    $result_eliminar_atletas = $conn->query($query_eliminar_atletas);

    if ($result_eliminar_atletas) {
        echo "Se eliminaron los atletas con DNI: $dni y Nivel: $nivel de la tabla $tabla.<br>";
    } else {
        echo "Error al eliminar atletas: " . $conn->error . "<br>";
    }
}

// Verificar si se envió el formulario para agregar atletas de pentatlón
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dni_pentatlon"]) && isset($_POST["nivel_pentatlon"])) {
    $dni_pentatlon_ingresado = $_POST["dni_pentatlon"];
    $nivel_pentatlon_ingresado = $_POST["nivel_pentatlon"];
    $tabla_pentatlon_seleccionada = "resultados_pentatlon_cc";

    agregarAtletaPentatlon($dni_pentatlon_ingresado, $nivel_pentatlon_ingresado, $tabla_pentatlon_seleccionada);
}

// Verificar si se envió el formulario para eliminar atletas de pentatlón
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dni_eliminar_pentatlon"]) && isset($_POST["nivel_eliminar_pentatlon"])) {
    $dni_eliminar_pentatlon = $_POST["dni_eliminar_pentatlon"];
    $nivel_eliminar_pentatlon = $_POST["nivel_eliminar_pentatlon"];
    $tabla_eliminar_pentatlon = "resultados_pentatlon_cc";

    eliminarAtletasPentatlon($dni_eliminar_pentatlon, $nivel_eliminar_pentatlon, $tabla_eliminar_pentatlon);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Resultados de Relevo 4x100 metros y Eliminación de Atletas por Grupo</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

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

        <!-- Formulario de Resultados de Relevo 4x100 metros -->
        <div class="mt-5">
            <h2>Formulario de Resultados de Relevo 4x100 metros</h2>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-3">
                <div class="form-group">
                    <label for="dni1_4x100">DNI Atleta 1:</label>
                    <input type="text" class="form-control" name="dni1_4x100" required>
                </div>

                <div class="form-group">
                    <label for="dni2_4x100">DNI Atleta 2:</label>
                    <input type="text" class="form-control" name="dni2_4x100" required>
                </div>

                <div class="form-group">
                    <label for="dni3_4x100">DNI Atleta 3:</label>
                    <input type="text" class="form-control" name="dni3_4x100" required>
                </div>

                <div class="form-group">
                    <label for="dni4_4x100">DNI Atleta 4:</label>
                    <input type="text" class="form-control" name="dni4_4x100" required>
                </div>

                <div class="form-group">
                    <label for="nivel_4x100">Nivel:</label>
                    <select class="form-control" name="nivel_4x100" required>
                        <option value="DISTRITAL">DISTRITAL</option>
                        <option value="PROVINCIAL">PROVINCIAL</option>
                        <option value="REGIONAL">REGIONAL</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Agregar Resultado</button>
            </form>
        </div>

        <hr>

        <!-- Formulario de Eliminación de Atletas por Grupo -->
        <div class="mt-5">
            <h2>Formulario de Eliminación de Atletas por Grupo</h2>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-3">
                <div class="form-group">
                    <label for="dni_eliminar_grupo">Ingresa el DNI de un Atleta del Grupo:</label>
                    <input type="text" class="form-control" name="dni_eliminar_grupo" required>
                </div>

                <div class="form-group">
                    <label for="nivel_eliminar_grupo">Nivel del Atleta:</label>
                    <select class="form-control" name="nivel_eliminar_grupo" required>
                        <option value="DISTRITAL">DISTRITAL</option>
                        <option value="PROVINCIAL">PROVINCIAL</option>
                        <option value="REGIONAL">REGIONAL</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Eliminar Atletas del Grupo</button>
            </form>
        </div>

        <!-- Formulario de Resultados de Hexatlón -->
        <div class="mt-5">
            <h2>Formulario de Resultados de Hexatlón</h2>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-3">
                <div class="form-group">
                    <label for="dni_hexatlon">DNI Atleta:</label>
                    <input type="text" class="form-control" name="dni_hexatlon" required>
                </div>

                <div class="form-group">
                    <label for="nivel_hexatlon">Nivel:</label>
                    <select class="form-control" name="nivel_hexatlon" required>
                        <option value="DISTRITAL">DISTRITAL</option>
                        <option value="PROVINCIAL">PROVINCIAL</option>
                        <option value="REGIONAL">REGIONAL</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Agregar Resultado</button>
            </form>
        </div>

        <!-- Formulario para Eliminar Resultados de Hexatlón por Grupo -->
        <div class="mt-5">
            <h2>Formulario para Eliminar Resultados de Hexatlón por Grupo</h2>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-3">
                <div class="form-group">
                    <label for="dni_grupo_eliminar_hexatlon">Ingresa el DNI de un Atleta del Grupo:</label>
                    <input type="text" class="form-control" name="dni_grupo_eliminar_hexatlon" required>
                </div>

                <div class="form-group">
                    <label for="nivel_grupo_eliminar_hexatlon">Nivel del Atleta:</label>
                    <select class="form-control" name="nivel_grupo_eliminar_hexatlon" required>
                        <option value="DISTRITAL">DISTRITAL</option>
                        <option value="PROVINCIAL">PROVINCIAL</option>
                        <option value="REGIONAL">REGIONAL</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Eliminar Resultados por Grupo</button>
            </form>
        </div>

        <!-- Formulario de Atletas de Pentatlón -->
        <div class="mt-5">
            <h2>Formulario de Atletas de Pentatlón</h2>
            <!-- Formulario para agregar atletas -->
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-3">
                <div class="form-group">
                    <label for="dni_pentatlon">DNI Atleta:</label>
                    <input type="text" class="form-control" name="dni_pentatlon" required>
                </div>

                <div class="form-group">
                    <label for="nivel_pentatlon">Nivel:</label>
                    <select class="form-control" name="nivel_pentatlon" required>
                        <option value="DISTRITAL">DISTRITAL</option>
                        <option value="PROVINCIAL">PROVINCIAL</option>
                        <option value="REGIONAL">REGIONAL</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Agregar Atleta</button>
            </form>

            <!-- Formulario para eliminar atletas -->
            <h2 class="mt-5">Formulario para Eliminar Atletas por Grupo</h2>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-3">
                <div class="form-group">
                    <label for="dni_eliminar_pentatlon">Ingresa el DNI de un Atleta del Grupo:</label>
                    <input type="text" class="form-control" name="dni_eliminar_pentatlon" required>
                </div>

                <div class="form-group">
                    <label for="nivel_eliminar_pentatlon">Nivel del Atleta:</label>
                    <select class="form-control" name="nivel_eliminar_pentatlon" required>
                        <option value="DISTRITAL">DISTRITAL</option>
                        <option value="PROVINCIAL">PROVINCIAL</option>
                        <option value="REGIONAL">REGIONAL</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Eliminar Atleta</button>
            </form>
        </div>

    </div>
    <div class="container mt-4">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mb-4">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="tabla">Seleccionar Tabla:</label>
                <select name="tabla" id="tabla" class="form-control">
                    <option value="relevo">Resultados Relevo 4x100 metros</option>
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
        foreach ($row as $clave => $valor) {
            echo "<td>$valor</td>";
        }
        echo "</tr>";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mostrar"])) {
        $tabla_seleccionada = $_POST["tabla"];
        $nivel_seleccionado = $_POST["nivel"];

        switch ($tabla_seleccionada) {
            case "relevo":
                $sql = "SELECT * FROM resultados_relevo4x100metros_cc WHERE Nivel = '$nivel_seleccionado'";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    echo "<h2 class='mt-4'>Resultados Relevo 4x100 metros ($nivel_seleccionado)</h2>";
                    echo "<div class='table-responsive'>";
                    echo "<table class='table table-bordered'>";
                    echo "<thead class='thead-light'><tr><th>ID_Atleta1</th><th>DNI_Atleta1</th><th>ID_Atleta2</th><th>DNI_Atleta2</th><th>ID_Atleta3</th><th>DNI_Atleta3</th><th>ID_Atleta4</th><th>DNI_Atleta4</th><th>Resultado</th><th>Lugar</th><th>Serie</th><th>Pista</th><th>Nivel</th></tr></thead><tbody>";
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
                $sql = "SELECT * FROM resultados_pentatlon_cc WHERE Nivel = '$nivel_seleccionado'";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    echo "<h2 class='mt-4'>Resultados Pentatlón ($nivel_seleccionado)</h2>";
                    echo "<div class='table-responsive'>";
                    echo "<table class='table table-bordered'>";
                    echo "<thead class='thead-light'><tr><th>ID_Atleta</th><th>DNI_Atleta</th><th>80mConVallas_Dia1</th><th>ImpulsionBala_Dia1</th><th>SaltoLargo_Dia1</th><th>SaltoAlto_Dia2</th><th>Distancia_600m_Dia2</th><th>Nivel</th></tr></thead><tbody>";
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
                $sql = "SELECT * FROM resultados_hexatlon_cc WHERE Nivel = '$nivel_seleccionado'";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    echo "<h2 class='mt-4'>Resultados Hexatlón ($nivel_seleccionado)</h2>";
                    echo "<div class='table-responsive'>";
                    echo "<table class='table table-bordered'>";
                    echo "<thead class='thead-light'><tr><th>ID_Atleta</th><th>DNI_Atleta</th><th>100mConVallas_Dia1</th><th>ImpulsionBala_Dia1</th><th>SaltoLargo_Dia1</th><th>LanzamientoJabalina_Dia2</th><th>SaltoAlto_Dia2</th><th>Distancia_800m_Dia2</th><th>Nivel</th></tr></thead><tbody>";
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

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

</body>

</html>
