<?
include "../_includes-functions/conexion_improved.php";
include "../_includes-functions/seguridad.php"; 
include "../_includes-functions/funciones.php";
include '../_includes-functions/barraNavegacion.php';


/*Por Seguridad solo los usuarios con niveles altos pueden ingresar*/
if( ($_SESSION['nivel']!='2') and ($_SESSION['nivel']!='3')){$_SESSION['alerta'][]='No puedes ingresar a esta aplicación.';}

/*Si no existe la tabla crearla*/
$insertar_nueva_pagina=$con->query("CREATE TABLE IF NOT EXISTS paginas (id_pagina INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,fecha_creacion TIMESTAMP,nombre_pagina VARCHAR(100) NOT NULL,estado INT(6),color_pagina VARCHAR(100) NOT NULL) ENGINE=MEMORY;");


/*Para anotar un nueva pagina*/
if(isset($_POST['nueva'])){/*If isset nueva*/
                  
       $nombre_pagina=$_POST['nombre_pagina'];
       //echo '$nombre_pagina: '.$nombre_pagina."<br>";

       $color_pagina="#".$_POST['color_pagina'];
       //echo '$color_pagina: '.$color_pagina."<br>";
       
       
      /*Si hace falta datos saca alerta*/
      if(empty($nombre_pagina)){$_SESSION['alerta'][]='Debes ingresar el nombre del pagina.';}
      
      if(!isset($_SESSION['alerta'])){/*Si ni hay alerta*/

                      /*Se ingresa nombre de pagina a la base de datos*/
                      $insertar_nueva_pagina=$con->query("INSERT INTO `paginas`(`id_pagina`, `fecha_creacion`, `nombre_pagina`,color_pagina, `estado`) 
                                                          VALUES (default,'$lahoraencolombia','$nombre_pagina','$color_pagina',1)");

                      /*Alerta OK*/
                      if($insertar_nueva_pagina){/*Si se insertó el pagina a base*/
                            $_SESSION['alerta_ok'][]='pagina Ingresada Correctamente.';
                            $last_id = $con->insert_id;
                      
                          
                          /*Si se adjunto un archivo*/
                           if($_FILES['logo_pagina']['size'] > 0){/*Si se adjunto un archivo*/
                                     /*Exceso de tamaño*/
                                     if($_FILES['logo_pagina']['size'] > 6000000){$_SESSION['alerta'][]="La foto no debe tener un tamaño superior a 6 megas.";}
                                     /*si no hay error*/
                                     if($_FILES['logo_pagina']['error']){$_SESSION['alerta'][]="La foto tiene un error.";}
                                     /*La foto no es png o jpg*/
                                     if(($_FILES['logo_pagina']['type']!='image/jpg') and ($_FILES['logo_pagina']['type']!='image/jpeg') and ($_FILES['logo_pagina']['type']!='image/png') ){$_SESSION['alerta'][]="La imagen debe ser JPG, JPEG o PNG.";}
                                     
                                             
                                               /*Se crea el Directorio si no existe*/
                                               if (!file_exists('../_globales/images/'.$_SESSION['nombre_base'].'_paginas/')) {/*Creacion directorio*/
                                                       mkdir('../_globales/images/'.$_SESSION['nombre_base'].'_paginas/', 0777, true);
                                               }/*Creacion Directorio*/
        
                                               ////////////* SERVIDOR LOCAL*///////////////
                                               $nombre_foto='../_globales/images/'.$_SESSION['nombre_base'].'_paginas/'.$last_id .'.png';
                                               //move_uploaded_file($_FILES['logo_pagina']['tmp_name'],"$nombre_foto");
        
                                               
                                               /*Se incluye la libreria SimpleImage -> Para transformacion de imagenes*/
                                               include_once('../_includes-functions/librerias/SimpleImage-master/src/abeautifulsite/SimpleImage.php');
                                               
                                               /*Transformamos y guardamos la Imagen*/
                                               try {/*Try*/
                                               $img = new abeautifulsite\SimpleImage($_FILES['logo_pagina']['tmp_name']);
                                               $img->best_fit(1000,1000)->save("$nombre_foto");
                                               }/*Try*/ catch(Exception $e) {/*Catch*/
                                               echo 'Error: ' . $e->getMessage();
                                               }/*Catch*/
                           
                                      
                                                                           
                                              if(file_exists($nombre_foto)){/*Comprobacion*/
                                                    $_SESSION['alerta_ok'][]="La foto se adjuntó correctamente.";
                                              }/*Comprobacion*/else{/*Comprobacion*/
                                                     $_SESSION['alerta'][]="La foto NO se pudo adjuntar.";
                                              }/*Comprobacion*/
                           
                           }/*Si se adjunto un archivo*/       

                      }/*Si se insertó el pagina a base*/
                      
      }/*Si ni hay alerta*/

}/*If isset nueva*/

/*Activar un nueva pagina de la lista de eliminados*/
if(isset($_POST['activar'])){/*If isset actualizar*/
                  
       $id_pagina=$_POST['activar'];
      //echo $id_pagina."<br>";

      $reactivar_pagina=$con->query("UPDATE `paginas` SET fecha_creacion='$lahoraencolombia',`estado`=1 WHERE id_pagina='$id_pagina' ");
      if($reactivar_pagina){$_SESSION['alerta_ok'][]='pagina Reactivado.';}

                    
}/*If isset actualizar*/

/*Eliminar un pagina*/
if(isset($_POST['eliminar'])){/*If isset actualizar*/
                  
      $id_pagina=$_POST['eliminar'];
      //echo $id_cuenta."<br>";

      $eliminar_pagina=$con->query("UPDATE `paginas` SET fecha_creacion='$lahoraencolombia', `estado`=0 WHERE id_pagina='$id_pagina' ");
      if($eliminar_pagina){$_SESSION['alerta_ok'][]='pagina Eliminado.';}              
       
                    
}/*If isset actualizar*/

/*Edicion de pagina*/
if(isset($_POST['editar'])){/*1*/
                            $_SESSION['paginas_id_pagina']=$_POST['editar'];

                 echo"<script>window.location.href='paginas.php#".$_SESSION['paginas_id_pagina']."';</script>";
                           }/*1*/

/*Editar2*/               
if(isset($_POST['editar2'])){/*1*/

                $id_pagina=$_POST['editar2'];
                $nuevanompagina=$_POST['nuevanompagina'];
                //echo $nuevanompagina;
                $color_pagina="#".$_POST['color_pagina'];
                //echo $color_pagina;

                /*Si hace falta datos saca alerta*/
                if(empty($nuevanompagina)){$_SESSION['alerta'][]='Debes ingresar el nombre del pagina.';}
                
                if(!isset($_SESSION['alerta'])){/*Si ni hay alerta*/
          
                                /*Se ingresa nombre de pagina a la base de datos*/
                                $editar_nueva_pagina=$con->query("UPDATE paginas SET nombre_pagina='$nuevanompagina', color_pagina='$color_pagina' WHERE id_pagina='$id_pagina'");
          
                                /*Alerta OK*/
                                if($editar_nueva_pagina){/*Si se insertó el pagina a base*/
                                     
                                     $_SESSION['alerta_ok'][]='pagina Editado Correctamente.';
                                                                     
                                    
                                    /*Si se adjunto un archivo*/
                                     if($_FILES['nueva_logo_pagina']['size'] > 0){/*Si se adjunto un archivo*/
                                               /*Exceso de tamaño*/
                                               if($_FILES['nueva_logo_pagina']['size'] > 6000000){$_SESSION['alerta'][]="La foto no debe tener un tamaño superior a 6 megas.";}
                                               /*si no hay error*/
                                               if($_FILES['nueva_logo_pagina']['error']){$_SESSION['alerta'][]="La foto tiene un error.";}
                                               /*La foto no es png o jpg*/
                                               if(($_FILES['nueva_logo_pagina']['type']!='image/jpg') and ($_FILES['nueva_logo_pagina']['type']!='image/jpeg') and ($_FILES['nueva_logo_pagina']['type']!='image/png') ){$_SESSION['alerta'][]="La imagen debe ser JPG, JPEG o           PNG.";}
                                               
                                                       
                                                         /*Se crea el Directorio si no existe*/
                                                         if (!file_exists('../_globales/images/'.$_SESSION['nombre_base'].'_paginas/')) {/*Creacion directorio*/
                                                                 mkdir('../_globales/images/'.$_SESSION['nombre_base'].'_paginas/', 0777, true);
                                                         }/*Creacion Directorio*/
                  
                                                         ////////////* SERVIDOR LOCAL*///////////////
                                                         $nombre_foto='../_globales/images/'.$_SESSION['nombre_base'].'_paginas/'.$id_pagina .'.png';
                                                         //move_uploaded_file($_FILES['nueva_logo_pagina']['tmp_name'],"$nombre_foto");
                  
                                                         
                                                         /*Se incluye la libreria SimpleImage -> Para transformacion de imagenes*/
                                                         include_once('../_includes-functions/librerias/SimpleImage-master/src/abeautifulsite/SimpleImage.php');
                                                         
                                                         /*Transformamos y guardamos la Imagen*/
                                                         try {/*Try*/
                                                         $img = new abeautifulsite\SimpleImage($_FILES['nueva_logo_pagina']['tmp_name']);
                                                         $img->best_fit(1000,1000)->save("$nombre_foto");
                                                         }/*Try*/ catch(Exception $e) {/*Catch*/
                                                         echo 'Error: ' . $e->getMessage();
                                                         }/*Catch*/
                                     
                                                
                                                                                     
                                                        if(file_exists($nombre_foto)){/*Comprobacion*/
                                                              $_SESSION['alerta_ok'][]="La foto se Reemplazó correctamente.";
                                                        }/*Comprobacion*/else{/*Comprobacion*/
                                                               $_SESSION['alerta'][]="La foto NUEVA NO se pudo adjuntar.";
                                                        }/*Comprobacion*/
                                     
                                     }/*Si se adjunto un archivo*/

                                /*Se resetea la edicion*/
                                $_SESSION['paginas_id_pagina']='';
                                
                                }/*Si se insertó el pagina a base*/
                                
                }/*Si ni hay alerta*/


}/*1*/
               

if(!isset($_SESSION['paginas_id_pagina'])){$_SESSION['paginas_id_pagina']='';}



?>
<!DOCTYPE html>
<html>
<head>

  <link rel="stylesheet" type="text/css" href="../_globales/styles/resetcss.css">
	<link rel="stylesheet" type="text/css" href="../_includes-functions/styles/barraNavegacion.css">
	<link rel="stylesheet" type="text/css" href="../_includes-functions/styles/footer.css">
	<link rel="stylesheet" type="text/css" href="styles/paginas.css">

	<title>paginas</title>
  <style>
  a{text-decoration: none;}
  #post_div
  {
  display:none;
  }
  #button_nice{
  background:#fff;
  background:-webkit-linear-gradient(#fff, #fff);
  background:linear-gradient(#fff, #fff);
  border:1px solid #569;
  border-radius: 5px;
  color:#666;
  display:inline-block;
  padding:15px 25px;
  font:normal 700 20px/1 "Calibri", sans-serif;
  text-align:center;
  text-shadow:none;
  }
  </style>
  
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  
  <!--Esconde y Muestra los paginas Eliminados-->
  <script> 
  $(document).ready(function(){
  $(".show").click(function(){
  $("#post_div").slideToggle("slow");
  
  });
  });
  </script>

<!--Esconde y Muestra la div de ingresar un nueva pagina-->
  <script> 
  $(document).ready(function(){
  $(".mostrar").click(function(){
  $("#entrevistas_cuerpo_formularioEntrevistas_paginas").slideToggle("slow");
  
  });
  });
  </script>
<!--Script para escoger el color de la pagina-->
<script src="scripts/jscolor.js"></script>

</head>
<body>



<div id="entrevistas_cuerpo">
      
		

<?include "../_includes-functions/foreach_alerta.php"; ?>




    
                    

              

<?/*Por Seguridad solo los usuarios con niveles altos pueden ingresar*/
if( ($_SESSION['nivel']=='2') or ($_SESSION['nivel']=='3')){/*SI tiene permisos*/



      
       ////////////////////////////////////
      ////////////ADJUNTAR nueva//////////
     ////////////////////////////////////     
echo "<form action='' method='POST' id='entrevistas_cuerpo_formularioEntrevistas'  enctype='multipart/form-data'>";   
            
            echo "<fieldset id='entrevistas_cuerpo_formularioEntrevistas_paginas' style='margin-bottom:100px;'> ";
            
            echo "<h1>Adjuntar Nueva Pagina</h1>";
            echo "<p>En el siguiente campo puedes agregar nuevas paginas donde vas a transmitir, ejemplo: Chaturbate.</p>";
            
           

            echo "<table id='entrevistas_cuerpo_formularioEntrevistas_paginas_tabla' cellpadding='1' cellspacing='1' width='900' >";
                
                echo "<tr id='pagina_nueva'>";
                echo "<td>Nombre pagina: <input class='allinputs' autocomplete='off' type='text'  style='width:150px;' name='nombre_pagina' ></td>";
                echo "<td>Color: <input name='color_pagina' class='jscolor' value='FFFFFF'></td>";
                echo "<td><label class='input_tipo_archivo'><input type='file' name='logo_pagina' style='position:absolute;left:-9999px' />Adjuntar Logo</label></td>";
                echo "<td><button name='nueva' style='border:0;background:transparent;cursor:pointer;'><img src='../_globales/images/agregarModelo.png' width='18px'></button></td>";
                echo "</tr>";

                echo "</table>";

            echo "</fieldset>";
                
echo"</form>";
      
       ////////////////////////////////////
      /////////////EXISTENTES/////////////
     ////////////////////////////////////     
      
echo "<form action='' method='POST' id='entrevistas_cuerpo_formularioEntrevistas'  enctype='multipart/form-data'>";   
      
      echo "<fieldset id='entrevistas_cuerpo_formularioEntrevistas_paginas' style='margin-bottom:100px;'>";
            
            echo "<h1>Paginas de Transmision</h1>";
            echo "<p>Aquí se pueden visualizar y editar las paginas que aparecen en la aplicacion de pagos y de entrevistas.</p>";

            echo "<table id='entrevistas_cuerpo_formularioEntrevistas_paginas_tabla' cellpadding='1' cellspacing='1' width='900' >";

                /*Nombres de paginas Existentes*/
                $conteo_cuentas=0;

                $paginas=$con->query("SELECT * FROM  paginas WHERE estado='1' ORDER BY fecha_creacion DESC");
                while($row=$paginas->fetch_assoc()){/*While*/
                
                           if($_SESSION['paginas_id_pagina']!=$row['id_pagina']){/*NO Editar*/
                                
                                 if (!@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_paginas/'.$row['id_pagina'].'.png')) {$image='../_globales/images/no_image2.png';}else{$image="../_globales/images/".$_SESSION['nombre_base'].  "_paginas/".$row['id_pagina'].".png";}

                                echo "<tr>";
                                     
                                     echo "<td>Nombre pagina: ".ucwords($row['nombre_pagina'])."</td>";
                                     echo "<td>Color: <input style='background-color:".$row['color_pagina'].";' ></td>";
                                     echo "<td><img src=".$image." style='max-width:100px;'></td>";
                                     echo "<td><button name='editar' title='Editar' value='".$row['id_pagina']."' style='border:0;background:transparent;cursor:pointer;'><img src='../_globales/images/editicon.png' width='18px'></button></td>";
                                     echo "<td><button name='eliminar' title='Eliminar' value='".$row['id_pagina']."' style='border:0;background:transparent;cursor:pointer;'><img src='../_globales/images/wrongiconsmall.png' width='18px'></button></td>";
                                    
                                 echo "</tr>";   

                           }/*NO Editar*/else{/*Editar*/
                                
                                echo "<tr>";
                                     
                                     echo "<td>Nombre pagina: <input class='allinputs' autocomplete='off' type='text'  value='".ucwords($row['nombre_pagina'])."' style='width:150px;' name='nuevanompagina' ></td>";
                                     echo "<td>Color: <input name='color_pagina' class='jscolor' value='".$row['color_pagina']."'></td>";
                                     echo "<td><label class='input_tipo_archivo'><input type='file' name='nueva_logo_pagina' style='position:absolute;left:-9999px' />Reemplazar Logo</label></td>";
                                     echo "<td><button name='editar2' title='Editar' value='".$row['id_pagina']."' style='border:0;background:transparent;cursor:pointer;'><img src='../_globales/images/goodjobicon2.png' width='18px'></button></td>";
                                                                        
                                     
                                echo "</tr>";  

                           }/*Editar*/
                 

                      $conteo_cuentas++;

                }/*While*/
      
      
            echo "</table>";
      
            if($conteo_cuentas==0){echo "<p style='color:red;'>No existen paginas Registrados.</p>";}
      
      echo "</fieldset>";
      
echo "</form>";

         
      
      
       /////////////////////////////////
      ////////////ELIMINADOS///////////
     /////////////////////////////////
          echo "<div id='aspirantes_cuerpo_contenedor_verAntiguos' style='margin:30px;' >";
          echo "<button id='button_nice' src='../_globales/images/verantiguos.png' id='aspirantes_cuerpo_verAntiguos' class='show' >Mostrar paginas Eliminadas...</button>";
          echo "</div>";

            echo "<form action='' method='POST' id='entrevistas_cuerpo_formularioEntrevistas'>";
      
            echo "<div id='post_div'><!--ABRE post_div-->";
            
                  echo "<fieldset id='entrevistas_cuerpo_formularioEntrevistas_paginas' style='margin-bottom:100px;'>";
                  
                  echo "<h1>Eliminadas</h1>";
                  echo "<p>Aquí se pueden visualizar Los paginas ELIMINADAS.</p>";
                  
                  echo "<table id='entrevistas_cuerpo_formularioEntrevistas_paginas_tabla' cellpadding='1' cellspacing='1' width='900' >";
            

            
                       
            
                        /*Nombres de paginas Existentes*/
                        $conteo_cuentas=0;

                        $paginas=$con->query("SELECT * FROM  paginas WHERE estado='0' ORDER BY fecha_creacion DESC");
                        while($row=$paginas->fetch_assoc()){/*While*/
                        
                                     
                                     if (!@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_paginas/'.$row['id_pagina'].'.png')) {$image='../_globales/images/no_image2.png';}else{$image="../_globales/images/".$_SESSION['nombre_base'].  "_paginas/".$row['id_pagina'].".png";}

                                    echo "<tr>";
                                         
                                         echo "<td>Nombre pagina: ".ucwords($row['nombre_pagina'])."</td>";
                                         echo "<td>Color: <input style='background-color:".$row['color_pagina']."' ></td>";
                                         echo "<td><img src=".$image." style='max-width:100px;'></td>";
                                         echo "<td><button name='activar' title='Eliminar' value='".$row['id_pagina']."' style='border:0;background:transparent;cursor:pointer;'><img src='../_globales/images/goodjobicon2.png'></button></td>";
                                        
                                         
                                    echo "</tr>";   

                          

                              $conteo_cuentas++;

                        }/*While*/
            
            
                        echo "</table>";
            
                        if($conteo_cuentas==0){echo "<p style='color:red;'>No existen paginas eliminados.</p>";}
            
                  echo "</fieldset>";
            
                  
            echo "</div><!--CIERRA post_div-->";
            echo "</form>";
      
     

}/*SI tiene permisos*/

?>



</form>



</div>

<?php include '../_includes-functions/footer.php';?>

</body>
</html>