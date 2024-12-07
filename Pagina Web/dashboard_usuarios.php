<?php

include("setup/config.php");

session_start();


if(isset($_SESSION['usu']))
{
    switch ($_SESSION['tipo']){
        case 1: $tipo="Admin";
            break;
        case 2: $tipo="Usuario";
            break;
    }

    if(isset($_GET['idusu']))
    {
        $sql_usu="select * from usuarios where idusu=".$_GET['idusu'];
        $result_usu=mysqli_query(conectar(),$sql_usu);
        $datos_usu=mysqli_fetch_array($result_usu);
    }

    if($_SESSION['tipo']==2)
    {
        header("Location:error.html");
    }

?>

<html>
    <head>
        <title>DASHBOARD</title>
        <meta charset="UTF-8">
        <link rel="shortcut icon" type="x-icon" href="img/favicon.ico">
        <link rel="stylesheet" href="css/dashboardadm.css">
        <link rel="stylesheet" href="css/navperfiladm.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/validarregistro.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="js/mijsusu.js"></script>
    </head>
    <header>
        <div id="logo"><img src="img/PENKA2.png" width="150px" height="105px"></div>
        <div id="menu">
            <nav>
            <div class="profile-dropdown">
        <div onclick="toggle()" class="profile-dropdown-btn">
          <div class="profile-img">
            <i>
            <?php
                if(isset($_SESSION['idusu']))
                {
                ?>
                    <img class="img-account-profile rounded-circle mb-2" src="img/fotos/;?>" width="80px">
                                        
                    <?php }else{
                    ?>
                    <img class="img-account-profile rounded-circle mb-2" src="img/fotos/comodin.png" width="80px">
                    <?php
                }
            ?>
            </i>
          </div>

          <span
            ><?php echo $_SESSION['usu'];?>
            <?php echo $tipo;?>
            <i class="fa fa-bars"></i>
          </span>
        </div>

        <ul class="profile-dropdown-list">

          <li class="profile-dropdown-list-item">
            <a href="cerrar.php">
              <i class="fa fa-sign-out"></i>
              Cerrar Sesión
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <script src="js/perfil.js"></script>
            </nav>
        </div>
    </header>
    <body>
        <div id="sesion">
                <!-- Load an icon library -->
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

                <!-- The sidebar -->
                <div class="sidebar">
                <div id="logo"><img src="img/logos/CrimeWatch.png" width="150px" height="135px"></div>
                <a href="dashboard_usuarios.php"><i class="fa fa-fw fa-home"></i> Adm. Usuarios</a>
            </div>
            <hr>
            <div id="menu2">
            <div class="card">
                <div class="card-header textalign color">Administrador de Usuarios</div>
                <div class="card-body">
                <form action="crud_usuarios.php" method="post" name="frm_usu" enctype="multipart/form-data">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                            <span class="form-label">Apellidos:</span>
                            <input type="text" class="form-control" placeholder="Apellido(s)" id="frm_apellidos" name="frm_apellidos" value="<?php if(isset($_GET['idusu'])){ echo $datos_usu['apellidos'];}?>">
                            <?php if(!isset($_GET['idusu'])){?>
                            <span class="form-label">Ingrese Contraseña:</span>
                            <input type="password" class="form-control" placeholder="Contraseña" id="frm_pass" name="frm_pass">
                            <?php } ?>
                            <span class="form-label">Estado:</span>
                            <select class="form-select" id="frm_estado" name="frm_estado">
                                <option value="3">Seleccionar</option>
                                <option value="1" <?php if(isset($_GET['idusu'])){ if($datos_usu['estado']==1){?> selected <?php }} ?>>Activo</option>
                                <option value="0" <?php if(isset($_GET['idusu'])){ if($datos_usu['estado']==0){?> selected <?php }} ?>>Inactivo</option>
                            </select>
                            <span class="form-label">Telefono:</span>
                            <input type="text" class="form-control" placeholder="9 XXXX XXXX (Todo Junto)" id="frm_movil" name="frm_movil" value="<?php if(isset($_GET['idusu'])){ echo $datos_usu['telefono'];}?>">
                            </div>
                            <div class="col-sm-6">
                            <span class="form-label">Nombres:</span>
                            <input type="text" class="form-control" placeholder="Nombre(s)" id="frm_nombres" name="frm_nombres" value="<?php if(isset($_GET['idusu'])){ echo $datos_usu['nombres'];}?>">
                            <?php if(!isset($_GET['idusu'])){?>
                            <span class="form-label">Repita Contraseña:</span>
                            <input type="password" class="form-control" placeholder="Repetir Contraseña" id="frm_rep_pass" name="frm_rep_pass">
                            <?php } ?>
                            <span class="form-label">Usuario (email):</span>
                            <input type="text" class="form-control" placeholder="Correo Electronico" id="frm_usu" name="frm_usu" value="<?php if(isset($_GET['idusu'])){ echo $datos_usu['usuario'];}?>">
                            <span class="form-label">Tipo de Usuario:</span>
                            <select class="form-select" id="frm_tipo" name="frm_tipo">
                                <option value="0">Seleccionar</option>
                                <?php

                                $sql="select * from tipousu where estado=1";
                                $result=mysqli_query(conectar(),$sql);
                                while($datos=mysqli_fetch_array($result))
                                {
                                ?>
                                    <option value="<?php echo $datos['idtipousu'];?>" <?php if(isset($_GET['idusu'])){ if($datos_usu['idtipousu']==$datos['idtipousu']){?> selected <?php }} ?>><?php echo $datos['nombre'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12 textalign">
                            <?php

                            if(!isset($_GET['idusu']))
                            {
                            ?>
                            <input type="button" class="btn btn-primary" onclick="document.frm_usu.accion.value='INGRESAR'; this.form.submit();" value="INGRESAR">
                            <?php

                            }else{
                                ?>
                            <input type="button" class="btn btn-success"  onclick="document.frm_usu.accion.value='MODIFICAR'; this.form.submit();" value="MODIFICAR">
                            <input type="button" class="btn btn-danger"  onclick="document.frm_usu.accion.value='ELIMINAR'; this.form.submit();" value="ELIMINAR">
                            <?php
                            }
                            ?>
                            <input type="button" class="btn btn-warning"  onclick="document.frm_usu.accion.value='CANCELAR'; this.form.submit();" value="CANCELAR">
                            <input type="hidden" name="accion">
                            <input type="hidden" name="idoc" value="<?php if (isset($_GET['idusu'])){echo $_GET['idusu'];}?>">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <div id="busqueda">
            <span class="form-label">Buscar:</span>
            <input type="text" id="txt" class="form-control">
        </div>
        <div id="menu3">
        </div>


    </body>
</html>
<?php
}else{
    header("Location:error.html");
}
?>