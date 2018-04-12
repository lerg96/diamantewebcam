<?
include "../_includes-functions/conexion_improved.php";
include "../_includes-functions/seguridad.php"; 
include "../_includes-functions/funciones.php";
//include '../_includes-functions/barraNavegacion.php';
$id_usuario=$_GET['usuario'];
$_SESSION['estadisticaslider_desde']=$_GET['inicio'];
//echo $_SESSION['estadisticaslider_desde']."<br>";
$_SESSION['estadisticaslider_hasta']=$_GET['final'];
//echo $_SESSION['estadisticaslider_hasta']."<br>";
$_SESSION['estadisticaslider_modelo']=$id_usuario;
//echo $_SESSION['estadisticaslider_modelo']."<br>";
?>
<!DOCTYPE html>
<html>
<head>
<script>
function loaded()
{
    //window.print();
    window.setTimeout(CloseMe, 100000);
}

function CloseMe() 
{
    window.close();
}
</script>

	<title>Imprimir Reporte</title>
	<link rel="stylesheet" type="text/css" href="../_globales/styles/resetcss.css">

	<style type="text/css">
		
		#reporteModelos{
			background-color: whitesmoke;
			width: 900px;
			margin: auto;
			margin-bottom: 20px;
			padding: 20px;
		}
		table {font-family: HelveticaNeueLTStd-Lt; }
		#reporteModelos_tabla1 td {height: 25px; width: 50%; padding-left:10px; border-color:#efefef; }
		#reporteModelos_tabla2 td { height: 25px; width: 70px;  padding-left:10px; }
		.bolder{font-family: HelveticaNeueLTStd-Bd; font-size: 18px;}
		.redcolor{color:#700013 }

	</style>


</head>
<body onLoad="loaded()">

	<div id="reporteModelos">
<?
include("../_includes-functions/madre_de_estadisticas.php");
?>
    <form style='text-align:center;'>
	<input type="button" value="Imprimir Reporte" onClick="window.print()">
	</form>

		<div> <img src="../_globales/images/headerReporteVentasModelos.jpg">  </div>

		<table id="reporteModelos_tabla1" cellspacing="0" cellspacing="0" border="0" bgcolor="white" width="100%" >
			
			<tr>
				<td >Sede</td>
				<?
				$nombre_estudio=$con->query("SELECT nombre_estudio FROM estudios WHERE id_estudio='".$estudio_usuario[$id_usuario]."'")->fetch_assoc();
				$nombre_estudio=$nombre_estudio['nombre_estudio'];
				if($nombre_estudio==''){$nombre_estudio='Sin Estudio';}

				?>
				<td class="redcolor"><? echo ucfirst($nombre_estudio);?></td>
			</tr>

			<tr>
				<td>Beneficiario</td>
				<td class="redcolor"><? echo $nombres_usuario[$id_usuario]; ?></td>
			</tr>

			<tr>
				<td>Periodo de facturación</td>
				<td class="redcolor"><? echo "Del ".date_format(date_create($_SESSION['estadisticaslider_desde']),'d/m/Y')." Al ".date_format(date_create($_SESSION['estadisticaslider_hasta']),'d/m/Y'); ?></td>
			</tr>

			<tr>
				<td>Total dolares facturados</td>
				<td class="redcolor">$<? echo number_format($suma_ventas_por_usuario_usd[$id_usuario],2,'.','.'); ?> USD</td>
			</tr>
 
			<tr>
				<td>Promedio de ventas diario</td>
				<td class="redcolor">$<? echo number_format($promedio_ventas_modelos_usd,2,'.','.'); ?> USD</td>
			</tr>

			<tr class="bolder" >
				<td><? echo $pocerntaje_pago[$id_usuario]; ?>% para modelo</td>
				<td class="redcolor">$<? echo number_format($pago_inicial_usd[$id_usuario],2,'.','.'); ?> USD</td>
			</tr>

			<tr>
				<td>Total Inacistencias</td>
				<td class="redcolor"><? echo $conteo_rojos_por_usuario[$id_usuario]; ?></td>
			</tr>

			<tr>
				<td>Total Dias Penalizables</td>
				<td class="redcolor"><? echo $dias_penalizables[$id_usuario]; ?></td>
			</tr>

			<tr>
				<td>Total Porcentaje a Descontar</td>
				<td class="redcolor">-<? echo $porcentaje_descontable[$id_usuario]; ?>%</td>
			</tr>

			<tr class="bolder">
				<td>Pago con Descuentos</td>
				<td class="redcolor">$ <? echo number_format($pago_final_usd[$id_usuario],2,'.','.'); ?> USD</td>
			</tr>

			<tr>
				<td>TRM dolar</td>
				<td class="redcolor">$ <? echo number_format($cop_val_deducido,0,'.','.'); ?> COP</td>
			</tr>

			<tr class="bolder">
				<td>Total a pagar en pesos modelo</td>
				<td class="redcolor">$ <? echo number_format($pago_final_usd[$id_usuario]*$cop_val_deducido,0,'.','.'); ?> COP</td>
			</tr>

		</table>

		<br><img src="../_globales/images/separador.png"><br>

		<h1 style="margin-top:15px; margin-bottom:15px; color:#700013;" ><img src="../_globales/images/sheeticon.png"> Resumen de ventas por día</h1>
		<table id="reporteModelos_tabla2" cellspacing="0" cellspacing="0" border="1" bgcolor="white" width="100%" style="border-color:#dadada;" >
		
		<?
		$dias_de_ventas=$con->query("SELECT ventas.*,SUM(ventas.venta_usd) as suma_ventas_dia FROM ventas 
                                WHERE (ventas.fecha_creacion BETWEEN '".$_SESSION['estadisticaslider_desde']." 00:00:00' AND '".$_SESSION['estadisticaslider_hasta']." 23:59:59')
                                AND ventas.id_usuario='".$id_usuario."' GROUP BY DAY(ventas.fecha_creacion)");
        while($row1=$dias_de_ventas->fetch_assoc()){/*WHILE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
        	
        	$fecha_creacion=date_parse($row1['fecha_creacion']);
			$fecha_creacion=$fecha_creacion['day']." de ".$meses[$fecha_creacion['month']-1];

			 /*Verificamos si el dia es dia de fiesta*/
	        $dia_de_fiesta=$con->query("SELECT * FROM dias_festivos WHERE fecha_festiva = DATE('".$row1['fecha_creacion']."')")->fetch_assoc();
          	$dia_de_fiesta=$dia_de_fiesta['fecha_festiva'];
          	//echo $dia_de_fiesta;

			echo "<tr>";
				echo "<td>$fecha_creacion</td>";
				echo "<td>$ ".$row1['suma_ventas_dia']." USD</td>";
				echo "<td>";
				if(!empty($dia_de_fiesta)){echo "<span style='color:#007FDD;'>- Día <b style='font-family:HelveticaNeueLTStd-Bd'>NO</b> laborable -</span>";}
				elseif($row1['suma_ventas_dia']<$venta_minima_asistencia){echo "<b style='color:#FF2222;'>- </nav><img style='margin-right:5px;' src='../_globales/images/wrongiconsmall.png'>Inacistencia -</b>";}
				
				echo "</td>";
			echo "</tr>";

        }/*WHILE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
        ?>
		
			
			



		</table>	

	</div>

</body>
</html>