<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../estilo.css">
    <style>
    /* Estilo de ejemplo en línea */
.container {
    align-content: center;
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

#athlete-container { /* CSS for the container with background image */
    background-image: url('https://img.freepik.com/fotos-premium/bandera-peru-musculos-abdominales-entrenamiento-deporte-nacional-concepto-culturismo-fondo-negro_559531-6988.jpg'); /* Replace with the path to your background image */
    background-size: cover;
    background-position: center;
    color: #fff; /* Set text color to white for better visibility */
    padding: 20px;
}

.athlete-name { /* CSS style for the athlete's name */
    font-size: 132px; /* Adjust the font size as needed */
    font-weight: bold;
    text-transform: uppercase;
}

.athlete-last { /* CSS style for the athlete's name */
    font-size: 52px; /* Adjust the font size as needed */
    font-weight: bold;
    text-transform: uppercase;
}

.athlete-3 { /* CSS style for the athlete's name */
    font-size: 17px; /* Adjust the font size as needed */
    font-weight: bold;
    text-transform: uppercase;
}

.athlete-4 { /* CSS style for the athlete's name */
    font-size: 23px; /* Adjust the font size as needed */
    font-weight: bold;
    text-transform: uppercase;
}
.athlete-1 { /* CSS style for the athlete's name */
    font-size: 33px; /* Adjust the font size as needed */
    font-weight: bold;
    text-transform: uppercase;
}

.athlete-2 { /* CSS style for the athlete's name */
    font-size: 23px; /* Adjust the font size as needed */
    font-weight: bold;
    text-transform: uppercase;
}
/* Estilo para el pie de página */
footer {
    background-color: #535353;
    padding: 20px;
    color: #ffffff;
    text-align: center;
}

footer a {
    color: #ff9900; /* Cambia el color de los enlaces en el pie de página */
}

footer a:hover {
    color: #fff; /* Cambia el color de los enlaces al pasar el cursor */
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
                    <li><a href="../login/login2.html">INICIAR profesor</a></li>
                    <li><a href="../menu/torneo.html">TORNEO</a></li>
                    <li><a href="../menu/calendario.html">CALENDARIO</a></li>
                    <li><a href="../menu/atletas.html">ATLETAS</a></li>
                    <li><a href="../menu/rankings.html">RANKINGS</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <BR><BR><BR><BR><BR>

    <!-- Información del Atleta -->
    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Conecta a la base de datos MySQL
        $db_host = "localhost";
        $db_user = "root";
        $db_pass = "";
        $db_name = "atletismo";

        $conexion = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

        if (!$conexion) {
            die("Error al conectar a la base de datos: " . mysqli_connect_error());
        }

        $query = "SELECT * FROM atletas WHERE id = $id";
        $resultado = mysqli_query($conexion, $query);

        if ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<div id=\"athlete-container\" class=\"container\">";
            echo "<p class='athlete-name'>" . $fila['nombre'] . "</p>";
            echo "<p class='athlete-last'>" . $fila['apellido'] . "</p>";
            echo "<p>" . $fila['pais'] . " <img src='https://i.pinimg.com/originals/4b/da/b6/4bdab6a64af4d3e35d2b4d746a14b2c4.jpg' alt='" . $fila['pais'] . " Flag' width='30' height='20'></p>";
            echo "<p class='athlete-3'>Fecha de Nacimiento: " . $fila['nacimiento'] . "</p>";
            echo "<p class='athlete-4'>institucion: " . $fila['institucion'] . "</p>";
            echo "<p class='athlete-1'>Departamento: " . $fila['departamento'] . "</p>";
            echo "<p class='athlete-2'>Provincia: " . $fila['provincia'] . "</p>";
            echo "</div>";
        } else {
            echo "Atleta no encontrado";
        }
        
        

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
