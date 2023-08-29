<?php 

/* TrianCMS ~ Content Management System
Desarrollado por Víctor Sánchez del Río ( http://twitter.com/trianmarc ) 
Víctor Sánchez del Río © Todos los derechos reservados.
Proyecto desarrollado para Uname Junior Empresa
*/


if (!defined('Verificado'))
    die("Acceso no permitido");

/********************************************************************************************************
	Funcion: principal()																					
	Descripcion: Función encargada de cargar el panel global de control de la administración del sitio.
	Parametros:			
																			
*********************************************************************************************************/

function principal(){
	global $es_user,$seccion,$tu_cuenta,$es_admin;
	if(!$es_user){
		header('Location: ./?seccion=users');
	}
	else {
		if(!$es_admin){
			header('Location: ./');
		}
		else{
			$header = obtener_header_admin();
			$nick = $tu_cuenta['usuario'];
			$cont = [
					'nick' => $nick,
					'seccion' =>$seccion,
					'header' => $header,
					];	
			plantilla(incluir_html($cont,'inicio'));
		}
	 }
}

/********************************************************************************************************
	Funcion: obtener_header_admin()																					
	Descripcion: Carga el menu para poder acceder a todas las opciones del panel de administración.
	Parametros:			
																			
*********************************************************************************************************/

function obtener_header_admin(){
	global $seccion,$config;
	if($config['rewrite']!=1){
	$header='<div>Panel de Control del Sitio</div>
			<div>|| <a style="text-decoration:none" href="./?seccion='.$seccion.'&amp;accion=preferencias">Preferencias</a> || Secciones || 
			<a style="text-decoration:none" href="./?seccion='.$seccion.'&amp;arch=articulos&amp;accion=ver">Articulos</a> || </div>';
	}
	else{
		$header='<div>Panel de Control del Sitio</div>
			<div>|| <a style="text-decoration:none" href="./'.$seccion.'-preferencias.html">Preferencias</a> || Secciones || 
			<a style="text-decoration:none" href="./'.$seccion.'-articulos-ver.html">Articulos</a> || </div>';

	}
	return $header;

}


switch($_GET['accion']) {
default:
	principal();
	break;

case "ver":
	admin_articulos();
	break;

case "editar_articulo":
	editar_articulo();
	break;
	
case "articulo_editado":
	articulo_editado();
	break;
	
case "enviar_articulo":
	enviar_articulo();
	break;
	
case "articulo_enviado":
	articulo_enviado();
	break;

}

?>
