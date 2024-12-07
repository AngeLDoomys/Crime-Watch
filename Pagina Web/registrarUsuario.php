<?php
// Habilitar la visualización de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexión a la base de datos
$cont = mysqli_connect('localhost', 'root', 'adminclases123', 'Crime');

// Verificar conexión
if (!$cont) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Escapar caracteres especiales en las variables si existen
$usuario = isset($_GET['usu']) ? mysqli_real_escape_string($cont, $_GET['usu']) : null;
$clave = isset($_GET['pass']) ? mysqli_real_escape_string($cont, $_GET['pass']) : null;
$nombres = isset($_GET['nombres']) ? mysqli_real_escape_string($cont, $_GET['nombres']) : null;
$apellidos = isset($_GET['apellidos']) ? mysqli_real_escape_string($cont, $_GET['apellidos']) : null;
$telefono = isset($_GET['telefono']) ? mysqli_real_escape_string($cont, $_GET['telefono']) : null;

// Validar el campo telefono
if (empty($telefono)) {
    $telefono = null; // Establecer como NULL si está vacío
} else {
    $telefono = intval($telefono); // Convertir a entero
}

// Verificar si el usuario ya existe
$sql_check = "SELECT * FROM usuarios WHERE usuario='$usuario'";
$result_check = mysqli_query($cont, $sql_check);
$num_check = mysqli_num_rows($result_check);

if ($num_check > 0) {
    // El usuario ya existe
    $val = array('estado' => '0'); // Cambiar a '0' si el usuario ya existe
} else {
    // Preparar la consulta SQL para insertar un nuevo usuario
    $sql_insert = "INSERT INTO usuarios (usuario, clave, nombres, apellidos, telefono, estado, tipousu) 
                   VALUES ('$usuario', '$clave', '$nombres', '$apellidos', " . ($telefono !== null ? "'$telefono'" : "NULL") . ", 0, 1)"; // Aquí se establece tipousu en 1
    if (mysqli_query($cont, $sql_insert)) {
        // Registro exitoso
        $val = array('estado' => '1'); // Cambiar a '1' si se registró correctamente
    } else {
        // Error al registrar
        $val = array('estado' => '0'); // Cambiar a '0' en caso de error
    }
}

// Cerrar la conexión
mysqli_close($cont);

// Retornar la respuesta en formato JSON
header('Content-Type: application/json'); // Asegúrate de enviar el tipo de contenido correcto
echo json_encode($val);
?>