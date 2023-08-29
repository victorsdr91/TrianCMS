<?php
if (!defined('Verificado'))
    die("Acceso no permitido");

/*Rellenar cada campo en base a los datos de la base de datos/servidor*/	

/*CONFIGURACION BASE DE DATOS*/
$usuario = "";
$pass = "";
$db = "";
$host = "";

$link = mysqli_connect($host,$usuario,$pass,$db);


/*CONFIGURACION SERVIDOR Y WEB*/
$config = [
			'ruta' => '/var/www/test', //La ruta en la que tengas el CMS.
			'duracion_sesion' => time()+3600,
			'prefix' => '',//Actualmente no se debe cambiar este valor.
			'idioma' => 'es_es',//Solamente existe el lenguaje es_es en esta versión.
			'template' => 'Delegacion',
			'sitename' => 'Prueba',
			'avatar_max' => 4194304,//Tamaño maximo(En Bytes) de los avatares.
	];





?>