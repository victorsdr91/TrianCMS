<?php
/* TrianCMS ~ Content Management System
Desarrollado por Víctor Sánchez del Río ( http://twitter.com/trianmarc ) 
Víctor Sánchez del Río © Todos los derechos reservados.
Proyecto desarrollado para Uname Junior Empresa*/
define('Verificado',true);

/*Variable global para indicar la duracion de la sesion en el fichero config.php*/
$duracion_sesion=NULL;

/*carga de la configuración*/
include_once('config.php');

/*Variable global para indicar la zona en la que nos encontramos*/
$seccion = NULL;
$seccion_pred= 'portada';

/*Definimos la variable de identificacion de usuario a false*/
$es_user = FALSE;
$es_admin = FALSE;
$tu_cuenta = [];
$regresar = 0;

/*carga de las funciones generales*/
include_once('./funciones/funciones.php');

/*Variables encargadas de administrar el uso de cookies */
$mostrar_cookies=FALSE;
$usar_cookies=FALSE;
$cookies = 0;

/*Comprobando cookies...*/ 
$url=comprobar_cookies();
if($_GET['cookies'] == 'aceptadas' ) {cookies_comprobadas($url);}
if(intval($_GET['regresar'])==1) { $regresar=1; }

/*Obtencion de la seccion en la que se encuentra el cliente*/
obtener_seccion();

/*Comprobación de si el cliente es o no usuario del sistema*/
comprobar_usuario();

/*Formato de la ruta de la seccion*/
if($seccion==NULL) {$fichero='./';}
else {	$fichero='./secciones/'.$seccion;}

/*Carga del fichero de inclusiones*/
include_once('include.php');

/*Cierre de la conexión a la base de datos*/
mysqli_close($link);
?>

