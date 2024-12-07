<?php

include("setup/config.php");

    $sql="INSERT INTO `usuarios` (`nombres`, `apellidos`, `usuario`, `clave`, `telefono`, `estado`, `idtipousu`) VALUES ('".$_POST['nombre']."', '".$_POST['apellido']."', '".$_POST['email']."', '".md5($_POST['reclave'])."', '".$_POST['movil']."', 1,  2)";
    mysqli_query(conectar(),$sql);
    header("Location:iniciarsesion.html");

?>