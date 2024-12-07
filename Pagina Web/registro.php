<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<link rel="shortcut icon" type="x-icon" href="img/logos/favicon.ico">
    <link rel="stylesheet" href="css/CrimeRegister.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/validarregistro.js"></script>
    <title>Registro</title>
</head>
<body>
<div class="card">
        <header class="card-header">
            <div id="logo"><img src="img/logos/CrimeWatch.png" width="230px" height="200px"></div>
            <h4 class="card-title mt-2 centrado">Registrarse</h4>
        </header>
        <article class="card-body">
        <form action="crud_registro.php" method="post" name="frm_registro">
            <div class="form-row">
                <div class="col form-group">
                    <label>Nombre </label>   
                    <input type="text" class="form-control" placeholder="Nombre(s)" required id="nombre" name="nombre">
                </div> <!-- form-group end.// -->
                <div class="col form-group">
                    <label>Apellido</label>
                      <input type="text" class="form-control" placeholder="Apellido(s)" required id="apellido" name="apellido">
                </div> <!-- form-group end.// -->
            </div> <!-- form-row end.// -->
            <div class="form-group">
                <label>Correo Eletronico</label>
                <input type="text" class="form-control" placeholder="" requiered id="email" name="email">
            </div> <!-- form-group end.// -->
            <div class="form-group">
                <label>Contraseña</label>
                <input class="form-control" type="password" required id="clave" name="clave">
            </div> <!-- form-group end.// -->  
            <div class="form-group">
                <label>Repetir Contraseña</label>
                <input class="form-control" type="password" id="reclave" name="reclave">
            </div> <!-- form-group end.// --> 
            <div class="form-row">
                <div class="form-group">
                  <label>Telefono</label>
                  <input type="text" class="form-control" placeholder="" required id="movil" name="movil">
                </div> <!-- form-group end.// -->
                <div class="form-group col-md-6">
                </div> <!-- form-group end.// -->
            </div> <!-- form-row.// -->
            <div class="form-group">
            </div> <!-- form-group end.// -->   
            <div class="form-group centrado">
                <input type="submit" class="btn btn-primary" onclick="validar(this.value);" value="Registrarse">
            </div> <!-- form-group// -->      
            <small class="text-muted moverizq">Al apretar el boton de 'Registrarse', usted confirma que acepta nuestros</small>
            <small class="text-muted moverizq2">Terminos de Servicio y Privacidad.</small>                                             
        </form>
        </article> <!-- card-body end .// -->
        <div class="border-top card-body text-center">Ya tiene una cuenta? <a href="iniciarsesion.html">Ingresar</a></div>
        </div> <!-- card.// -->
        </div> <!-- col.//-->
        
        </div> <!-- row.//-->
        
        
        </div> 
        <!--container end.//-->
        
        <br><br>
        <br><br>
        </article>
</body>
</html>