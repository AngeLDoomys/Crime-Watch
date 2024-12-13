<?php
    include("setup/config.php");

    session_start();

    if(isset($_GET['idincidente'])) {
        $sql = "SELECT
                    incidente.idincidente,
                    incidente.descripcion,
                    incidente.fecha,
                    incidente.hora,
                    incidente.latitud,
                    incidente.longitud,
                    usuarios.nombres,
                    usuarios.apellidos
                FROM incidente
                INNER JOIN usuarios ON incidente.idusuario = usuarios.idusu
                WHERE incidente.idincidente = ".$_GET['idincidente'];
        $result = mysqli_query(conectar(), $sql);
        $datos = mysqli_fetch_array($result);
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="img/logos/favicon.ico">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/reportes.css">
    <link rel="stylesheet" href="css/navperfil.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="js/bootstrap.bundle.js"></script>
    <!-- Asegúrate de reemplazar YOUR_API_KEY con tu clave de API de Google Maps -->
    <script src="https://maps.googleapis.com/maps/api/" async defer></script>
    <title>Robo Reporte</title>
</head>
<body>
    <header>
        <div id="menu">
            <div id="logo"><a href="index.php"><img src="img/logos/CrimeWatch.png" width="110px" height="95px"></div></a>
            <nav>
                <ul>
                    <li><a href="index.html" class="busqueda">Home</a></li>
                    <li><a href="iniciarsesion.html" class="ingreso">Iniciar Sesión</a></li>
                    <li><a href="registro.html" class="registro">Registrarse</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="row">
        <div class="leftcolumn">
            <div class="card">
                <div class="card-header color">Detalles del reporte</div>
                    <h2>Numero del Incidente: <?php echo $datos['idincidente'];?></h2>
                    <h5>Fecha del reporte: <?php echo $datos['fecha'];?></h5>
                    <h5>Hora del Reporte: <?php echo $datos['hora'];?></h5>
                    
                    <!-- Contenedor para el mapa -->
                    <div id="map" style="height: 400px; width: 100%;"></div>
            </div>
        </div>

        <div class="rightcolumn">
            <div class="card">
                <div class="card-header color">Datos del Reportante: </div>
                <div class="card-body">
                    <!-- Nombre y Apellido concatenados -->
                    <span class="texto0 titulo" aria-hidden="true">Nombre: <?php echo $datos['nombres'] . " " . $datos['apellidos']; ?></span><br/>
                </div>
            </div>
        </div>
    </div>

    <div class="container-xl px-4 mt-4">
        <div class="card mb-4 cajainfo">
            <div class="card-header color2">Descripción del Incidente</div>
            <div class="card-body cajainfo">
                <span class="" aria-hidden="true"><?php echo $datos['descripcion'];?></span>
            </div>
        </div>
    </div>

    <footer>Todos Los derechos reservados Crime Watch 2024</footer>

    <script>
        // Función para inicializar el mapa
        function initMap() {
            var location = {lat: <?php echo $datos['latitud']; ?>, lng: <?php echo $datos['longitud']; ?>};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: location
            });
            var marker = new google.maps.Marker({
                position: location,
                map: map
            });
        }
    </script>
</body>
</html>
