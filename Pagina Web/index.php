<?php
    include("setup/config.php");

    // Consulta SQL para obtener todos los incidentes con sus ubicaciones
    $sql = "SELECT idincidente, descripcion, latitud, longitud FROM incidente";
    $result = mysqli_query(conectar(), $sql);
    $reportes = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $reportes[] = $row;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="img/logos/favicon.ico">
    <link rel="stylesheet" href="css/CrimeHome.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <title>Neighborhood Crime Watch</title>
</head>
<body>
    <header>
        <div id="menu">
          <div id="logo"><img src="img/logos/CrimeWatch.png" width="110px" height="95px"></div>
            <nav>
                <ul>
                    <li><a href="busqueda.php" class="busqueda">Reportes</a></li>
                    <li><a href="iniciarsesion.html" class="ingreso">Iniciar Sesión</a></li>
                    <li><a href="registro.php" class="registro">Registrarse</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <input type="text" id="place_input" placeholder="Ingresa una ubicación...">
    <section id="map">
      <script async
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBepMDN-G6Z9GVFVOW7ULSB2RJI4nARlG4&libraries=places&callback=initMap">
      </script>
      <script>
        const clCoords = { lat: -29.907777777778, lng: -71.254166666667};
        const mapDiv = document.getElementById("map");
        const input = document.getElementById("place_input");
        let map;
        let marker;
        let autocomplete;

        // Agregar los reportes obtenidos del PHP
        const reportes = <?php echo json_encode($reportes); ?>;

        function initMap(){
          map = new google.maps.Map(mapDiv, {
            center: clCoords,
            zoom: 10,
          });

          // Crear un marcador para cada reporte
          reportes.forEach(function(reporte) {
            const latLng = { lat: parseFloat(reporte.latitud), lng: parseFloat(reporte.longitud) };
            const marker = new google.maps.Marker({
              position: latLng,
              map: map,
              title: reporte.descripcion // Puedes mostrar la descripción en el marcador
            });
          });

          initAutocomplete();
        }

        function initAutocomplete(){
          autocomplete = new google.maps.places.Autocomplete(input);
          autocomplete.addListener('place_changed',function(){
            const place = autocomplete.getPlace();
            map.setCenter(place.geometry.location);
            marker.setPosition(place.geometry.location);
          });
        }
      </script> 
    </section>

    <section id="PropHeader">
      <span>Neighborhood Crime Watch</span>
    </section>

    <section id="textoSection">
      <div class="container">
        <h2>Sobre Nosotros</h2>
        <p>Con nuestro servicio llamado Crime Watch, te ofrecemos la oportunidad de reportar un crimen en el momento en el que este este ocurriendo.
          Ya sea en su mismo hogar, o en el hogar de su vecino, al reportarlo de manera instantánea quedará registrado y se le informará sobre el robo mediante una alarma a todos los vecinos del área.
          También, aquí en nuestra página web podrá revisar los crímenes reportados a lo largo de la ciudad.
        </p>
      </div>
    </section>

    <footer>Todos Los derechos reservados Crime Watch 2024</footer>
</body>
</html>