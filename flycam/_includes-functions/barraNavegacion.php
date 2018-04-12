<?
include "../_includes-functions/conexion_improved.php";

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
	<link rel="stylesheet" type="text/css" href="../_globales/styles/styles_globales.css">
	<link rel="stylesheet" type="text/css" href="styles/barraNavegacion.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

	<script> 
		$(document).ready(function(){
			$("#fondoVentanaModal").click(function(){
				$("#ventanaModal").hide("slow");
				

			});
		});
	</script>

</head>
<body>

<?
			/*Se verifica la firma del cotrato*/
          	$firma_contrato=$con->query("SELECT * FROM contratos WHERE id_usuario = ".$_SESSION['id_usuario']."")->fetch_assoc();
          	if(empty($firma_contrato) and empty($_SESSION['contrato_mostrado_una_vez'])){/*No se ha firmado el contrato*/
          	//var_dump($firma_contrato);

?>
	<div id="ventanaModal">

		<div id="ventanaModal_contrato" >
			<h1><img style="margin-right:15px;" src="../_globales/images/contratoicono.png">Normas y acuerdo laboral del modelo</h1>
			<span>Antes de comenzar a utilizar el Marilyn deberá aceptar los terminos y condiciones laborales de nuestro estudio. En caso de no estar de acuerdo con la normatividad establecidad por favor comunicarlo a la persona encargada.</span>

			<?
			include "../contrato/contrato_texto.php";
			?>

			

			<form action='' method='POST'>
			<div style='margin-top:20px;' id="ventanaModal_contrato_contenedorFirma">
				<label>Firma Digital:</label><br>
				<input type="text" name="nombre_firma" placeholder="Escriba su nombre aquí">
			</div>

			<input class="bigcta" type="submit" name="enviar_firma_contrato" value="Acepto los terminos laborales" style="width:374px;" >
			</form>
		</div>

<div id="fondoVentanaModal" style="
width: 100%;
	height: 100%;
	background-color: 
	/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#3e0417+0,8d2257+100 */
background: #3e0417; /* Old browsers */
background: -moz-linear-gradient(top,  #3e0417 0%, #8d2257 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top,  #3e0417 0%,#8d2257 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom,  #3e0417 0%,#8d2257 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3e0417', endColorstr='#8d2257',GradientType=0 ); /* IE6-9 */;
opacity: 0.9;
position: fixed;
z-index: 3;

		" > </div>

	</div>

<?
/*Si el contrato se mostró una vez se pone en valor 1, para no mostrarlo mas de una vez en la misma session*/
$_SESSION['contrato_mostrado_una_vez']=1;
}/*No se ha firmado el contrato*/
?>
	
	<nav id="barraLateral">
		<ul id="barraLateral_cuerpoBarra">

			<a href=""><img id="barraLateral_cuerpoBarra_logomwcc" src="../_globales/images/logomarilyn.png"></a>
			
						<? if( $_SESSION['nivel']>=1 ){ ?>
						<li class="barraLateral_cuerpoBarra_boton" > <img src="../_globales/images/agregarModelo.png"><a href="../entrevistas/entrevistas.php?ingresar_usuario">Entrevistas</a></li>
						<? } ?>

						<? if( $_SESSION['nivel']>=1 ){ ?>
						<li class="barraLateral_cuerpoBarra_boton" > <img src="../_globales/images/aspirantes.png"><a href="../aspirantes/aspirantes.php">Bolsa de aspirantes</a></li>
						<? } ?>

						<? if( $_SESSION['nivel']>=2 ){ ?>
						<li class="barraLateral_cuerpoBarra_boton" > <img src="../_globales/images/modelos.png"><a href="../modelos/modelos.php">Modelos</a></li>
						<? } ?>
						
						<? if( $_SESSION['nivel']>=2 ){ ?>
						<li class="barraLateral_cuerpoBarra_boton" > <img src="../_globales/images/pageicon.png"><a href="../credenciales/paginas.php">Paginas</a></li>
						<? } ?>

						<? if( $_SESSION['nivel']>=0 ){ ?>
						<li class="barraLateral_cuerpoBarra_boton" > <img src="../_globales/images/perfil.png"><a href="../credenciales/credenciales.php?editar_usuario=<? echo $_SESSION['id_usuario']; ?>">Credenciales</a></li>
						<? } ?>

						<? if( $_SESSION['nivel']>=2 ){ ?>
						<li class="barraLateral_cuerpoBarra_boton" > <img src="../_globales/images/bankicon.png"><a href="../cuentas/bancos.php">Bancos</a></li>
						<? } ?>


						<? if( $_SESSION['nivel']>=0 ){ ?>
						<li class="barraLateral_cuerpoBarra_boton" > <img src="../_globales/images/cardicon.png"><a href="../cuentas/cuentas.php?editar_usuario=<? echo $_SESSION['id_usuario']; ?>">Cuentas</a></li>
						<? } ?>

						<? if( $_SESSION['nivel']>=0 ){ ?>
						<li class="barraLateral_cuerpoBarra_boton" > <img src="../_globales/images/ingresarVenta.png"><a href="../ventas/ventas.php">Ingresar venta diaria</a></li>
						<? } ?>

						<? if( $_SESSION['nivel']>=2 ){ ?>
						<li class="barraLateral_cuerpoBarra_boton" > <img src="../_globales/images/estadisticas.png"><a href="../estadisticas/estadisticasLider.php">Estadistícas Líder</a></li>
						<? } ?>

						<? if( $_SESSION['nivel']>=0 ){ ?>
						<li class="barraLateral_cuerpoBarra_boton" > <img src="../_globales/images/estadisticas.png"><a href="../estadisticas/estadisticasModelo.php">Estadistícas Modelo</a></li>
						<? } ?>

						<? if( $_SESSION['nivel']>=0 ){ ?>
						<li class="barraLateral_cuerpoBarra_boton" > <img src="../_globales/images/referidos.png"><a href="../referidos/referidos.php">Referidos</a></li>
						<? } ?>

						<? if( $_SESSION['nivel']>=6){ ?>
						<!--<li class="barraLateral_cuerpoBarra_boton" > <img src="../_globales/images/concursosicono.png"><a href="../concursos/concursoVentas.php">Concurso</a></li>-->
						<? } ?>

						<? if( $_SESSION['nivel']>=0 ){ ?>
						<li class="barraLateral_cuerpoBarra_boton" > <img src="../_globales/images/contrato.png"><a target="_blank" href="../contrato/contrato.php">Contrato</a></li>
						<? } ?>

						<? if( $_SESSION['nivel']>=3 ){ ?>
						<li class="barraLateral_cuerpoBarra_boton" > <img src="../_globales/images/cajaFuerte.png"><a href="../_includes-functions/sitio-en-construccion.php">Caja fuerte</a></li>
						<? } ?>


						<? if( $_SESSION['nivel']>=3 ){ ?>
						<li class="barraLateral_cuerpoBarra_boton" > <img src="../_globales/images/tareas.png"><a href="../_includes-functions/sitio-en-construccion.php">Tareas</a></li>
						<? } ?>

					


						<? if( $_SESSION['nivel']>=3 ){ ?>
						<li class="barraLateral_cuerpoBarra_boton" > <img src="../_globales/images/perfil.png"><a href="../_includes-functions/sitio-en-construccion.php">Inventario</a></li>
						<? } ?>

						<? if( $_SESSION['nivel']>=3 ){ ?>
						<li class="barraLateral_cuerpoBarra_boton" > <img src="../_globales/images/perfil.png"><a href="../_includes-functions/sitio-en-construccion.php">Reportes</a></li>
						<? } ?>

						<? if( $_SESSION['nivel']>=3 ){ ?>
						<li class="barraLateral_cuerpoBarra_boton" > <img src="../_globales/images/perfil.png"><a href="../_includes-functions/sitio-en-construccion.php">Cartas Amarillas y rojas</a></li>
						<? } ?>

																</ul>
															</nav>

<?


		 if(DATE('j')>16){/*Del 01 al dia actual*/
                            /*Mes Actual*/
                            $desde=DATE('Y-m-16');
                          	$hasta=DATE('Y-m-d');
	                      }/*Del 01 al dia actual*/
		else{/*Del 16 al dia Actual*/
                          /*Mes Actual*/
                          $desde=DATE('Y-m-01');
                          $hasta=DATE('Y-m-d');
        }/*Del 16 al dia Actual*/

echo "<div id='contenedorMultas'>";




//echo $_SESSION['id_usuario']."<br>";
$conteo=1;
$dias_de_gracia=1;
$venta_minima_asistencia=0.6;

		/*Consulta de suma de ventas del Usuario en la fecha seleccionada agrupadas por dia*/
		$dias_de_ventas=$con->query("SELECT ventas.*,SUM(ventas.venta_usd) as suma_ventas_dia FROM ventas 
                                WHERE (ventas.fecha_creacion BETWEEN '".$desde." 00:00:00' AND '".$hasta." 23:59:59')
                                AND ventas.id_usuario='".$_SESSION['id_usuario']."' GROUP BY DAY(ventas.fecha_creacion)");
        while($row1=$dias_de_ventas->fetch_assoc()){/*WHILE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
        	
        	/*Fomateo de la fecha*/
        	$fecha_creacion=date_parse($row1['fecha_creacion']);
			$fecha_creacion=substr($meses[$fecha_creacion['month']-1],0,3).".".$fecha_creacion['day'];
			//echo $fecha_creacion."<br>";

			/*Dia de la semana*/
            $timestamp = strtotime($row1['fecha_creacion']);
            $dia_de_la_semana=date("w", $timestamp);   

            /*Verifica si el día consultado es hoy*/
            $fecha_consultada=(date_format(date_create($row1['fecha_creacion']),'Y-m-d'));

			/*Verificamos si el dia es dia de fiesta*/
	        $dia_de_fiesta=$con->query("SELECT * FROM dias_festivos WHERE fecha_festiva = DATE('".$row1['fecha_creacion']."')")->fetch_assoc();
          	$dia_de_fiesta=$dia_de_fiesta['fecha_festiva'];
          	//echo $dia_de_fiesta;

          	/*Modalidad de Trabajo de modelo*/
          	$modalidad_usuario=$con->query("SELECT * FROM usuarios WHERE id_usuario = ".$_SESSION['id_usuario']."")->fetch_assoc();
          	$modalidad_usuario=$modalidad_usuario['modalidad'];

			echo "<tr>";

				
				if( ($row1['suma_ventas_dia']<$venta_minima_asistencia) and ( ($dia_de_la_semana!='0') and ($dia_de_la_semana!='6') ) and empty($dia_de_fiesta) and $lafechaencolombia!=$fecha_consultada and $modalidad_usuario!=2){/*Si Faltó*/
					
					if($conteo<=$dias_de_gracia){/*Si fué día de gracia*/
					echo "<div class='contenedorMultas_letrero_free'><span id='contenedorMultas_letrero_fecha'>$fecha_creacion</span><img src='../_globales/images/corazoniconoblanco.png'><span>Free :)</span></div>";
					}/*Si fué día de gracia*/else{/*Si fué día de gracia*/
					echo "<div class='contenedorMultas_letrero'> <span id='contenedorMultas_letrero_fecha' >$fecha_creacion</span> <img src='../_globales/images/wrongiconsmallwhite.png'> <span>-10%</span></div>";
					}/*Si fué día de gracia*/
					
					$conteo++;

				}/*Si Faltó*/
				
				echo "</td>";
			echo "</tr>";

        }/*WHILE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/



		
		
echo "</div>";
?>

<div id="header">

	<p id="header_fechayhora"><?php echo date('l jS \of F Y h:i:s A'); ?></p>

	<span> | </span>

	<span> 
		<p style='display:inline;color: #9a004a; font-size: 14px;' >Valor Actual del dolar:
			<b style='font-family:HelveticaNeueLTStd-Bd;' >
				<?php
				echo /*"$".number_format($cop_val_inicial,0,'.','.')." COP / */ "$".number_format($cop_val_deducido,0,'.','.')." COP" 
				?> 
			</b>
		</p>
	</span>

	<div id="header_nombreUsuario"> <img src="../_globales/images/iconoperfil.png" > Hola! <? echo ucfirst($_SESSION['usuario']); ?></div>




	<form style="display:inline" id="salir" action="../usuario/boton_log_out.php" method="POST">

		<div id="header_botonSalir" ><input type="image" src="../_globales/images/iconosalida.png" ></div>

	</form>




	<?
//   BORRADO TEMPORALEMTE POR ERROR EN REDIRECCIONAMIENTO
//	/*ESTA OPERACION AYUDA A DEFINIR LA DIRECCION ACTUAL DE LA PERSONA*/
//		$pageURL = 'http';
//		if(isset($_SERVER["HTTPS"])){/*if isset*/ if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";} }/*if isset*/
//		 $pageURL .= "://";
//		 if ($_SERVER["SERVER_PORT"] != "80") {
//		  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
//		} else {
//		  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
//		}
//		
//		$link = $pageURL;
//		$_SESSION['links_para_log_in']=$pageURL;


	/*Se envia info a boton_log_out.php*/
	if(isset($_SESSION['general_id_lider_before'])){/*Si un lider esta disfrazado de modelo*/

		echo "<form id='volverAcuentaLider' action='../usuario/boton_volver_como_lider.php' method='POST'>";

		echo "<button id='header_botonCuentaLider' name='cambio_modelo_por_lider'>";
		echo "<p>Volver a cuenta lider</p>";
		echo "<img src='../_globales/images/iconocuentalider.png'>";
		echo "</button>";

		
		echo "</form>";
	}/*Si un lider esta disfrazado de modelo*/

	?>

</div>



</body>
</html>