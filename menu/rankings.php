
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
        <li><a href="calendario.html">CALENDARIO</a></li>
        <li><a href="atletas.html">ATLETAS</a></li>
        <li><a href="rankings.php">RANKINGS</a></li>
      </ul>
    </div>
  </div>
    </nav>
    <BR><BR><BR><BR><BR>
    <?php
// Configuración de la conexión a la base de datos
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "atletismo";

// Crear la conexión
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Verificar errores en la conexión
if ($conn->connect_error) {
    die("La conexión a la base de datos ha fallado: " . $conn->connect_error);
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Realizar la consulta
    $sql = "SELECT r.*, a.genero
            FROM resultados_80metrosplanos_cb r
            JOIN atletas a ON r.DNI_Atleta = a.dni
            WHERE r.año = 2023 AND r.Nivel = 'DISTRITAL' AND a.genero = 'M'";

    $result = $conn->query($sql);

    // Mostrar resultados o mensaje de error
    if ($result) {
        if ($result->num_rows > 0) {
            echo "<div class='container result-container'>
                    <h2>Resultados</h2>
                    <table class='table'>
                        <thead>
                            <tr>
                                <th>ID Atleta</th>
                                <th>DNI Atleta</th>
                                <th>Resultado</th>
                                <th>Lugar</th>
                                <th>Serie</th>
                                <th>Pista</th>
                                <th>Nivel</th>
                                <th>Año</th>
                                <th>Género</th>
                            </tr>
                        </thead>
                        <tbody>";

            $hayResultadosNoCero = false;

            // Mostrar cada fila de resultados
            while ($row = $result->fetch_assoc()) {
                // Verificar si el resultado es diferente de cero
                if ($row['Resultado'] != 0) {
                    $hayResultadosNoCero = true;

                    echo "<tr>
                            <td>{$row['ID_Atleta']}</td>
                            <td>{$row['DNI_Atleta']}</td>
                            <td>{$row['Resultado']}</td>
                            <td>{$row['Lugar']}</td>
                            <td>{$row['Serie']}</td>
                            <td>{$row['Pista']}</td>
                            <td>{$row['Nivel']}</td>";

                    // Verificar si la clave 'Año' existe antes de mostrarla
                    if (isset($row['Año'])) {
                        echo "<td>{$row['Año']}</td>";
                    } else {
                        echo "<td>No disponible</td>";
                    }

                    echo "<td>{$row['genero']}</td>
                        </tr>";
                }
            }

            echo "</tbody>
                </table>";

            if (!$hayResultadosNoCero) {
                echo "<p>Todos los resultados son cero. En proceso...</p>";
            }

            echo "</div>";
        } else {
            echo "<div class='container result-container'>
                    <p>No se encontraron resultados para los criterios seleccionados.</p>
                </div>";
        }
    } else {
        echo "Error en la consulta: " . $conn->error;
    }
}

// Cerrar la conexión
$conn->close();
?>

<!-- Formulario con el botón para mostrar los resultados -->
<div class='container form-container'>
    <form action='<?php echo $_SERVER["PHP_SELF"]; ?>' method='post'>
        <div class='form-group'>
            <button type='submit' class='btn btn-primary' name='submit'>Mostrar Resultados</button>
        </div>
    </form>
</div>

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