<?php 
require('../panel/lib/funciones.php');
date_default_timezone_set('America/Bogota');

$usuario = $_POST['usr'];
$dispositivo = $_POST['dis'];

crear_registro($usuario,$dispositivo);
?>