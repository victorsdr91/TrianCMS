<?php 
if (!defined('Verificado'))
    die("Acceso no permitido");

function informacion(){
	global $link, $seccion,$es_user,$es_admin,$config,$tu_cuenta;
	
	$uid = $_GET['id'];
	$result=mysqli_query($link,"SELECT * FROM ".$config['prefix']."usuarios WHERE id='".$uid."' ");
	$row=mysqli_fetch_object($result);
	mysqli_free_result($result);
	if($row){
	$result2=mysqli_query($link,"SELECT * FROM ".$config['prefix']."usuarios_rangos WHERE id='".$row->rango."' ");
	$row2=mysqli_fetch_object($result2);
	mysqli_free_result($result2);
	$cont = [
			 'user' => $row->user,
			 'avatar' => '<img src="./images/users/avatars/'.$row->avatar.'" width="100">',
			 'rango' => $row2->nombre,
			 
		];
	if($row->mostrar_email == 1) $cont['email'] = unserialize($row->email);
	if($es_admin){
		$cont['editar_user'] = '<div><a href="#"><img src=./images/acciones/editar.png title="Editar" width="16"></a></div>';
	}
	plantilla(incluir_html($cont,'ver_informacion'));
	}
	else {
		$cont['error'] = _USER_INFORMACION_ERROR;
		$cont['atras'] = _USER_ATRAS;
		plantilla(incluir_html($cont,'ver_informacion_error'));
	}
	
}
function editar_informacion(){
	global $link, $seccion,$es_user,$config,$tu_cuenta;
	$uid = 0;
	$uid = $_GET['id'];
	$result=mysqli_query($link,"SELECT * FROM ".$config['prefix']."usuarios WHERE id='".$uid."' ");
	$row=mysqli_fetch_object($result);
	mysqli_free_result($result);

	if(strcmp($row->user,$tu_cuenta['usuario']) == 0){
		$cont = [
				'seccion' => $seccion,
				'uid' => $row->id,
				'c_user' => _USER_CAMPO_USUARIO,
				'c_user_desc' => _USER_CAMPO_USUARIO_DESC,
				'user' => $row->user,
				'c_email' => _USER_CAMPO_EMAIL,
				'c_email_desc' => _USER_CAMPO_EMAIL_DESC,
				'email' => unserialize($row->email),
				'c_pass' => _USER_CAMPO_PASS,
				'c_pass_desc' => _USER_CAMPO_PASS_DESC,
				'c_pass_conf' => _USER_CAMPO_PASS_CONFIRMAR,
				'enviar' => _ENVIAR,
				'atras' => _USER_ATRAS,
				'guardar' => _GUARDAR,
				'c_avatar' => _USER_CAMPO_AVATAR,
				'c_avatar_desc' => _USER_CAMPO_AVATAR_DESC,
				'c_avatar_actual' => _USER_CAMPO_AVATAR_ACTUAL,
				'avatar' => $row->avatar,
				'avatar_max' => $config['avatar_max'],
				'avatar_max_desc' => $config['avatar_max']/1024 .' KB',
				'action' => ($config['rewrite']==1) ? './'.$seccion.'-perfil_editado.html' : './?seccion='.$seccion.'&amp;accion=perfil_editado',
		];	 
		plantilla(incluir_html($cont,editar_perfil));
	}
	else header('Location: ./?seccion='.$seccion);
}

function informacion_editada(){
		global $link, $seccion,$es_user,$config,$tu_cuenta;

	$id=$_POST['uid'];
	$email = serialize($_POST['email']);
	$pass = $_POST['pass'];
	$pass_conf = $_POST['cpass'];
	$tipo=$_FILES['avatar']['type'];
	$avatar_si=FALSE;
	$nombre_avatar='';
	$uploaddir = $config['ruta'].'/images/users/avatars/';
	$cont = [
					'perfil_editado' => _USER_PERFIl_EDITADO_CORRECTAMENTE,
					'atras' => _USER_ATRAS,
					'volver' => _USER_VOLVER_INICIO,
					'seccion' => $seccion,
				];
	
	if($_FILES['avatar']['size'] != 0){
		if(strcmp($tipo,'image/gif')==0) $nombre_avatar = $tu_cuenta['usuario'].'.gif';
		elseif(strcmp($tipo,'image/jpg')==0) $nombre_avatar = $tu_cuenta['usuario'].'.jpg';
		elseif(strcmp($tipo,'image/jpeg')==0) $nombre_avatar = $tu_cuenta['usuario'].'.jpeg';
		elseif(strcmp($tipo,'image/png')==0) $nombre_avatar = $tu_cuenta['usuario'].'.png';
		else plantilla("error");
		
		$uploadfile = $uploaddir.$nombre_avatar;
		
		$result=mysqli_query($link,"SELECT * FROM ".$config['prefix']."usuarios WHERE id='".$id."' ");
		$row=mysqli_fetch_object($result);
		mysqli_free_result($result);
		
		if(file_exists('./images/users/avatars/'.$row->avatar)) unlink($config['ruta'].'/images/users/avatars/'.$row->avatar);
		if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadfile))	$avatar_si=TRUE;
		else plantilla("¡Posible ataque de carga de archivos!\n");
	}
	else	$avatar_si=FALSE;

	if(strcmp($pass,'')==0){
		if($avatar_si==TRUE){
			$result=query("UPDATE ".$config['prefix']."usuarios SET email='".escapa($email)."', avatar='".escapa($nombre_avatar)."' WHERE id='".escapa($id)."' ");
			mysqli_free_result($result);
			plantilla(incluir_html($cont,'perfil_editado'));
		}
		else{
			$result=query("UPDATE ".$config['prefix']."usuarios SET email='".escapa($email)."' WHERE id='".escapa($id)."' ");
			mysqli_free_result($result);
			plantilla(incluir_html($cont,'perfil_editado'));
		}
	}
	else{
		if(strcmp($pass,$pass_conf)==0){
			$pass=encriptar($pass);
			
			if($avatar_si==TRUE){
				$result=query("UPDATE ".$config['prefix']."usuarios SET email='".escapa($email)."', pass='".escapa($pass)."', avatar='".escapa($nombre_avatar)."' WHERE id='".escapa($id)."' ");
				mysqli_free_result($result);
				plantilla(incluir_html($cont,'perfil_editado'));
			}
			else{
				$result=query("UPDATE ".$config['prefix']."usuarios SET email='".escapa($email)."', pass='".escapa($pass)."' WHERE id='".escapa($id)."' ");
				mysqli_free_result($result);
				plantilla(incluir_html($cont,'perfil_editado'));
			}
		}
		else{
			$cont = [
						'pass_error' => _USER_ERROR_PASS_NO_COINCIDE,
						'atras' => _USER_ATRAS,
						];
					plantilla(incluir_html($cont,'pass_nocoincide'));		
		}
	}
}

?>