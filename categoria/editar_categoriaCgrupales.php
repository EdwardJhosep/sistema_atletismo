<?php
// Conexión a la base de datos
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

// Inicializar variable para habilitar/deshabilitar el botón de agregar
$disableAgregar = "disabled";

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dniAtleta = isset($_POST["dniAtleta"]) ? $_POST["dniAtleta"] : "";
    $nivel = isset($_POST["nivel"]) ? $_POST["nivel"] : "";
    $tabla = isset($_POST["tabla"]) ? $_POST["tabla"] : "";

    // Aquí debes agregar la lógica de validación y seguridad necesaria

    // Insertar datos en la tabla correspondiente
    switch ($tabla) {
        case "relevo":
            $dniAtleta1 = isset($_POST["dniAtleta1"]) ? $_POST["dniAtleta1"] : "";
            $dniAtleta2 = isset($_POST["dniAtleta2"]) ? $_POST["dniAtleta2"] : "";
            $dniAtleta3 = isset($_POST["dniAtleta3"]) ? $_POST["dniAtleta3"] : "";
            $dniAtleta4 = isset($_POST["dniAtleta4"]) ? $_POST["dniAtleta4"] : "";

            $sql = "INSERT INTO Resultados_Relevo4x100Metros_CC (DNI_Atleta1, DNI_Atleta2, DNI_Atleta3, DNI_Atleta4, Nivel) 
                    VALUES ('$dniAtleta1', '$dniAtleta2', '$dniAtleta3', '$dniAtleta4', '$nivel')";
            break;
        case "pentatlon":
            $sql = "INSERT INTO Resultados_Pentatlon_CC (DNI_Atleta, Nivel) 
                    VALUES ('$dniAtleta', '$nivel')";
            break;
        case "hexatlon":
            $sql = "INSERT INTO Resultados_Hexatlon_CC (DNI_Atleta, Nivel) 
                    VALUES ('$dniAtleta', '$nivel')";
            break;
        default:
            // Manejar caso por defecto si es necesario
            break;
    }

    if ($conn->query($sql) === TRUE) {
        echo "Atleta agregado correctamente.";
    } else {
        echo "Error al agregar atleta: " . $conn->error;
    }
}

// Si se ha seleccionado una tabla, habilitar el botón de agregar
if (isset($_POST["tabla"])) {
    $disableAgregar = "";
}

// Cerrar conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoría Grupal</title>
    <script>
        function mostrarCampos() {
            var tablaSeleccionada = document.getElementById("tabla").value;
            var camposRelevo = document.getElementById("camposRelevo");
            var camposPentatlon = document.getElementById("camposPentatlon");
            var botonAgregar = document.getElementById("botonAgregar");

            // Mostrar u ocultar campos adicionales dependiendo de la tabla seleccionada
            camposRelevo.style.display = (tablaSeleccionada === "relevo") ? "block" : "none";
            camposPentatlon.style.display = (tablaSeleccionada === "pentatlon") ? "block" : "none";

            // Habilitar/deshabilitar el botón de agregar según la tabla seleccionada
            botonAgregar.disabled = (tablaSeleccionada === "");
        }
    </script>
</head>
<body>

<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
    <label for="dniAtleta">DNI del Atleta:</label>
    <input type="text" name="dniAtleta" required>

    <label for="nivel">Seleccione Nivel:</label>
    <select name="nivel" required>
        <option value="distrital">Distrital</option>
        <option value="regional">Regional</option>
        <option value="provincial">Provincial</option>
    </select>

    <label for="tabla">Seleccionar Tabla:</label>
    <select name="tabla" id="tabla" onchange="mostrarCampos()" required>
        <option value="">Seleccionar</option>
        <option value="relevo">Relevo 4x100 Metros</option>
        <option value="pentatlon">Prueba Combinada: Pentatlón</option>
        <option value="hexatlon">Prueba Combinada: Hexatlón</option>
    </select>

    <!-- Campos específicos para el Relevo 4x100 Metros -->
    <div id="camposRelevo" style="display:none;">
        <label for="dniAtleta1">DNI del Atleta 1:</label>
        <input type="text" name="dniAtleta1" required>

        <label for="dniAtleta2">DNI del Atleta 2:</label>
        <input type="text" name="dniAtleta2" required>

        <label for="dniAtleta3">DNI del Atleta 3:</label>
        <input type="text" name="dniAtleta3" required>

        <label for="dniAtleta4">DNI del Atleta 4:</label>
        <input type="text" name="dniAtleta4" required>
    </div>

    <!-- Campos específicos para el Pentatlón -->
    <div id="camposPentatlon" style="display:none;">
        <!-- Agregar campos específicos del Pentatlón según sea necesario -->
    </div>

    <input type="submit" id="botonAgregar" value="Agregar Atleta" <?php echo $disableAgregar; ?>>
</form>

</body>
</html>
