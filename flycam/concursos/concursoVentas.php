<?
include "../_includes-functions/conexion_improved.php";
include "../_includes-functions/seguridad.php"; 
include "../_includes-functions/funciones.php";
include '../_includes-functions/barraNavegacion.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Concurso por ventas</title>

	<link rel="stylesheet" type="text/css" href="../_globales/styles/resetcss.css">
	<link rel="stylesheet" type="text/css" href="../_includes-functions/styles/barraNavegacion.css">
	<link rel="stylesheet" type="text/css" href="../_includes-functions/styles/footer.css">
	<link rel="stylesheet" type="text/css" href="styles/concursoVentas.css">

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

	<script> 

		$(document).ready(function(){
			$("#verAntiguosGanadores").click(function(){
				$("#concursoVentas_ganadoresAntiguos").slideToggle("slow");

			});
		});

		$(document).ready(function(){
			$("#vertodasLasPosiciones").click(function(){
				$("#concursoVentas_todasLasPosiciones").slideToggle("slow");

			});
		});

	</script>


</head>

<body>

	<div id="concursoVentas">

		<h1 style="margin-bottom:25px;" ><img style="margin-right:10px; vertical-align:bottom;" src="../_globales/images/concursoventasicono.png">Concurso por ventas</h1>
		<p>Un premio de dinero en efectivo entregado cada quincena! Una oportunidad para ganar más.</p><br>

		<img src="../_globales/images/premioconcursoventas.png"><br>

		<h2 style="font-size:30px;" >Últimos ganadores <span style="font-size:20px;" >(Quincenas pasadas)</span></h2><br>



		<table id="concursoVentas_ultimoGanador" cellspacing="0" cellpadding="5" border="1" >

			<thead>

				<tr>
					<td>Fecha</td>
					<td>Foto</td>
					<td>Nombre	</td>
					<td>Studio</td>
					<td>Ciudad</td>
					<td>Total Fact.</td>
					<td>Modalidad</td>
				</tr>

			</thead>

			<tbody>
				

<?				          	
							/*Hace 15 Dias*/
							if(DATE('j')>16){/*Del 16 al Dia Actual*/
					
          					                  	/*Quincena Anterior*/
          					                  	$from_date1=DATE('Y-m-01');
          					                  	$to_date1=DATE('Y-m-15');
          					            

            				  	$consulta_posiciones_1=$con->query("
								SELECT SUM(venta_usd) as ventas_sumadas,ventas.*,estudios.nombre_estudio,usuarios.* FROM ventas 
								INNER JOIN usuarios ON (usuarios.id_usuario=ventas.id_usuario) 
								INNER JOIN estudios ON (usuarios.id_estudio=estudios.id_estudio)
								WHERE ventas.fecha_creacion BETWEEN '" . $from_date1 . "' AND  '" . $to_date1 . " 23:59:59' 
								GROUP BY ventas.id_usuario 
								ORDER BY ventas_sumadas DESC, nombres ASC
								LIMIT 1");
								
							$posicion='1';
							while($row1 = $consulta_posiciones_1->fetch_assoc()){/*While*/
							
							/*CREACION DE IMAGEN*/
							if (!@getimagesize('../_globales/images/cedulas_mano/'.$row1['id_usuario'].'.jpg')) {$image='../_globales/images/no_image.png';}else{$image="../_globales/images/cedulas_mano/".$row1['id_usuario'].".jpg";}	

											
											echo "<tr>";
											echo"<td>$to_date1</td>";
											echo "<td id='td2' ><img src='$image' style='width: 120px;'></td>";
											echo"<td>".$row1['nombres']."</td>";
											echo"<td>".$row1['nombre_estudio']."</td>";
											echo"<td>".$row1['ciudad']."</td>";
											echo"<td>$".$row1['ventas_sumadas']." USD</td>";
											if($row1['modalidad']=='1'){echo "<td id='td7' ><img src='../_globales/images/iconoestudio.png' alt='Estudio'></td>";}
            				   				else{echo "<td id='td7' ><img src='../_globales/images/iconosatelite.png' alt='Satelite'></td>";}
											echo "</tr>";

				
								$posicion++;
								
								
							}/*While*/	
}/*Del 16 al Dia Actual*/

								
								/*Hace 30 Dias*/
          					    $from_date3=DATE('Y-m-16' , strtotime("-1 months", strtotime(date("F") . "1")));
          					    //echo $from_date3."<br>";
          					    $to_date3=DATE('Y-m-t' , strtotime("-1 months", strtotime(date("F") . "1")));
          					    //echo $to_date3."<br>";       


                            	$consulta_posiciones_1=$con->query("
								SELECT SUM(venta_usd) as ventas_sumadas,ventas.*,estudios.nombre_estudio,usuarios.* FROM ventas 
								INNER JOIN usuarios ON (usuarios.id_usuario=ventas.id_usuario) 
								INNER JOIN estudios ON (usuarios.id_estudio=estudios.id_estudio)
								WHERE ventas.fecha_creacion BETWEEN '" . $from_date3 . " ' AND  '" . $to_date3 . " 23:59:59' 
								GROUP BY ventas.id_usuario 
								ORDER BY ventas_sumadas DESC, nombres ASC
								LIMIT 1");
								
							$posicion='1';
							while($row1 = $consulta_posiciones_1->fetch_assoc()){/*While*/
							
							/*CREACION DE IMAGEN*/
							if (!@getimagesize('../_globales/images/cedulas_mano/'.$row1['id_usuario'].'.jpg')) {$image='../_globales/images/no_image.png';}else{$image="../_globales/images/cedulas_mano/".$row1['id_usuario'].".jpg";}	

											
											echo "<tr>";
											echo"<td>$to_date3</td>";
											echo "<td id='td2' ><img src='$image' style='width: 120px;'></td>";
											echo"<td>".$row1['nombres']."</td>";
											echo"<td>".$row1['nombre_estudio']."</td>";
											echo"<td>".$row1['ciudad']."</td>";
											echo"<td>$".$row1['ventas_sumadas']." USD</td>";
											if($row1['modalidad']=='1'){echo "<td id='td7' ><img src='../_globales/images/iconoestudio.png' alt='Estudio'></td>";}
            				   				else{echo "<td id='td7' ><img src='../_globales/images/iconosatelite.png' alt='Satelite'></td>";}
											echo "</tr>";

				
								$posicion++;
								
								
							}/*While*/	



								/*Hace 45 Dias*/
          					    $from_date3=DATE('Y-m-01' , strtotime("-1 months", strtotime(date("F") . "1")));
          					    $to_date3=DATE('Y-m-15' , strtotime("-1 months", strtotime(date("F") . "1")));
          					           


                            	$consulta_posiciones_1=$con->query("
								SELECT SUM(venta_usd) as ventas_sumadas,ventas.*,estudios.nombre_estudio,usuarios.* FROM ventas 
								INNER JOIN usuarios ON (usuarios.id_usuario=ventas.id_usuario) 
								INNER JOIN estudios ON (usuarios.id_estudio=estudios.id_estudio)
								WHERE ventas.fecha_creacion BETWEEN '" . $from_date3 . "' AND  '" . $to_date3 . " 23:59:59' 
								GROUP BY ventas.id_usuario 
								ORDER BY ventas_sumadas DESC, nombres ASC
								LIMIT 1");
								
							$posicion='1';
							while($row1 = $consulta_posiciones_1->fetch_assoc()){/*While*/
							
							/*CREACION DE IMAGEN*/
							if (!@getimagesize('../_globales/images/cedulas_mano/'.$row1['id_usuario'].'.jpg')) {$image='../_globales/images/no_image.png';}else{$image="../_globales/images/cedulas_mano/".$row1['id_usuario'].".jpg";}	

											
											echo "<tr>";
											echo"<td>$to_date3</td>";
											echo "<td id='td2' ><img src='$image' style='width: 120px;'></td>";
											echo"<td>".$row1['nombres']."</td>";
											echo"<td>".$row1['nombre_estudio']."</td>";
											echo"<td>".$row1['ciudad']."</td>";
											echo"<td>$".$row1['ventas_sumadas']." USD</td>";
											if($row1['modalidad']=='1'){echo "<td id='td7' ><img src='../_globales/images/iconoestudio.png' alt='Estudio'></td>";}
            				   				else{echo "<td id='td7' ><img src='../_globales/images/iconosatelite.png' alt='Satelite'></td>";}
											echo "</tr>";

				
								$posicion++;
								
								
							}/*While*/	




							?>

			</tbody>

		</table>


		

		<div class="hide" id="concursoVentas_ganadoresAntiguos">

			<table  id="concursoVentas_ultimoGanador" cellspacing="0" cellpadding="5" border="1" >


				<tbody>


				<?
								




                            
                            
                            
            				  	
									

?>
				</tbody>

			</table>

		</div>	

		<div id="concursoVentas_tablaPosiciones" >
			
			<br>	<img src="../_globales/images/medalicon.png"> <h2 >Tabla de Posiciones Período Actual:</h2><br>


			<!--
			////////////////////////////////////////////////
			////////////PRIMERAS POSICIONES////////////////
			//////////////////////////////////////////////
			-->

			<table id="concursoVentas_tablaPosiciones_tabla" cellspacing="0" cellpadding="5" border="1" >

				<thead>

					<tr>
						<td>Fecha</td>
						<td>Foto</td>
						<td>Nombre	</td>
						<td>Studio</td>
						<td>Ciudad</td>
						<td>Total Fact.</td>
						<td>Modalidad</td>
					</tr>

				</thead>

				<tbody>

					

			<?
			/*Quincena Actual*/
			if(DATE('j')>16){/*Del 16 al Dia Actual*/

                            /*Mes Actual*/
                            $from_date=DATE('Y-m-16');
                            $to_date=DATE('Y-m-d');
                      }/*Del 16 al Dia Actual*/else{/*Del 01 al 15*/

                      		/*Mes Actual*/
                            $from_date=DATE('Y-m-01');
                            $to_date=DATE('Y-m-15');
                      }/*Del 01 al 15*/

                            
                            


			$consulta_posiciones_1=$con->query("
				SELECT SUM(venta_usd) as ventas_sumadas,ventas.*,estudios.nombre_estudio,usuarios.* FROM ventas 
				INNER JOIN usuarios ON (usuarios.id_usuario=ventas.id_usuario) 
				INNER JOIN estudios ON (usuarios.id_estudio=estudios.id_estudio)
				WHERE ventas.fecha_creacion BETWEEN '" . $from_date . "' AND  '" . $to_date . "' 
				AND usuarios.estado=1
				GROUP BY ventas.id_usuario 
				ORDER BY ventas_sumadas DESC, nombres ASC
				LIMIT 10");
				
			$posicion='1';
			while($row1 = $consulta_posiciones_1->fetch_assoc()){/*While*/
			
			/*CREACION DE IMAGEN*/
			if (!@getimagesize('../_globales/images/cedulas_mano/'.$row1['id_usuario'].'.jpg')) {$image='../_globales/images/no_image.png';}else{$image="../_globales/images/cedulas_mano/".$row1['id_usuario'].".jpg";}	


				if($posicion==1){/*Si es el primero*/
				
							echo "<tr id='tr1'>";
							echo "<td id='td1' >$posicion</td>";
							echo "<td id='td2' ><img src='$image' style='width: 120px;'></td>";
							echo "<td id='td3' >".$row1['nombres']."</td>";
							echo "<td id='td4' >".$row1['nombre_estudio']."</td>";
							echo "<td id='td5' >".$row1['ciudad']."</td>";
							echo "<td id='td6' >$".$row1['ventas_sumadas']." USD</td>";
							if($row1['modalidad']=='1'){echo "<td id='td7'><img src='../_globales/images/iconoestudio.png' alt='Estudio'></td>";}
               				else{echo "<td id='td7'><img src='../_globales/images/iconosatelite.png' alt='Satelite'></td>";}
							echo "</tr>";
				
				}/*Si es el primero*/else{/*Si NO es el primero*/
							
							echo "<tr>";
							echo"<td>$posicion</td>";
							echo "<td id='td2' ><img src='$image' style='width: 120px;'></td>";
							echo"<td>".$row1['nombres']."</td>";
							echo"<td>".$row1['nombre_estudio']."</td>";
							echo"<td>".$row1['ciudad']."</td>";
							echo"<td>$".$row1['ventas_sumadas']." USD</td>";
							if($row1['modalidad']=='1'){echo "<td id='td7' ><img src='../_globales/images/iconoestudio.png' alt='Estudio'></td>";}
               				else{echo "<td id='td7' ><img src='../_globales/images/iconosatelite.png' alt='Satelite'></td>";}
							echo "</tr>";
			}/*Si NO es el primero*/

				$posicion++;
				
				
			}/*While*/
			?>


					


				</tbody>

			</table>
			




			<!--
			////////////////////////////////////////////////
			////////////RESTO DE POSICIONES////////////////
			//////////////////////////////////////////////
			-->
			<button id='vertodasLasPosiciones' class="myButton">Ver todas las posiciones</button>

			<div class="hide2" id="concursoVentas_todasLasPosiciones">
				
				<table id="concursoVentas_todasLasPosiciones_tabla" cellspacing="0" cellpadding="5" border="1" >
				
				<thead>

					<tr>
						<td>Fecha</td>
						<td>Foto</td>
						<td>Nombre	</td>
						<td>Studio</td>
						<td>Ciudad</td>
						<td>Total Fact.</td>
						<td>Modalidad</td>
					</tr>

				</thead>

				<tbody>
			<?
				$consulta_posiciones_1=$con->query("
				SELECT SUM(venta_usd) as ventas_sumadas,ventas.*,estudios.nombre_estudio,usuarios.* FROM ventas 
				INNER JOIN usuarios ON (usuarios.id_usuario=ventas.id_usuario) 
				INNER JOIN estudios ON (usuarios.id_estudio=estudios.id_estudio)
				WHERE ventas.fecha_creacion BETWEEN '" . $from_date . "' AND  '" . $to_date . "' 
				AND usuarios.estado=1
				GROUP BY ventas.id_usuario 
				ORDER BY ventas_sumadas DESC, nombres ASC
				LIMIT 100 OFFSET 10
				");
				
			
			while($row1 = $consulta_posiciones_1->fetch_assoc()){/*While*/
			
			/*CREACION DE IMAGEN*/
			if (!@getimagesize('../_globales/images/cedulas_mano/'.$row1['id_usuario'].'.jpg')) {$image='../_globales/images/no_image.png';}else{$image="../_globales/images/cedulas_mano/".$row1['id_usuario'].".jpg";}	


								
							echo "<tr>";
							echo"<td>$posicion</td>";
							echo "<td id='td2' ><img src='$image' style='width: 120px;'></td>";
							echo"<td>".$row1['nombres']."</td>";
							echo"<td>".$row1['nombre_estudio']."</td>";
							echo"<td>".$row1['ciudad']."</td>";
							echo"<td><img src='../_globales/images/blur_ventas.jpg'></td>";
							if($row1['modalidad']=='1'){echo "<td id='td7' ><img src='../_globales/images/iconoestudio.png' alt='Estudio'></td>";}
               				else{echo "<td id='td7' ><img src='../_globales/images/iconosatelite.png' alt='Satelite'></td>";}
							echo "</tr>";
			

				$posicion++;
				
				
			}/*While*/
			?>
				</tbody>

			</table>


			</div>

		</div>	

	</div>

	<?php include '../_includes-functions/footer.php';?>

</body>
</html>