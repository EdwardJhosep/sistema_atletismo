
<!DOCTYPE html>
<html>
<head>
    <title>Asignar Horas Personalizadas</title>
    <script>
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "../php/obtener_hora_cierre.php", true);
        xhr.send();

        function iniciarContador(horaCierre) {
            var ahora = Math.floor(Date.now() / 1000); // Timestamp actual
            var tiempoSesion = horaCierre - ahora;

            function actualizarContador() {
                var minutos = Math.floor(tiempoSesion / 60);
                var segundos = tiempoSesion % 60;

                document.getElementById("contador").innerHTML = minutos + "m " + segundos + "s";

                if (tiempoSesion <= 0) {
                    // Redirige al árbitro al index.html u otra acción de cierre de sesión
                    window.location.href = "../index.html";
                } else {
                    tiempoSesion--;
                    setTimeout(actualizarContador, 1000);
                }
            }

            actualizarContador();
        }

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var respuesta = JSON.parse(xhr.responseText);
                var horaCierre = respuesta.horaCierre;
                iniciarContador(horaCierre);
            }
        };
    </script>
</head>
<body>
    <h2>Árbitros:</h2>
    <p>Tiempo restante : <span id="contador"></span></p>
    <!-- Resto del formulario -->
</body>
</html>
