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

function agregarAtleta($dni, $nivel, $tabla, $fechaCompetencia) {
    global $conn;

    // Verificar si el atleta ya tiene registros en los tres niveles
    $query_verificar_atleta_en_tres_niveles = "SELECT DISTINCT Nivel FROM $tabla WHERE DNI_Atleta = '$dni'";
    $result_verificar_atleta_en_tres_niveles = $conn->query($query_verificar_atleta_en_tres_niveles);

    $niveles_registrados = [];
    while ($row_nivel = $result_verificar_atleta_en_tres_niveles->fetch_assoc()) {
        $niveles_registrados[] = $row_nivel['Nivel'];
    }

    if (count($niveles_registrados) === 3) {
        echo "El atleta con DNI: $dni ya participa en los tres niveles (DISTRITAL, PROVINCIAL y REGIONAL).<br>";
    } elseif (in_array($nivel, $niveles_registrados)) {
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
                                         VALUES ('$id_atleta', '$dni', 0.0, 0, 0, '', '$nivel', '$fechaCompetencia')";
            $result_insertar_resultado = $conn->query($query_insertar_resultado);
    
            if ($result_insertar_resultado) {
                echo "Se agregó el atleta con ID: $id_atleta, Nombre: $nombre_atleta, DNI: $dni y Nivel: $nivel a la tabla $tabla.<br>";
            } else {
                echo "Error al agregar el resultado: " . $conn->error . "<br>";
            
            }
        } else {
            echo "No se encontró un atleta con DNI: $dni en la tabla atletas.<br>";
        }
    }
}
// Función para eliminar atleta por DNI, tabla y nivel
function eliminarAtleta($dni, $tabla, $nivel) {
    global $conn;

    // Eliminar resultados de la tabla seleccionada por DNI y nivel
    $query_eliminar_resultados = "DELETE FROM $tabla WHERE DNI_Atleta = '$dni' AND Nivel = '$nivel'";
    $result_eliminar_resultados = $conn->query($query_eliminar_resultados);

    if ($result_eliminar_resultados) {
        echo "Se eliminaron los resultados del atleta con DNI: $dni de la tabla $tabla en el nivel $nivel.<br>";
    } else {
        echo "Error al eliminar los resultados: " . $conn->error . "<br>";
    }
}


// Función para mostrar resultados de una tabla filtrando por categoría
function mostrarResultadosPorCategoria($tabla, $categoria) {
    global $conn;

    $query_resultados = "SELECT * FROM $tabla WHERE Nivel = '$categoria'";
    $result_resultados = $conn->query($query_resultados);

    if ($result_resultados) {
        if ($result_resultados->num_rows > 0) {
            echo "<h2>Resultados de la tabla $tabla para la categoría $categoria</h2>";
            echo "<table class='table'>
                    <thead>
                        <tr>
                            <th>ID_Atleta</th>
                            <th>DNI_Atleta</th>
                            <th>Nombre_Atleta</th>
                            <th>Resultado</th>
                            <th>Lugar</th>
                            <th>Serie</th>
                            <th>Pista</th>
                            <th>Etapa</th>
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
                        <td>" . $row["ID_Atleta"] . "</td>
                        <td>" . $dni_atleta . "</td>
                        <td>" . $nombre_atleta . "</td>
                        <td>" . $row["Resultado"] . "</td>
                        <td>" . $row["Lugar"] . "</td>
                        <td>" . $row["Serie"] . "</td>
                        <td>" . $row["Pista"] . "</td>
                        <td>" . $row["Nivel"] . "</td>
                    </tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<p>No se encontraron resultados en la tabla $tabla para la categoría $categoria.</p>";
        }
    } else {
        echo "<p>Error en la consulta: " . $conn->error . "</p>";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dni"]) && isset($_POST["nivel"]) && isset($_POST["tabla"]) && isset($_POST["fechaCompetencia"])) {
    // Obtener el DNI, el nivel, la tabla y la fecha de competencia del formulario
    $dni_ingresado = $_POST["dni"];
    $nivel_ingresado = $_POST["nivel"];
    $tabla_seleccionada = $_POST["tabla"];
    $fechaCompetencia = $_POST["fechaCompetencia"];  // Agrega esta línea

    // Llamar a la función para agregar atleta
    agregarAtleta($dni_ingresado, $nivel_ingresado, $tabla_seleccionada, $fechaCompetencia);  // Agrega el parámetro
}


// Verificar si se envió el formulario de eliminar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar_dni"]) && isset($_POST["tabla_eliminar"]) && isset($_POST["nivel_eliminar"])) {
    // Obtener el DNI, la tabla y el nivel a eliminar del formulario
    $dni_eliminar = $_POST["eliminar_dni"];
    $tabla_eliminar = $_POST["tabla_eliminar"];
    $nivel_eliminar = $_POST["nivel_eliminar"];

    // Llamar a la función para eliminar atleta
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
    <h1>CATEGORIA C </h1>
    <BR>
    <BR>
    <BR>
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
                <label for="tabla">Seleccione La Etapa:</label>
                <select id="tabla" name="tabla" class="form-control" required>
                <option value="Resultados_100MetrosPlanos_CC">100MetrosPlanos</option>
        <option value="Resultados_200MetrosPlanos_CC">200MetrosPlanos</option>
        <option value="Resultados_LanzamientoDisco1kg_CC">LanzamientoDisco1kg</option>
        <option value="Resultados_LanzamientoDisco1.5kg_CC">LanzamientoDisco1.5kg</option>
        <option value="Resultados_LanzamientoMartillo3kg_CC">LanzamientoMartillo3kg</option>
        <option value="Resultados_LanzamientoMartillo5kg_CC">LanzamientoMartillo5kg</option>
        <option value="Resultados_LanzamientoJabalina500gr_CC">LanzamientoJabalina500gr</option>
        <option value="Resultados_LanzamientoJabalina700gr_CC">LanzamientoJabalina700gr</option>
        <option value="Resultados_ImpulsionBala3kg_CC">ImpulsionBala3kg</option>
        <option value="Resultados_ImpulsionBala5kg_CC">ImpulsionBala5kg</option>
        <option value="Resultados_SaltoLargoConImpulso_CC">SaltoLargoConImpulso</option>
        <option value="Resultados_SaltoAlto_CC">SaltoAlto</option>
        <option value="Resultados_SaltoConGarrocha_CC">SaltoConGarrocha</option>
        <option value="Resultados_400MetrosPlanos_CC">400MetrosPlanos</option>
        <option value="Resultados_1500MetrosPlanos_CC">1500MetrosPlanos</option>
        <option value="Resultados_3000MetrosPlanos_CC">3000MetrosPlanos</option>
        <option value="Resultados_100MetrosConVallas_CC">100MetrosConVallas</option>
        <option value="Resultados_110MetrosConVallas_CC">110MetrosConVallas</option>
        <option value="Resultados_5KmMarcha_CC">5KmMarcha</option>
        <option value="Resultados_10KmMarcha_CC">10KmMarcha</option>
        <option value="Resultados_2000mConObstaculos_CC">2000mConObstaculos</option>
                </select>
            </div>
            <div class="col-md-4">
    <label for="fechaCompetencia">Seleccione la Fecha de Competencia:</label>
    <input type="date" id="fechaCompetencia" name="fechaCompetencia" class="form-control" required>
</div>


            <div class="col-md-4">
                <button type="submit" class="btn btn-primary mt-4">Agregar Información</button>
            </div>
        </div>
    </form>
</div>

<br><br>
<br><br><br><br>
<div class="container mt-5">
    <h1 class="text-center">Eliminar Atletas de las Competencias</h1>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="mb-4">
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="eliminar_dni">Ingrese DNI a eliminar:</label>
                <input type="text" id="eliminar_dni" name="eliminar_dni" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="tabla_eliminar">Seleccione La Categoría para Eliminar:</label>
                <select id="tabla_eliminar" name="tabla_eliminar" class="form-control" required>
                    <option value="Resultados_100MetrosPlanos_CC">100MetrosPlanos</option>
                    <option value="Resultados_200MetrosPlanos_CC">200MetrosPlanos</option>
                    <option value="Resultados_LanzamientoDisco1kg_CC">LanzamientoDisco1kg</option>
                    <option value="Resultados_LanzamientoDisco1.5kg_CC">LanzamientoDisco1.5kg</option>
                    <option value="Resultados_LanzamientoMartillo3kg_CC">LanzamientoMartillo3kg</option>
                    <option value="Resultados_LanzamientoMartillo5kg_CC">LanzamientoMartillo5kg</option>
                    <option value="Resultados_LanzamientoJabalina500gr_CC">LanzamientoJabalina500gr</option>
                    <option value="Resultados_LanzamientoJabalina700gr_CC">LanzamientoJabalina700gr</option>
                    <option value="Resultados_ImpulsionBala3kg_CC">ImpulsionBala3kg</option>
                    <option value="Resultados_ImpulsionBala5kg_CC">ImpulsionBala5kg</option>
                    <option value="Resultados_SaltoLargoConImpulso_CC">SaltoLargoConImpulso</option>
                    <option value="Resultados_SaltoAlto_CC">SaltoAlto</option>
                    <option value="Resultados_SaltoConGarrocha_CC">SaltoConGarrocha</option>
                    <option value="Resultados_400MetrosPlanos_CC">400MetrosPlanos</option>
                    <option value="Resultados_1500MetrosPlanos_CC">1500MetrosPlanos</option>
                    <option value="Resultados_3000MetrosPlanos_CC">3000MetrosPlanos</option>
                    <option value="Resultados_100MetrosConVallas_CC">100MetrosConVallas</option>
                    <option value="Resultados_110MetrosConVallas_CC">110MetrosConVallas</option>
                    <option value="Resultados_5KmMarcha_CC">5KmMarcha</option>
                    <option value="Resultados_10KmMarcha_CC">10KmMarcha</option>
                    <option value="Resultados_2000mConObstaculos_CC">2000mConObstaculos</option>
                    <!-- Add more options as needed -->
                </select>
            </div>
            <div class="col-md-4 mb-3">
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

    <div class="text-center">
        <a class="btn btn-secondary mt-3" href="../categoria/editar_categoriaCgrupales.php">Agregar Pentatlón, Hexatlón y Relevo 4 x 100 Metros</a>
    </div>

    <h1 class="mt-5 text-center">Mostrar Información de las Competencias</h1>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="mb-4">
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="tabla_mostrar">Seleccione Tabla para Mostrar:</label>
                <select id="tabla_mostrar" name="tabla_mostrar" class="form-control" required>
                    <option value="Resultados_100MetrosPlanos_CC">100MetrosPlanos</option>
                    <option value="Resultados_200MetrosPlanos_CC">200MetrosPlanos</option>
                    <option value="Resultados_LanzamientoDisco1kg_CC">LanzamientoDisco1kg</option>
                    <option value="Resultados_LanzamientoDisco1.5kg_CC">LanzamientoDisco1.5kg</option>
                    <option value="Resultados_LanzamientoMartillo3kg_CC">LanzamientoMartillo3kg</option>
                    <option value="Resultados_LanzamientoMartillo5kg_CC">LanzamientoMartillo5kg</option>
                    <option value="Resultados_LanzamientoJabalina500gr_CC">LanzamientoJabalina500gr</option>
                    <option value="Resultados_LanzamientoJabalina700gr_CC">LanzamientoJabalina700gr</option>
                    <option value="Resultados_ImpulsionBala3kg_CC">ImpulsionBala3kg</option>
                    <option value="Resultados_ImpulsionBala5kg_CC">ImpulsionBala5kg</option>
                    <option value="Resultados_SaltoLargoConImpulso_CC">SaltoLargoConImpulso</option>
                    <option value="Resultados_SaltoAlto_CC">SaltoAlto</option>
                    <option value="Resultados_SaltoConGarrocha_CC">SaltoConGarrocha</option>
                    <option value="Resultados_400MetrosPlanos_CC">400MetrosPlanos</option>
                    <option value="Resultados_1500MetrosPlanos_CC">1500MetrosPlanos</option>
                    <option value="Resultados_3000MetrosPlanos_CC">3000MetrosPlanos</option>
                    <option value="Resultados_100MetrosConVallas_CC">100MetrosConVallas</option>
                    <option value="Resultados_110MetrosConVallas_CC">110MetrosConVallas</option>
                    <option value="Resultados_5KmMarcha_CC">5KmMarcha</option>
                    <option value="Resultados_10KmMarcha_CC">10KmMarcha</option>
                    <option value="Resultados_2000mConObstaculos_CC">2000mConObstaculos</option>
                    <!-- Add more options as needed -->
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="categoria_mostrar">Seleccione Etapa:</label>
                <select id="categoria_mostrar" name="categoria_mostrar" class="form-control" required>
                    <option value="DISTRITAL">DISTRITAL</option>
                    <option value="PROVINCIAL">PROVINCIAL</option>
                    <option value="REGIONAL">REGIONAL</option>
                    <!-- Add more options as needed -->
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-success mt-4">Mostrar Resultados</button>
            </div>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>



<br>
<br>
<br>
    <?php
  // Verificar si se envió el formulario de mostrar resultados
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tabla_mostrar"]) && isset($_POST["categoria_mostrar"])) {
    // Obtener la tabla y la categoría a mostrar del formulario
    $tabla_mostrar = $_POST["tabla_mostrar"];
    $categoria_mostrar = $_POST["categoria_mostrar"];

    // Llamar a la función para mostrar resultados filtrados por categoría
    mostrarResultadosPorCategoria($tabla_mostrar, $categoria_mostrar);
}

    ?>
</div>
</body>
</html>
