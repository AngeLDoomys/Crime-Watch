<?php

include("setup/config.php");

$sql="select * from usuarios where usuario='".$_POST['email']."'and clave='".md5($_POST['pswd'])."' and estado=1";
$result=mysqli_query(conectar(),$sql);
//OBTENER DATOS DE LA TABLA USUARIOS
$datos=mysqli_fetch_array($result);

$cont=mysqli_num_rows($result);

if($cont==0)
{
    header("location:indexlogin.html");
}else{
    session_start();
    $_SESSION['usu']=$datos['nombres'];
    $_SESSION['tipo']=$datos['idtipousu'];
    $_SESSION['apellidos']=$datos['apellidos'];
    $_SESSION['correo']=$datos['usuario'];
    $_SESSION['genero']=$datos['sexo'];
    $_SESSION['telef']=$datos['telefono'];
    $_SESSION['idusu']=$datos['idusu'];
    header("location:dashboard.php");
}
?>