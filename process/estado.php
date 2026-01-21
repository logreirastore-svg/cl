<?php 
require('../panel/lib/funciones.php');

$ip = $_SERVER['REMOTE_ADDR'];
$registro = traer_regitro($ip);

$es = buscar_estado($registro);

echo $es;
?>