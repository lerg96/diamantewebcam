<?
include "../_includes-functions/conexion_improved.php";
include "../_includes-functions/seguridad.php"; 
include "../_includes-functions/funciones.php";
include '../_includes-functions/barraNavegacion.php';

/*Si se pide editar a un usuario, se verifica que el usuario exista.*/
if(isset($_GET['editar_usuario'])){$editar_usuario=$_GET['editar_usuario'];}else{$editar_usuario=0;}

if(isset($_GET['editar_usuario'])){$usuario_editar=$con->query("SELECT * FROM usuarios WHERE id_usuario='".$editar_usuario."'")->fetch_assoc();
      if(empty($usuario_editar)){$_SESSION['alerta'][]='El usuario que se quiere editar no existe.';}
}
//echo $usuario_editar['id_usuario']."<br>";

/*Por Seguridad solo los usuarios con niveles altos y el usuario mismo pueden ingresar*/
if( ($_SESSION['id_usuario']!=$editar_usuario) and ($_SESSION['nivel']!='2') and ($_SESSION['nivel']!='3')){$_SESSION['alerta'][]='Solo puedes acceder a tus mismas credenciales.';}

/*Para anotar una nueva credencial*/
if(isset($_POST['nuevo'])){/*If isset nuevo*/
                  
       $id_usuario=$_POST['id_usuario'];
       //echo $id_usuario."<br>";
       
       $usuario_n=$_POST['usuario_n'];
       //echo $usuario_n."<br>";
       
       $password_n=$_POST['password_n'];
       //echo $password_n."<br>";
       
       $email_n=$_POST['email_n'];
       //echo $email_n."<br>";
       
       $id_pagina_n=$_POST['id_pagina_n'];
       //echo $id_pagina_n."<br>";
       //print_r($_POST);
       //echo $lahoraencolombia;
       
      /*Si hace falta datos saca alerta*/
      if($id_usuario==''){$_SESSION['alerta'][]='Faltan el usuario que está ingresando la información.';}
      if($usuario_n==''){$_SESSION['alerta'][]='Falta el user name.';}
      if($password_n==''){$_SESSION['alerta'][]='Falta el Password.';}
      if($email_n==''){$_SESSION['alerta'][]='Falta el Email de Registro.';}
      if($id_pagina_n==''){$_SESSION['alerta'][]='Falta La Pagina.';}
      
      if(!isset($_SESSION['alerta'])){/*Si ni hay alerta*/
                      $insertar_nueva_credencial=$con->query("INSERT INTO `credenciales`(`id_credencial`, `fecha_creacion`, `id_pagina`, `id_usuario`, `usuario`, `password`, `email_de_registro`) 
                                                VALUES (default,'$lahoraencolombia',$id_pagina_n,$id_usuario,'$usuario_n','$password_n','$email_n')");

                      if($insertar_nueva_credencial){$_SESSION['alerta_ok'][]='Ingresada Correctamente.';}

        }/*Si ni hay alerta*/

}/*If isset nuevo*/


if(isset($_POST['reactivar'])){/*If isset actualizar*/
                  
       $id_credencial=$_POST['reactivar'];
      //echo $id_credencial."<br>";

      $reactivar_credencial=$con->query("UPDATE `credenciales` SET fecha_creacion='$lahoraencolombia',`eliminado`=0 WHERE id_credencial='$id_credencial' ");
      if($reactivar_credencial){$_SESSION['alerta_ok'][]='Credencial Reactivada.';}

                    
}/*If isset actualizar*/


if(isset($_POST['eliminar'])){/*If isset actualizar*/
                  
      $id_credencial=$_POST['eliminar'];
      //echo $id_credencial."<br>";

      $eliminar_credencial=$con->query("UPDATE `credenciales` SET fecha_creacion='$lahoraencolombia', `eliminado`=1 WHERE id_credencial='$id_credencial' ");
      if($eliminar_credencial){$_SESSION['alerta_ok'][]='Credencial Eliminada.';}              
       
                    
}/*If isset actualizar*/


?>
<!DOCTYPE html>
<html>
<head>

	<link rel="stylesheet" type="text/css" href="../_globales/styles/resetcss.css">
	<link rel="stylesheet" type="text/css" href="../_includes-functions/styles/barraNavegacion.css">
	<link rel="stylesheet" type="text/css" href="../_includes-functions/styles/footer.css">
	<link rel="stylesheet" type="text/css" href="styles/credenciales.css">

	<title>Credenciales</title>
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
  
  <script> 
  $(document).ready(function(){
  $(".show").click(function(){
  $("#post_div").slideToggle("slow");
  
  });
  });
  </script>

</head>
<body>



	<div id="entrevistas_cuerpo">
      
		

<?include "../_includes-functions/foreach_alerta.php"; ?>



		<form action="" method='POST' id="entrevistas_cuerpo_formularioEntrevistas"  enctype="multipart/form-data">
    <input type='hidden' name='id_usuario' value='<? echo $usuario_editar['id_usuario']; ?>'>
                    

              

<?/*Por Seguridad solo los usuarios con niveles altos y el usuario mismo pueden ingresar*/
if( ($_SESSION['id_usuario']==$editar_usuario) or ($_SESSION['nivel']=='2') or ($_SESSION['nivel']=='3')){/*SI tiene permisos*/



      
      
      
            echo "<fieldset id='entrevistas_cuerpo_formularioEntrevistas_paginas' style='margin-bottom:100px;'>";
            
            echo "<h1>Credenciales</h1>";
            echo "<p>Aquí se pueden visualizar las credenciales de acceso a cada una de las paginas de tranmisión.</p>";
            
            echo "<table id='entrevistas_cuerpo_formularioEntrevistas_paginas_tabla' cellpadding='1' cellspacing='1' width='900' >";
      
      
            
            /*Añadir una Credencial*/
            echo "<tr>";
                
                /*Populacion de paginas*/
                echo "<td>";
                echo "<select name='id_pagina_n'>";
                $credenciales=$con->query("SELECT * FROM  paginas");
                while($row=$credenciales->fetch_assoc()){/*While*/
                      
                      echo "<option value='".$row['id_pagina']."'>".$row['nombre_pagina']."</option>";
                
                }/*While*/
                echo "</select>";
                echo "</td>";
                echo "<td>Usuario: <input class='allinputs' autocomplete='off' type='text' style='width:150px;' name='usuario_n' ></td>";
                echo "<td>Password: <input class='allinputs' autocomplete='off' type='text' style='width:150px;' name='password_n' ></td>";
                echo "<td>Email: <input class='allinputs' autocomplete='off' type='email' style='width:150px;' name='email_n' ></td>";
                echo "<td><button name='nuevo' style='border:0;background:transparent;cursor:pointer;'><img src='../_globales/images/agregarModelo.png'></button></td>";
            echo "</tr>";  
      
      
            
                  $numero_credenciales=$con->query("SELECT COUNT(id_credencial) AS id_credencial FROM  credenciales WHERE id_usuario='".$usuario_editar['id_usuario']."'")->fetch_assoc();
                  //print_r($numero_credenciales);
                  $numero_credenciales=$numero_credenciales['id_credencial'];
      
                 
      
                        $conteo_credenciales=0;
      
                        $credenciales=$con->query("SELECT * FROM  credenciales WHERE id_usuario='".$usuario_editar['id_usuario']."' AND eliminado='0' ORDER BY fecha_creacion DESC");
                        while($row=$credenciales->fetch_assoc()){/*While*/
                        

                                 if (!@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_paginas/'.$row['id_pagina'].'.png')) {$image='../_globales/images/no_image2.png';}else{$image="../_globales/images/".$_SESSION['nombre_base'].  "_paginas/".$row['id_pagina'].".png";}
      
                                    echo "<tr>";
                                         echo "<td><img src=".$image." style='max-width:100px;'></td>";echo "<td>Usuario: ".$row['usuario']."</td>";
                                         echo "<td>Password: ".$row['password']."</td>";
                                         echo "<td>Email: ".$row['email_de_registro']."</td>";
                                         echo "<td><button name='eliminar' value='".$row['id_credencial']."' style='border:0;background:transparent;cursor:pointer;'><img src='../_globales/images/wrongiconsmall.png'></button></td>";
                                        
                                         
                                    echo "</tr>";   
      
                          
      
                              $conteo_credenciales++;
      
                        }/*While*/
      
      
                  echo "</table>";
      
                  if($conteo_credenciales==0){echo "<p style='color:red;'>No existen credenciales de paginas para este usuario.</p>";}
      
            echo "</fieldset>";
      
            echo "</form>";
          echo "<div id='aspirantes_cuerpo_contenedor_verAntiguos' style='margin:30px;' >";
          echo "<button id='button_nice' src='../_globales/images/verantiguos.png' id='aspirantes_cuerpo_verAntiguos' class='show' >Mostrar Eliminados...</button>";
          echo "</div>";
      
      
      /////////////////////////////////
      ////////////ELIMINADOS//////////
      /////////////////////////////////
      
            echo "<form action='' method='POST' id='entrevistas_cuerpo_formularioEntrevistas'>";
      
            echo "<div id='post_div'><!--ABRE post_div-->";
            
                  echo "<fieldset id='entrevistas_cuerpo_formularioEntrevistas_paginas' style='margin-bottom:100px;'>";
                  
                  echo "<h1>Eliminadas</h1>";
                  echo "<p>Aquí se pueden visualizar las credenciales ELIMINADAS.</p>";
                  
                  echo "<table id='entrevistas_cuerpo_formularioEntrevistas_paginas_tabla' cellpadding='1' cellspacing='1' width='900' >";
            
            
                 
                        $numero_credenciales=$con->query("SELECT COUNT(id_credencial) AS id_credencial FROM  credenciales WHERE id_usuario='".$usuario_editar['id_usuario']."' AND eliminado='1'")->fetch_assoc();
                        //print_r($numero_credenciales);
                        $numero_credenciales=$numero_credenciales['id_credencial'];
            
                       
            
                              $conteo_credenciales=0;
            
                              $credenciales=$con->query("SELECT * FROM  credenciales WHERE id_usuario='".$usuario_editar['id_usuario']."' AND eliminado='1' ORDER BY fecha_creacion DESC");
                              while($row=$credenciales->fetch_assoc()){/*While*/
            
                              if (!@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_paginas/'.$row['id_pagina'].'.png')) {$image='../_globales/images/no_image2.png';}else{$image="../_globales/images/".$_SESSION['nombre_base'].  "_paginas/".$row['id_pagina'].".png";}
                              
                                          echo "<tr>";
                                               echo "<td><img src=".$image." style='max-width:100px;'></td>";
                                               echo "<td>Usuario: ".$row['usuario']."</td>";
                                               echo "<td>Password: ".$row['password']."</td>";
                                               echo "<td>Email: ".$row['email_de_registro']."</td>";
                                               echo "<td><button name='reactivar' value='".$row['id_credencial']."' style='border:0;background:transparent;cursor:pointer;'><img src='../_globales/images/goodjobicon2.png'></button></td>";
                                              
                                               
                                          echo "</tr>";   
            
                                
            
                                    $conteo_credenciales++;
            
                              }/*While*/
            
            
                        echo "</table>";
            
                        if($conteo_credenciales==0){echo "<p style='color:red;'>No existen credenciales eliminadas.</p>";}
            
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