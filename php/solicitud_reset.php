<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Solicitud</title>
    <style>
        /* Estilo para el cuerpo de la página */
body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    margin: 0;
    padding: 0;
}

/* Estilo para el encabezado h1 */
h1 {
    text-align: center;
    background-color: #333;
    color: #fff;
    padding: 20px;
}

/* Estilo para el formulario */
form {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
}

/* Estilo para las etiquetas de los campos del formulario */
label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

/* Estilo para los campos de entrada */
input[type="text"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

/* Estilo para el botón "Guardar Solicitud" */
input[type="submit"] {
    background-color: #333;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

/* Estilo para el botón "Volver" */
.btn {
    background-color: #d9534f;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
    margin-right: 10px;
}

/* Estilo para el botón "Volver" al hacer hover */
.btn:hover {
    background-color: #c9302c;
}

    </style>
</head>
<body>
    <h1>Formulario de Solicitud</h1>
    <form action="solicitud_reset.php" method="post">
        <label for="dni">DNI:</label>
        <input type="text" name="dni" id="dni" required>
        <br>
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" id="telefono" required>
        <br>
        <br>
        <a href="../login/login.html" class="btn btn-danger">Volver</a>
        <br>
        <br>
        <input type="submit" name="guardar_solicitud" value="Guardar Solicitud">
    </form>

    <?php
    // Conexión a la base de datos
    $db_host = "localhost"; // Cambia a tu servidor de base de datos
    $db_user = "root"; // Cambia a tu nombre de usuario
    $db_pass = ""; // Cambia a tu contraseña
    $db_name = "atletismo"; // Cambia al nombre de tu base de datos

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Verificar la conexión a la base de datos
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    if (isset($_POST['guardar_solicitud'])) {
        // Obtener el DNI y el teléfono del formulario
        $dni = $_POST['dni'];
        $telefono = $_POST['telefono'];

        // Verificar si el DNI existe en la tabla de arbitros
        $query = "SELECT arbitro_id FROM arbitros WHERE dni = '$dni'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            // El DNI existe en la tabla de arbitros, verifica si ya existe una solicitud con el mismo DNI
            $check_existing_query = "SELECT solicitud_id FROM solicitud_reset WHERE dni = '$dni'";
            $existing_result = $conn->query($check_existing_query);

            if ($existing_result->num_rows == 0) {
                // No hay solicitud existente con el mismo DNI, puedes insertar la solicitud en solicitud_reset
                $insert_query = "INSERT INTO solicitud_reset (dni, telefono) VALUES ('$dni', '$telefono')";

                if ($conn->query($insert_query) === TRUE) {
                    echo "Solicitud guardada con éxito.";
                } else {
                    echo "Error al guardar la solicitud: " . $conn->error;
                }
            } else {
                echo "Ya existe una solicitud con el mismo DNI. Por favor, verifique el DNI e inténtelo de nuevo.";
            }
        } else {
            echo "El DNI no existe en la tabla de arbitros. Por favor, verifique el DNI e inténtelo de nuevo.";
        }
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
    ?>
</body>
</html>
