<?
include "../_includes-functions/conexion_improved.php";
include "../_includes-functions/seguridad.php"; 
include "../_includes-functions/funciones.php";
include '../_includes-functions/barraNavegacion.php';

/*Si no existe la tabla crearla*/
$crear_tabla=$con->query("CREATE TABLE IF NOT EXISTS cuentas (
                                                              id_cuenta INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                                              fecha_creacion TIMESTAMP,
                                                              id_banco INT(6) NOT NULL,
                                                              id_usuario INT(6) NOT NULL,
                                                              numero_cuenta VARCHAR(100) NOT NULL,
                                                              tipo_cuenta VARCHAR(100) NOT NULL,
                                                              estado INT(6)
                                                              ) 
                                                              ENGINE=MEMORY;");

/*Si no existe $_GET['editar_usuario'] entonces se pone valor 0*/
if(isset($_GET['editar_usuario'])){$editar_usuario=$_GET['editar_usuario'];}else{$editar_usuario=0;}

/*Se verifica que el usuario exista.*/
if(isset($_GET['editar_usuario'])){$usuario_editar=$con->query("SELECT * FROM usuarios WHERE id_usuario='".$editar_usuario."'")->fetch_assoc();
      if(empty($usuario_editar)){$_SESSION['alerta'][]='El usuario que se quiere editar no existe.';}
}
//echo $usuario_editar['id_usuario']."<br>";

/*Por Seguridad solo los usuarios con niveles altos y el usuario mismo pueden ingresar*/
if( ($_SESSION['id_usuario']!=$editar_usuario) and ($_SESSION['nivel']!='2') and ($_SESSION['nivel']!='3')){$_SESSION['alerta'][]='Solo puedes acceder a tu misma información.';}

/*Para anotar una nueva credencial*/
if(isset($_POST['nuevo'])){/*If isset nuevo*/
                  
       $id_banco_n=$_POST['id_banco_n'];
       //echo '$id_banco_n: '.$id_banco_n."<br>";
       
       $id_usuario=$editar_usuario;
       //echo '$id_usuario: '.$id_usuario."<br>";
       
       $tipo_cuenta_n=$_POST['tipo_cuenta_n'];
       //echo '$tipo_cuenta_n: '.$tipo_cuenta_n."<br>";
       
       $numero_cuenta_n=$_POST['numero_cuenta_n'];
       //echo '$numero_cuenta_n: '.$numero_cuenta_n."<br>";
       
       
      /*Si hace falta datos saca alerta*/
      if($id_usuario=='' or $id_usuario=='0'){$_SESSION['alerta'][]='Faltan el usuario que está ingresando la información.';}
       if($id_banco_n=='' or $id_banco_n=='0'){$_SESSION['alerta'][]='Falta el Banco.';}
      if($tipo_cuenta_n=='' or $tipo_cuenta_n=='0'){$_SESSION['alerta'][]='Falta el Tipo de Cuenta.';}
      if($numero_cuenta_n=='' or $numero_cuenta_n=='0'){$_SESSION['alerta'][]='Falta el Numero de Cuenta.';}
     
      
      if(!isset($_SESSION['alerta'])){/*Si ni hay alerta*/
                      $insertar_nueva_credencial=$con->query("INSERT INTO `cuentas`(`id_cuenta`, `fecha_creacion`, `id_banco`, `id_usuario`, `numero_cuenta`, `tipo_cuenta`, `estado`) 
                                                              VALUES (default,'$lahoraencolombia',$id_banco_n,$id_usuario,'$numero_cuenta_n','$tipo_cuenta_n',1)");

                      if($insertar_nueva_credencial){$_SESSION['alerta_ok'][]='Cuenta Ingresada Correctamente.';}

        }/*Si ni hay alerta*/

}/*If isset nuevo*/


if(isset($_POST['reactivar'])){/*If isset actualizar*/
                  
       $id_cuenta=$_POST['reactivar'];
      //echo $id_cuenta."<br>";

      $reactivar_cuenta=$con->query("UPDATE `cuentas` SET fecha_creacion='$lahoraencolombia',`estado`=1 WHERE id_cuenta='$id_cuenta' ");
      if($reactivar_cuenta){$_SESSION['alerta_ok'][]='Credencial Reactivada.';}

                    
}/*If isset actualizar*/


if(isset($_POST['eliminar'])){/*If isset actualizar*/
                  
      $id_cuenta=$_POST['eliminar'];
      //echo $id_cuenta."<br>";

      $eliminar_cuenta=$con->query("UPDATE `cuentas` SET fecha_creacion='$lahoraencolombia', `estado`=0 WHERE id_cuenta='$id_cuenta' ");
      if($eliminar_cuenta){$_SESSION['alerta_ok'][]='Credencial Eliminada.';}              
       
                    
}/*If isset actualizar*/


?>
<!DOCTYPE html>
<html>
<head>

	<link rel="stylesheet" type="text/css" href="../_globales/styles/resetcss.css">
	<link rel="stylesheet" type="text/css" href="../_includes-functions/styles/barraNavegacion.css">
	<link rel="stylesheet" type="text/css" href="../_includes-functions/styles/footer.css">
	<link rel="stylesheet" type="text/css" href="styles/cuentas.css">

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
    
                    

              

<?/*Por Seguridad solo los usuarios con niveles altos y el usuario mismo pueden ingresar*/
if( ($_SESSION['id_usuario']==$editar_usuario) or ($_SESSION['nivel']=='2') or ($_SESSION['nivel']=='3')){/*SI tiene permisos*/



      
      
      
            echo "<fieldset id='entrevistas_cuerpo_formularioEntrevistas_paginas' style='margin-bottom:100px;'>";
            
            echo "<h1>Cuentas Bancarias</h1>";
            echo "<p>Aquí se pueden visualizar las cuentas bancarias donde se pueden hacer los depositos a el modelo.</p>";
            
            echo "<table id='entrevistas_cuerpo_formularioEntrevistas_paginas_tabla' cellpadding='1' cellspacing='1' width='900' >";
      
      
            
            /*Añadir una Credencial*/
            echo "<tr>";
                
                /*Populacion de bancos*/
                echo "<td>";
                echo "<select name='id_banco_n'>";
                echo "<option value='0'>Seleccionar</option>";
                $bancos=$con->query("SELECT * FROM  bancos where estado='1'");
                while($row=$bancos->fetch_assoc()){/*While*/
                       echo "<option value='".$row['id_banco']."'>".ucfirst($row['nombre_banco'])."</option>";
                }/*While*/
                echo "</select>";
                echo "</td>";
                
                echo "<td>";
                echo "<select name='tipo_cuenta_n'>";
                echo "<option value='0'>Seleccionar</option>";
                echo "<option value='1'>Ahorros</option>";
                echo "<option value='2'>Corriente</option>";
                echo "</select>";
                echo "</td>";
              
                echo "<td>Numero: <input class='allinputs' autocomplete='off' type='text' style='width:150px;' name='numero_cuenta_n' ></td>";
                
                echo "<td><button name='nuevo' style='border:0;background:transparent;cursor:pointer;'><img src='../_globales/images/agregarModelo.png'></button></td>";
            
            echo "</tr>";  
      
                 
      
                        $conteo_cuentas=0;
      
                        $credenciales=$con->query("SELECT * FROM  cuentas WHERE id_usuario='".$usuario_editar['id_usuario']."' AND estado='1' ORDER BY fecha_creacion DESC");
                        while($row=$credenciales->fetch_assoc()){/*While*/
                        
                         /*Imagen del Banco*/
                         if (!@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_bancos/'.$row['id_banco'].'.png')) {$image='../_globales/images/no_image2.png';}else{$image="../_globales/images/".$_SESSION['nombre_base'].  "_bancos/".$row['id_banco'].".png";}

                        /*Se designa tipo de cuenta según numero 1 o 2*/
                        if($row['tipo_cuenta']==1){$tipo_cuenta='Ahorros';}
                        elseif ($row['tipo_cuenta']==2) {$tipo_cuenta='Corriente';}
                         
                                    echo "<tr>";
                                         echo "<td><img src=".$image." style='max-width:100px;'></td>";
                                         echo "<td>Tipo: ".$tipo_cuenta."</td>";
                                         echo "<td>Numero: ".$row['numero_cuenta']."</td>";
                                         echo "<td><button name='eliminar' title='Eliminar' value='".$row['id_cuenta']."' style='border:0;background:transparent;cursor:pointer;'><img src='../_globales/images/wrongiconsmall.png'></button></td>";
                                        
                                         
                                    echo "</tr>";   
      
                          
      
                              $conteo_cuentas++;
      
                        }/*While*/
      
      
                  echo "</table>";
      
                  if($conteo_cuentas==0){echo "<p style='color:red;'>No existen credenciales de paginas para este usuario.</p>";}
      
            echo "</fieldset>";
      
            echo "</form>";
          echo "<div id='aspirantes_cuerpo_contenedor_verAntiguos' style='margin:30px;' >";
          echo "<button id='button_nice' src='../_globales/images/verantiguos.png' id='aspirantes_cuerpo_verAntiguos' class='show' >Mostrar Cuentas Eliminadas...</button>";
          echo "</div>";
      
      
      /////////////////////////////////
      ////////////ELIMINADOS//////////
      /////////////////////////////////
      
            echo "<form action='' method='POST' id='entrevistas_cuerpo_formularioEntrevistas'>";
      
            echo "<div id='post_div'><!--ABRE post_div-->";
            
                  echo "<fieldset id='entrevistas_cuerpo_formularioEntrevistas_paginas' style='margin-bottom:100px;'>";
                  
                  echo "<h1>Eliminadas</h1>";
                  echo "<p>Aquí se pueden visualizar las cuentas ELIMINADAS.</p>";
                  
                  echo "<table id='entrevistas_cuerpo_formularioEntrevistas_paginas_tabla' cellpadding='1' cellspacing='1' width='900' >";
            

            
                       
            
                        $conteo_cuentas=0;
      
                        $credenciales=$con->query("SELECT * FROM  cuentas WHERE id_usuario='".$usuario_editar['id_usuario']."' AND estado='0' ORDER BY fecha_creacion DESC");
                        while($row=$credenciales->fetch_assoc()){/*While*/
                        
                        /*Se designa tipo de cuenta según numero 1 o 2*/
                        if($row['tipo_cuenta']==1){$tipo_cuenta='Ahorros';}
                        elseif ($row['tipo_cuenta']==2) {$tipo_cuenta='Corriente';}
                         
                                    echo "<tr>";
                                         echo "<td><img src='../_globales/images/".$_SESSION['nombre_base']."_bancos/".$row['id_banco'].".jpg' style='max-width:100px;'></td>";
                                         echo "<td>Tipo: ".$tipo_cuenta."</td>";
                                         echo "<td>Numero: ".$row['numero_cuenta']."</td>";
                                         echo "<td><button name='reactivar' title='Activar' value='".$row['id_cuenta']."' style='border:0;background:transparent;cursor:pointer;'><img src='../_globales/images/goodjobicon2.png'></button></td>";
                                        
                                         
                                    echo "</tr>";   
      
                          
      
                              $conteo_cuentas++;
      
                        }/*While*/
            
            
                        echo "</table>";
            
                        if($conteo_cuentas==0){echo "<p style='color:red;'>No existen cuentas eliminadas.</p>";}
            
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