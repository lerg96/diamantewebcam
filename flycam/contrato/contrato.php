<? 
include "../_includes-functions/conexion_improved.php";
include "../_includes-functions/seguridad.php"; 
include "../_includes-functions/funciones.php";
include '../_includes-functions/barraNavegacion.php'; 

if(isset($_POST['enviar_firma_contrato'])){/*Envio de contrato*/
											
											if(empty($_POST['nombre_firma'])){/*Si el nombre está vacio*/
																			$_SESSION['alerta'][]='debe ingresar su nombre para firmar el contrato.';
																			}/*Si el nombre está vacio*/

											if(empty($_SESSION['id_usuario'])){/*Si el nombre está vacio*/
																			$_SESSION['alerta'][]='No existe un id de usuario.';
																			}/*Si el nombre está vacio*/
											
											if(!isset($_SESSION['alerta'])){/*Si no hay alerta*/
																			
																			/*Consulta*/
																			$firma_contrato=$con->query("INSERT INTO contratos (id_contrato,fecha_creacion,id_usuario,nombre_firma) VALUES (default,'$lafechaencolombia',".$_SESSION['id_usuario'].",'".ucwords($_POST['nombre_firma'])."') ");
																			
																			/*Si se firmó el contrato*/
																			if($firma_contrato){$_SESSION['alerta_ok'][]='Contrato firmado correctamente.';}
											}/*Si no hay alerta*/

											
}/*Envio de contrato*/
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>

<link rel="stylesheet" type="text/css" href="../_globales/styles/resetcss.css">
	<link rel="stylesheet" type="text/css" href="styles/contrato.css">
	<link rel="stylesheet" type="text/css" href="../_includes-functions/styles/barraNavegacion.css">
	<link rel="stylesheet" type="text/css" href="../_includes-functions/styles/footer.css">

</head>
<body>

	<div id="contrato_cuerpo">

    <?
    include "../_includes-functions/foreach_alerta.php"; 
    ?>


    			<h1><img style="margin-right:15px;" src="../_globales/images/contratoiconorojo.png">Normas y acuerdo laboral del modelo</h1>
			<p id="contrato_cuerpo_parrafoIntroductorio" >Antes de comenzar a utilizar el Marilyn deberá aceptar los terminos y condiciones laborales de nuestro estudio. En caso de no estar de acuerdo con la normatividad establecidad por favor comunicarlo a la persona encargada.</p>

			<?
			include "../contrato/contrato_texto.php";
			?>
			

			<!--<div id="ventanaModal_contrato_contenedorCheckbox" ><input type="checkbox" name=""><label>Acepto los terminos y condiciones para modelos</label></div>-->


			


			<?
			/*Se verifica la firma del cotrato*/
          	$firma_contrato=$con->query("SELECT * FROM contratos WHERE id_usuario = ".$_SESSION['id_usuario']."")->fetch_assoc();
          	if( empty($firma_contrato) ){/*No se ha firmado el contrato*/
          		          		
          		echo "<form action='' method='POST'>";
          		echo "<div style='margin-top:25px;' id='ventanaModal_contrato_contenedorFirma'>";
					echo "<label>Firma Digital:</label><br>";
					echo "<input type='text' name='nombre_firma'  placeholder='Escriba su nombre aquí''>";
				echo "</div>";

          		/*Si el contrato no se ha firmado hay un boton que permite firmarlo*/
          		echo "<input class='bigcta' type='submit' name='enviar_firma_contrato' value='Acepto los terminos laborales' style='width:374px;'>";
          		echo "</form>";

          	}/*No se ha firmado el contrato*/else{/*Si se firmo el contrato*/
          		
          		echo "<div style='margin-top:25px;' id='ventanaModal_contrato_contenedorFirma'>";
					echo "<label>Firma Digital:</label><br>";
					echo "<input type='text' name='' value='".$firma_contrato['nombre_firma']."' readonly placeholder='Escriba su nombre aquí'>";
				echo "</div>";

          	}/*Si se firmo el contrato*/
          		
          	?>

			
			

		</div>

		

	

	<?php include '../_includes-functions/footer.php';?>

</body>
</html>