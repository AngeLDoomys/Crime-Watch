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

    if(isset($_SESSION['idusu']))
    {
        $sql_usu="select * from usuarios where idusu=".$_SESSION['idusu'];
        $result_usu=mysqli_query(conectar(),$sql_usu);
        $datos_usu=mysqli_fetch_array($result_usu);
    }
?>

<html>
    <head>
        <title>DASHBOARD</title>
        <meta charset="UTF-8">
        <link rel="shortcut icon" type="x-icon" href="img/favicon.ico">
        <link rel="stylesheet" href="css/dashboarded3.css">
        <link rel="stylesheet" href="css/navperfil.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>
    <header>
        <div id="logo"><img src="img/PENKA2.png" width="150px" height="135px"></div>
        <div id="menu">
            <nav>
            <div class="profile-dropdown">
        <div onclick="toggle()" class="profile-dropdown-btn">
          <div class="profile-img">
            <i>
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
            <a href="frm_perfil.php">
              <i class="fa-pencil-square"></i>
              Editar Perfil
            </a>
          </li>

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
            <div class="card">
                <div class="card-header">   
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                    </svg>  
                Bienvenido usuario al sistema, <?php echo $tipo;?> </div>
            <hr>
            <div id="menu2">
            <div class="card">
                <div class="card-header textalign color">Seleccionar Acciones a realizar</div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-4">
                             <?php
                             if($_SESSION['tipo']!=1)
                             {
                                 ?>
                                <div class="caja">
                                    <img src="img/editarperfil.png"><br>
                                    Editar Perfil
                                </div>
                            <?php
                             }else{
                                header("location:dashboard_usuarios.php");
                                ?>
                                <div class="caja">
                                    <a class="quitarlink" href="frm_usuarios.php"><img src="img/adminprousuarios .png"><br>
                                    Admin. Usuarios</a>
                                </div>
                            <?php
                             }
                             ?>
                            </div>
                            <div class="col-sm-4">
                            <?php
                             if($_SESSION['tipo']==1)
                             {
                                 ?>
                                <div class="caja">
                                    <a class="quitarlink" href="frm_propietarios.php"><img src="img/adminpropietario .png"><br>
                                    Admin. Propietarios</a>
                                </div>
                            <?php
                             }
                             if($_SESSION['tipo']==2)
                             {
                                header("location:dashboardprop.php");
                             ?>
                                <div class="caja">
                                    <img src="img/adminpropiedades .png"><br>
                                    Admin. Propiedades
                                </div>
                            <?php
                             }
                             ?>
                            </div>
                            <div class="col-sm-4">
                            <?php
                             if($_SESSION['tipo']==1)
                             {
                                 ?>
                                <div class="caja">
                                <a class="quitarlink" href="frm_vendedores.php"><img src="img/adminvende .png"><br>
                                    Admin. Vendedores</a>
                                </div>
                            <?php
                             }
                             if($_SESSION['tipo']==3)
                             {
                             ?>
                                <div class="caja">
                                    <img src="img/adminventas .png"><br>
                                    Admin. Ventas
                                </div>
                            <?php
                             }
                             ?>
                            </div>
                        </div>
                        </div>
                    </div>
            </div>
        </div>
    </body>
</html>
<?php
}else{
    header("location:error.html");
}
?>