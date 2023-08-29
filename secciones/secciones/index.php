<?php

if(!defined('Verificado')) die("Acceso no permitido");
$arch=$_GET['arch'];
include_once('./secciones/'.$seccion.'/'.$arch.'.php');
include_once('./secciones/'.$seccion.'/inicio.php');

?>