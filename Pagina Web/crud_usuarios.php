<?php

include("setup/config.php");


switch($_POST['accion'])
{
    case "INGRESAR": INGRESAR();
        break;
    case "MODIFICAR": modificar();
        break;
    case "ELIMINAR": eliminar();
        break;
    case "CANCELAR": cancelar();
        break;
}


function INGRESAR(){

    $sql="INSERT INTO `usuarios` (`nombres`, `apellidos`, `usuario`, `clave`, `estado`, `telefono`, `idtipousu`) VALUES ('".$_POST['frm_nombres']."', '".$_POST['frm_apellidos']."', '".$_POST['frm_usu']."', '".md5($_POST['frm_rep_pass'])."', ".$_POST['frm_estado'].", '".$_POST['frm_movil']."', ".$_POST['frm_tipo'].")";

    mysqli_query(conectar(),$sql);
    header("Location:dashboard_usuarios.php");
    die;
}


function modificar(){

    $sql="UPDATE `usuarios` SET `nombres` = '".$_POST['frm_nombres']."', `apellidos` = '".$_POST['frm_apellidos']."', `usuario` = '".$_POST['frm_usu']."', `telefono` = '".$_POST['frm_movil']."', `estado` = ".$_POST['frm_estado'].", `idtipousu` = ".$_POST['frm_tipo']." WHERE `usuarios`.`idusu` =".$_POST['idoc'];
    mysqli_query(conectar(),$sql);
    header("Location:dashboard_usuarios.php");
    die;
}


function eliminar(){
    $sql="DELETE FROM `usuarios` WHERE `usuarios`.`idusu` =".$_POST['idoc'];
    mysqli_query(conectar(),$sql);
    header("Location:dashboard_usuarios.php");
}

function cancelar(){
    header("Location:dashboard_usuarios.php");
}




if(isset($_GET['idusu']))
{
    if($_GET['est']==1)
    {
        $sql="UPDATE `usuarios` SET `estado` = '0' WHERE `usuarios`.`idusu` = ".$_GET['idusu'];
    }else{
        $sql="UPDATE `usuarios` SET `estado` = '1' WHERE `usuarios`.`idusu` = ".$_GET['idusu'];    
    }
    mysqli_query(conectar(),$sql);
    header("Location:dashboard_usuarios.php");
}

?>
