<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://www.shutterstock.com/image-vector/initial-letter-ap-logo-design-260nw-2343832111.jpg" type="image/png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../estilo.css">
    <style>
/* Style for the main content container */
.container {
    margin: 20px auto; /* Center the container horizontally */
    padding: 20px;
    border: 1px solid #ccc;
    background-color: #f9f9f9;
}

/* Style for the header (navbar) to center it */
.container-fluid {
    text-align: center;
}

/* Style for the container with background image */
#athlete-container {
    background-image: url('https://img.freepik.com/fotos-premium/bandera-peru-musculos-abdominales-entrenamiento-deporte-nacional-concepto-culturismo-fondo-negro_559531-6988.jpg');
    background-size: cover;
    background-position: center;
    color: #fff;
    padding: 20px;
}
/* CSS styles for athlete's name */
.athlete-name {
    font-size: 132px;
    font-weight: bold;
    text-transform: uppercase;
    font-family: 'Arial', sans-serif; /* Change the font family to Arial or your preferred font */
    color: #FF0000; /* Red text color for the athlete's name */
    /* Add any other text styles you want for the athlete's name */
}

/* CSS for other athlete details */
.athlete-last {
    font-size: 63px;
    font-weight: bold;
    text-transform: uppercase;
    font-family: 'Verdana', sans-serif; /* Change the font family to Verdana or your preferred font */
    color: #00FF00; /* Green text color for the last name */
    /* Add any other text styles you want for the last name */
}

.athlete-3 {
    font-size: 23px;
    font-weight: bold;
    text-transform: uppercase;
    font-family: 'Times New Roman', serif; /* Change the font family to Times New Roman or your preferred font */
    /* Add text styles for athlete-3 */
}

.athlete-4 {
    font-size: 43px;
    font-weight: bold;
    text-transform: uppercase;
    font-family: 'Georgia', serif; /* Change the font family to Georgia or your preferred font */
    /* Add text styles for athlete-4 */
}

.athlete-1 {
    font-size: 43px;
    font-weight: bold;
    text-transform: uppercase;
    font-family: 'Tahoma', sans-serif; /* Change the font family to Tahoma or your preferred font */
    /* Add text styles for athlete-1 */
}

.athlete-2 {
    font-size: 33px;
    font-weight: bold;
    text-transform: uppercase;
    font-family: 'Courier New', monospace; /* Change the font family to Courier New or your preferred font */
    /* Add text styles for athlete-2 */
}


/* Style for the footer */
footer {
    background-color: #535353;
    padding: 20px;
    color: #fff;
}

footer a {
    color: #ff9900;
}

footer a:hover {
    color: #fff;
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
            echo "<p class='athlete-4'>institucion: " . $fila['institucion'] . "</p>";
            echo "<p class='athlete-1'>Departamento: " . $fila['departamento'] . "</p>";
            echo "<p class='athlete-2'>Provincia: " . $fila['provincia'] . "</p>";
            echo "<p class='athlete-3'>Fecha de Nacimiento: " . $fila['nacimiento'] . "</p>";
            echo "<p>" . $fila['pais'] . " <img src='https://i.pinimg.com/originals/4b/da/b6/4bdab6a64af4d3e35d2b4d746a14b2c4.jpg' alt='" . $fila['pais'] . " Flag' width='40' height='30'></p>";
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
