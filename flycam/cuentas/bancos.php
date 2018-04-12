<?
include "../_includes-functions/conexion_improved.php";
include "../_includes-functions/seguridad.php"; 
include "../_includes-functions/funciones.php";
include '../_includes-functions/barraNavegacion.php';


/*Por Seguridad solo los usuarios con niveles altos pueden ingresar*/
if( ($_SESSION['nivel']!='2') and ($_SESSION['nivel']!='3')){$_SESSION['alerta'][]='No puedes ingresar a esta aplicación.';}

/*Si no existe la tabla crearla*/
$insertar_nuevo_banco=$con->query("CREATE TABLE IF NOT EXISTS bancos (id_banco INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,fecha_creacion TIMESTAMP,nombre_banco VARCHAR(100) NOT NULL,estado INT(6)) ENGINE=MEMORY;");


/*Para anotar un nuevo Banco*/
if(isset($_POST['nuevo'])){/*If isset nuevo*/
                  
       $nombre_banco=$_POST['nombre_banco'];
       //echo '$nombre_banco: '.$nombre_banco."<br>";
       
       
      /*Si hace falta datos saca alerta*/
      if(empty($nombre_banco)){$_SESSION['alerta'][]='Debes ingresar el nombre del Banco.';}
      
      if(!isset($_SESSION['alerta'])){/*Si ni hay alerta*/

                      /*Se ingresa nombre de banco a la base de datos*/
                      $insertar_nuevo_banco=$con->query("INSERT INTO `bancos`(`id_banco`, `fecha_creacion`, `nombre_banco`, `estado`) 
                                                          VALUES (default,'$lahoraencolombia','$nombre_banco',1)");

                      /*Alerta OK*/
                      if($insertar_nuevo_banco){/*Si se insertó el banco a base*/
                            $_SESSION['alerta_ok'][]='Banco Ingresada Correctamente.';
                            $last_id = $con->insert_id;
                      
                          
                          /*Si se adjunto un archivo*/
                           if($_FILES['logo_banco']['size'] > 0){/*Si se adjunto un archivo*/
                                     /*Exceso de tamaño*/
                                     if($_FILES['logo_banco']['size'] > 6000000){$_SESSION['alerta'][]="La foto no debe tener un tamaño superior a 6 megas.";}
                                     /*si no hay error*/
                                     if($_FILES['logo_banco']['error']){$_SESSION['alerta'][]="La foto tiene un error.";}
                                     /*La foto no es png o jpg*/
                                     if(($_FILES['logo_banco']['type']!='image/jpg') and ($_FILES['logo_banco']['type']!='image/jpeg') and ($_FILES['logo_banco']['type']!='image/png') ){$_SESSION['alerta'][]="La imagen debe ser JPG, JPEG o PNG.";}
                                     
                                             
                                               /*Se crea el Directorio si no existe*/
                                               if (!file_exists('../_globales/images/'.$_SESSION['nombre_base'].'_bancos/')) {/*Creacion directorio*/
                                                       mkdir('../_globales/images/'.$_SESSION['nombre_base'].'_bancos/', 0777, true);
                                               }/*Creacion Directorio*/
        
                                               ////////////* SERVIDOR LOCAL*///////////////
                                               $nombre_foto='../_globales/images/'.$_SESSION['nombre_base'].'_bancos/'.$last_id .'.png';
                                               //move_uploaded_file($_FILES['logo_banco']['tmp_name'],"$nombre_foto");
        
                                               
                                               /*Se incluye la libreria SimpleImage -> Para transformacion de imagenes*/
                                               include_once('../_includes-functions/librerias/SimpleImage-master/src/abeautifulsite/SimpleImage.php');
                                               
                                               /*Transformamos y guardamos la Imagen*/
                                               try {/*Try*/
                                               $img = new abeautifulsite\SimpleImage($_FILES['logo_banco']['tmp_name']);
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

                      }/*Si se insertó el banco a base*/
                      
      }/*Si ni hay alerta*/

}/*If isset nuevo*/

/*Activar un nuevo banco de la lista de eliminados*/
if(isset($_POST['activar'])){/*If isset actualizar*/
                  
       $id_banco=$_POST['activar'];
      //echo $id_banco."<br>";

      $reactivar_banco=$con->query("UPDATE `bancos` SET fecha_creacion='$lahoraencolombia',`estado`=1 WHERE id_banco='$id_banco' ");
      if($reactivar_banco){$_SESSION['alerta_ok'][]='Banco Reactivado.';}

                    
}/*If isset actualizar*/

/*Eliminar un banco*/
if(isset($_POST['eliminar'])){/*If isset actualizar*/
                  
      $id_banco=$_POST['eliminar'];
      //echo $id_cuenta."<br>";

      $eliminar_banco=$con->query("UPDATE `bancos` SET fecha_creacion='$lahoraencolombia', `estado`=0 WHERE id_banco='$id_banco' ");
      if($eliminar_banco){$_SESSION['alerta_ok'][]='Banco Eliminado.';}              
       
                    
}/*If isset actualizar*/

/*Edicion de Banco*/
if(isset($_POST['editar'])){/*1*/
                            $_SESSION['bancos_id_banco']=$_POST['editar'];

                 echo"<script>window.location.href='bancos.php#".$_SESSION['bancos_id_banco']."';</script>";
                           }/*1*/

/*Editar2*/               
if(isset($_POST['editar2'])){/*1*/

                $id_banco=$_POST['editar2'];
                $nuevonombanco=$_POST['nuevonombanco'];
                //echo $nuevonombanco;

                /*Si hace falta datos saca alerta*/
                if(empty($nuevonombanco)){$_SESSION['alerta'][]='Debes ingresar el nombre del Banco.';}
                
                if(!isset($_SESSION['alerta'])){/*Si ni hay alerta*/
          
                                /*Se ingresa nombre de banco a la base de datos*/
                                $editar_nuevo_banco=$con->query("UPDATE bancos SET nombre_banco='$nuevonombanco' WHERE id_banco='$id_banco'");
          
                                /*Alerta OK*/
                                if($editar_nuevo_banco){/*Si se insertó el banco a base*/
                                     
                                     $_SESSION['alerta_ok'][]='Banco Editado Correctamente.';
                                                                     
                                    
                                    /*Si se adjunto un archivo*/
                                     if($_FILES['nuevo_logo_banco']['size'] > 0){/*Si se adjunto un archivo*/
                                               /*Exceso de tamaño*/
                                               if($_FILES['nuevo_logo_banco']['size'] > 6000000){$_SESSION['alerta'][]="La foto no debe tener un tamaño superior a 6 megas.";}
                                               /*si no hay error*/
                                               if($_FILES['nuevo_logo_banco']['error']){$_SESSION['alerta'][]="La foto tiene un error.";}
                                               /*La foto no es png o jpg*/
                                               if(($_FILES['nuevo_logo_banco']['type']!='image/jpg') and ($_FILES['nuevo_logo_banco']['type']!='image/jpeg') and ($_FILES['nuevo_logo_banco']['type']!='image/png') ){$_SESSION['alerta'][]="La imagen debe ser JPG, JPEG o           PNG.";}
                                               
                                                       
                                                         /*Se crea el Directorio si no existe*/
                                                         if (!file_exists('../_globales/images/'.$_SESSION['nombre_base'].'_bancos/')) {/*Creacion directorio*/
                                                                 mkdir('../_globales/images/'.$_SESSION['nombre_base'].'_bancos/', 0777, true);
                                                         }/*Creacion Directorio*/
                  
                                                         ////////////* SERVIDOR LOCAL*///////////////
                                                         $nombre_foto='../_globales/images/'.$_SESSION['nombre_base'].'_bancos/'.$id_banco .'.png';
                                                         //move_uploaded_file($_FILES['nuevo_logo_banco']['tmp_name'],"$nombre_foto");
                  
                                                         
                                                         /*Se incluye la libreria SimpleImage -> Para transformacion de imagenes*/
                                                         include_once('../_includes-functions/librerias/SimpleImage-master/src/abeautifulsite/SimpleImage.php');
                                                         
                                                         /*Transformamos y guardamos la Imagen*/
                                                         try {/*Try*/
                                                         $img = new abeautifulsite\SimpleImage($_FILES['nuevo_logo_banco']['tmp_name']);
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
                                $_SESSION['bancos_id_banco']='';
                                
                                }/*Si se insertó el banco a base*/
                                
                }/*Si ni hay alerta*/


}/*1*/
               

if(!isset($_SESSION['bancos_id_banco'])){$_SESSION['bancos_id_banco']='';}



?>
<!DOCTYPE html>
<html>
<head>

  <link rel="stylesheet" type="text/css" href="../_globales/styles/resetcss.css">
	<link rel="stylesheet" type="text/css" href="../_includes-functions/styles/barraNavegacion.css">
	<link rel="stylesheet" type="text/css" href="../_includes-functions/styles/footer.css">
	<link rel="stylesheet" type="text/css" href="styles/bancos.css">

	<title>Bancos</title>
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
  
  <!--Esconde y Muestra los Bancos Eliminados-->
  <script> 
  $(document).ready(function(){
  $(".show").click(function(){
  $("#post_div").slideToggle("slow");
  
  });
  });
  </script>

<!--Esconde y Muestra la div de ingresar un nuevo Banco-->
  <script> 
  $(document).ready(function(){
  $(".mostrar").click(function(){
  $("#entrevistas_cuerpo_formularioEntrevistas_paginas").slideToggle("slow");
  
  });
  });
  </script>


</head>
<body>



<div id="entrevistas_cuerpo">
      
		

<?include "../_includes-functions/foreach_alerta.php"; ?>




    
                    

              

<?/*Por Seguridad solo los usuarios con niveles altos pueden ingresar*/
if( ($_SESSION['nivel']=='2') or ($_SESSION['nivel']=='3')){/*SI tiene permisos*/



      
       ////////////////////////////////////
      ////////////ADJUNTAR NUEVO//////////
     ////////////////////////////////////     
echo "<form action='' method='POST' id='entrevistas_cuerpo_formularioEntrevistas'  enctype='multipart/form-data'>";   
            
            echo "<fieldset id='entrevistas_cuerpo_formularioEntrevistas_paginas' style='margin-bottom:100px;'> ";
            
            echo "<h1>Adjuntar Nuevo Banco</h1>";
            echo "<p>En el siguiente campo puedes agregar nuevas instituciones bancarias.</p>";
            
           

            echo "<table id='entrevistas_cuerpo_formularioEntrevistas_paginas_tabla' cellpadding='1' cellspacing='1' width='900' >";
                
                echo "<tr id='banco_nuevo'>";
                echo "<td>Nombre Banco: <input class='allinputs' autocomplete='off' type='text'  style='width:150px;' name='nombre_banco' ></td>";
                echo "<td><label class='input_tipo_archivo'><input type='file' name='logo_banco' style='position:absolute;left:-9999px' />Adjuntar Logo</label></td>";
                echo "<td><button name='nuevo' style='border:0;background:transparent;cursor:pointer;'><img src='../_globales/images/agregarModelo.png' width='18px'></button></td>";
                echo "</tr>";

                echo "</table>";

            echo "</fieldset>";
                
echo"</form>";
      
       ////////////////////////////////////
      /////////////EXISTENTES/////////////
     ////////////////////////////////////     
      
echo "<form action='' method='POST' id='entrevistas_cuerpo_formularioEntrevistas'  enctype='multipart/form-data'>";   
      
      echo "<fieldset id='entrevistas_cuerpo_formularioEntrevistas_paginas' style='margin-bottom:100px;'>";
            
            echo "<h1>Instituciones Bancarias</h1>";
            echo "<p>Aquí se pueden visualizar y editar los bancos que aparecen en la lista de la aplicación Cuentas.</p>";

            echo "<table id='entrevistas_cuerpo_formularioEntrevistas_paginas_tabla' cellpadding='1' cellspacing='1' width='900' >";

                /*Nombres de Bancos Existentes*/
                $conteo_cuentas=0;

                $Bancos=$con->query("SELECT * FROM  bancos WHERE estado='1' ORDER BY fecha_creacion DESC");
                while($row=$Bancos->fetch_assoc()){/*While*/
                
                           if($_SESSION['bancos_id_banco']!=$row['id_banco']){/*NO Editar*/
                                
                                 if (!@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_bancos/'.$row['id_banco'].'.png')) {$image='../_globales/images/no_image2.png';}else{$image="../_globales/images/".$_SESSION['nombre_base'].  "_bancos/".$row['id_banco'].".png";}

                                echo "<tr>";
                                     
                                     echo "<td>Nombre Banco: ".ucwords($row['nombre_banco'])."</td>";
                                     echo "<td><img src=".$image." style='max-width:100px;'></td>";
                                     echo "<td><button name='editar' title='Editar' value='".$row['id_banco']."' style='border:0;background:transparent;cursor:pointer;'><img src='../_globales/images/editicon.png' width='18px'></button></td>";
                                     echo "<td><button name='eliminar' title='Eliminar' value='".$row['id_banco']."' style='border:0;background:transparent;cursor:pointer;'><img src='../_globales/images/wrongiconsmall.png' width='18px'></button></td>";
                                    
                                 echo "</tr>";   

                           }/*NO Editar*/else{/*Editar*/
                                
                                echo "<tr>";
                                     
                                     echo "<td>Nombre Banco: <input class='allinputs' autocomplete='off' type='text'  value='".ucwords($row['nombre_banco'])."' style='width:150px;' name='nuevonombanco' ></td>";
                                     echo "<td><label class='input_tipo_archivo'><input type='file' name='nuevo_logo_banco' style='position:absolute;left:-9999px' />Reemplazar Logo</label></td>";
                                     echo "<td><button name='editar2' title='Editar' value='".$row['id_banco']."' style='border:0;background:transparent;cursor:pointer;'><img src='../_globales/images/goodjobicon2.png' width='18px'></button></td>";
                                                                        
                                     
                                echo "</tr>";  

                           }/*Editar*/
                 

                      $conteo_cuentas++;

                }/*While*/
      
      
            echo "</table>";
      
            if($conteo_cuentas==0){echo "<p style='color:red;'>No existen Bancos Registrados.</p>";}
      
      echo "</fieldset>";
      
echo "</form>";

         
      
      
       /////////////////////////////////
      ////////////ELIMINADOS///////////
     /////////////////////////////////
          echo "<div id='aspirantes_cuerpo_contenedor_verAntiguos' style='margin:30px;' >";
          echo "<button id='button_nice' src='../_globales/images/verantiguos.png' id='aspirantes_cuerpo_verAntiguos' class='show' >Mostrar Bancos Eliminados...</button>";
          echo "</div>";

            echo "<form action='' method='POST' id='entrevistas_cuerpo_formularioEntrevistas'>";
      
            echo "<div id='post_div'><!--ABRE post_div-->";
            
                  echo "<fieldset id='entrevistas_cuerpo_formularioEntrevistas_paginas' style='margin-bottom:100px;'>";
                  
                  echo "<h1>Eliminadas</h1>";
                  echo "<p>Aquí se pueden visualizar Los Bancos ELIMINADOS.</p>";
                  
                  echo "<table id='entrevistas_cuerpo_formularioEntrevistas_paginas_tabla' cellpadding='1' cellspacing='1' width='900' >";
            

            
                       
            
                        /*Nombres de Bancos Existentes*/
                        $conteo_cuentas=0;

                        $Bancos=$con->query("SELECT * FROM  bancos WHERE estado='0' ORDER BY fecha_creacion DESC");
                        while($row=$Bancos->fetch_assoc()){/*While*/
                        
                                     
                                     if (!@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_bancos/'.$row['id_banco'].'.png')) {$image='../_globales/images/no_image2.png';}else{$image="../_globales/images/".$_SESSION['nombre_base'].  "_bancos/".$row['id_banco'].".png";}

                                    echo "<tr>";
                                         
                                         echo "<td>Nombre Banco: ".ucwords($row['nombre_banco'])."</td>";
                                         echo "<td><img src=".$image." style='max-width:100px;'></td>";
                                         echo "<td><button name='activar' title='Eliminar' value='".$row['id_banco']."' style='border:0;background:transparent;cursor:pointer;'><img src='../_globales/images/goodjobicon2.png'></button></td>";
                                        
                                         
                                    echo "</tr>";   

                          

                              $conteo_cuentas++;

                        }/*While*/
            
            
                        echo "</table>";
            
                        if($conteo_cuentas==0){echo "<p style='color:red;'>No existen Bancos eliminados.</p>";}
            
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