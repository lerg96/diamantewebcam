<?

include "../_includes-functions/conexion_improved.php";
include "../_includes-functions/seguridad.php"; 
include "../_includes-functions/funciones.php";
include '../_includes-functions/barraNavegacion.php';

/*A todos los que no han puesto sus ventas el dia de hoy se les pone 0 en las paginas en las que esten trabajando*/
$result_reporte1 = $con->query("SELECT id_usuario,usuario_page FROM usuarios WHERE id_usuario NOT IN (select id_usuario from ventas WHERE date(fecha_creacion) = '$lafechaencolombia') AND estado='1' ORDER BY id_usuario");
while ($row = $result_reporte1->fetch_assoc()) {/*while*/
			$id_usuario=$row['id_usuario'];
			//echo $id_usuario."<br>";
			
			if($row['usuario_page']!=''){/*El usuario tiene paginas inscritas*/
						$paginas_del_usuario=explode('|',$row['usuario_page']);
						if(isset($paginas_del_usuario[0])){/*Si hay por lo menos una pagina donde anotar*/
								
								/*Consulta para sacer datos de cada usuario necesarios para ingresar la ventas*/
								$select_data=$con->query("
								SELECT usuarios.id_estudio,usuarios.id_referente,estudios.id_lider,estudios.porcent_lider
								FROM usuarios
								LEFT JOIN estudios ON (usuarios.id_estudio=estudios.id_estudio)
								WHERE usuarios.id_usuario='$id_usuario'
								")->fetch_assoc();
								
								$id_estudio=$select_data['id_estudio'];
								if($id_estudio==''){$id_estudio=0;}
								
								$id_referente=$select_data['id_referente'];
								if($id_referente==''){$id_referente=0;}
								
								if($id_referente!='0'){$porcent_referente='2.5';}else{$porcent_referente='0.0';}
								//echo '$porcent_referente: '.$porcent_referente."<br>";

								$id_lider=$select_data['id_lider'];
								if($id_lider==''){$id_lider=0;}
								
								$porcent_lider=$select_data['porcent_lider'];
								if($porcent_lider==''){$porcent_lider=0;}
								
								
								/*For each de cada pagina*/
								foreach ($paginas_del_usuario as $id_pagina) {/*Por cada pagina*/
											
											/*Unique code*/
											$unique_code=$lafechaencolombia."-".$id_usuario."-".$id_pagina;

											/*ingreso de Venta*/
											$ingresar=$con->query("	INSERT INTO ventas(id_venta,fecha_creacion,unique_code,id_usuario,id_estudio,id_pagina,id_lider,porcent_lider,id_referente,porcent_referente,venta_usd) 
																	VALUES (default,'$lahoraencolombia','$unique_code',$id_usuario,$id_estudio,$id_pagina,$id_lider,$porcent_lider,$id_referente,$porcent_referente,0.00)
																");
								
								}/*Por cada pagina*/
								
						}/*Si hay por lo menos una pagina donde anotar*/
			}/*El usuario tiene paginas inscritas*/

}/*while*/

/**************BOTONES********************/
if(isset($_POST['enviar_ventas_hoy'])){/*Boton Enviar Ventas Hoy*/

							/*Ventas*/
							$ventas=$_POST['pagina'];

							/*Seleccionamos Data Para Comisiones*/
							$select_data=$con->query("
														SELECT usuarios.id_estudio,usuarios.id_referente,estudios.id_lider,estudios.porcent_lider FROM usuarios
														LEFT JOIN estudios ON (usuarios.id_estudio=estudios.id_estudio)
														WHERE usuarios.id_usuario='".$_SESSION['id_usuario']."'
													")->fetch_assoc();
							
							$id_estudio=$select_data['id_estudio'];
							if($id_estudio==''){$id_estudio=0;}
							//echo '$id_estudio: '.$id_estudio."<br>";

							$id_referente=$select_data['id_referente'];
							if($id_referente==''){$id_referente=0;}
							//echo '$id_referente: '.$id_referente."<br>";

							if($id_referente!='0'){$porcent_referente='2.5';}else{$porcent_referente='0.0';}
							//echo '$porcent_referente: '.$porcent_referente."<br>";

							$id_lider=$select_data['id_lider'];
							if($id_lider==''){$id_lider=0;}
							//echo '$id_lider: '.$id_lider."<br>";

							$porcent_lider=$select_data['porcent_lider'];
							if($porcent_lider==''){$porcent_lider=0;}
							//echo '$porcent_lider: '.$porcent_lider."<br>";

							//print_r($select_data);


							foreach ($ventas as $id_pagina => $venta_usd) {/*Foreach*/
										//echo $venta_usd." | ";
										//echo $id_pagina."<br>"; 
										/*si la venta esta vacia interpretese como si fuera 0*/
										if($venta_usd==''){$venta_usd=0;}
													
													/*Si Existe Usuario*/
													$unique_code=$lafechaencolombia."-".$_SESSION['id_usuario']."-".$id_pagina;
													

													$insertar=$con->query("
																			INSERT INTO ventas(id_venta,fecha_creacion,unique_code,id_usuario,id_estudio,id_pagina,id_lider,porcent_lider,id_referente,porcent_referente,venta_usd) 
																			VALUES (default,'$lahoraencolombia','$unique_code',".$_SESSION['id_usuario'].",$id_estudio,$id_pagina,$id_lider,$porcent_lider,$id_referente,$porcent_referente,$venta_usd)
																			ON DUPLICATE KEY UPDATE venta_usd=$venta_usd,porcent_lider=$porcent_lider,porcent_referente=$porcent_referente;
																		");

										
										
										
										
							}/*Foreach*/

							if(isset($insertar)){
								if($insertar){$_SESSION['ventas_id_pagina_editar_hoy']='';}
							}

							/*Mostrar la div de HOY*/			
							$_SESSION['ventas_div_ventas_hoy']='1';
							/*Esconder la div de AYER*/			
							$_SESSION['ventas_div_ventas_ayer']='0';

}/*Boton Enviar Ventas Hoy*/

if(isset($_POST['enviar_ventas_ayer'])){/*Boton Enviar Ventas Ayer*/

							/*Ventas*/
							$ventas=$_POST['pagina'];

							/*Seleccionamos Data Para Comisiones*/
							$select_data=$con->query("
														SELECT usuarios.id_estudio,usuarios.id_referente,estudios.id_lider,estudios.porcent_lider	FROM usuarios
														LEFT JOIN estudios ON (usuarios.id_estudio=estudios.id_estudio)
														WHERE usuarios.id_usuario='".$_SESSION['id_usuario']."'
													")->fetch_assoc();
							
							$id_estudio=$select_data['id_estudio'];
							if($id_estudio==''){$id_estudio=0;}
							//echo '$id_estudio: '.$id_estudio."<br>";

							$id_referente=$select_data['id_referente'];
							if($id_referente==''){$id_referente=0;}
							//echo '$id_referente: '.$id_referente."<br>";

							if($id_referente!='0'){$porcent_referente='2.5';}else{$porcent_referente='0.0';}
							//echo '$porcent_referente: '.$porcent_referente."<br>";

							$id_lider=$select_data['id_lider'];
							if($id_lider==''){$id_lider=0;}
							//echo '$id_lider: '.$id_lider."<br>";

							$porcent_lider=$select_data['porcent_lider'];
							if($porcent_lider==''){$porcent_lider=0;}
							//echo '$porcent_lider: '.$porcent_lider."<br>";

							//print_r($select_data);


							foreach ($ventas as $id_pagina => $venta_usd) {/*Foreach*/
										//echo $venta_usd." | ";
										//echo $id_pagina."<br>";
										/*si la venta esta vacia interpretese como si fuera 0*/
										if($venta_usd==''){$venta_usd=0;}
													
													/*Si Existe Usuario*/
													$fecha_ayer=date("Y-m-d", time() - 60 * 60 * 24);
													$fecha_y_hora_ayer=$fecha_ayer." 00:00:00";
													$unique_code=$fecha_ayer."-".$_SESSION['id_usuario']."-".$id_pagina;
													

													$insertar=$con->query("
																			INSERT INTO ventas(id_venta,fecha_creacion,unique_code,id_usuario,id_estudio,id_pagina,id_lider,porcent_lider,id_referente,porcent_referente,venta_usd) 
																			VALUES (default,'$fecha_y_hora_ayer','$unique_code',".$_SESSION['id_usuario'].",$id_estudio,$id_pagina,$id_lider,$porcent_lider,$id_referente,$porcent_referente,$venta_usd)
																			ON DUPLICATE KEY UPDATE venta_usd=$venta_usd,porcent_lider=$porcent_lider,porcent_referente=$porcent_referente;
																		");

										
									
										
							}/*Foreach*/

							if(isset($insertar)){
								if($insertar){$_SESSION['ventas_id_pagina_editar_ayer']='';}
							}

							/*Mostrar la div de ayer*/			
							$_SESSION['ventas_div_ventas_ayer']='1';
							/*Esconder la div de Hoy*/			
							$_SESSION['ventas_div_ventas_hoy']='0';

}/*Boton Enviar Ventas Ayer*/


/*Boton Editar 1*/
if(isset($_POST['editar_uno'])){/*Boton Editar 1*/		
														$id_pagina=$_POST['editar_uno'];

														/*Identifica el origen de la edicion, si de HOY o de ayer*/
														if($_POST['origen']=='hoy'){
																	$_SESSION['ventas_id_pagina_editar_hoy']=$id_pagina;
																	/*Mostrar la div de ayer*/			
																	$_SESSION['ventas_div_ventas_ayer']='0';
																	/*Esconder la div de Hoy*/			
																	$_SESSION['ventas_div_ventas_hoy']='1';
														}elseif($_POST['origen']=='ayer'){
																	$_SESSION['ventas_id_pagina_editar_ayer']=$id_pagina;
																	/*Mostrar la div de ayer*/			
																	$_SESSION['ventas_div_ventas_ayer']='1';
																	/*Esconder la div de Hoy*/			
																	$_SESSION['ventas_div_ventas_hoy']='0';
														}

														
														
}/*Boton Editar 1*/


/*Boton Enviar Excusa*/
if(isset($_POST['enviar_excusa'])){/*Boton Enviar Excusa*/
									
									/*Cariables*/
									$unique_code=$lafechaencolombia."-".$_SESSION['id_usuario'];
									$explicacion=$_POST['explicacion'];

									/*Debe haber una axplicacion*/
									if($explicacion==''){/*Si la explicacion está vacia*/$_SESSION['alerta'][]='Debes escribir una explicación de inasistencia.';}/*Si la explicacion está vacia*/
												
									if(!isset($_SESSION['alerta'])){/*Si no hay alerta*/

												/*Insertar*/
												$insert_excusa=$con->query("
													INSERT INTO excusas(id_excusa,fecha_creacion,unique_code,id_usuario,explicacion) 
													VALUES (default,default,'$unique_code',".$_SESSION['id_usuario'].",'$explicacion')
													ON DUPLICATE KEY UPDATE id_excusa=LAST_INSERT_ID(id_excusa), explicacion='$explicacion';
													");
												$id_excusa=$con->insert_id;

												/*Excusa En foto*/
												if($_FILES['excusa']['size'] > 0){/*Si se adjunto un archivo*/
												        /*Exceso de tamaño*/
												        if($_FILES['excusa']['size'] > 6000000){$_SESSION['alerta'][]="La foto no debe tener un tamaño superior a 6 megas.";}
												        /*si no hay error*/
												        if($_FILES['excusa']['error']){$_SESSION['alerta'][]="La foto tiene un error.";}
												        /*La foto no es jpg*/
												        if(($_FILES['excusa']['type']!='image/jpg') and ($_FILES['excusa']['type']!='image/jpeg') and ($_FILES['excusa']['type']!='image/png') ){$_SESSION['alerta'][]="La imagen debe ser JPG, JPEG o PNG.";}
												        /*Move file*/
												        if(!isset($_SESSION['alerta'])){/*Si no hay alerta*/
												       
												                ////////////* SERVIDOR LOCAL*///////////////
												                $nombre_foto='../_globales/images/excusas/'.$id_excusa.'.jpg';
												                //move_uploaded_file($_FILES['excusa']['tmp_name'],"$nombre_foto");

												                
												                /*Se incluye la libreria SimpleImage -> Para transformacion de imagenes*/
												                include_once('../_includes-functions/librerias/SimpleImage-master/src/abeautifulsite/SimpleImage.php');
												                
												                /*Transformamos y guardamos la Imagen*/
												                try {/*Try*/
												                $img = new abeautifulsite\SimpleImage($_FILES['excusa']['tmp_name']);
												                $img->best_fit(1000,1000)->save("$nombre_foto");
												                }/*Try*/ catch(Exception $e) {/*Catch*/
												                echo 'Error: ' . $e->getMessage();
												                }/*Catch*/

												          }/*Si no hay alerta*/
												         
												        
												}/*Si se adjunto un archivo*/   

									

												if (!@getimagesize('../_globales/images/excusas/'.$id_excusa.'.jpg')) {$_SESSION['alerta'][]="Falta la Imagen de la excusa.";}

												if( isset($_SESSION['alerta'])){/*Si no hay alerta*/

															$delete=$con->query("DELETE FROM excusas WHERE id_excusa=$id_excusa");

												}/*Si no hay alerta*/else{/*Si no hay alerta*/
															$_SESSION['alerta_ok'][]='Su excusa se a adjuntado correctamente.';
												}/*Si no hay alerta*/

									}/*Si no hay alerta*/
}/*Boton Enviar Excusa*/
                              

 


 /**************SESSIONES********************/                            
/*Session de la id de la pagina a editar HOY*/
if(!isset($_SESSION['ventas_id_pagina_editar_hoy'])){$_SESSION['ventas_id_pagina_editar_hoy']='';}
//echo 'Session '.$_SESSION['ventas_id_pagina_editar_hoy']."<br>";

/*Session de la id de la pagina a editar AYER*/
if(!isset($_SESSION['ventas_id_pagina_editar_ayer'])){$_SESSION['ventas_id_pagina_editar_ayer']='';}
//echo 'Session '.$_SESSION['ventas_id_pagina_editar_ayer']."<br>";

/*Mostrar o esconder div de ventas de HOY*/
if(!isset($_SESSION['ventas_div_ventas_hoy'])){$_SESSION['ventas_div_ventas_hoy']='0';}
//echo 'Session HOY:'.$_SESSION['ventas_div_ventas_hoy']."<br>";

/*Mostrar o esconder div de ventas de AYER*/
if(!isset($_SESSION['ventas_div_ventas_ayer'])){$_SESSION['ventas_div_ventas_ayer']='0';}
//echo 'Session AYER:'.$_SESSION['ventas_div_ventas_ayer']."<br>";

/***************CONSULTAS*****************/
/*Consulta Info Pagina*/				
$pagina_info=$con->query("SELECT * FROM paginas ");
while($row=$pagina_info->fetch_assoc()){/*While*/
			
			$pagina_color[$row['id_pagina']]=$row['color_pagina'];
			$pagina_nombre[$row['id_pagina']]=$row['nombre_pagina'];
}/*While*/

/*Consulta Ventas por Pagina De HOY*/				
$ventas_info=$con->query("SELECT ventas.*,paginas.* FROM paginas LEFT JOIN ventas ON (ventas.id_pagina=paginas.id_pagina) WHERE ventas.id_usuario=".$_SESSION['id_usuario']." AND DATE(ventas.fecha_creacion)=CURDATE() ");
while($row=$ventas_info->fetch_assoc()){/*While*/
			
			$ventas_usd[$row['id_pagina']]=$row['venta_usd'];
			
}/*While*/
//print_r($ventas_usd);

/*Consulta Ventas por Pagina De AYER*/
$fecha_ayer=date("Y-m-j", time() - 60 * 60 * 24);
$ventas_info=$con->query("SELECT ventas.*,paginas.* FROM paginas LEFT JOIN ventas ON (ventas.id_pagina=paginas.id_pagina) WHERE ventas.id_usuario=".$_SESSION['id_usuario']." AND DATE(ventas.fecha_creacion)='".$fecha_ayer."' ");
while($row=$ventas_info->fetch_assoc()){/*While*/
			
			$ventas_usd_ayer[$row['id_pagina']]=$row['venta_usd'];
			
}/*While*/
//print_r($ventas_usd_ayer);

?>
<!DOCTYPE html>
<html>
<head>

	<link rel="stylesheet" type="text/css" href="../_globales/styles/resetcss.css">
	<link rel="stylesheet" type="text/css" href="../_includes-functions/styles/barraNavegacion.css">
	<link rel="stylesheet" type="text/css" href="../_includes-functions/styles/footer.css">
	<link rel="stylesheet" type="text/css" href="styles/ventas.css">

	<title>
		
	</title>
<style>
.myButton {
	-moz-box-shadow: 0px 10px 14px -7px #949494;
	-webkit-box-shadow: 0px 10px 14px -7px #949494;
	box-shadow: 0px 10px 14px -7px #949494;
	background-color:transparent;
	-moz-border-radius:10px;
	-webkit-border-radius:10px;
	border-radius:8px;
	border:3px solid #b3afb3;
	display:inline-block;
	cursor:pointer;
	color:#6b686b;
	font-family:Verdana;
	font-size:14px;
	width: 350px;
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
			$("#hoyBoton").click(function(){
				$("#hoyBoton").hide("slow");
				$("#ayerBoton").show("slow");
				
				$("#hoyDiv").show("slow");
				$("#ayerDiv").hide("slow");
				
			});
		});
	</script>

	<script> 
		$(document).ready(function(){
			$("#ayerBoton").click(function(){
				$("#hoyBoton").show("slow");
				$("#ayerBoton").hide("slow");
				
				$("#hoyDiv").hide("slow");
				$("#ayerDiv").show("slow");
				
			});
		});
	</script>
</head>
<body>


	<div id="ventas_cuerpo">

	<?include "../_includes-functions/foreach_alerta.php"; ?>
	
		<h1>Ingresar ventas diarias</h1><br>
		<p>Ingrese diariamente la cantidad de dolares realizados en su día de trabajo. En caso de inacistencia <b><a href='' >diligencie una excusa.</a></b> </p><br> 

			<?
//////////////////////////////////////////////////
/////////////////Ventas Hoy//////////////////////
////////////////////////////////////////////////


						
						/*Boton de Mostrar o esconder div de Ventas de hoy*/
						echo "<button id='hoyBoton' style='display:block;";
						if($_SESSION['ventas_div_ventas_hoy']=='1'){echo "display:none;";}
						echo "'class='myButton'>Anotar Ventas de HOY</button>";

echo "<div id='hoyDiv'";
	 if($_SESSION['ventas_div_ventas_hoy']=='0'){echo "style='display:none;";}
echo "'><!--ABRE HoyDiv-->";

				echo "<h1 style='display:inline;margin-left:40px;font-size:25px;'><br><span style='padding-left:10%;'>Ventas de Hoy:  ".date('d')." de ".$meses[date('n')-1]."</span><br><br></h1>";

			echo "<form id='ventas_cuerpo_formularioVentas' method='POST' name='form_ventas' action=''>";

echo "<table width='790' border='0' cellpadding='5' cellspacing='0'>"; 


			/*Datos de las paginas del usuario*/
			$paginas_del_usuario=$con->query("SELECT usuario_page FROM usuarios WHERE id_usuario=".$_SESSION['id_usuario']."")->fetch_assoc();
			$paginas_del_usuario=$paginas_del_usuario['usuario_page'];

			/*Creamos Array con las paginas con las que cuentra el usuario*/
			$paginas_del_usuario=explode('|',$paginas_del_usuario);
			


			/*Cada una de las paginas*/
			foreach ($paginas_del_usuario as $id_pagina) {/*foreach*/


						
						
						
						/*Creacion del contenido de la tabla*/				
						echo "<tr style='background-color:".$pagina_color[$id_pagina]."; height:55px; font-family:arial; font-size:14px; color:white; '>";
						
						if (@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'paginas/'.$id_pagina.'.jpg')) {echo"<td><img class='logo' src=\"../_globales/images/".$_SESSION['nombre_base']."_paginas/".$id_pagina.".png\" style='max-width:100px;max-height:30px; vertical-align:middle; margin-left:20px; '></td> ";}else{echo "<td><img src=\"../_globales/images/".$_SESSION['nombre_base']."_paginas/".$id_pagina.".png\" style='max-width:100px;max-height:30px;vertical-align:middle;margin-left:20px;'></td>";}

						echo "<td><label>Ingresar dolares de hoy en USD $ </label></td>";

						if( (!empty($ventas_usd[$id_pagina])) and ($ventas_usd[$id_pagina]>0) and ($_SESSION['ventas_id_pagina_editar_hoy']!=$id_pagina)){/*Si hubo ventas en esta pagina*/
									
									
									echo "<td><label><b>Dolares ingresados el día de HOY $<b>$ventas_usd[$id_pagina]  </b></label>
									<button style='background-color:Transparent;background-repeat:no-repeat;border:none;cursor:pointer;overflow:hidden;outline:none;' name='editar_uno' value='$id_pagina' type='submit' >
									<img class='editIcon' src='images/editicon.png' >
									</button></td>";
								

						}/*Si hubo ventas en esta pagina*/else{/*Si hubo ventas en esta pagina*/
									echo "<td><input style='font-size:17px;height:30px;border-style:none;padding-left:10px;'";
									if( (!empty($ventas_usd[$id_pagina]) ) and ($ventas_usd[$id_pagina]>0) ){/*Se pone el valor en dolares*/echo "value='".$ventas_usd[$id_pagina]."'";}/*Se pone el valor en dolares*/
									echo "type='number' name='pagina[".$id_pagina."]' onkeypress='return (event.charCode >= 48 && event.charCode <= 57) or (event.charCode == 46) or (event.charCode == 44))' step='0.01' placeholder='0' ></td>";
						}/*Si hubo ventas en esta pagina*/
						echo "</tr>";

						
				

			
			}/*foreach*/

				
			?>
</table>	
				<input type='hidden' name='origen' value='hoy'/>
				<input id="ventas_cuerpo_formularioVentas_ingresarDatos" type="submit" value="Ingresar Ventas de HOY" name='enviar_ventas_hoy'></input>
			</form>
</div><!--CIERRA HoyDiv-->
<?

///////////////////////////////////////////////////
/////////////////Ventas Ayer//////////////////////
/////////////////////////////////////////////////

			/*Boton de Mostrar o esconder div de Ventas de AYER*/
			echo "<button id='ayerBoton' style='display:block;";
			if($_SESSION['ventas_div_ventas_ayer']=='1'){echo "display:none;";}
			echo "'class='myButton'>Anotar Ventas de AYER</button>";


			

echo "<div id='ayerDiv'";
	 if($_SESSION['ventas_div_ventas_ayer']=='0'){echo "style='display:none;";}
echo "'><!--ABRE AyerDiv-->";


			$fecha_ayer=date_parse(date("j F Y", time() - 60 * 60 * 24));
				echo "<h1 style='display:inline;margin-left:40px;font-size:25px;'><br><span style='padding-left:10%;'>Ventas de Ayer:  ".$fecha_ayer['day']." de ".$meses[$fecha_ayer['month']-1]."</span><br><br></h1>";

			echo "<form id='ventas_cuerpo_formularioVentas' method='POST' name='form_ventas' action=''>";

echo "<table width='790' border='0' cellpadding='5' cellspacing='0'>"; 


			/*Datos de las paginas del usuario*/
			$paginas_del_usuario=$con->query("SELECT usuario_page FROM usuarios WHERE id_usuario=".$_SESSION['id_usuario']."")->fetch_assoc();
			$paginas_del_usuario=$paginas_del_usuario['usuario_page'];

			/*Creamos Array con las paginas con las que cuentra el usuario*/
			$paginas_del_usuario=explode('|',$paginas_del_usuario);
			


			/*Cada una de las paginas*/
			foreach ($paginas_del_usuario as $id_pagina) {/*foreach*/


						
						
						
						/*Creacion del contenido de la tabla*/				
						echo "<tr style='background-color:".$pagina_color[$id_pagina]."; height:55px; font-family:arial; font-size:14px; color:white; '>";
						
						if (@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'paginas/'.$id_pagina.'.jpg')) {echo"<td><img class='logo' src=\"../_globales/images/".$_SESSION['nombre_base']."_paginas/".$id_pagina.".png'\" style='max-width:100px;max-height:30px; vertical-align:middle; margin-left:20px; '></td> ";}else{echo "<td><img src=\"../_globales/images/".$_SESSION['nombre_base']."_paginas/".$id_pagina.".png'\" style='max-width:100px;max-height:30px;vertical-align:middle;margin-left:20px;'></td>";}

						echo "<td><label>Ingresar dolares de AYER en USD $ </label></td>";

						if( (!empty($ventas_usd_ayer[$id_pagina])) and ($ventas_usd_ayer[$id_pagina]>0) and ($_SESSION['ventas_id_pagina_editar_ayer']!=$id_pagina)){/*Si hubo ventas en esta pagina*/
									
									
									echo "<td><label><b>Dolares ingresados el día de hoy $<b>$ventas_usd_ayer[$id_pagina]  </b></label>
									<button style='background-color:Transparent;background-repeat:no-repeat;border:none;cursor:pointer;overflow:hidden;outline:none;' name='editar_uno' value='$id_pagina' type='submit' >
									<img class='editIcon' src='images/editicon.png' >
									</button></td>";
								

						}/*Si hubo ventas en esta pagina*/else{/*Si hubo ventas en esta pagina*/
									echo "<td><input style='font-size:17px;height:30px;border-style:none;padding-left:10px;'";
									if( (!empty($ventas_usd_ayer[$id_pagina]) ) and ($ventas_usd_ayer[$id_pagina]>0) ){/*Se pone el valor en dolares*/echo "value='".$ventas_usd_ayer[$id_pagina]."'";}/*Se pone el valor en dolares*/
									echo "type='number' name='pagina[".$id_pagina."]' onkeypress='return (event.charCode >= 48 && event.charCode <= 57) or (event.charCode == 46) or (event.charCode == 44))' step='0.01' placeholder='0' ></td>";
						}/*Si hubo ventas en esta pagina*/
						echo "</tr>";

						
				

			
			}/*foreach*/

				
			?>
</table>	
				<input type='hidden' name='origen' value='ayer'/>
				<input id="ventas_cuerpo_formularioVentas_ingresarDatos" type="submit" value="Ingresar Ventas de AYER" name='enviar_ventas_ayer'></input>
			</form>

</div><!--CIERRA AyerDiv-->

<div id="ventas_cuerpo_advertencia">

<img src="images/cautionicon.png"><p>Cualquier intento de fraude al ingresar datos financieros genera una multa del <b>-10%</b> sobre las ventas del periodo del modelo (acomulables)</p>

</div>

			<img style="margin-top:20px; margin-bottom:20px;" src="images/separador.png">


			<!-- AQUI COMIENZA LA SECCIÓN DE DILIGENCIAR EXCUSA -->


			<p>Diligencie este formulario solo en caso de no haber podido asistir a trabajar el día de hoy **</p> <br>

			<form id="ventas_cuerpo_diligenciarExcusa" method='POST' action='' enctype="multipart/form-data">
				<h1 id="ventas_cuerpo_diligenciarExcusa_titulo" >Diligenciar Excusa</h1><br>
				<?
				/*Selection of Level of the user*/
				$data=$con->query("SELECT * FROM excusas WHERE id_usuario=".$_SESSION['id_usuario']." AND DATE(fecha_creacion)=CURDATE()")->fetch_assoc();
				$id_excusa=$data['id_excusa'];
				$explicacion=$data['explicacion'];
				?>
				<p>1. Por favor cuentenos en pocas palabras porque no ha podido trabajar el día de hoy...</p><br>

				<textarea rows="4" cols="100" name="explicacion" form="ventas_cuerpo_diligenciarExcusa"><? echo $explicacion; ?></textarea>

				<p>2. Ingrese una imagen que le ayude a soportar su excusa:</p><br>

				<?
				
				if(!empty($id_excusa)){/*Si existe excusa*/
							echo "<img src='../_globales/images/excusas/".$id_excusa.".jpg?".DATE('siH')."' style='max-width:100px;max-height:40px;'>";
				/*Si existe excusa*/}else{/*Si existe excusa*/
							echo "<img src='images/iconoimagen.png'>";
				}/*Si existe excusa*/
				
				?>
				
				<input id="ventas_cuerpo_diligenciarExcusa_inputFile" name='excusa' type="file"></input>
				<input id="ventas_cuerpo_diligenciarExcusa_enviarExcusa" type="submit" style='width:155px;'name='enviar_excusa' value="Enviar Excusa>" ></input>


			</form>



			<!-- AQUI TERMINA LA SECCIÓN DE DILIGENCIAR EXCUSA -->


		</div>

		<?php include '../_includes-functions/footer.php';?>

	</body>
	</html>