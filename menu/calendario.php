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
        <li><a href="calendario.php">CALENDARIO</a></li>
        <li><a href="atletas.html">ATLETAS</a></li>
        <li><a href="rankings.php">RANKINGS</a></li>
      </ul>
    </div>
  </div>
    </nav>
    <BR><BR><BR><BR><BR>
    <style>
        /* Clickable Cards Styles */
.clickable {
    cursor: pointer;
    color: #333;
    text-decoration: none;
    display: block;
    padding: 10px;
    margin: 5px 0;
    border: 1px solid #ccc; /* Color del borde de los elementos clicables */
    border-radius: 5px;
    background-color: #fff;
    transition: background-color 0.3s ease;
}

.clickable:hover {
    background-color: #f0f0f0;
}

.selected {
    background-color: #D3FAD2;
    color: #fff;
}

/* Card Styles */
.card {
    border: 1px solid #ccc;
    border-radius: 8px;
    margin-bottom: 20px;
    background-color: #fff;
}

.card-header {
    background-color: #D3FAD2;
    color: #fff;
    padding: 15px;
    border-bottom: 1px solid #ccc;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}

.card-body {
    padding: 20px;
}

.card-text {
    margin-bottom: 0;
    color: #333;
}

/* Advertising Panel Styles */
.publicidad {
    text-align: center;
    padding: 20px;
}

.vertical-ad {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-end;
    height: 100%;
}

.vertical-ad img {
    max-height: 160px;
    border: 2px solid #ccc;
    border-radius: 10px;
    margin: 10px 0;
    box-shadow: 4px 4px 8px rgba(102, 255, 0, 0.2);
}

/* Footer Styles */
footer {
    background-color: #535353;
    padding: 20px;
    color: #ffffff;
}

/* Social Icons Styles */
footer ul {
    list-style: none;
    padding: 0;
}

footer ul li {
    display: inline-block;
    margin-right: 10px;
}

footer ul li a {
    color: #ffffff;
    text-decoration: none;
}

footer ul li a:hover {
    color: #007bff;
}

/* Copyright Text Styles */
footer p {
    text-align: center;
    margin-top: 15px;
}
#filtered-results-container {
    background-color: #f5f5f5; /* Cambia este color según tu preferencia, es un gris claro */
    padding: 15px; /* Reduje el relleno para hacerlo más compacto */
    border-radius: 8px; /* Reduje el radio del borde */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-top: 10px; /* Ajusta el margen según sea necesario */
    max-width: 1200px; /* Establece el ancho máximo según tus preferencias */
    margin-left: auto; /* Centra el contenedor horizontalmente */
    margin-right: auto;
}

/* Estilo para el texto dentro del contenedor */
#filtered-results-container p {
    margin-bottom: 8px; /* Reduje el margen inferior */
    color: #333; /* Color de texto oscuro */
}

#filtered-results-container .clickable {
    color: #007bff; /* Color de enlace azul para elementos clicables */
}

#filtered-results-container .clickable:hover {
    text-decoration: underline; /* Subraya el enlace al pasar el cursor */
}
    </style>
    <div id="filtered-results-container">
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

// Obtener fechas de inicio y fin (puedes ajustarlas según tus necesidades)
$fecha_inicio = '2023-01-01';
$fecha_fin = '2030-12-31';

// Obtener el nombre de las tablas que contienen la columna 'fecha_competencia'
$result = $conn->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME = 'fecha_competencia' AND TABLE_SCHEMA = '$dbname'");

if ($result === false) {
    // Imprimir el mensaje de error
    echo '<div class="alert alert-danger" role="alert">';
    echo "Error al obtener el nombre de las tablas: " . $conn->error;
    echo '</div>';
} else {
    // Almacenar las tablas y sus fechas en un array asociativo
    $competencias = [];

    // Iterar sobre las tablas
    while ($row = $result->fetch_assoc()) {
        $table = $row['TABLE_NAME'];

        // Consulta SQL para obtener fechas y niveles de la tabla actual dentro del rango
        $sql = "SELECT fecha_competencia, nivel FROM $table WHERE fecha_competencia BETWEEN '$fecha_inicio' AND '$fecha_fin' ORDER BY nivel";

        // Ejecutar la consulta
        $resultTable = $conn->query($sql);

        if ($resultTable === false) {
            // Imprimir el mensaje de error
            echo '<div class="alert alert-danger" role="alert">';
            echo "Error en la consulta para la tabla $table: " . $conn->error;
            echo '</div>';
        } elseif ($resultTable->num_rows > 0) {
            // Almacenar las fechas y niveles en el array asociativo
            $competencias[$table] = [];
            while ($rowTable = $resultTable->fetch_assoc()) {
                $competencias[$table][] = [
                    'fecha_competencia' => $rowTable['fecha_competencia'],
                    'nivel' => $rowTable['nivel']
                ];
            }
        }
    }

    // Ordenar el array por nivel y mostrar la información
    foreach ($competencias as $table => $fechas) {
        echo '<div class="card mb-4">';
        echo '<div class="card-header">';
        echo '<div class="card-header" style="background-color: #007bff; color: #D3FAD2; padding: 5px; border-bottom: 1px solid #ccc; border-top-left-radius: 8px; border-top-right-radius: 8px;">';
        echo "<p style='font-size: 20px; color: black;'>PROGRAMACION DEL AÑO : $table</p>";
        echo '</div>';
        
        echo '</div>';
        echo '<div class="card-body">';
        // Ordenar las fechas por nivel
        usort($fechas, function ($a, $b) {
            return strcmp($a['nivel'], $b['nivel']);
        });

        // Mostrar las fechas ordenadas
        foreach ($fechas as $rowTable) {
            echo '<p class="card-text clickable" data-table="' . $table . '" data-fecha="' . $rowTable['fecha_competencia'] . '" data-nivel="' . $rowTable['nivel'] . '">';
            echo "Fecha Competencia: " . $rowTable['fecha_competencia'] . " - Nivel: " . $rowTable['nivel'];
            echo '</p>';
            // Puedes mostrar otras columnas según tus necesidades
        }

        echo '</div>'; // Cierre de card-body
        echo '</div>'; // Cierre de card
    }
}
echo '</div>';

$conn->close();
?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Función para manejar el clic en una fecha y nivel
        function handleDateLevelClick(table, fecha, nivel) {
            // Agregar clase 'selected' al elemento clicado y remover de otros elementos
            var clickableElements = document.querySelectorAll('.clickable');
            clickableElements.forEach(function (element) {
                element.classList.remove('selected');
            });
            this.classList.add('selected');

            // Puedes realizar una nueva consulta aquí y mostrar los datos de la tabla según la fecha y el nivel seleccionados
            // Por ejemplo, puedes redirigir a una nueva página con los parámetros de la consulta
            window.location.href = 'detalle_tabla.php?table=' + table + '&fecha=' + fecha + '&nivel=' + nivel;
        }

        // Asignar evento de clic a los elementos con la clase 'clickable'
        var clickableElements = document.querySelectorAll('.clickable');

        clickableElements.forEach(function (element) {
            element.addEventListener('click', function () {
                // Obtener datos de atributos personalizados (data)
                var table = this.getAttribute('data-table');
                var fecha = this.getAttribute('data-fecha');
                var nivel = this.getAttribute('data-nivel');

                // Manejar el clic
                handleDateLevelClick.call(this, table, fecha, nivel);
            });
        });
    });
</script>
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