<?
if(session_id() == ''){
session_start();
}

///*Cockie que se pone en login.php cuando el dispositivo es android para poder avivar la session*/
//if(isset($_COOKIE['LongValue'])){/*Si es Android*/
//			$valor=$_COOKIE['LongValue'];
//			
//			/*Consulta*/
//			$usuario=$con->query("SELECT * FROM usuarios WHERE id_usuario=$valor")->fetch_assoc();
//			
//			$_SESSION['logueado']=true;
//			$_SESSION['nombre']=$usuario['nombres'];
//			$_SESSION['usuario']=$usuario['usuario'];
//			$_SESSION['id_usuario']=$usuario['id_usuario'];
//			$_SESSION['es_android']=true;
//			$_SESSION['permiso_de_acceso']='yes';
//
//}/*Si es Android*/

///*ESTA OPERACION AYUDA A DEFINIR LA DIRECCION ACTUAL DE LA PERSONA**************************/
//$pageURL = 'http';
//if(isset($_SERVER["HTTPS"])){/*if isset*/ if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}}/*if isset*/
// $pageURL .= "://";
// if ($_SERVER["SERVER_PORT"] != "80") {
//  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
// } else {
//  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
// }
// 

/*Seguridad********************************************************************************/

/*Permisos Aplicaciones*/
//$permisos_aplicaciones=array();
//$sele=$con->query("SELECT id_seguridad,id_usuario,push,descripcion FROM seguridad_aplicaciones");
//while($row=$sele->fetch_assoc()){/*while*/ 
//$id=explode("|",$row['id_usuario']);
//foreach($id as $id){
//if(($push=='on')and($row['push']==1)){$id=0;}/*If Push Is On*/
//$permisos_aplicaciones[$row['id_seguridad']][$id]=$row['descripcion'];
//}
//unset($id);
//}/*while*/

//echo "<pre>";
//print_r($permisos_aplicaciones);
//echo "</pre>";

/*Permisos Sub Aplicaciones*/
//$permisos=array();
//$sele=$con->query("SELECT id_seguridad,id_usuario,push FROM seguridad_sub_aplicaciones");
//while($row=$sele->fetch_assoc()){/*while*/
//$id=explode("|",$row['id_usuario']);
//foreach($id as $id){
//if(($push=='on')and($row['push']==1)){$id=0;}/*If Push Is On*/
//$permisos[$row['id_seguridad']][$id]=$id;
//}
//unset($id);
//}/*while*/
//echo "<pre>";
//print_r($permisos);
//echo "</pre>";

/*Permisos Fracciones*/
//$permisos_fracciones=array();
//$sele=$con->query("SELECT id_seguridad,id_usuario,push FROM seguridad_fracciones");
//while($row=$sele->fetch_assoc()){/*while*/ 
//$id=explode("|",$row['id_usuario']);
//foreach($id as $id){
//if(($push=='on')and($row['push']==1)){$id=0;}/*If Push Is On*/
//$permisos_fracciones[$row['id_seguridad']][$id]=$id;
//}
//unset($id);
//}/*while*/
//echo "<pre>";
//print_r($permisos_fracciones);
//echo "</pre>";

/*Volver a la ultima pagina*/
//$expiretime = time()+60;
//$link = $pageURL;

/*Si no está Logueado**********************************************************************/
if(!$_SESSION['logueado']){/*Si existe la session logueado puesta en login.php*/
			
			//if (!headers_sent()) {/*2*/setcookie('ultima_pagina',$link,$expiretime,'/');}/*2*/
			if(!isset($_SESSION['nombre_base'])){/*Si el nombre de la base de datos no existe*/
						
						/*Se destruye la session y lo envia a login.php*/
						include ('../usuario/boton_log_out.php');
			
			}/*Si el nombre de la base de datos no existe*/

}/*Si existe la session logueado puesta en login.php*/
?>