<?php

if (!defined('Verificado'))
    die("Acceso no permitido");
	
/*GENERAL*/
define('_USER_ATRAS','Volver atr&aacute;s');
define('_USER_VOLVER','Volver');
define('_USER_VOLVER_INICIO','Volver al inicio');


/*ERRORES*/
define('_USER_ERROR_PASSWORD','Contrase&ntilde;a incorrecta');
define('_USER_ERROR_FALTA_NICK','Error, Introduce un nick valido');
define('_USER_ERROR_FALTA_PASS','Error, Introduce la contrase&ntilde;a');
define('_USER_ERROR_PASS_NO_COINCIDE','Error, las contrase&ntilde;as no coinciden');
define('_USER_INFORMACION_ERROR','Error, el usuario no existe en nuestra base de datos.');

/*CASOS INDEPENDIENTES*/
define('_USER_REGISTRADO','Te has registrado correctamente. Ya puedes acceder con tu usuario y contrase&ntilde;a');
define('_USER_DESCONECTADO','Te has desconectado correctamente.');

/*EDICION PERFIL*/
define('_USER_CAMPO_USUARIO','<b>Nombre de usuario: </b>');
define('_USER_CAMPO_USUARIO_DESC','<i>Por motivos de seguridad, el nombre de usuario no es posible editarlo.</i>');

define('_USER_CAMPO_EMAIL','<b>Correo Electr&oacute;nico: </b>');
define('_USER_CAMPO_EMAIL_DESC','<i>Establece tu nueva direcci&oacute;n de correo electr&oacute;nico.</i>');

define('_USER_CAMPO_PASS','<b>Contrase&ntilde;a: </b>');
define('_USER_CAMPO_PASS_CONFIRMAR','<b>Confirmar Contrase&ntilde;a: </b>');
define('_USER_CAMPO_PASS_DESC','<i>Rellena el campo solo si quieres modificar tu contrase&ntilde;a.</i>');

define('_USER_CAMPO_AVATAR','<b>Imagen de Perfil: </b>');
define('_USER_CAMPO_AVATAR_DESC','<i>Establece la imagen de tu perfil. Tama&ntilde;o m&aacute;ximo: </i>');
define('_USER_CAMPO_AVATAR_ACTUAL','<b>Imagen actual: </b>');

define('_USER_PERFIl_EDITADO_CORRECTAMENTE','<b>Perfil editado correctamente.</b>');


?>