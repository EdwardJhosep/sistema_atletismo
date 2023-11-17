<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.html");
    exit();
}

// Configura las contraseñas del administrador
$contrasena_admin1 = '123';
$contrasena_admin2 = 'edward@75902205';

// Conexión a la base de datos (reemplaza con tus propios datos)
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "atletismo";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$usuarios = array(); // Almacena los usuarios disponibles en la base de datos

// Consulta para obtener la lista de usuarios (ajusta según tu esquema de base de datos)
$sql = "SELECT usuario, dni FROM arbitros";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $usuarios[$row['usuario']] = $row['dni'];
    }
}

// Procesar el formulario de edición y eliminación cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar la contraseña del administrador
    $admin_password = $_POST['admin_password'];

    if ($admin_password === $contrasena_admin1 || $admin_password === $contrasena_admin2) {
        if (isset($_POST['editar_arbitro'])) {
            // Obtener el usuario seleccionado del formulario
            $usuario_a_editar = $_POST['usuario_seleccionado'];

            // Verificar si se ha seleccionado un usuario
            if ($usuario_a_editar) {
                // Resto de la lógica de edición aquí
                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $nivel = $_POST['nivel'];

                // Verifica si se proporcionó una nueva contraseña
                if (!empty($_POST['contrasena'])) {
                    // Hashea la contraseña
                    $hashed_password = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

                    // Prepara la consulta SQL para actualizar el árbitro con la nueva contraseña y sin cambiar el DNI (ajusta según tu esquema de base de datos)
                    $sql = "UPDATE arbitros SET nombre = ?, apellido = ?, contrasena = ?, nivel = ? WHERE usuario = ?";

                    // Prepara la declaración
                    if ($stmt = $conn->prepare($sql)) {
                        // Vincula los parámetros y establece sus valores
                        $stmt->bind_param("ssssi", $nombre, $apellido, $hashed_password, $nivel, $usuario_a_editar);

                        // Ejecuta la consulta
                        if ($stmt->execute()) {
                            echo "Árbitro actualizado con éxito.";
                        } else {
                            echo "Error al actualizar el árbitro: " . $conn->error;
                        }

                        // Cierra la declaración
                        $stmt->close();
                    } else {
                        echo "Error en la preparación de la consulta: " . $conn->error;
                    }
                } else {
                    // No se proporcionó una nueva contraseña, actualiza sin cambiar la contraseña
                    $sql = "UPDATE arbitros SET nombre = ?, apellido = ?, nivel = ? WHERE usuario = ?";

                    // Prepara la declaración
                    if ($stmt = $conn->prepare($sql)) {
                        // Vincula los parámetros y establece sus valores
                        $stmt->bind_param("sssi", $nombre, $apellido, $nivel, $usuario_a_editar);

                        // Ejecuta la consulta
                        if ($stmt->execute()) {
                            echo "Árbitro actualizado con éxito.";
                        } else {
                            echo "Error al actualizar el árbitro: " . $conn->error;
                        }

                        // Cierra la declaración
                        $stmt->close();
                    } else {
                        echo "Error en la preparación de la consulta: " . $conn->error;
                    }
                }
            } else {
                echo "Error: Debes seleccionar un usuario para editar.";
            }
        } elseif (isset($_POST['eliminar_arbitro'])) {
            // Obtener el usuario seleccionado del formulario
            $usuario_a_eliminar = $_POST['usuario_seleccionado'];

            // Verificar si se ha seleccionado un usuario
            if ($usuario_a_eliminar) {
                // Realizar la eliminación del árbitro (ajusta según tu esquema de base de datos)
                $sql = "DELETE FROM arbitros WHERE usuario = ?";

                // Prepara la declaración
                if ($stmt = $conn->prepare($sql)) {
                    // Vincula el parámetro y establece su valor
                    $stmt->bind_param("i", $usuario_a_eliminar);

                    // Ejecuta la consulta
                    if ($stmt->execute()) {
                        echo "Árbitro eliminado con éxito.";
                    } else {
                        echo "Error al eliminar el árbitro: " . $conn->error;
                    }

                    // Cierra la declaración
                    $stmt->close();
                } else {
                    echo "Error en la preparación de la consulta: " . $conn->error;
                }
            } else {
                echo "Error: Debes seleccionar un usuario para eliminar.";
            }
        }
    } else {
        echo "Contraseña de administrador incorrecta. No tienes permiso para realizar esta acción.";
    }
}

// Cierra la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar y Eliminar Árbitro</title>
    <!-- Agregar el enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2 class="mt-4">Editar y Eliminar Árbitro</h2>
    <form action="editar_arbitro.php" method="POST">
        <div class="form-group">
            <label for="usuario_seleccionado">Selecciona un usuario por DNI:</label>
            <select class="form-control" name="usuario_seleccionado" required>
                <option value="">-- Selecciona un usuario --</option>
                <?php
                // Genera las opciones de la lista desplegable a partir de la lista de usuarios
                foreach ($usuarios as $usuario => $dni) {
                    echo "<option value=\"$usuario\">$dni</option>";
                }
                ?>
            </select>
        </div>

        <!-- Botón de eliminar -->
        <button type="submit" class="btn btn-danger" name="eliminar_arbitro">Eliminar Árbitro</button>

        <!-- Resto del formulario de edición -->
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" name="nombre" required>
        </div>

        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" class="form-control" name="apellido" required>
        </div>

        <div class="form-group">
            <label for="nivel">Nivel:</label>
            <input type="text" class="form-control" name="nivel" required>
        </div>
        
        <div class="form-group">
            <label for="admin_password">Contraseña del Administrador:</label>
            <input type="password" class="form-control" name="admin_password" required>
        </div>

        <button type="submit" class="btn btn-primary" name="editar_arbitro">Guardar Cambios</button>
        <a href="../usuarios/users.php" class="btn btn-danger">Volver</a>
    </form>
</div>

<!-- Agregar el enlace a Bootstrap JS y jQuery (opcional) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
