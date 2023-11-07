<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://www.shutterstock.com/image-vector/initial-letter-ap-logo-design-260nw-2343832111.jpg" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../estilo.css">
    <style>
        /* Estilo de ejemplo en línea */
        .container {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
        .publicidad {
            text-align: center;
            padding: 20px;
            background-color: #e0e0e0;
        }
        footer {
            background-color: #535353;
            padding: 20px;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <img src="../img/logo.jpg" alt="Logo de tu sitio" style="width: 255px; height: 40px; margin-right: 10px;">
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="../index.html">INICIO <span class="sr-only">(current)</span></a></li>
                    <li><a href="../login/admin.html">ADMIN</a></li>
                    <li><a href="../login/login.html">INICIAR encargado</a></li>
                    <li><a href="../menu/torneo.html">TORNEO</a></li>
                    <li><a href="../menu/calendario.html">CALENDARIO</a></li>
                    <li><a href="../menu/atletas.html">ATLETAS</a></li>
                    <li><a href="../menu/rankings.html">RANKINGS</a></li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Resultados de la Búsqueda -->
    <?php
    if (isset($_POST['nombre'])) {
        // Conecta a la base de datos MySQL (coloca esta parte en la parte superior del archivo si no está ya conectado)
        $db_host = "localhost";
        $db_user = "root";
        $db_pass = "";
        $db_name = "atletismo";

        $conexion = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

        if (!$conexion) {
            die("Error al conectar a la base de datos: " . mysqli_connect_error());
        }

        // Obtiene el nombre a buscar
        $nombre = $_POST['nombre'];

        // Realiza la consulta SQL para buscar atletas por nombre
        $query = "SELECT * FROM atletas WHERE nombre LIKE '%$nombre%'";

        $resultado = mysqli_query($conexion, $query);

        echo "<div class='container'>";

        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<p><a href='../php/detalles_atleta.php?id=" . $fila['id'] . "'>" . $fila['nombre'] . "</a></p>";
            echo "<hr>";
        }

        echo "</div>";

        mysqli_close($conexion);
    }
    ?>

    <!-- Panel de Publicidad -->
    <div class="publicidad" style="text-align: center; padding: 20px;">
        <!-- Tu panel de publicidad aquí -->
    </div>

    <!-- Pie de página -->
    <footer style="background-color: #535353; padding: 20px; color: #ffffff;">
        <div class="row">
            <div class="col-md-6">
                <h4>Contacto</h4>
                <p>iep.isaacnewtonhuanuco@gmail.com</p>
                <p>juanantee@gmail.com</p>
            </div>
            <div class="col-md-6">
                <h4>Redes Sociales</h4>
                <ul>
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Twitter</a></li>
                    <li><a href="#">Instagram</a></li>
                </ul>
            </div>
        </div>
        <p style="text-align: center;">© Todos los derechos reservados. Desarrollado por EDWARD JUANANTE RODRIGUEZ</p>

</footer>

</body>
</html>
