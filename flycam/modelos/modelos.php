
<?
include "../_includes-functions/conexion_improved.php";
include "../_includes-functions/seguridad.php";
include "../_includes-functions/funciones.php";

/*Estados de Usuario*/
/*
0 = Bolsa de Apirantes = Ingresado a la bolsa.
1 = Activado = Fue Activado.
2 = Desactivado = Fue Activado pero Eliminado.
3 = Rechazado = No Fue Activado y Fue Eliminado.
4 = Pausados = Fue Activado pero pausado temporalmente
*/

if(isset($_POST['modalidad'])){/*Activar Usuario*/
                           $_SESSION['modelos_estudio']=$_POST['modalidad'];
}/*Activar Usuario*/

if(isset($_POST['retornar'])){/*Retornar Usuario*/
							$id_usuario_reserva=$_POST['retornar'];
							$actualizar=$con->query("UPDATE usuarios_solicitudes SET estado='0' WHERE id_usuario_reserva='$id_usuario_reserva' ");
							if($actualizar){$_SESSION['alerta_ok'][]="Usuario Retornado correctamente.";}
}/*Retornar Usuario*/

if(isset($_POST['pausar'])){/*Pausar Usuario*/
							
							$id_usuario=$_POST['pausar'];
							$actualizar=$con->query("UPDATE usuarios SET estado=4, id_estudio=".$_SESSION['modelos_estudio']." WHERE id_usuario='$id_usuario' ");
							if($actualizar){$_SESSION['alerta_ok'][]="Usuario Pausado correctamente.";}
}/*Pausar Usuario*/

if(isset($_POST['desactivar'])){/*DES Activar Usuario*/
							
							$id_usuario=$_POST['desactivar'];
							$actualizar=$con->query("UPDATE usuarios SET estado=2, id_estudio=".$_SESSION['modelos_estudio']." WHERE id_usuario='$id_usuario' ");
							if($actualizar){$_SESSION['alerta_ok'][]="Usuario Desactivado correctamente.";}
}/*DES Activar Usuario*/

if(isset($_POST['rechazar'])){/*Rechazar Usuario*/
							
							$id_usuario=$_POST['rechazar'];
							$actualizar=$con->query("UPDATE usuarios SET estado=3, id_estudio=".$_SESSION['modelos_estudio']." WHERE id_usuario='$id_usuario' ");
							if($actualizar){$_SESSION['alerta_ok'][]="Usuario Rechazado correctamente.";}
}/*Rechazar Usuario*/

if(isset($_POST['reactivar'])){/*RE Activar Usuario*/
							
							$id_usuario=$_POST['reactivar'];
							$actualizar=$con->query("UPDATE usuarios SET estado=1 WHERE id_usuario='$id_usuario' ");
							if($actualizar){$_SESSION['alerta_ok'][]="Usuario Cambiado de estudio correctamente.";}
}/*RE Activar Usuario*/

/*Cambio de estudio de un usuario*/
if(isset($_POST['datos_nuevo_estudio'])){/*Nuevo_estudio*/
							$datos=array();
							$datos=explode('|',$_POST['datos_nuevo_estudio']);
							//print_r($datos);
							$id_estudio=$datos[0];
							$id_usuario=$datos[1];
							$actualizar=$con->query("UPDATE usuarios SET id_estudio=$id_estudio WHERE id_usuario='$id_usuario' ");
							if($actualizar){$_SESSION['alerta_ok'][]="Usuario cambió de estudio correctamente.";}
}/*Nuevo_estudio*/


if(isset($_POST['mascara_modelo'])){/*Se enmascara de modelo a el lider*/
							
							/*Id del modelo a convertirse*/							
							$id_usuario=$_POST['mascara_modelo'];
							
							/*Consulta datos del modelo*/
							$datos_modelo=$con->query("SELECT * FROM usuarios WHERE id_usuario='".$id_usuario."'")->fetch_assoc();

							/*Se remplaza*/
							if($datos_modelo){/*Cambio de sessiones de lider a modelo*/
								
								if(!empty($datos_modelo['id_usuario'])){/*Si hay data del modelo*/
											
											/*Session que permite volver como lider*/
											$_SESSION['general_id_lider_before']=$_SESSION['id_usuario'];
											//echo '$_SESSION[\'general_id_lider_before\'] '.$_SESSION['general_id_lider_before'];

											/*Reestablece las sessiones del Lider*/
											$_SESSION['nombre']=$datos_modelo['nombres'];
											//echo '$_SESSION[\'nombre\'] '.$_SESSION['nombre'];

											$_SESSION['usuario']=$datos_modelo['usuario'];
											//echo '$_SESSION[\'usuario\'] '.$_SESSION['usuario'];
											
											$_SESSION['nivel']=$datos_modelo['nivel'];
											//echo '$_SESSION[\'nivel\'] '.$_SESSION['nivel'];
											
											$_SESSION['id_usuario']=$datos_modelo['id_usuario'];
											//echo '$_SESSION[\'id_usuario\'] '.$_SESSION['id_usuario'];

											/*redireccionamos al log in*/
											echo"<script> window.location.href='../ventas/ventas.php';</script>";
			
								}/*Si hay data del modelo*/
							
							}/*Cambio de sessiones de lider a modelo*/

}/*Se enmascara de modelo a el lider*/







if(!isset($_SESSION['modelos_estudio'])){$_SESSION['modelos_estudio']='0';}
//echo $_SESSION['modelos_estudio'];
//var_dump($_SESSION['modelos_estudio']);
?>
<!DOCTYPE html>
<html>
<head>

	<link rel="stylesheet" type="text/css" href="../_globales/styles/resetcss.css">
	<link rel="stylesheet" type="text/css" href="../_includes-functions/styles/barraNavegacion.css">
	<link rel="stylesheet" type="text/css" href="../_includes-functions/styles/footer.css">
	<link rel="stylesheet" type="text/css" href="styles/modelos.css">

	<title> Modelos </title>

	<style>
		.hide
		{
			display:none;
		}
.myButton {
	-moz-box-shadow: 0px 10px 14px -7px #949494;
	-webkit-box-shadow: 0px 10px 14px -7px #949494;
	box-shadow: 0px 10px 14px -7px #949494;
	background-color:transparent;
	-moz-border-radius:10px;
	-webkit-border-radius:10px;
	border-radius:8px;
	border:2px solid #b3afb3;
	display:inline-block;
	cursor:pointer;
	color:#1d1c1d;
	font-family: HelveticaNeueLTStd-Lt;
	font-size:14px;
	width: 500px;
	height: 60px;
	margin: 10px;
	text-decoration:none;
	text-shadow:0px 1px 0px #999999;
}
.myButton:hover {
	background-color:transparent;
}
.myButton:active {
	position:relative;
	top:1px;
}




	</style>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

	<script> 
		$(document).ready(function(){
			$("#div11").click(function(){
				$("#div1").show("slow");
				$("#div2").hide("slow");
				$("#div3").hide("slow");
				$("#div4").hide("slow");

				$("#div11").hide("slow");
				$("#div22").show("slow");
				$("#div33").show("slow");
				$("#div44").show("slow");
				
			});
		});
	</script>

	<script> 
		$(document).ready(function(){
			$("#div22").click(function(){
				$("#div1").hide("slow");
				$("#div2").show("slow");
				$("#div3").hide("slow");
				$("#div4").hide("slow");

				$("#div11").show("slow");
				$("#div22").hide("slow");
				$("#div33").show("slow");
				$("#div44").show("slow");
				
			});
		});
	</script>

	<script> 
		$(document).ready(function(){
			$("#div33").click(function(){
				$("#div1").hide("slow");
				$("#div2").hide("slow");
				$("#div3").show("slow");
				$("#div4").hide("slow");

				$("#div11").show("slow");
				$("#div22").show("slow");
				$("#div33").hide("slow");
				$("#div44").show("slow");
				
			});
		});
	</script>

	<script> 
		$(document).ready(function(){
			$("#div44").click(function(){
				$("#div1").hide("slow");
				$("#div2").hide("slow");
				$("#div3").hide("slow");
				$("#div4").show("slow");

				$("#div11").show("slow");
				$("#div22").show("slow");
				$("#div33").show("slow");
				$("#div44").hide("slow");
				
			});
		});
	</script>

</head>
<body>

	<?
	include '../_includes-functions/barraNavegacion.php';
	include "../_includes-functions/foreach_alerta.php"; 
	
////////////////////////////////////////////
///////////////ESTUDIOS////////////////////
//////////////////////////////////////////

	?>

	<div id="modelos_cuerpo">

		<img id="modelos_cuerpo_modelosIcono" src="../_globales/images/modelosicono.png"><h1 style="display: inline;">Modelos</h1>
		<form id="modelos_cuerpo_formulario1" action='' method='POST'>
			<select name='modalidad' style='width:150px;' onchange="this.form.submit()">
				
				
				<?

				if($_SESSION['modelos_estudio']!='0'){/*Modelos Estudio*/
				/*Nombre de estudio actual*/
				$nombre_estudio=$con->query("SELECT * FROM estudios WHERE id_estudio='".$_SESSION['modelos_estudio']."' ")->fetch_assoc();
				$nombre_estudio=$nombre_estudio['nombre_estudio'];
				//echo $nombre_estudio;
					echo "<option value='".$_SESSION['modelos_estudio']."'>".ucfirst($nombre_estudio)."</option>";
				}/*Modelos Estudio*/else{
					echo "<option value='0'>Seleccione Estudio</option>";
				}

				/*Populacion de los selects con todos los estudios*/
				$popu_estudios=$con->query("SELECT * from estudios WHERE NOT (id_estudio='".$_SESSION['modelos_estudio']."') ");
				while ($row=$popu_estudios->fetch_assoc()) {/*While*/
							echo "<option value='".$row['id_estudio']."'>".ucfirst($row['nombre_estudio'])."</option>";
				}/*While*/

				?>
				
			</select>
		</form>
		<br>
		<p id="modelos_cuerpo_primerParrafo">En esta sección podrá encontrar las modelos clasificadas en 3 categorias: Por activar, Activas e Inactivas.</p><br>

		
<?
if($_SESSION['modelos_estudio']!='0'){/*Si no se ha seleccionado un estudio*/
?>

<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

			<!--////////////////////////////////////////////
			/////////MODELOS POR ACTIVAR///////////////
			//////////////////////////////////////////-->
			
			<div id="modelos_cuerpo_contenedor_verInactivos" >
						<button id='div11' class="myButton">Ver Por Activar...</button>
						
			</div>
					
					
			
				<div id='div1' class='hide'> <!--ABRE post_div-->
			
					<h1 style="display:inline;margin-left:40px;font-size:25px;">- Por Activar</h1>
					<p>Las siguientes modelos estan reservadas solo por las siguientes 24 horas de la solicitud.</p>
			
					<table style="text-align: center ;width: 100%; padding-right: 20px; border:0px;" cellspacing="0" cellpadding="0" border="1" >
			
						<form action='' method='POST' id="modelos_cuerpo_formulario2">
			
			<?
			$conteo=1;
						$select_bolsa=$con->query("SELECT usuarios.*,usuarios_solicitudes.fecha_creacion,usuarios_solicitudes.id_usuario_reserva FROM usuarios 
													INNER JOIN usuarios_solicitudes ON (usuarios.id_usuario=usuarios_solicitudes.id_usuario) 
													WHERE usuarios.estado='0' 
													AND usuarios_solicitudes.fecha_creacion > DATE_SUB(NOW(), INTERVAL 24 HOUR)
													AND usuarios_solicitudes.estado='1' 
													AND usuarios_solicitudes.id_lider=".$_SESSION['id_usuario']." 
													GROUP BY usuarios.id_usuario 
													ORDER BY usuarios_solicitudes.fecha_creacion DESC");
			while($row=$select_bolsa->fetch_assoc()){/****************************************************************************While**********************************************************************************************/
			        $nombres=explode(' ',$row['nombres']);
			        $apellidos=explode(' ',$row['apellidos']);
			        $edad=floor((time() - strtotime($row['fecha_de_nacimiento'])) / 31556926);
			        
			        /*Se verifica la disponibilidad de las imagenes y se muestra la más propicia*/
        			if (@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_fotos_perfil/'.$row['id_usuario'].'.jpg')) {$image="../_globales/images/".$_SESSION['nombre_base']."_fotos_perfil/".$row['id_usuario'].".jpg";}
        			elseif (@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_cedulas_mano/'.$row['id_usuario'].'.jpg')) {$image="../_globales/images/".$_SESSION['nombre_base']."_cedulas_mano/".$row['id_usuario'].".jpg";}
        			else{$image='../_globales/images/no_image.png';}
			        
			
						/*Fecha Ultima Reserva*/
						$fecha_ultima_reserva=$row['fecha_creacion'];
			
						/*Diferencia en minutos*/
						$diferencia_ultima_reserva=fechas_mediano_y_largo_tareas($fecha_ultima_reserva);
			
						
					
							echo "<tr>";
							echo "<td><number>$conteo.</number></td>";
							echo "<td><img class='img' src='$image' style='width: 120px;'></td>";
							echo "<td><span class='span'>".$nombres['0']." ".$apellidos['0']." (".$row['usuario'].") </span></td>";
							//echo "<td><img class='img' src='../_globales/images/whatsappicon.png'></td>";
							//echo "<td><p class='p'>".$row['celular']."</p></td>";
							echo "<td><span class='span'>|</span></td>";
							echo "<td><p class='p' id='p'>".$row['ciudad']."</p></td>";
							echo "<td><span class='span'>|</span></td>";
							echo "<td><img class='img' src='../_globales/images/iconoreloj.png'> <p class='p' id='p'> 8 am-12 pm</p></td>";
							echo "<td><p style='color:#062C96;'><img style='vetical-align:middle' src='../_globales/images/stopwatch.png'> $diferencia_ultima_reserva</p></td>";
							echo "<td><button id='modelos_cuerpo_formulario2_activar' class='input' type='button' title='Activar Usuario' onClick=\"window.location='../usuario/activar.php?usuario=".$row['usuario']."'\" name='ingresar'>Activar</button></td>";
							echo "<td><button type='submit' value='".$row['id_usuario_reserva']."' name='retornar' title='Retornar a Bolsa' style='border-style:none;background:none;color:#FFF;cursor:pointer;padding: 0px 1px 0px 1px;'><img type='image' src='../_globales/images/iconoretornar.png' 			id='modelos_cuerpo_formulario2_retornar'></button></td>";
							/*Se eliminó este boton, ya que cuando se recghazaba un usuario este no podia ser recibido nuevamente, se estaba haciendo un mal uso de este boton.*/
							//echo "<td><button type='submit' value='".$row['id_usuario']."' title='Rechazar Usuario' name='rechazar' style='border-style:none;background:none;color:#FFF;cursor:pointer;padding: 0px 1px 0px 1px;'><img type='image' src='../_globales/images/iconodesactivar.png'";
							echo "</tr>";
							echo "<tr>";
							echo "<td colspan='20'>";
							echo "<img src='../_globales/images/separador.png'>";
							echo "</td>";
							echo "</tr>";
					        $conteo++;
			
			
			}/****************************************************************************While**********************************************************************************************/
			?>
			
						</form>
			
					</table>
			<?
			if($conteo==1){echo "<div style='width:99%;text-align:center;'><span style='color:red;font-family:verdana;font-size:larger;'>No existen Modelos por Activar.</span></div>";}
			?>
			</div>
			
<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->			
			<!--////////////////////////////////////////////
			////////////MODELOS ACTIVOS////////////////////
			//////////////////////////////////////////-->
			
					<div id="modelos_cuerpo_contenedor_verInactivos" >
						<button id='div22' class="myButton">Ver Activos...</button>
						
					</div>




			<div id='div2' class='hide'> <!--ABRE post_div-->
			
				<h1 style="display:inline;margin-left:40px;font-size:25px;">- Activos</h1>
					
						
								
								<table style="text-align: center ;width: 100%; padding-right: 20px; border:0px;" cellspacing="0" cellpadding="0" border="1" >
			
						
			
			<?
			/*Creacion de Array con estudios*/
			$estudios=array();
			$select_bolsa=$con->query("SELECT * FROM estudios");
			while($row=$select_bolsa->fetch_assoc()){/*While*/
						$estudios[$row['id_estudio']]=$row['nombre_estudio'];
			}/*While*/
			//print_r($estudios);
			

			$conteo=1;

						$select_bolsa=$con->query("SELECT usuarios.*,estudios.* FROM usuarios 
													INNER JOIN estudios ON (usuarios.id_estudio=estudios.id_estudio) 
													WHERE usuarios.estado='1'  
													AND estudios.id_estudio=".$_SESSION['modelos_estudio']."
													ORDER BY usuarios.id_usuario DESC
													");
			while($row=$select_bolsa->fetch_assoc()){/****************************************************************************While**********************************************************************************************/
			        $nombres=explode(' ',$row['nombres']);
			        $apellidos=explode(' ',$row['apellidos']);
			        $edad=floor((time() - strtotime($row['fecha_de_nacimiento'])) / 31556926);
			        
			/*Se verifica la disponibilidad de las imagenes y se muestra la más propicia*/
        	if (@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_fotos_perfil/'.$row['id_usuario'].'.jpg')) {$image="../_globales/images/".$_SESSION['nombre_base']."_fotos_perfil/".$row['id_usuario'].".jpg";}
       		elseif (@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_cedulas_mano/'.$row['id_usuario'].'.jpg')) {$image="../_globales/images/".$_SESSION['nombre_base']."_cedulas_mano/".$row['id_usuario'].".jpg";}
        	else{$image='../_globales/images/no_image.png';}
			        
			        
						echo "<tr>";
						echo "<td><number>$conteo.</number></td>";
						echo "<td><img class='img' src='$image' style='width: 120px;'></td>";
						echo "<td><a href='../entrevistas/entrevistas.php?editar_usuario=".$row['id_usuario']."' style='text-decoration:none;'><span class='span'>".$nombres['0']." ".$apellidos['0']." (".$row['usuario'].")</span></a></td>";
						echo "<td>";
						
						/*Lista de Estudios*/
						echo "<form action='' method='POST'>";
						echo '<select name="datos_nuevo_estudio" onchange="this.form.submit();">';
						echo "<option value='".$row['id_estudio']."|".$row['id_usuario']."'>".$row['nombre_estudio']."</option>";
						foreach ($estudios as $id_estudio => $estudio) {/*Foreach*/
									echo "<option value='$id_estudio|".$row['id_usuario']."'>$estudio</option>";
						}/*Foreach*/

						echo "</select>";
						echo "</form>";
    					echo "</td>";
						echo "<td><span class='span'>|</span></td>";
						echo "<td><img class='img' src='../_globales/images/whatsappicon.png'></td>";
						echo "<td><p class='p'>".$row['celular']."</p></td>";
						echo "<td><span class='span'>|</span></td>";
						echo "<td><p class='p' id='p'>".$row['ciudad']."</p></td>";
						echo "<td><span class='span'>|</span></td>";
						echo "<td><img class='img' src='../_globales/images/iconoreloj.png'> <p class='p' id='p'> 8 am-12 pm</p></td>";
						echo "<td></td>";
						
						
						echo "<form action='' method='POST'>";
						echo "<td>";
						echo "<button id='modelos_cuerpo_formulario2_ingresar' title='Ingresar Como Modelo' class='input' name='mascara_modelo' value='".$row['id_usuario']."' type='submit' >Ingresar</button>";
						echo "</td>";
						//echo "<td><a href='../entrevistas/entrevistas.php?id_usuario=".$row['id_usuario']."'><img src='../_globales/images/iconoperfil.png'></a></td>";
						echo "<td><button type='submit' value='".$row['id_usuario']."' name='pausar' title='Pausar Usuario'  style='border-style:none;background:none;color:#FFF;cursor:pointer;padding: 0px 1px 0px 1px;'><img type='image' src='../_globales/images/pause.png' width='22px;' id='modelos_cuerpo_formulario2_desactivar'></button>";
						echo"</td>";
						echo "<td><button type='submit' value='".$row['id_usuario']."' name='desactivar' title='Inactivar Usuario'  style='border-style:none;background:none;color:#FFF;cursor:pointer;padding: 0px 1px 0px 1px;'><img type='image' src='../_globales/images/iconodesactivar.png' id='modelos_cuerpo_formulario2_desactivar'></button>";
						echo"</td>";
						echo "</form>";
						
						echo "</tr>";
						echo "<tr>";
						echo "<td colspan='20'>";
						echo "<img src='../_globales/images/separador.png'>";
						echo "</td>";
						echo "</tr>";
			
			
			        $conteo++;
			}/****************************************************************************While**********************************************************************************************/
			?>
							
			
			
			
						
			
					</table>

					
			<?
			if($conteo==1){echo "<div style='width:99%;text-align:center;'><span style='color:red;font-family:verdana;font-size:larger;'>No existen Activos.</span></div>";}
			?>	

						
			</div><!--Cierra post_div-->

<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

			<!--////////////////////////////////////////////
			////////MODELOS Pausados////////////////////
			//////////////////////////////////////////-->
			
					<div id="modelos_cuerpo_contenedor_verInactivos" >
						<button id='div33' class="myButton">Ver Pausados...</button>
					</div>




			<div id='div3' class='hide'> <!--ABRE post_div-->
			
				<h1 style="display:inline;margin-left:40px;font-size:25px;">- Pausados</h1>
					
						
								
								<table style="text-align: center ;width: 100%; padding-right: 20px; border:0px;" cellspacing="0" cellpadding="0" border="1" >
			
						
			
			<?
			/*Creacion de Array con estudios*/
			$estudios=array();
			$select_bolsa=$con->query("SELECT * FROM estudios");
			while($row=$select_bolsa->fetch_assoc()){/*While*/
						$estudios[$row['id_estudio']]=$row['nombre_estudio'];
			}/*While*/
			//print_r($estudios);
			

			$conteo=1;

						$select_bolsa=$con->query("SELECT usuarios.*,estudios.* FROM usuarios 
													INNER JOIN estudios ON (usuarios.id_estudio=estudios.id_estudio) 
													WHERE usuarios.estado='4'  
													AND estudios.id_estudio=".$_SESSION['modelos_estudio']."
													ORDER BY usuarios.id_usuario DESC
													");
			while($row=$select_bolsa->fetch_assoc()){/****************************************************************************While**********************************************************************************************/
			        $nombres=explode(' ',$row['nombres']);
			        $apellidos=explode(' ',$row['apellidos']);
			        $edad=floor((time() - strtotime($row['fecha_de_nacimiento'])) / 31556926);
			       
			            /*Se verifica la disponibilidad de las imagenes y se muestra la más propicia*/
        				if (@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_fotos_perfil/'.$row['id_usuario'].'.jpg')) {$image="../_globales/images/".$_SESSION['nombre_base']."_fotos_perfil/".$row['id_usuario'].".jpg";}
        				elseif (@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_cedulas_mano/'.$row['id_usuario'].'.jpg')) {$image="../_globales/images/".$_SESSION['nombre_base']."_cedulas_mano/".$row['id_usuario'].".jpg";}
        				else{$image='../_globales/images/no_image.png';}

			        
						echo "<tr>";
						echo "<td><number>$conteo.</number></td>";
						echo "<td><img class='img' src='$image' style='width: 120px;'></td>";
						echo "<td><a href='../entrevistas/entrevistas.php?editar_usuario=".$row['id_usuario']."' style='text-decoration:none;'><span class='span'>".$nombres['0']." ".$apellidos['0']." (".$row['usuario'].")</span></a></td>";
						echo "<td><span class='span'>|</span></td>";
						echo "<td><img class='img' src='../_globales/images/whatsappicon.png'></td>";
						echo "<td><p class='p'>".$row['celular']."</p></td>";
						echo "<td><span class='span'>|</span></td>";
						echo "<td><p class='p' id='p'>".$row['ciudad']."</p></td>";
						echo "<td><span class='span'>|</span></td>";
						echo "<td><img class='img' src='../_globales/images/iconoreloj.png'> <p class='p' id='p'> 8 am-12 pm</p></td>";
						echo "<td></td>";
						
						echo "<form action='' method='POST'>";
						echo "<td><button type='submit' value='".$row['id_usuario']."' name='reactivar' title='reactivar'  style='border-style:none;background:none;color:#FFF;cursor:pointer;padding: 0px 1px 0px 1px;'><img type='image' src='../_globales/images/play.png' id='modelos_cuerpo_formulario2_desactivar' width='22px'></button>";
						echo"</td>";
						echo "</form>";
						
						echo "</tr>";
						echo "<tr>";
						echo "<td colspan='20'>";
						echo "<img src='../_globales/images/separador.png'>";
						echo "</td>";
						echo "</tr>";
			
			
			        $conteo++;
			}/****************************************************************************While**********************************************************************************************/
			?>
							
			
			
			
						
			
					</table>

					
			<?
			if($conteo==1){echo "<div style='width:99%;text-align:center;'><span style='color:red;font-family:verdana;font-size:larger;'>No existen Pausados.</span></div>";}
			?>	

						
			</div><!--Cierra post_div-->
<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
			
			<!--////////////////////////////////////////////
			///////////MODELOS INACTIVOS///////////////
			//////////////////////////////////////////-->
			
					<div id="modelos_cuerpo_contenedor_verInactivos" >
						<button id='div44' class="myButton">Ver Inactivos...</button>
						
					</div>

			
					<div id='div4' class='hide'> <!--ABRE post_div-->
			
			<h1 style="display:inline;margin-left:40px;font-size:25px;">- Inactivos</h1>	
			
						<table style="text-align: center ;width: 100%; padding-right: 20px; border:0px;" cellspacing="0" cellpadding="0" border="1" >
			
							<form action='' method='POST' id="modelos_cuerpo_formulario2">
			
						
			<?
			
			$conteo=1;
						$select_bolsa=$con->query("
													SELECT usuarios.* FROM usuarios 
													INNER JOIN estudios ON (usuarios.id_estudio=estudios.id_estudio) 
													WHERE usuarios.estado='2'  
													AND estudios.id_estudio=".$_SESSION['modelos_estudio']."
													ORDER BY usuarios.id_usuario DESC
			
													
													");
			while($row=$select_bolsa->fetch_assoc()){/****************************************************************************While**********************************************************************************************/
			        $nombres=explode(' ',$row['nombres']);
			        $apellidos=explode(' ',$row['apellidos']);
			        $edad=floor((time() - strtotime($row['fecha_de_nacimiento'])) / 31556926);
			        
			        /*Se verifica la disponibilidad de las imagenes y se muestra la más propicia*/
        			if (@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_fotos_perfil/'.$row['id_usuario'].'.jpg')) {$image="../_globales/images/".$_SESSION['nombre_base']."_fotos_perfil/".$row['id_usuario'].".jpg";}
        			elseif (@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_cedulas_mano/'.$row['id_usuario'].'.jpg')) {$image="../_globales/images/".$_SESSION['nombre_base']."_cedulas_mano/".$row['id_usuario'].".jpg";}
        			else{$image='../_globales/images/no_image.png';}
			        
						echo "<tr>";
						echo "<td><number>$conteo.</number></td>";
						echo "<td><img class='img' src='$image' style='width: 120px;'></td>";
						echo "<td><span class='span'>".$nombres['0']." ".$apellidos['0']." (".$row['usuario'].")</span></td>";
						
						echo "<td><p class='p'><img class='img' src='../_globales/images/whatsappicon.png'> ".$row['celular']."</p></td>";
						echo "<td><span class='span'>|</span></td>";
						echo "<td><p class='p' id='p'>".$row['ciudad']."</p></td>";
						echo "<td><span class='span'>|</span></td>";
						echo "<td><img class='img' src='../_globales/images/iconoreloj.png'> <p class='p' id='p'> 8 am-12 pm</p></td>";
						ECHO "<td></td>";
						echo "<td><button id='modelos_cuerpo_formulario2_reActivar' title='Reactivar Usuario' value='".$row['id_usuario']."' name='reactivar' class='input' type='submit' >Re activar</button></td>";
			
						echo "</tr>";
						echo "<tr>";
						echo "<td colspan='20'>";
						echo "<img src='../_globales/images/separador.png'>";
						echo "</td>";
						echo "</tr>";
			
			
			        $conteo++;
			}/****************************************************************************While**********************************************************************************************/
			?>
			
			
							</form>
			
						</table>
			
			<?
			if($conteo==1){echo "<div style='width:99%;text-align:center;'><span style='color:red;font-family:verdana;font-size:larger;'>No existen inactivos.</span></div>";}
			?>			
					</div> <!--CIERRA post_div-->
			


<?
}/*Si no se ha seleccionado un estudio*/
?>
	</div>


</body>
</html>