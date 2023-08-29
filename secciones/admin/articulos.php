<?php
/* TrianCMS ~ Content Management System
Desarrollado por Víctor Sánchez del Río ( http://twitter.com/trianmarc ) 
Víctor Sánchez del Río © Todos los derechos reservados.
Proyecto desarrollado para Uname Junior Empresa
*/


if (!defined('Verificado'))
    die("Acceso no permitido");
	
/********************************************************************************************************
	Funcion: obtener_header_admin_articulos()																					
	Descripcion: Carga el menu para poder acceder a todas las opciones del panel de administración.
	Parametros:			
																			
*********************************************************************************************************/

function obtener_header_admin_articulos(){
	global $seccion,$config;
	if($config['rewrite']!=1){
	$header='<div>Control Art&iacute;culos: || <a style="text-decoration:none" href="./?seccion='.$seccion.'&amp;arch=articulos&amp;accion=enviar_articulo">A&ntilde;adir Articulo</a> || <a style="text-decoration:none" href="./?seccion='.$seccion.'&amp;arch=articulos&amp;accion=ver">Ver Articulos</a> || </div>';
	}
	else{
		$header='<div>Control Art&iacute;culos: || <a style="text-decoration:none" href="./'.$seccion.'-articulos-enviar_articulo.html">A&ntilde;adir Articulo</a> || <a style="text-decoration:none" href="./'.$seccion.'-articulos-ver.html">Ver Articulos</a> || </div>';

	}
	return $header;

}

/********************************************************************************************************
	Funcion: admin_articulos()																				
	Descripcion: Obtiene un listado en una tabla todos los articulos de la base de datos y dá 
				 la opcion de editarlos y borrarlos.
	Parametros:			
																			
*********************************************************************************************************/

function admin_articulos(){

	global $seccion, $config, $tu_cuenta,$es_user,$es_admin;
	if(!$es_user){
		header('Location: ./?seccion=users');
	}
	else {
		if(!$es_admin){
			header('Location: ./');
		}
		else{
			
			$modulo = obtener_header_admin();
			$modulo .= '<hr>'.obtener_header_admin_articulos();
			
			$modulo .= '<br><table style="font-size:14px;text-align:center;">
							<tr>
								<th>ID</th>
								<th>'._ADMIN_ARTICULOS_TITULO.'</th>
								<th>'._ADMIN_ARTICULOS_CATEGORIA.'</th>
								<th>'._ADMIN_ARTICULOS_AUTOR.'</th>
								<th>'._ADMIN_ARTICULOS_SECCION.'</th>
								<th> </th>
							</tr>';
			$result=query("SELECT a.id,a.titulo,c.nombre,s.seccion,u.user FROM ".$config['prefix']."usuarios u,".$config['prefix']."articulos a,
			".$config['prefix']."categoria c,".$config['prefix']."articulos_seccion a_s ,".$config['prefix']."secciones s WHERE a.uid=u.id AND a.id=a_s.aid AND s.sid=a_s.sid AND a.cid=c.id ");
			while($row=mysqli_fetch_object($result)){
				if($config['rewrite']!=1){
					$url_edit='./?seccion='.$seccion.'&amp;arch=articulos&amp;accion=editar_articulo&amp;id='.$row->id;
					$url_borrar='./?seccion='.$seccion.'&amp;arch=articulos&amp;accion=borrar_articulo&amp;id='.$row->id;
				}
				{
					$url_edit='./'.$seccion.'-articulos-editar_articulo-'.$row->id.'.html';
					$url_borrar='./'.$seccion.'-articulos-borrar_articulo-'.$row->id.'.html';
				}
				$modulo .= '
							<tr>
								<td>'.$row->id.'</td>
								<td>'.unserialize($row->titulo).'</td>
								<td>'.$row->nombre.'</td>
								<td>'.$row->user.'</td>
								<td>'.$row->seccion.'</td>
								<td><a href="'.$url_edit.'">'._ADMIN_ARTICULOS_EDITAR.'</a> | <a href="'.$url_borrar.'">'._ADMIN_ARTICULOS_BORRAR.'</a></td>
							
							</tr>	
									
						 ';
			}
			mysqli_free_result($result);
			$modulo .= '</table>';
			plantilla($modulo,'Administrar Art&iacute;culos');
		}
	}


}


/********************************************************************************************************
	Funcion: editar_articulo()																					
	Descripcion: Función que se encarga de cargar el formulario de edición de los articulos desde el panel de
				 administración.
	Parametros:			
																			
*********************************************************************************************************/

function editar_articulo(){
	global $config,$es_admin,$es_user,$seccion;
	
	if(!$es_user){
		header('Location: ./?seccion=users');
	}
	else {
		if(!$es_admin){
			header('Location: ./');
		}
		else{
			$header = obtener_header_admin();
			$menu_art= obtener_header_admin_articulos();
			$aid= $_GET['id'];
			$result=query("SELECT a.*, c.nombre, c.imagen as cat_img FROM ".$config['prefix']."articulos a , ".$config['prefix']."categoria c WHERE a.id='".$aid."' AND a.cid = c.id ");
			$row=mysqli_fetch_object($result);
			mysqli_free_result($result);
			$cont = [
					'seccion' => $seccion,
					'enviar' => _ENVIAR,
					'aid' => $aid,
					'campo_categoria' => _ADMIN_ARTICULOS_CATEGORIA,
					'campo_categoria_desc' => _ADMIN_ARTICULOS_CATEGORIA_DESC,
					'campo_titulo' => _ADMIN_ARTICULOS_TITULO,
					'campo_titulo_desc' => _ADMIN_ARTICULOS_TITULO_DESC,
					'titulo' => unserialize($row->titulo),
					'campo_imagen' => _ADMIN_ARTICULOS_IMAGEN,
					'campo_imagen_desc' => _ADMIN_ARTICULOS_IMAGEN_DESC,
					'campo_imagen_actual' => _ADMIN_ARTICULOS_IMAGEN_ACTUAL,
					'imagen' => $row->imagen,
					'campo_resumen' => _ADMIN_ARTICULOS_RESUMEN,
					'campo_resumen_desc' => _ADMIN_ARTICULOS_RESUMEN_DESC,
					'resumen' => unserialize($row->resumen),
					'campo_texto' => _ADMIN_ARTICULOS_TEXTO,
					'campo_texto_desc' => _ADMIN_ARTICULOS_TEXTO_DESC,
					'texto' => unserialize($row->contenido),
					'campo_seccion' => _ADMIN_ARTICULOS_SECCIONES,
					'campo_seccion_desc' => _ADMIN_ARTICULOS_SECCIONES_DESC,
					'header' => $header,
					'menu_art' => $menu_art,
					'atras' => _ATRAS, 
			];
			if($config['rewrite']!=1) $cont['action'] = './?seccion='.$seccion.'&amp;arch=articulos&amp;accion=articulo_editado';
			else $cont['action'] = './'.$seccion.'-articulos-articulo_editado.html';
			
			$cont['categorias'] = '<select name="categoria">';
			$result=query("SELECT * FROM ".$config['prefix']."categoria ");
			while($row2=mysqli_fetch_object($result)){
				if(strcmp($row2->nombre,$row->nombre) == 0){
					$cont['categorias'] .='<option value="'.$row2->nombre.'" selected>'.$row2->nombre.'</option>';
				}else{
					$cont['categorias'] .='<option value="'.$row2->nombre.'">'.$row2->nombre.'</option>';
				}
			};		
			mysqli_free_result($result);
			$cont['categorias'] .= '</select>';
			
			$result2=query("SELECT * FROM ".$config['prefix']."articulos_seccion WHERE aid = '".$aid."' ");
			$cont['secciones'] = '';
			while($row4=mysqli_fetch_object($result2)){
				$id[$row4->sid] = $row4->sid;
			};
			mysqli_free_result($result2);	
			$result=query("SELECT * FROM ".$config['prefix']."secciones ");
			while($row3=mysqli_fetch_object($result)){
				if($row3->sid == $id[$row3->sid]){
					$cont['secciones'] .='<input type="checkbox" name="secciones[]" value="'.$row3->seccion.'" checked>'.$row3->seccion.'</option>';
				}else{
					$cont['secciones'] .='<input type="checkbox" name="secciones[]" value="'.$row3->seccion.'">'.$row3->seccion.'</option>';
				}
			};		
			mysqli_free_result($result);						
			plantilla(incluir_html($cont,editar_articulo),'Editar Art&iacute;culo');		
		}
	}
}


/********************************************************************************************************
	Funcion: articulo_editado()																					
	Descripcion: Función que encargada de recuperar los datos del formulario y tratarlos, para subirlos 
				 posteriormente a la base de datos de la web.
	Parametros:			
																			
*********************************************************************************************************/

function articulo_editado(){
	global $config,$es_admin,$es_user;
	if(!$es_user){
		header('Location: ./?seccion=users');
	}
	else {
		if(!$es_admin){
			header('Location: ./');
		}
		else{
			$cat_n = $_POST['categoria'];	
			$result=query("SELECT id FROM categoria WHERE nombre='".$cat_n."'");
			$cat = mysqli_fetch_object($result);
			mysqli_free_result($result);
			$aid = $_POST['aid']; 
			$tit = $_POST['titulo'];
			$res = $_POST['resumen']; 
			$txt = $_POST['texto']; 
			$uploaddir = $config['ruta'].'/images/articulos/';
			$imagen_si = FALSE;
			//Comprobamos si se ha seleccionado alguna imagen para subir.
			if($_FILES['img_articulo']['size'] != 0){
				$fich = $_FILES['img_articulo']['name'];
				$uploadfile = $uploaddir.$fich;
				
				if (move_uploaded_file($_FILES['img_articulo']['tmp_name'], $uploadfile)){
					$result=query("SELECT * FROM ".$config['prefix']."articulos WHERE id='".$aid."' ");
					$row3=mysqli_fetch_object($result);
					mysqli_free_result($result);
					if(file_exists('./images/articulos/'.$row3->imagen)) unlink($config['ruta'].'/images/articulos/'.$row3->imagen);
					$imagen_si=TRUE;
				
				}
				else plantilla("¡Posible ataque de carga de archivos!\n");
			}
			//Comprobamos si hay secciones a mostrar seleccionadas
			if(is_array($_POST['secciones'])){
				$result=query("DELETE FROM articulos_seccion WHERE aid='".$aid."'");
				mysqli_free_result($result);
				foreach($_POST['secciones'] as $valor){
					$sec[$valor]=$valor;
					$result=query("SELECT sid FROM secciones WHERE seccion='".$valor."'");
					$row = mysqli_fetch_object($result);
					mysqli_free_result($result);
					$result2=query("INSERT INTO articulos_seccion (aid,sid) VALUES ('".$aid."','".$row->sid."')");
					mysqli_free_result($result);		
				}
				if($imagen_si){
					$result=query("UPDATE articulos SET titulo='".escapa(serialize($tit))."', resumen='".escapa(serialize($res))."', contenido='".escapa(serialize($txt))."',
					imagen='".escapa($fich)."', cid='".escapa($cat->id)."' WHERE id='".escapa($aid)."'");
					mysqli_free_result($result);
					plantilla(incluir_html($cont,'articulo_editado'),'Art&iacute;culo editado');
				}
				else {
					$result=query("UPDATE articulos SET titulo='".escapa(serialize($tit))."', resumen='".escapa(serialize($res))."', contenido='".escapa(serialize($txt))."',
					cid='".escapa($cat->id)."' WHERE id='".escapa($aid)."' ");
					mysqli_free_result($result);
					plantilla(incluir_html($cont,'articulo_editado'),'Art&iacute;culo editado');
				}
			}
			else{
				plantilla(incluir_html($cont,'error_no_seccion'),'Error, no hay secci&oacute;n seleccionada');
			}
			
		}
	}

}

/********************************************************************************************************
	Funcion: enviar_articulo()																					
	Descripcion: Función que se encarga de cargar el formulario para enviar nuevos artículos desde el panel de
				 administración.
	Parametros:			
																			
*********************************************************************************************************/

function enviar_articulo(){
	global $config,$es_admin,$es_user,$seccion;
	
	if(!$es_user){
		header('Location: ./?seccion=users');
	}
	else {
		if(!$es_admin){
			header('Location: ./');
		}
		else{
			$header = obtener_header_admin();
			$menu_art= obtener_header_admin_articulos();
			$cont = [
					'seccion' => $seccion,
					'enviar' => _ENVIAR,
					'campo_categoria' => _ADMIN_ARTICULOS_CATEGORIA,
					'campo_categoria_desc' => _ADMIN_ARTICULOS_CATEGORIA_DESC,
					'campo_titulo' => _ADMIN_ARTICULOS_TITULO,
					'campo_titulo_desc' => _ADMIN_ARTICULOS_TITULO_DESC,
					'campo_imagen' => _ADMIN_ARTICULOS_IMAGEN,
					'campo_imagen_desc' => _ADMIN_ARTICULOS_IMAGEN_DESC,
					'campo_imagen_actual' => _ADMIN_ARTICULOS_IMAGEN_ACTUAL,
					'campo_resumen' => _ADMIN_ARTICULOS_RESUMEN,
					'campo_resumen_desc' => _ADMIN_ARTICULOS_RESUMEN_DESC,
					'campo_texto' => _ADMIN_ARTICULOS_TEXTO,
					'campo_texto_desc' => _ADMIN_ARTICULOS_TEXTO_DESC,
					'campo_seccion' => _ADMIN_ARTICULOS_SECCIONES,
					'campo_seccion_desc' => _ADMIN_ARTICULOS_SECCIONES_DESC,
					'header' => $header,
					'menu_art' => $menu_art,
					'atras' => _ATRAS, 
			];
			if($config['rewrite']!=1) $cont['action'] = './?seccion='.$seccion.'&amp;arch=articulos&amp;accion=articulo_enviado';
			else $cont['action'] = './'.$seccion.'-articulos-articulo_enviado.html';
			
			$cont['categorias'] = '<select name="categoria">';
			$result=query("SELECT * FROM ".$config['prefix']."categoria ");
			while($row2=mysqli_fetch_object($result)){
					$cont['categorias'] .='<option value="'.$row2->nombre.'">'.$row2->nombre.'</option>';
			};		
			mysqli_free_result($result);
			$cont['categorias'] .= '</select>';
			mysqli_free_result($result2);	
			$result=query("SELECT * FROM ".$config['prefix']."secciones ");
			while($row3=mysqli_fetch_object($result)){
					$cont['secciones'] .='<input type="checkbox" name="secciones[]" value="'.$row3->seccion.'">'.$row3->seccion.'</option>';
			};		
			mysqli_free_result($result);						
			plantilla(incluir_html($cont,enviar_articulo),'Enviar Art&iacute;culo');		
		}
	}
}

/********************************************************************************************************
	Funcion: articulo_enviado()																					
	Descripcion: Función que encargada de recuperar los datos del formulario de enviar_articulo.html
				 y tratarlos, para subirlos posteriormente a la base de datos de la web.
	Parametros:			
																			
*********************************************************************************************************/

function articulo_enviado(){
	global $config,$es_admin,$es_user,$tu_cuenta;
	if(!$es_user){
		header('Location: ./?seccion=users');
	}
	else {
		if(!$es_admin){
			header('Location: ./');
		}
		else{
			$cat_n = $_POST['categoria'];	
			$result=query("SELECT id FROM categoria WHERE nombre='".$cat_n."'");
			$cat = mysqli_fetch_object($result);
			mysqli_free_result($result);
			$tit = $_POST['titulo'];
			$res = $_POST['resumen']; 
			$txt = $_POST['texto']; 
			$uploaddir = $config['ruta'].'/images/articulos/';
			$imagen_si = FALSE;
			//Comprobamos si se ha seleccionado alguna imagen para subir.
			if($_FILES['img_articulo']['size'] != 0){
				$mime = obtener_mime($_FILES['img_articulo']['type']);
				$fich = $_FILES['img_articulo']['name'].'.'.$mime;
				$uploadfile = $uploaddir.$fich;
				
				if (move_uploaded_file($_FILES['img_articulo']['tmp_name'], $uploadfile)){
					$imagen_si=TRUE;
				}
				else plantilla("¡Posible ataque de carga de archivos!\n");
			}
			//Comprobamos si hay secciones a mostrar seleccionadas
			if(is_array($_POST['secciones'])){
				
				if($imagen_si){
					$result=query("INSERT INTO articulos VALUES ('','".escapa(serialize($tit))."','".escapa(serialize($res))."','".escapa(serialize($txt))."','".escapa($fich)."','".escapa($cat->id)."','".escapa($tu_cuenta['id'])."')");
					mysqli_free_result($result);
				}
				else {
					$result=query("INSERT INTO articulos VALUES ('','".escapa(serialize($tit))."','".escapa(serialize($res))."','".escapa(serialize($txt))."','','".escapa($cat->id)."','".escapa($tu_cuenta['id'])."')");
					mysqli_free_result($result);
				}
				$result=query("SELECT id FROM articulos WHERE titulo='".escapa(serialize($tit))."' AND resumen='".escapa(serialize($res))."' AND contenido='".escapa(serialize($txt))."' AND cid='".escapa($cat->id)."' AND uid='".escapa($tu_cuenta['id'])."' ORDER BY id DESC");
				$row2 = mysqli_fetch_object($result);
				mysqli_free_result($result);
				$aid= $row2->id;
				foreach($_POST['secciones'] as $valor){
					$sec[$valor]=$valor;
					$result=query("SELECT sid FROM secciones WHERE seccion='".$valor."'");
					$row = mysqli_fetch_object($result);
					mysqli_free_result($result);
					$result2=query("INSERT INTO articulos_seccion (aid,sid) VALUES ('".$aid."','".$row->sid."')");
					mysqli_free_result($result);		
				}
				plantilla(incluir_html($cont,'articulo_enviado'),'Art&iacute;culo enviado');
			}
			else{
				plantilla(incluir_html($cont,'error_no_seccion'),'Error, no hay secci&oacute;n seleccionada');
			}
			
		}
	}
}

?>