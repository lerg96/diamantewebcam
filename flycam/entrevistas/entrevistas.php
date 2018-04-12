<?
include "../_includes-functions/conexion_improved.php";
include "../_includes-functions/seguridad.php"; 
include "../_includes-functions/funciones.php";
include '../_includes-functions/barraNavegacion.php';

//Extendi la session a 6 Horas para que se puedan demorar ingresando la info
ini_set('session.gc_maxlifetime', 21600); // 6horas


/*Si se pide editar a un usuario, se verifica que el usuario exista.*/
if(isset($_GET['editar_usuario'])){$usuario_editar=$con->query("SELECT * FROM usuarios WHERE id_usuario='".$_GET['editar_usuario']."'")->fetch_assoc();
                                    $usuario_editar2=$con->query("SELECT * FROM notas_de_registro WHERE id_usuario='".$_GET['editar_usuario']."'")->fetch_assoc();
      if(empty($usuario_editar)){$_SESSION['alerta'][]='El usuario que se quiere editar no existe.';}
}
//echo $usuario_editar['id_usuario'];



if(isset($_POST['enviar'])){/*If isset enviar*/
                  
                     /*Ojo la razon por la cual no se envian las imagenes antes de la consulta de insertar es porque necesitamos el id para guardar las fotos.*/


                    /*USUARIO*/
                    $usuario=$_POST['usuario'];
                    //echo $usuario;
                    $usuario=$con->real_escape_string(trim(str_replace(' ','', strtolower($usuario))));/*por seguridad se escapan los cuotes*/
                    if(strlen($usuario)>25){$_SESSION['alerta'][]="El USUARIO es demasiado Largo.";}
                    if(strlen($usuario)<=3){$_SESSION['alerta'][]="El USUARIO es demasiado Corto.";}
                    
                    /*Verificamos si el usuario ya existe*/
                    $verificacion_usuario=$con->query("SELECT * FROM usuarios WHERE usuario='".$usuario."'");
                    if( ($verificacion_usuario->num_rows > 0) and (!isset($_GET['editar_usuario'])) ){/*Si es un usuario repetido*/
                          $_SESSION['alerta'][]="El NOMBRE de usuario está repetido";
                    }/*Si es un usuario repetido*/


                    /*Informacion Personal y de contacto*/
                    $nombres=ucwords(trim($_POST['nombres']));
                    if(empty($nombres)){$_SESSION['alerta'][]="El NOMBRE está vacio.";}
                    //echo $nombres."<br>";
                    
                    $apellidos=trim($_POST['apellidos']);
                    if(empty($apellidos)){$_SESSION['alerta'][]="El APELLIDO está vacio.";}
                    //echo $apellidos."<br>";

                    $cedula=trim($_POST['cedula']);
                    if(empty($cedula)){$_SESSION['alerta'][]="La CEDULA está vacia.";}
                    //echo $cedula."<br>";
                    
                    $celular=$_POST['celular'];
                    if(empty($celular)){$_SESSION['alerta'][]="El CELULAR está vacio.";}
                    //echo $celular."<br>";
                    
                    $telefono=$_POST['telefono'];
                    //echo $telefono."<br>";
                    
                    $password=trim($_POST['cedula']);//El numero de cedula es el mismo PASS
                    //echo $password."<br>";
                    
                    $genero=$_POST['genero'];
                    //echo $genero."<br>";
                    
                    $fecha_de_nacimiento=$_POST['fecha_de_nacimiento'];

                    if(empty($fecha_de_nacimiento)){$_SESSION['alerta'][]="La Fecha de Nacimiento está vacio.";}
                    //echo $fecha_de_nacimiento."<br>";
                    
                    $email=$_POST['email'];
                    if(empty($email)){$_SESSION['alerta'][]="El EMAIL está vacio.";}
                    //echo $email."<br>";
                    
                    $facebook=$_POST['facebook'];
                    //echo $facebook."<br>";
                    
                    $instagram=$_POST['instagram'];
                    //echo $instagram."<br>";
                    
                    $twitter=$_POST['twitter'];
                    //echo $twitter."<br>";
                    
                    $direccion=ucwords($_POST['direccion']);
                    if(empty($direccion)){$_SESSION['alerta'][]="La DIRECCION está vacia.";}
                    //echo $direccion."<br>";
                    
                    $ciudad=ucwords($_POST['ciudad']);
                    if(empty($ciudad)){$_SESSION['alerta'][]="La CIUDAD está vacia.";}
                    //echo $ciudad."<br>";

                  


                    /*Referencia 1*/
                          $ref1_nombre=ucwords($_POST['ref1_nombre']);
                          if(empty($ref1_nombre)){$_SESSION['alerta'][]="La Nombres Referencia 1 está vacia.";}
                          //echo $ref1_nombre."<br>";
                          
                          $ref1_apellidos=ucwords($_POST['ref1_apellidos']);
                          if(empty($ref1_apellidos)){$_SESSION['alerta'][]="La Apellidos Referencia 1 está vacia.";}
                          //echo $ref1_apellidos."<br>";
                          
                          $ref1_parentesco=$_POST['ref1_parentesco'];
                          //echo $ref1_parentesco."<br>";
                          
                          $ref1_celular=$_POST['ref1_celular'];
                          if(empty($ref1_parentesco)){$_SESSION['alerta'][]="La Celular Referencia 1 está vacia.";}
                          //echo $ref1_celular."<br>";
                         
                          $ref1_telefono=$_POST['ref1_telefono'];
                          //echo $ref1_telefono."<br>";
                   
                    /*Referencia 2*/
                          $ref2_nombre=ucwords($_POST['ref2_nombre']);
                          if(empty($ref2_nombre)){$_SESSION['alerta'][]="La Nombre Referencia 2 está vacia.";}
                          //echo $ref2_nombre."<br>";
                        
                          $ref2_apellidos=ucwords($_POST['ref2_apellidos']);
                          if(empty($ref2_apellidos)){$_SESSION['alerta'][]="La Apellidos Referencia 2 está vacia.";}
                          //echo $ref2_apellidos."<br>";
                        
                          $ref2_parentesco=$_POST['ref2_parentesco'];
                          //echo $ref2_parentesco."<br>";
                         
                          $ref2_celular=$_POST['ref2_celular'];
                          if(empty($ref2_celular)){$_SESSION['alerta'][]="La Celular Referencia 2 está vacia.";}
                          //echo $ref2_celular."<br>";
                        
                          $ref2_telefono=$_POST['ref2_telefono'];
                          //echo $ref2_telefono."<br>";
                  

                    /*Referencia 3*/
                          $ref3_nombre=ucwords($_POST['ref3_nombre']);
                          if(empty($ref3_nombre)){$_SESSION['alerta'][]="La Nombre Referencia 3 está vacia.";}
                          //echo $ref3_nombre."<br>";
                        
                          $ref3_apellidos=ucwords($_POST['ref3_apellidos']);
                          if(empty($ref3_apellidos)){$_SESSION['alerta'][]="La Aprellidos Referencia 3 está vacia.";}
                          //echo $ref3_apellidos."<br>";
                        
                          $ref3_parentesco=$_POST['ref3_parentesco'];
                          //echo $ref3_parentesco."<br>";
                        
                          $ref3_celular=$_POST['ref3_celular'];
                          if(empty($ref3_celular)){$_SESSION['alerta'][]="La Celular Referencia 3 está vacia.";}
                          //echo $ref3_celular."<br>";
                         
                          $ref3_telefono=$_POST['ref3_telefono'];
                          //echo $ref3_telefono."<br>";

                   
                    /*Informacion de registro de la pagina*/
                        if(!empty($_POST['usuario_page'])){
                        $usuario_page=implode('|',$_POST['usuario_page']);
                        //echo $usuario_page."<br>";
                        //var_dump($usuario_page);
                    }else{$usuario_page='';$_SESSION['alerta'][]="Debes seleccionar por lo menos 1 Pagina.";}
                  //var_dump($_POST['usuario_page']);

                    /*Video Entrevista Youtube*/
                    $url_entrevista=str_replace("watch?v=","embed/",$_POST['url_entrevista']);
                    //echo $url_entrevista;

                    /*Notas*/
                    $nota=$_POST['nota'];
                    //echo $notas."<br>";
                    
                    /*Disponibilidad*/
                       if(!empty($_POST['disponibilidad'])){
                        $disponibilidad=implode('|',$_POST['disponibilidad']);
                        //echo $usuario_page."<br>";
                    }else{$disponibilidad='';$_SESSION['alerta'][]="Debes seleccionar por lo menos 1 disponibilidad.";}
                    
                    /*Modalidad*/
                       if(!empty($_POST['modalidad'])){
                        $modalidad=implode('|',$_POST['modalidad']);
                        //echo $usuario_page."<br>";
                    }else{
                      /*Si la modalidad está vacia debe ser modalidad 1  (Para trabajar en estudio) lo anterior se hizo porque ya no trabajamos con satelites*/
                      $modalidad='1';
                      //$modalidad='';
                      //$_SESSION['alerta'][]="Debes seleccionar por lo menos 1 modalidad.";
                    }

                          /*Usuario_referente*/
                          //$usuario_referente=$_POST['usuario_referente'];
                          //echo $usuario_referente."<br>";
                          
                          /*Verificamos si el usuario Referente si existe*/
                          if(!isset($usuario_referente)){/*1*/$id_usuario_referente=0;}/*1*/else{/*1*/
                                                      $verificacion_referente=$con->query("SELECT * FROM usuarios WHERE usuario='".$usuario_referente."'");
                                                      if($verificacion_referente->num_rows > 0){/*Si es un usuario repetido*/
                                                            $verificacion_referente=$verificacion_referente->fetch_assoc();
                                                            $id_usuario_referente=$verificacion_referente['id_usuario'];
                                                      }/*Si es un usuario repetido*/else{/*Si existe el usuario*/
                                                            $_SESSION['alerta'][]="El USUARIO Referente no existe.";
                                                      }/*Si existe el usuario*/

                          }/*1*/
                          



                    if(!isset($_SESSION['alerta'])){/*Si no hay alerta*/               
                                     
                                     /*Si estamos editando se actualiza el usuario, de lo contrario se ingresa un usuario nuevo*/
                                     if(empty($usuario_editar)){$id_usuario='default';}else{$id_usuario=$_GET['editar_usuario'];}
                                      

                                      /*query de actualizacion*/
                                      $insert=$con->query("  

                                      INSERT INTO usuarios(id_usuario,fecha_creacion,usuario,disponibilidad,id_referente,nombres,apellidos,modalidad,password,celular,telefono,cedula,genero,fecha_de_nacimiento,email,facebook, instagram, twitter, direccion, ciudad, ref1_nombre, ref1_apellidos, ref1_parentesco, ref1_celular, ref1_telefono, ref2_nombre, ref2_apellidos, ref2_parentesco, ref2_celular, ref2_telefono, ref3_nombre, ref3_apellidos, ref3_parentesco, ref3_celular, ref3_telefono, usuario_page,  url_entrevista, estado, inmune_asistencia) 

                                      VALUES($id_usuario,'$lahoraencolombia','$usuario','$disponibilidad',$id_usuario_referente,'$nombres','$apellidos','$modalidad','$password','$celular','$telefono','$cedula','$genero','$fecha_de_nacimiento','$email','$facebook','$instagram','$twitter','$direccion','$ciudad','$ref1_nombre','$ref1_apellidos','$ref1_parentesco','$ref1_celular','$ref1_telefono','$ref2_nombre','$ref2_apellidos','$ref2_parentesco','$ref2_celular','$ref2_telefono','$ref3_nombre','$ref3_apellidos','$ref3_parentesco','$ref3_celular','$ref3_telefono','$usuario_page','$url_entrevista',0,0)

                                      ON DUPLICATE KEY UPDATE usuario='$usuario',disponibilidad='$disponibilidad',id_referente=$id_usuario_referente,nombres='$nombres',apellidos='$apellidos',modalidad='$modalidad',password='$password',celular='$celular',telefono='$telefono',cedula='$cedula',genero='$genero',fecha_de_nacimiento='$fecha_de_nacimiento',email='$email',facebook='$facebook',instagram='$instagram',twitter='$twitter',direccion='$direccion',ciudad='$ciudad',ref1_nombre='$ref1_nombre',ref1_apellidos='$ref1_apellidos',ref1_parentesco='$ref1_parentesco',ref1_celular='$ref1_celular',ref1_telefono='$ref1_telefono',ref2_nombre='$ref2_nombre',ref2_apellidos='$ref2_apellidos',ref2_parentesco='$ref2_parentesco',ref2_celular='$ref2_celular',ref2_telefono='$ref2_telefono',ref3_nombre='$ref3_nombre',ref3_apellidos='$ref3_apellidos',ref3_parentesco='$ref3_parentesco',ref3_celular='$ref3_celular',ref3_telefono='$ref3_telefono',usuario_page='$usuario_page',url_entrevista='$url_entrevista';



                                      ");

                                      /*Si estamos editando se actualiza el id_usuario se coje de GET, de lo contrario se coje de insert_id*/
                                      if(empty($usuario_editar)){$id_usuario=$con->insert_id;}else{$id_usuario=$_GET['editar_usuario'];}
   
                    
                                      /*query de actualizacion de la nota*/
                                      $insert_nota=$con->query("  
                                      INSERT INTO notas_de_registro(`id_nota_de_registro`, `fecha_creacion`, `id_usuario`, `nota`) 
                                      VALUES (default,'$lahoraencolombia',$id_usuario,'$nota')
                                      ON DUPLICATE KEY UPDATE id_usuario=$id_usuario,nota='$nota';
                                      ");

                    }/*Si no hay alerta*/ 

                    /*Alerta si no inserto en base de datos*/
                    if(empty($insert)){$_SESSION['alerta'][]="No se pudo insertar información en la base de datos.";}
                    

                    if(!isset($_SESSION['alerta']) and ($id_usuario!='') and (!empty($id_usuario))){/*Si no hay alerta*/   
              
                              /*********************************************************************************CEDULA BACK*********************************************************************************/
                              /*Si se adjunto un archivo*/
                              if($_FILES['cedula_back']['size'] > 0){/*Si se adjunto un archivo*/
                                        /*Exceso de tamaño*/
                                        if($_FILES['cedula_back']['size'] > 60000000){$_SESSION['alerta'][]="La foto no debe tener un tamaño superior a 6 megas.";}
                                        /*si no hay error*/
                                        if($_FILES['cedula_back']['error']){$_SESSION['alerta'][]="La foto tiene un error.";}
                                        /*La foto no es jpg*/
                                        if(($_FILES['cedula_back']['type']!='image/jpg') and ($_FILES['cedula_back']['type']!='image/jpeg') and ($_FILES['cedula_back']['type']!='image/png') ){$_SESSION['alerta'][]="La imagen debe ser JPG, JPEG o PNG.";}
                                        /*Move file*/
                                        if(!isset($_SESSION['alerta']) ){/*Si no hay alerta*/
                                                
                                                /*Se crea el Directorio si no existe*/
                                                if (!file_exists('../_globales/images/'.$_SESSION['nombre_base'].'_cedulas_back/')) {/*Creacion directorio*/
                                                        mkdir('../_globales/images/'.$_SESSION['nombre_base'].'_cedulas_back/', 0777, true);
                                                }/*Creacion Directorio*/

                                                ////////////* SERVIDOR LOCAL*///////////////
                                                $nombre_foto='../_globales/images/'.$_SESSION['nombre_base'].'_cedulas_back/'.$id_usuario.'.jpg';
                                                //move_uploaded_file($_FILES['cedula_back']['tmp_name'],"$nombre_foto");

                                                
                                                /*Se incluye la libreria SimpleImage -> Para transformacion de imagenes*/
                                                include_once('../_includes-functions/librerias/SimpleImage-master/src/abeautifulsite/SimpleImage.php');
                                                
                                                /*Transformamos y guardamos la Imagen*/
                                                try {/*Try*/
                                                $img = new abeautifulsite\SimpleImage($_FILES['cedula_back']['tmp_name']);
                                                $img->best_fit(2000,2000)->save("$nombre_foto");
                                                }/*Try*/ catch(Exception $e) {/*Catch*/
                                                echo 'Error: ' . $e->getMessage();
                                                }/*Catch*/
                              
                                          }/*Si no hay alerta*/
                                         
                                        
                                          if(!file_exists($nombre_foto)){/*Comprobacion*/
                                                $_SESSION['alerta'][]="La foto no se pudo adjuntar.";
                                                }/*Comprobacion*/
                              }/*Si se adjunto un archivo*/       


                             /*********************************************************************************CEDULA FRONT*********************************************************************************/
                              /*Si se adjunto un archivo*/
                              if($_FILES['cedula_front']['size'] > 0){/*Si se adjunto un archivo*/
                                        /*Exceso de tamaño*/
                                        if($_FILES['cedula_front']['size'] > 10000000){$_SESSION['alerta'][]="La foto no debe tener un tamaño superior a 6 megas.";}
                                        /*si no hay error*/
                                        if($_FILES['cedula_front']['error']){$_SESSION['alerta'][]="La foto tiene un error.";}
                                        /*La foto no es jpg*/
                                        if(($_FILES['cedula_front']['type']!='image/jpg') and ($_FILES['cedula_front']['type']!='image/jpeg') and ($_FILES['cedula_front']['type']!='image/png') ){$_SESSION['alerta'][]="La imagen debe ser JPG, JPEG o PNG.";}
                                        /*Move file*/
                                        if(!isset($_SESSION['alerta'])){/*Si no hay alerta*/
                                                
                                                /*Se crea el Directorio si no existe*/
                                                if (!file_exists('../_globales/images/'.$_SESSION['nombre_base'].'_cedulas_front/')) {/*Creacion directorio*/
                                                        mkdir('../_globales/images/'.$_SESSION['nombre_base'].'_cedulas_front/', 0777, true);
                                                }/*Creacion Directorio*/

                                                ////////////* SERVIDOR LOCAL*///////////////
                                                $nombre_foto='../_globales/images/'.$_SESSION['nombre_base'].'_cedulas_front/'.$id_usuario.'.jpg';
                                                //move_uploaded_file($_FILES['cedula_front']['tmp_name'],"$nombre_foto");

                                                
                                                /*Se incluye la libreria SimpleImage -> Para transformacion de imagenes*/
                                                include_once('../_includes-functions/librerias/SimpleImage-master/src/abeautifulsite/SimpleImage.php');
                                                
                                                /*Transformamos y guardamos la Imagen*/
                                                try {/*Try*/
                                                $img = new abeautifulsite\SimpleImage($_FILES['cedula_front']['tmp_name']);
                                                $img->best_fit(2000,2000)->save("$nombre_foto");
                                                }/*Try*/ catch(Exception $e) {/*Catch*/
                                                echo 'Error: ' . $e->getMessage();
                                                }/*Catch*/
                              
                                          }/*Si no hay alerta*/
                                         
                                        
                                          if(!file_exists($nombre_foto)){/*Comprobacion*/
                                                $_SESSION['alerta'][]="La foto no se pudo adjuntar.";
                                                }/*Comprobacion*/

                              }/*Si se adjunto un archivo*/

                              /*********************************************************************************CEDULA MANO**********************************************************************************/
                              /*Si se adjunto un archivo*/
                              if($_FILES['cedula_mano']['size'] > 0){/*Si se adjunto un archivo*/
                                        /*Exceso de tamaño*/
                                        if($_FILES['cedula_mano']['size'] > 10000000){$_SESSION['alerta'][]="La foto no debe tener un tamaño superior a 6 megas.";}
                                        /*si no hay error*/
                                        if($_FILES['cedula_mano']['error']){$_SESSION['alerta'][]="La foto tiene un error.";}
                                        /*La foto no es jpg*/
                                        if(($_FILES['cedula_mano']['type']!='image/jpg') and ($_FILES['cedula_mano']['type']!='image/jpeg') and ($_FILES['cedula_mano']['type']!='image/png') ){$_SESSION['alerta'][]="La imagen debe ser JPG, JPEG o PNG.";}
                                        /*Move file*/
                                        if(!isset($_SESSION['alerta'])){/*Si no hay alerta*/
                                        
                                                /*Se crea el Directorio si no existe*/
                                                if (!file_exists('../_globales/images/'.$_SESSION['nombre_base'].'_cedulas_mano/')) {/*Creacion directorio*/
                                                        mkdir('../_globales/images/'.$_SESSION['nombre_base'].'_cedulas_mano/', 0777, true);
                                                }/*Creacion Directorio*/

                                                ////////////* SERVIDOR LOCAL*///////////////
                                                $nombre_foto='../_globales/images/'.$_SESSION['nombre_base'].'_cedulas_mano/'.$id_usuario.'.jpg';
                                                //move_uploaded_file($_FILES['cedula_mano']['tmp_name'],"$nombre_foto");

                                                
                                                /*Se incluye la libreria SimpleImage -> Para transformacion de imagenes*/
                                                include_once('../_includes-functions/librerias/SimpleImage-master/src/abeautifulsite/SimpleImage.php');
                                                
                                                /*Transformamos y guardamos la Imagen*/
                                                try {/*Try*/
                                                $img = new abeautifulsite\SimpleImage($_FILES['cedula_mano']['tmp_name']);
                                                $img->best_fit(2000,2000)->save("$nombre_foto");
                                                }/*Try*/ catch(Exception $e) {/*Catch*/
                                                echo 'Error: ' . $e->getMessage();
                                                }/*Catch*/
                              
                                          }/*Si no hay alerta*/
                                         
                                        
                                          if(!file_exists($nombre_foto)){/*Comprobacion*/
                                                $_SESSION['alerta'][]="La foto no se pudo adjuntar.";
                                                }/*Comprobacion*/
                              }/*Si se adjunto un archivo*/


                               /*********************************************************************************CEDULA MANO**********************************************************************************/
                              /*Si se adjunto un archivo*/
                              if($_FILES['foto_perfil']['size'] > 0){/*Si se adjunto un archivo*/
                                        /*Exceso de tamaño*/
                                        if($_FILES['foto_perfil']['size'] > 10000000){$_SESSION['alerta'][]="La foto no debe tener un tamaño superior a 6 megas.";}
                                        /*si no hay error*/
                                        if($_FILES['foto_perfil']['error']){$_SESSION['alerta'][]="La foto tiene un error.";}
                                        /*La foto no es jpg*/
                                        if(($_FILES['foto_perfil']['type']!='image/jpg') and ($_FILES['foto_perfil']['type']!='image/jpeg') and ($_FILES['foto_perfil']['type']!='image/png') ){$_SESSION['alerta'][]="La imagen debe ser JPG, JPEG o PNG.";}
                                        /*Move file*/
                                        if(!isset($_SESSION['alerta'])){/*Si no hay alerta*/
                                        
                                                /*Se crea el Directorio si no existe*/
                                                if (!file_exists('../_globales/images/'.$_SESSION['nombre_base'].'_fotos_perfil/')) {/*Creacion directorio*/
                                                        mkdir('../_globales/images/'.$_SESSION['nombre_base'].'_fotos_perfil/', 0777, true);
                                                }/*Creacion Directorio*/

                                                ////////////* SERVIDOR LOCAL*///////////////
                                                $nombre_foto='../_globales/images/'.$_SESSION['nombre_base'].'_fotos_perfil/'.$id_usuario.'.jpg';
                                                //move_uploaded_file($_FILES['foto_perfil']['tmp_name'],"$nombre_foto");

                                                
                                                /*Se incluye la libreria SimpleImage -> Para transformacion de imagenes*/
                                                include_once('../_includes-functions/librerias/SimpleImage-master/src/abeautifulsite/SimpleImage.php');
                                                
                                                /*Transformamos y guardamos la Imagen*/
                                                try {/*Try*/
                                                $img = new abeautifulsite\SimpleImage($_FILES['foto_perfil']['tmp_name']);
                                                $img->best_fit(2000,2000)->save("$nombre_foto");
                                                }/*Try*/ catch(Exception $e) {/*Catch*/
                                                echo 'Error: ' . $e->getMessage();
                                                }/*Catch*/
                              
                                          }/*Si no hay alerta*/
                                         
                                        
                                          if(!file_exists($nombre_foto)){/*Comprobacion*/
                                                $_SESSION['alerta'][]="La foto no se pudo adjuntar.";
                                                }/*Comprobacion*/
                              }/*Si se adjunto un archivo*/

            

                    }/*Si no hay alerta*/ 
                    //else{echo"<script>window.location.href='?info=despues_de_exito_debe_llevar_a_pagina_donde_muestre_el_perfil_o_la_bolsa';</script>";die();}
                    
                    /*Chequeo de Imagenes*/
                   //if (!@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_cedulas_front/'.$id_usuario.'.jpg')) {$_SESSION['alerta'][]="Falta la Imagen frontal.";}
                   //if (!@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_cedulas_back/'.$id_usuario.'.jpg')) {$_SESSION['alerta'][]="Falta la imagen de atras.";}
                   //if (!@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_cedulas_mano/'.$id_usuario.'.jpg')) {$_SESSION['alerta'][]="Falta la imagen de la cedula en la mano.";}

                   
                    /*Si hay alerta (osea si las fotos no se enviaron) entonces se borra lo ingresado a la base de datos.*/ 
                    if( isset($_SESSION['alerta'])){/*Si no hay alerta*/
                             if(empty($usuario_editar) and !empty($id_usuario)){/*Si no elstamos editando un usuario*/
                                      /*DELETE*/
                                      $delete=$con->query("DELETE FROM usuarios WHERE id_usuario=$id_usuario");
                                      }/*Si no elstamos editando un usuario*/
                                      $mostrar_POST=true;
                    }else{
                          $_SESSION['alerta_ok'][]="La informacion se guardó correctamente."; 
                          echo "<script>window.location.href='?editar_usuario=$id_usuario'</script>";
                          die();
                    }
                   
                    
}/*If isset enviar*/


?>
<!DOCTYPE html>
<html>
<head>

	<link rel="stylesheet" type="text/css" href="../_globales/styles/resetcss.css">
	<link rel="stylesheet" type="text/css" href="../_includes-functions/styles/barraNavegacion.css">
	<link rel="stylesheet" type="text/css" href="../_includes-functions/styles/footer.css">
	<link rel="stylesheet" type="text/css" href="styles/entrevistas.css">

	<title>Entrevistas</title>

<!--Script de facil seleccion del nombre de usuario-->
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script>
$(function() {
var availableTags = [
<?
$select_usuarios=$con->query("SELECT usuario FROM usuarios ORDER BY usuario");
$usuarios_arr=array();
while($row=$select_usuarios->fetch_assoc()){
array_push($usuarios_arr,'"'.$row['usuario'].'"');
}
echo implode(",",$usuarios_arr);
?>
];
$( "#tagss" ).autocomplete({
source: availableTags
});
});
</script>

</head>
<body>



	<div id="entrevistas_cuerpo">
      
		<h1>Entrevistas</h1><br>
		<p>Realice el  siguiente cuestionario al modelo e ingrese las respuestas de forma clara y precisa.</p><br>

    <?include "../_includes-functions/foreach_alerta.php"; ?>




		<form action="" method='POST' id="entrevistas_cuerpo_formularioEntrevistas"  enctype="multipart/form-data">

                      <fieldset id="entrevistas_cuerpo_formularioEntrevistas_informacionPersonal">

                              <legend>1. Información personal y de contacto:</legend><br>
                             
                              
                              

                              <label>Usuario</label><input class="allinputs" autocomplete='off' style="width: 462px" <? if(isset($mostrar_POST)){echo "value='".$_POST['usuario']."'";}elseif(!empty($usuario_editar)){echo "value='".$usuario_editar['usuario']."'";} ?>name="usuario" type="text" placeholder="Ingresar Usuario"></input> 
                              <br>
                              <label>Nombres</label><input class="allinputs" style="width: 314px" autocomplete='off' name="nombres" <? if(isset($mostrar_POST)){echo "value='".$_POST['nombres']."'";}elseif(!empty($usuario_editar)){echo "value='".$usuario_editar['nombres']."'";} ?> type="text" placeholder="Ingresar nombres"></input> 
                              <label>Apellidos</label> <input class="allinputs" style="width: 356px" autocomplete='off' name="apellidos" type="text" <? if(isset($mostrar_POST)){echo "value='".$_POST['apellidos']."'";}elseif(!empty($usuario_editar)){echo "value='".$usuario_editar['apellidos']."'";} ?> placeholder="Ingresar Apellidos" ></input>

                              <br>

                              <label>Celular</label><input class="allinputs"  style="width: 153px" name="celular" <? if(isset($mostrar_POST)){echo "value='".$_POST['celular']."'";}elseif(!empty($usuario_editar)){echo "value='".$usuario_editar['celular']."'";} ?> autocomplete='off' type="text" placeholder="300 287 39 XX"></input> 
                              <label>Teléfono fijo</label> <input class="allinputs" autocomplete='off' style="width: 111px" name="telefono" type="text" <? if(isset($mostrar_POST)){echo "value='".$_POST['telefono']."'";}elseif(!empty($usuario_editar)){echo "value='".$usuario_editar['telefono']."'";} ?> placeholder="270 14 39" ></input>
                              <label>Ciudad Actual</label> <input class="allinputs" autocomplete='off' style="width: 263px" type="text" name="ciudad" <? if(isset($mostrar_POST)){echo "value='".$_POST['ciudad']."'";}elseif(!empty($usuario_editar)){echo "value='".$usuario_editar['ciudad']."'";} ?> placeholder="Medellín" ></input>

                              <br>

                              <label>Numero de cedula</label><input class="allinputs" style="width:175px" autocomplete='off' type="text" name='cedula' <? if(isset($mostrar_POST)){echo "value='".$_POST['cedula']."'";}elseif(!empty($usuario_editar)){echo "value='".$usuario_editar['cedula']."'";} ?> placeholder="1037621344" ></input><label>Sexo</label>

                              <select style="width: 112px" type="select" name="genero" form="entrevistas_cuerpo_formularioEntrevistas">
                              <? if(isset($mostrar_POST)){echo "<option value='".$_POST['genero']."'>".$_POST['genero']."</option>";}elseif(!empty($usuario_editar)){echo "<option value='".$usuario_editar['genero']."'>".$usuario_editar['genero']."</option>";} ?>
                               <option value="masculino" >Masculino</option>
                               <option value="femenino" >Femenino</option>
                               <option value="transgenero" >Transgenero</option>
                               <option value="pareja" >Pareja</option>
                       </select>

                       <label>Fecha de nacimiento</label> <input class="allinputs" style="width: 170px" 
                       <? if(isset($mostrar_POST)){echo "value='".$_POST['fecha_de_nacimiento']."'";}
                       elseif(!empty($usuario_editar)){
                              $fecha_de_nacimiento=explode(" ",$usuario_editar['fecha_de_nacimiento']);
                              echo "value='".$fecha_de_nacimiento['0']."'";} ?> 
                        autocomplete='off' name='fecha_de_nacimiento' type="date"></input>

                       <br>

                       <label>Correo electrónico</label> <input class="allinputs" style="width: 280px" autocomplete='off' type="email" name="email" <? if(isset($mostrar_POST)){echo "value='".$_POST['email']."'";}elseif(!empty($usuario_editar)){echo "value='".$usuario_editar['email']."'";} ?>  placeholder="micorreo@hotmail.com"></input> 
                       
                       <label>Facebook</label>  <input class="allinputs" autocomplete='off' <? if(isset($mostrar_POST)){echo "value='".$_POST['facebook']."'";}elseif(!empty($usuario_editar)){echo "value='".$usuario_editar['facebook']."'";} ?> style="width: 312px" type="text" name="facebook" placeholder="micorreofacebook@hotmail.com"></input>

                       <br>

                       <label>Instagram</label><input class="allinputs" style="width: 342px" type="text" <? if(isset($mostrar_POST)){echo "value='".$_POST['instagram']."'";}elseif(!empty($usuario_editar)){echo "value='".$usuario_editar['instagram']."'";} ?> autocomplete='off' name="instagram" placeholder="@pepito21"></input> 

                       <label>Twitter</label> <input class="allinputs" autocomplete='off' style="width: 341px" type="text" <? if(isset($mostrar_POST)){echo "value='".$_POST['twitter']."'";}elseif(!empty($usuario_editar)){echo "value='".$usuario_editar['twitter']."'";} ?> name="twitter" placeholder="@mitwitter"></input>

                       <br>

                       <label>Dirección de residencia</label> <input class="allinputs" style="width: 665px" autocomplete='off' <? if(isset($mostrar_POST)){echo "value='".$_POST['direccion']."'";}elseif(!empty($usuario_editar)){echo "value='".$usuario_editar['direccion']."'";} ?> type="text" name="direccion" placeholder="Cra 48 #33 - 40 Apto 201 Ed. Los Bucaros" ></input> 

               </fieldset>

               <br>

               <!--*******************************************************************************************************************************************************************************************************************-->
               <img src="../_globales/images/separador.png"> 

               <br>

               <fieldset id="entrevistas_cuerpo_formularioEntrevistas_referenciasPersonales">

                <legend>2. Referencias personales:</legend><br>

                <fieldset id="entrevistas_cuerpo_formularioEntrevistas_referenciasPersonales_1" >
                       <label>Nombre</label> <input class="allinputs" autocomplete='off' <? if(isset($mostrar_POST)){echo "value='".$_POST['ref1_nombre']."'";}elseif(!empty($usuario_editar)){echo "value='".$usuario_editar['ref1_nombre']."'";}  ?> style="width: 292px" name="ref1_nombre" type="text" placeholder="Ingresar Nombres" ></input> 
                       
                       <label>Apellidos</label> <input class="allinputs" <? if(isset($mostrar_POST)){echo "value='".$_POST['ref1_apellidos']."'";}elseif(!empty($usuario_editar)){echo "value='".$usuario_editar['apellidos']."'";} ?> autocomplete='off' style="width:316px" name='ref1_apellidos' type="text" placeholder="Ingresar Apellidos"></input><br>
                       <label>Parentesco</label>
                       <select type="select" name="ref1_parentesco" >
                               <? if(isset($mostrar_POST)){echo "<option value='".$_POST['ref1_parentesco']."'>".$_POST['ref1_parentesco']."</option>";}elseif(!empty($usuario_editar)){"<option value='".$usuario_editar['ref1_parentesco']."'>".$usuario_editar['ref1_parentesco']."</option>";} ?>
                               <option value="hermano" > Hermano </option>
                               <option value="novio" > Novio </option>
                               <option value="abuelo" > Abuelo </option>
                               <option value="madre" > Madre </option>
                               <option value="padre" > Padre </option>
                               <option value="tio" > Tio </option>
                               <option value="primo" > Primo </option>
                               <option value="amigo" > Amigo </option>
                               <option value="otro" > Otro </option>

                       </select>

                       <label>Celular</label><input class="allinputs" autocomplete='off' type="text" <? if(isset($mostrar_POST)){echo "value='".$_POST['ref1_celular']."'";}elseif(!empty($usuario_editar)){echo "value='".$usuario_editar['ref1_celular']."'";} ?> name="ref1_celular" ></input>
                       <label>Teléfono</label><input class="allinputs" autocomplete='off' style="width:206px" type="text" name="ref1_telefono" <? if(isset($mostrar_POST)){echo "value='".$_POST['ref1_telefono']."'";}elseif(!empty($usuario_editar)){echo "value='".$usuario_editar['ref1_telefono']."'";} ?> placeholder="270 14 32"></input>

               </fieldset>

               <fieldset id="entrevistas_cuerpo_formularioEntrevistas_referenciasPersonales_2" >
                <label>Nombre</label> <input class="allinputs" autocomplete='off' style="width: 292px" name="ref2_nombre" type="text" <? if(isset($mostrar_POST)){echo "value='".$_POST['ref2_nombre']."'";}elseif(!empty($usuario_editar)){echo "value='".$usuario_editar['ref2_nombre']."'";} ?> placeholder="Ingresar Nombres" ></input>
                
                <label>Apellidos</label> <input class="allinputs" autocomplete='off' <? if(isset($mostrar_POST)){echo "value='".$_POST['ref2_apellidos']."'";}elseif(!empty($usuario_editar)){echo "value='".$usuario_editar['ref2_apellidos']."'";} ?> style="width: 316px" type="text" name='ref2_apellidos' placeholder="Ingresar Apellidos"></input><br>
                <label>Parentesco</label>
                <select type="select" name="ref2_parentesco" >
                         <? if(isset($mostrar_POST)){echo "<option value='".$_POST['ref2_parentesco']."'>".$_POST['ref2_parentesco']."</option>";}elseif(!empty($usuario_editar)){echo "<option value='".$usuario_editar['ref2_parentesco']."'>".$usuario_editar['ref2_parentesco']."</option>";} ?>
                        <option value="hermano" > Hermano </option>
                        <option value="novio" > Novio </option>
                        <option value="abuelo" > Abuelo </option>
                        <option value="madre" > Madre </option>
                        <option value="padre" > Padre </option>
                        <option value="tio" > Tio </option>
                        <option value="primo" > Primo </option>
                        <option value="amigo" > Amigo </option>
                         <option value="otro" > Otro </option>
                </select>

                <label>Celular</label><input class="allinputs" autocomplete='off' type="text" <? if(isset($mostrar_POST)){echo "value='".$_POST['ref2_celular']."'";}elseif(!empty($usuario_editar)){echo "value='".$usuario_editar['ref2_celular']."'";} ?> name="ref2_celular" ></input>
                <label>Teléfono</label><input class="allinputs" autocomplete='off' style="width: 206px" type="text" name="ref2_telefono" <? if(isset($mostrar_POST)){echo "value='".$_POST['ref2_telefono']."'";}elseif(!empty($usuario_editar)){echo "value='".$usuario_editar['ref2_telefono']."'";} ?> placeholder="270 14 32"></input>

        </fieldset>

        <fieldset id="entrevistas_cuerpo_formularioEntrevistas_referenciasPersonales_3" >
                <label>Nombre</label> <input class="allinputs" autocomplete='off'style="width: 292px" <? if(isset($mostrar_POST)){echo "value='".$_POST['ref3_nombre']."'";}elseif(!empty($usuario_editar)){echo "value='".$usuario_editar['ref3_nombre']."'";} ?> name="ref3_nombre" type="text" placeholder="Ingresar Nombres" ></input>
                <label>Apellidos</label> <input class="allinputs" <? if(isset($mostrar_POST)){echo "value='".$_POST['ref3_apellidos']."'";}elseif(!empty($usuario_editar)){echo "value='".$usuario_editar['ref3_apellidos']."'";} ?> autocomplete='off'style="width: 316px" type="text" name='ref3_apellidos' placeholder="Ingresar Apellidos"></input><br>
                <label>Parentesco</label>
                <select type="select" name="ref3_parentesco">
                        <? if(isset($mostrar_POST)){echo "<option value='".$_POST['ref3_parentesco']."'>".$_POST['ref3_parentesco']."</option>";}elseif(!empty($usuario_editar)){echo "<option value='".$usuario_editar['ref3_parentesco']."'>".$usuario_editar['ref3_parentesco']."</option>";} ?>
                        <option value="hermano" > Hermano </option>
                        <option value="novio" > Novio </option>
                        <option value="abuelo" > Abuelo </option>
                        <option value="madre" > Madre </option>
                        <option value="padre" > Padre </option>
                        <option value="tio" > Tio </option>
                        <option value="primo" > Primo </option>
                        <option value="amigo" > Amigo </option>
                         <option value="otro" > Otro </option>
                </select>

                <label>Celular</label><input class="allinputs" <? if(isset($mostrar_POST)){echo "value='".$_POST['ref3_celular']."'";}elseif(!empty($usuario_editar)){echo "value='".$usuario_editar['ref3_celular']."'";} ?> autocomplete='off' type="text" name="ref3_celular" ></input>
                <label>Teléfono</label><input class="allinputs" autocomplete='off'style="width:206px" type="text" <? if(isset($mostrar_POST)){echo "value='".$_POST['ref3_telefono']."'";}elseif(!empty($usuario_editar)){echo "value='".$usuario_editar['ref3_telefono']."'";} ?> name="ref3_telefono" placeholder="270 14 32"></input>

        </fieldset>

</fieldset>


<!--*******************************************************************************************************************************************************************************************************************-->
<img src="../_globales/images/separador.png">



<legend style="margin-top: 10px;">3. Información de registro en la página y disponibilidad:</legend>

<fieldset id="entrevistas_cuerpo_formularioEntrevistas_paginas">

        <span>3.1 ¿Qué páginas va a trabajar la modelo?</span><br>

       <table id="entrevistas_cuerpo_formularioEntrevistas_paginas_tabla" cellpadding="1" cellspacing="1" width="900" >

       <tr>
       <td>
           
<?
$conteo_paginas=0;
$checks=$con->query("SELECT * FROM  paginas WHERE estado=1");
while($row=$checks->fetch_assoc()){/*While*/
            $id_pagina=$row['id_pagina'];
            echo "<input type='checkbox' name='usuario_page[]'";
            if($conteo_paginas==0){echo "checked ";}
            elseif(isset($mostrar_POST)){if (strpos($usuario_page, $id_pagina) !== false) {echo 'checked ';}}
            elseif(!empty($usuario_editar)){if (strpos($usuario_editar['usuario_page'], $id_pagina) !== false){echo 'checked ';}}
            echo "value='$id_pagina'>".$row['nombre_pagina']."</input>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
            $conteo_paginas++;
}/*While*/


?>
  
       <td>
       </tr>         
       </table>

</fieldset>

<fieldset id="entrevistas_cuerpo_formularioEntrevistas_paginas">

        <span>3.2 ¿A que horas está diponible la modelo?</span><br>

       <table id="entrevistas_cuerpo_formularioEntrevistas_paginas_tabla" cellpadding="1" cellspacing="1" width="900" >

       <tr>
           <td>
        <input type='checkbox' name='disponibilidad[]' 
        <?
        if(isset($mostrar_POST)){;if (strpos($disponibilidad, '1') !== false) {echo 'checked ';}}
        elseif(!empty($usuario_editar)){if (strpos($usuario_editar['disponibilidad'], '1')!== false){echo 'checked ';}}
        ?>
        value='1'>Mañana &#9729;
         <? echo "&nbsp;|&nbsp;";?>
        <input type='checkbox' name='disponibilidad[]' 
        <?
        if(isset($mostrar_POST)){;if (strpos($disponibilidad, '2') !== false) {echo 'checked ';}}
        elseif(!empty($usuario_editar)){if (strpos($usuario_editar['disponibilidad'], '2')!== false){echo 'checked ';}}
        ?>
        value='2'>Tarde &#9788;
        <? echo "&nbsp;|&nbsp;";?>
        <input type='checkbox' name='disponibilidad[]'
        <?
        if(isset($mostrar_POST)){;if (strpos($disponibilidad, '3') !== false) {echo 'checked ';}}
        elseif(!empty($usuario_editar)){if (strpos($usuario_editar['disponibilidad'], '3')!== false){echo 'checked ';}}
        ?>
        value='3'>Noche &#9790;
          </td>
       </tr>         
       </table>

</fieldset>



<?
/*USUARIOS Y CONTRASEÑAS DE LAS DIFERENTES PAGINAS*/

if(isset($usuario_editar['id_usuario'])){/*Si no se esta consultando un usuario sino que se va a crear uno, osea si existe el $GET_['editar_usuario'] */

      echo "<fieldset id='entrevistas_cuerpo_formularioEntrevistas_paginas'>";

            echo "<span>3.3 Credenciales Paginas:</span>";
            echo "<a href='../credenciales/credenciales.php?editar_usuario=".$usuario_editar['id_usuario']."'><img src='../_globales/images/editar.png' style='float:right;'></a>";

            echo "<table id='entrevistas_cuerpo_formularioEntrevistas_paginas_tabla' cellpadding='1' cellspacing='1' width='900' >";


                  $conteo_credenciales=0;
                  
                  
                  $credenciales=$con->query("SELECT * FROM  credenciales WHERE id_usuario='".$usuario_editar['id_usuario']."' AND eliminado='0'");
                  while($row=$credenciales->fetch_assoc()){/*While*/
                  
                        echo "<tr>";
                                   echo "<td><img src='../_globales/images/".$_SESSION['nombre_base']."_paginas/".$row['id_pagina'].".png' style='max-width:100px;'></td>";
                                   echo "<td>Usuario: ".$row['usuario']."</td>";
                                   echo "<td>Password: ".$row['password']."</td>";
                                   echo "<td>Email: ".$row['email_de_registro']."</td>";
                        echo "</tr>";

                        $conteo_credenciales++;   
                  
                  }/*While*/
                      
                      
                  
                  if($conteo_credenciales==0){echo "No existen cuentas creadas a nombre de este usuario.";}
            
            
            
            echo "</table>";
      echo "</fieldset>";

}/*Si no se esta consultando un usuario sino que se va a crear uno, osea si existe el $GET_['editar_usuario']*/
?>


<fieldset id="entrevistas_cuerpo_formularioEntrevistas_paginas">

        <span>3.3 ¿En que modalidad está interesado(a)?</span><br>

       <table id="entrevistas_cuerpo_formularioEntrevistas_paginas_tabla" cellpadding="1" cellspacing="1" width="900" >

       <tr>
           <td>
        <input type='radio' name='modalidad[]' 
        <?
        if(isset($mostrar_POST)){;if (strpos($modalidad, '1') !== false) {echo 'checked ';}}
        elseif(!empty($usuario_editar)){if (strpos($usuario_editar['modalidad'], '1')!== false){echo 'checked ';}}
        ?>
        value='1'>Estudio <img src="../_globales/images/iconoestudio.png" alt="Satelite">
        <? echo "&nbsp;|&nbsp;";?>  
        
        <input type='radio' name='modalidad[]' 
        <?
        if(isset($mostrar_POST)){;if (strpos($modalidad, '2') !== false) {echo 'checked ';}}
        elseif(!empty($usuario_editar)){if (strpos($usuario_editar['modalidad'], '2')!== false){echo 'checked ';}}
        ?>
        value='2'>Satelite <img src="../_globales/images/iconosatelite.png" alt="Satelite">
        
      </table>

</fieldset>


<!--*******************************************************************************************************************************************************************************************************************-->

<img src="../_globales/images/separador.png"> <br><br>

<?
if(isset($_GET['editar_usuario'])){$id_usuario=$_GET['editar_usuario'];}
?>

<legend style="margin-top: 10px;">4. Fotografias de modelos:</legend>



<div style=' width:80%;'>

      
      <fieldset id="entrevistas_cuerpo_formularioEntrevistas_copiaCedula_cedulaEnMano" >       
              <span>4.1 Suba una fotografía de perfil de la modelo:</span><br><br>
              <?
               if (@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_fotos_perfil/'.$id_usuario.'.jpg')) {echo"<img src=\"../_globales/images/".$_SESSION['nombre_base']."_fotos_perfil/".$id_usuario.".jpg\" style='max-width:400px;max-height:300px;'> ";}else{echo "<img src=\"../_globales/images/imagendemuestra2.jpg\">";} 
              ?>
              <br><input class="allinputs" type="file" name='foto_perfil'></input> <br>
      </fieldset>
</div>

<img src="../_globales/images/separador.png">

<div style=' width:80%;'>
      
      
      <fieldset id="entrevistas_cuerpo_formularioEntrevistas_copiaCedula_cedulaEnMano" >       
              <span>4.2 Suba una fotografía con cedula en mano del modelo:</span><br><br>
              <?
               if (@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_cedulas_mano/'.$id_usuario.'.jpg')) {echo"<img src=\"../_globales/images/".$_SESSION['nombre_base']."_cedulas_mano/".$id_usuario.".jpg\" style='max-width:400px;max-height:300px;'> ";}else{echo "<img src=\"../_globales/images/cedulaenmano.jpg\">";} 
              ?>
              <br><input class="allinputs" type="file" name='cedula_mano'></input> <br>
      </fieldset>
</div>


      <img src="../_globales/images/separador.png"> 


<fieldset id="entrevistas_cuerpo_formularioEntrevistas_paginas">
        <span>4.3 Ingrese una copia de la cara frontal y una copia de la cara posterior</span><br><br>

        <div id="entrevistas_cuerpo_formularioEntrevistas_copiaCedula_inputCedula1">
                <p>Parte de adelante de la cedula</p>
                <?  
                
                if (@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_cedulas_front/'.$id_usuario.'.jpg')) {echo"<img src=\"../_globales/images/".$_SESSION['nombre_base']."_cedulas_front/".$id_usuario.".jpg\" style='max-width:400px;max-height:300px;'> ";}else{echo "<img src=\"../_globales/images/cedula1.png\">";} 
                ?>
                
                <input class="allinputs" type="file" name='cedula_front' ></input>
        </div>


        <div id="entrevistas_cuerpo_formularioEntrevistas_copiaCedula_inputCedula2">
                <p>Parte de atrás de la cedula</p>
                <?
                if (@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_cedulas_back/'.$id_usuario.'.jpg')) {echo"<img src=\"../_globales/images/".$_SESSION['nombre_base']."_cedulas_back/".$id_usuario.".jpg\"style='max-width:400px;max-height:300px;'> ";}else{echo "<img src=\"../_globales/images/cedula2.png\">";} 
                ?>
                <input class="allinputs" type="file" name='cedula_back'></input>
        </div>

</fieldset>





<img src="../_globales/images/separador.png">


<fieldset id="entrevistas_cuerpo_formularioEntrevistas_notas" >

       <legend>5. Adicione Notas del registro de la modelo:</legend><br>

       <p>Ponga cualquier nota que necesite recordar, que tenga que ver con cualquier aspecto del registro de la modelo: </p> <br>
       <textarea name='nota' placeholder="Escriba sus notas aquí..." style='width:900px;height:100px;' maxlength="5000" ><? if(isset($mostrar_POST)){echo $_POST['nota'];}elseif(!empty($usuario_editar2)){echo $usuario_editar2['nota'];} ?></textarea>

</fieldset>

<fieldset id="entrevistas_cuerpo_formularioEntrevistas_urlyoutube" >

       <legend>6. Ingrese la url del video de la entrevista:</legend><br>

       <p>Suba el video de la entrevista en www.youtube.com (en modo privado) e ingrese la URL del video en el siguiente campo: </p> <br>
       <img style="vertical-align: middle; margin-right: 15px;" src="../_globales/images/logoyoutube.jpg"> <input class="allinputs" style="width:700px; height:70px; font-size: 35px;  font-family: HelveticaNeueLTStd-Lt; padding-left: 15px;" id="entrevistas_cuerpo_formularioEntrevistas_urlyoutube_ingresarurl" type="text" <? if(isset($mostrar_POST)){echo "value='".$_POST['url_entrevista']."'";}elseif(!empty($usuario_editar)){echo "value='".$usuario_editar['url_entrevista']."'";} ?>autocomplete='off' name="url_entrevista" placeholder="https://www.youtube.com/watch?v=h_L4Rixya64..." ></input>

</fieldset>

<? if(0!=0){/*Desactive la seccion momentaneamente*/?>
<fieldset id="entrevistas_cuerpo_formularioEntrevistas_referido" >

       <legend>7. Por último! ¿Esta persona es referida? llene el siguiente campo:</legend><br>

       <p>Digite el nombre de usuario o nombre de la persona que ha referido al entrevistado.</p> <br>

      
      
            
      
             <div id="entrevistas_cuerpo_formularioEntrevistas_referido_1" >
             <style type="text/css">.ui-helper-hidden-accessible{display:none;}</style>
             
                     
             <div class='ui-widget'><!--Abre ui-widget-->
             <?
             if(!empty($usuario_editar)){/*Si el usuarios se esta editando se debe consultar el ususario del referente por medio del id_usuario*/
             $usuario_de_referente=$con->query("SELECT usuario FROM usuarios WHERE id_usuario='".$usuario_editar['id_referente']."' ")->fetch_assoc();
             $usuario_de_referente=$usuario_de_referente['usuario'];
             }/*Si el usuarios se esta editando se debe consultar el ususario del referente por medio del id_usuario*/
             ?>
                    <img style="vertical-align: bottom; margin-right: 15px;" src="../_globales/images/referidosicono.png"><font>Referido por</font>
                    <input class="allinputs" id='tagss' style="width:629px;height:70px;font-size:35px;margin-left:14px;font-family:HelveticaNeueLTStd-Lt;padding-left:15px;" type="text" <? if(isset($mostrar_POST)){echo "value='".$_POST['usuario_referente']."'";}elseif(!empty($usuario_editar)){echo "value='".$usuario_de_referente."'";} ?>autocomplete='off' name="usuario_referente" placeholder="Digite nombre o usuario..." ></input>
             </div><!--Cierra ui-widget-->
             </div>

      

</fieldset>
<?}?>

<input class="allinputs" id="entrevistas_cuerpo_formularioEntrevistas_ingresarDatosEntrevista" type="submit" name='enviar' value="Ingresar datos de entrevista >" ></input>

</form>



</div>

<?php include '../_includes-functions/footer.php';?>

</body>
</html>