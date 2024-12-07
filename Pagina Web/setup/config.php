<?php
//CREAR CONEXIÓN BD
function conectar(){

$con=mysqli_connect("localhost","root","","Crime");
return $con;
}

function sabertipo($t)
{
    switch ($t){
        case 1: $tipo="Admin";
            break;
        case 2: $tipo="Usuario";
            break;
    }
    return $tipo;  
}


function color($t){
    switch ($t){
        case 1: $col="text-danger";
            break;
        case 2: $col="text-primary";
            break;
        case 3: $col="text-success";
            break;
    }
    return $col;  
}
?>