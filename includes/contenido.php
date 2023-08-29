<?php
/* TrianCMS ~ Content Management System
Desarrollado por Víctor Sánchez del Río ( http://twitter.com/trianmarc ) 
Víctor Sánchez del Río © Todos los derechos reservados.
Proyecto desarrollado para Uname Junior Empresa*/
if (!defined('Verificado'))
    die("Acceso no permitido");

	$ruta_sec=$fichero.'/index.php';//Establece la ruta donde esta el fichero de carga de la sección
	obtener_idioma('inicio',2); //obtiene el idioma establecido de forma global
	obtener_idioma($seccion,1,'inicio'); //obtiene el idioma establecido para la seccion
	include_once($ruta_sec);//carga el contenido de la seccion
	
?>	
