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
    <title>Document</title>
    <style>
        .table th, .table td {
            text-align: center;
        }

        .hidden {
            display: none;
        }

        /* Estilo personalizado para la tabla */
        .custom-table {
            border: 2px solid #0011fa; /* Borde azul */
            border-radius: 10px; /* Bordes redondeados */
            margin: 10px 0; /* Espacio entre la tabla y otros elementos */
            box-shadow: 4px 4px 8px rgba(102, 255, 0, 0.2); /* Sombra */
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
        <li><a href="../index.html">INICIO</a></li>
        <li><a href="../login/admin.html">ADMIN</a></li>
        <li><a href="../login/login.html">INICIAR encargado</a></li>
        <li><a href="calendario.php">CALENDARIO</a></li>
        <li><a href="atletas.html">ATLETAS</a></li>
        <li><a href="rankings.php">RANKINGS</a></li>
      </ul>
    </div>
  </div>
    </nav>

    <BR><BR><BR><BR><BR>

    <?php
    // Conexión a la base de datos (ajusta los valores según tu configuración)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "atletismo";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener parámetros de la URL
    $table = isset($_GET['table']) ? $_GET['table'] : '';
    $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';
    $nivel = isset($_GET['nivel']) ? $_GET['nivel'] : '';

    // Consulta SQL para obtener detalles de la tabla según la fecha y el nivel
    $sql = "SELECT * FROM $table WHERE fecha_competencia = '$fecha' AND nivel = '$nivel'";

    // Ejecutar la consulta
    $result = $conn->query($sql);

    if ($result === false) {
        echo "Error en la consulta: " . $conn->error;
    } else {
        echo '<h2 class="mb-4 text-center">Detalles de la Competencia</h2>';
        echo '<h3 class="text-center" style="color: blue; font-family: Arial, sans-serif;"><strong>Fecha:</strong> ' . $fecha . '</h3>';
        echo '<h3 class="text-center" style="color: green; font-family: \'Times New Roman\', serif;"><strong>Nivel:</strong> ' . $nivel . '</h3>';
        

        if ($result->num_rows > 0) {
            echo '<div class="table-responsive">';
            echo '<table class="table table-bordered table-striped custom-table">';

            echo '<thead class="thead-dark">';
            echo '<tr>';
            $row = $result->fetch_assoc();
            foreach ($row as $column => $value) {
                if ($column !== 'ID_Atleta') {
                    echo '<th>' . $column . '</th>';
                }
            }
            echo '</tr>';
            echo '</thead>';

            echo '<tbody>';
            do {
                echo '<tr>';
                foreach ($row as $column => $value) {
                    if ($column !== 'ID_Atleta') {
                        echo '<td>' . $value . '</td>';
                    } else {
                        echo '<td class="hidden">' . $value . '</td>';
                    }
                }
                echo '</tr>';
            } while ($row = $result->fetch_assoc());
            echo '</tbody>';

            echo '</table>';
            echo '</div>';
        } else {
            echo '<p class="alert alert-warning mt-3">No hay datos disponibles para la fecha y nivel seleccionados.</p>';
        }
    }

    $conn->close();
    ?>
    <BR><BR><BR><BR><BR>

 <!-- Panel de Publicidad con imágenes -->
 <div class="publicidad" style="text-align: center; padding: 20px;">
          <div class="container">
            <div id="publicidad-container" class="vertical-ad">
              <!-- Las imágenes de la publicidad se cargarán aquí -->
            </div>
          </div>
        </div>
        
        <style>
          .vertical-ad {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-end;
            height: 100%;
          }
        
          .vertical-ad img {
            max-height: 160px; /* Cambia el valor para ajustar el tamaño de las imágenes */
            border: 2px solid #0011fa; /* Agrega un borde a las imágenes (color naranja) */
            border-radius: 10px; /* Agrega bordes redondeados */
            margin: 10px 0; /* Espacio entre imágenes */
            box-shadow: 4px 4px 8px rgba(102, 255, 0, 0.2); /* Agrega una sombra a las imágenes */
          }
        </style>
        
        <script>
          document.addEventListener("DOMContentLoaded", function() {
            // Array de URLs de imágenes de publicidad
            var imagenesPublicidad = [
              "https://www.ceupe.com/images/easyblog_articles/3406/b2ap3_thumbnail_publicidad.png",
              "https://i.ytimg.com/vi/xFNilhMACo0/maxresdefault.jpg",
              "https://cdn.marketingandweb.es/wp-content/uploads/Tipos-de-publicidad-online.png",
              // Agrega más rutas de imágenes aquí
            ];
        
            // Función para mostrar una imagen aleatoria de la publicidad
            function mostrarImagenAleatoria() {
              var publicidadContainer = document.getElementById("publicidad-container");
              var randomIndex = Math.floor(Math.random() * imagenesPublicidad.length);
              var imageUrl = imagenesPublicidad[randomIndex];
        
              // Crea un elemento de imagen y establece su fuente
              var img = document.createElement("img");
              img.src = imageUrl;
              img.alt = "Publicidad";
        
              // Limpia el contenedor y agrega la imagen
              publicidadContainer.innerHTML = "";
              publicidadContainer.appendChild(img);
            }
        
            // Mostrar una imagen aleatoria al cargar la página
            mostrarImagenAleatoria();
        
            // Establece un temporizador para cambiar la imagen periódicamente
            setInterval(mostrarImagenAleatoria, 5000); // Cambia la imagen cada 5 segundos (5000 ms)
          });
        </script> 
        <BR>
           <!-- Pie de página -->
        <footer style="background-color: #535353; padding: 20px; color: #ffffff;">
          <div class="container">
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
                  <p style="text-align: center;">© Todos los derechos reservados. Desarrollado por EDWARD JUANANTE RODRIGUEZ</p>

              </div>
          </div>
        </footer>
        </body>
</html>
