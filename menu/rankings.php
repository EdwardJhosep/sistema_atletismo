
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
    .container1 {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        margin-top: 50px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }

    select {
        width: 100%;
        padding: 8px;
        margin-bottom: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    button {
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }
</style>

<div class='container'>
    <form id="myForm" action='<?php echo $_SERVER["PHP_SELF"]; ?>' method='post'>
        <label for="year">Año:</label>
        <select name="year" id="year">
            <option value="2023">2023</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
            <option value="2026">2026</option>
        </select>

        <label for="level">Nivel:</label>
        <select name="level" id="level">
            <option value="DISTRITAL">DISTRITAL</option>
            <option value="REGIONAL">REGIONAL</option>
            <option value="PROVINCIAL">PROVINCIAL</option>
        </select>

        <label for="gender">Género:</label>
        <select name="gender" id="gender">
            <option value="M">Masculino</option>
            <option value="F">Femenino</option>
        </select>

        <label for="category">Categoría:</label>
        <select name="category" id="category">
            <option value="Categoria A">Categoria A</option>
            <option value="Categoria B">Categoria B</option>
            <option value="Categoria C">Categoria C</option>
        </select>

        <label for="table">Tabla:</label>
        <select name="table" id="table">
            <!-- This will be dynamically populated based on the selected category -->
        </select>

        <button type='submit' class='btn btn-primary mt-3' name='submit'>Mostrar Resultados</button>
    </form>
</div>
<BR<BR><BR><BR><BR><BR>

<script>
    // Define tables based on categories
    var tablesByCategory = {
        'Categoria A': ['Resultados_600MetrosPlanos_CA','Resultados_60MetrosVallas_CA','Resultados_60Metros_CA','Resultados_LanzamientoPelota_CA','Resultados_SaltoLargo_CA','Resultados_SaltoAlto_CA'],
        'Categoria B': ['Resultados_80MetrosPlanos_CB','Resultados_150MetrosPlanos_CB','Resultados_800MetrosPlanos_CB','Resultados_2000MetrosPlanos_CB','Resultados_80MetrosVallas_CB','Resultados_100MetrosVallas_CB','Resultados_3KmMarcha_CB','Resultados_5KmMarcha_CB','Resultados_LanzamientoJabalina500g_CB','Resultados_LanzamientoJabalina600g_CB','Resultados_ImpulsionBala3Kg_CB','Resultados_ImpulsionBala4Kg_CB','Resultados_LanzamientoDisco750g_CB','Resultados_LanzamientoDisco1Kg_CB','Resultados_LanzamientoMartillo3Kg_CB','Resultados_LanzamientoMartillo4Kg_CB','Resultados_SaltoLargoImpulso_CB','Resultados_SaltoAlto_CB','Resultados_SaltoGarrocha_CB','Resultados_Hexatlon_CB','Resultados_Pentatlon_CB','Resultados_Relevo5x80metros_CB'],
        'Categoria C': ['Resultados_100MetrosPlanos_CC','Resultados_200MetrosPlanos_CC','Resultados_LanzamientoDisco1kg_CC','Resultados_LanzamientoDisco1.5kg_CC','Resultados_LanzamientoMartillo3kg_CC','Resultados_LanzamientoMartillo5kg_CC','Resultados_LanzamientoJabalina500gr_CC','Resultados_LanzamientoJabalina700gr_CC','Resultados_ImpulsionBala3kg_CC','Resultados_ImpulsionBala5kg_CC','Resultados_SaltoLargoConImpulso_CC','Resultados_SaltoAlto_CC','Resultados_SaltoConGarrocha_CC','Resultados_400MetrosPlanos_CC','Resultados_1500MetrosPlanos_CC','Resultados_3000MetrosPlanos_CC','Resultados_100MetrosConVallas_CC','Resultados_110MetrosConVallas_CC','Resultados_5KmMarcha_CC','Resultados_10KmMarcha_CC','Resultados_2000mConObstaculos_CC']
    };

    // Function to populate the tables dropdown based on the selected category
    function populateTables() {
        var category = document.getElementById('category').value;
        var tablesDropdown = document.getElementById('table');

        // Clear existing options
        tablesDropdown.innerHTML = '';

        // Populate options based on the selected category
        tablesByCategory[category].forEach(function (table) {
            var option = document.createElement('option');
            option.value = table;
            option.text = table;
            tablesDropdown.add(option);
        });
    }

    // Add an event listener to the category dropdown to dynamically populate tables
    document.getElementById('category').addEventListener('change', populateTables);

    // Initial population when the page loads
    populateTables();
</script>



<script>
    function submitForm() {
        document.getElementById("myForm").submit();
    }
</script>
    <?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "atletismo";

// Create the connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection to the database has failed: " . $conn->connect_error);
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Get the values from the form
    $year = isset($_POST['year']) ? $_POST['year'] : '';
    $level = isset($_POST['level']) ? $_POST['level'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $tableName = isset($_POST['table']) ? $_POST['table'] : ''; // Add a new input field for the table name in your form

    // Construct the SQL query with the form values and table name
    $sql = "SELECT r.*, a.genero
            FROM $tableName r
            JOIN atletas a ON r.DNI_Atleta = a.dni
            WHERE r.año = '$year' AND r.Nivel = '$level' AND a.genero = '$gender'
            ORDER BY r.Lugar ASC";

    $result = $conn->query($sql);

    // Display results or an error message
    if ($result) {
        if ($result->num_rows > 0) {
            echo "<div class='container mt-4'>
                    <h2 class='mb-3'>Resultados</h2>
                    <div class='table-responsive'>
                        <table class='table table-striped'>
                            <thead>
                                <tr>
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

            // Display each row of results
            while ($row = $result->fetch_assoc()) {
                // Check if the result is different from zero
                if ($row['Resultado'] != 0) {
                    $hayResultadosNoCero = true;

                    echo "<tr>
                            <td>{$row['DNI_Atleta']}</td>
                            <td>{$row['Resultado']}</td>
                            <td>{$row['Lugar']}</td>
                            <td>{$row['Serie']}</td>
                            <td>{$row['Pista']}</td>
                            <td>{$row['Nivel']}</td>";

                    // Check if the 'año' key exists before displaying it
                    if (isset($row['año'])) {
                        echo "<td>{$row['año']}</td>";
                    } else {
                        echo "<td>No disponible</td>";
                    }

                    echo "<td>{$row['genero']}</td>
                        </tr>";
                }
            }

            echo "</tbody>
                </table>
            </div>";

            if (!$hayResultadosNoCero) {
                echo "<p class='mt-3'>Todos los resultados son cero. En proceso...</p>";
            }

            echo "</div>";
        } else {
            echo "<div class='container mt-4'>
                    <p>No se encontraron resultados para los criterios seleccionados.</p>
                </div>";
        }
    } else {
        echo "<div class='container mt-4'>
                <p class='text-danger'>Error en la consulta: " . $conn->error . "</p>
            </div>";
    }
}

// Close the connection
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

