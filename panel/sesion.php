<?php
session_start();

$posUsuario = $_POST['usr'];
$posPass = $_POST['pass'];

// Login simple sin SQL - acepta cualquier usuario/contraseña no vacía
if (!empty($posUsuario) && !empty($posPass)) {
	$_SESSION["usuario0608"] = $posUsuario;
	$_SESSION["sesion"] = "OK";	
	echo "OK";
} else {
	echo "NO";
}
?>