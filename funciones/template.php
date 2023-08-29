<?php
if (!defined('Verificado'))
    die("Acceso no permitido");
	
function plantilla($modulo,$pagetitle = NULL,$keywords = NULL,$description = NULL,$extra = NULL)
{
	global $seccion,$es_user,$es_admin,$config,$tu_cuenta,$regresar,$mostrar_cookies;
	if($config['rewrite'] == 1) {
		$admin='./admin.html';
	}
	else{
		$admin='./?seccion=admin';
	}
	$mostrar = [
			"template" => $config['template'],
			'sitename' => $config['sitename'],
			'user' => ($es_user) ?  '&nbsp;&nbsp;' . _BIENVENIDO . '<b> ' . $tu_cuenta['usuario'] . '</b>!': '&nbsp;&nbsp;' . _BIENVENIDO . ' Invitado!',
			'admin' => ($es_admin) ? '&nbsp;&nbsp;(<a href="'.$admin.'">'. _ADMINISTRAR .'</a>)' : '',
			'modulo' => $modulo,
			'pagetitle' => ' || '.$pagetitle,
	];
	if($regresar == 1) {
		$mostrar['regresar'] = '<script type="text/javascript">window.setTimeout(function(){window.history.go(-2)},5000);</script>';
		$mostrar['regresando'] = _REGRESAR_EN_5_SECS;
		$regresar = 0;
		$mostrar['modulo'] = '';
	}
	if($mostrar_cookies){
	  $mostrar['cookies'] = '<div style="margin:10px;margin-left:100px;font-family:sans-serif;"><img style="float:left" src="./images/cookies.png" alt="cookies" width="64" ><form method="post" action="./?cookies=aceptadas" name="cook" >Este sitio usa cookies para almacenar los datos de los usuarios,
			para que la web funcione correctamente te recomendamos aceptar.<br>
			<input type="hidden" name="cookiesaceptadas" value="1">
			<input type="submit" name="aceptar" value="Aceptar"></form></div>';
	
	}
	
	if (file_exists('./template/' . $config['template'] . '/' . $seccion . '/plantilla.html'))
  		$thefile = file_get_contents('./template/' . $config['template'] . '/' . $seccion . '/plantilla.html');
  	else
		$thefile = file_get_contents('./template/' . $config['template'] . '/plantilla.html');

  	$thefile = str_replace('"', '\"', $thefile);
    $thefile = preg_replace('#\{([^\}]+)\}#is', '".$1."', $thefile);

  	eval("\$print=\"" . $thefile . "\";");
	echo $print;
	

}

?>