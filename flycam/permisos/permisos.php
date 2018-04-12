<?
include '../_includes-functions/barraNavegacion.php';
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../_globales/styles/resetcss.css">
	<link rel="stylesheet" type="text/css" href="../_includes-functions/styles/barraNavegacion.css">
	<link rel="stylesheet" type="text/css" href="../_includes-functions/styles/footer.css">
	<link rel="stylesheet" type="text/css" href="styles/permisos.css">


	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

	<script> 
		if () { $(document).ready(function(){
			$(".editIcon").click(function(){
				$("#permisos_cuerpo_contenedorTabla").slideToggle("slow");
			}); 
		}); 
	}

if () { $(document).ready(function(){
			$(".editIcon").click(function(){
				$("#permisos_cuerpo_contenedorTabla").slideToggle("slow");
			}); 
		}); 
	}

	</script>

	<title>Permisos de aplicaciones</title>
</head>
<body>

	<div id="permisos_cuerpo">

		<img id="permisos_cuerpo_permisosIcono" src="../_globales/images/permisosicono.png"><h1 style="display: inline;">Permisos de aplicaciones</h1>

		<br>

		<!-- COMIENZA Formulario para crear aplicaciones -->

		

		<form id="permisos_cuerpo_formulario1"> 
			<table cellpadding="0" cellspacing="0"  width="650" style="" >
				<tr>
					<td>
						<label>Quiero crear:</label>
					</td>
					<td>
						<select name=''>
							<option>Aplicación</option>
							<option>Sub Aplicación</option>
							<option>Fragmento</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label><b>Ruta de la aplicación</b></label>
					</td>
					<td>
						<input type="text" name="" placeholder="Ingrese la URL de la app" >
					</td>

				</tr>

				<tr>

					<td>
						<label>Nombre personalizado</label>
					</td>
					<td>

						<input type="text" name="" placeholder="Ingrese un nombre personalizado" >
					</td>


				</tr>
				<tr>
					<td>
						<input class="allinputs" id="permisos_cuerpo_formulario1_boton" type="submit" name='enviar' value="Crear aplicación >" >
					</td> 
				</tr>
			</table>   
		</form>   

		<!-- TERMINA Formulario para crear aplicaciones -->

		<!-- COMIENZA Formulario para crear sub aplicaciones -->

		<form id="permisos_cuerpo_formulario1"> 
			<table cellpadding="0" cellspacing="0"  width="650" style="" >
				<tr>
					<td>
						<label>Quiero crear:</label>
					</td>
					<td>
						<select name=''>
							<option>Sub Aplicación</option>
							<option>Aplicación</option>
							<option>Fragmento</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label><b>Ruta de la aplicación</b></label>
					</td>
					<td>
						<input type="text" name="" placeholder="Ingrese la URL de la app" >
					</td>

				</tr>

				<tr>

					<td>
						<label>Nombre personalizado</label>
					</td>
					<td>

						<input type="text" name="" placeholder="Ingrese un nombre personalizado" >
					</td>


				</tr>
				<tr>
					<td>
						<input class="allinputs" id="permisos_cuerpo_formulario1_boton" type="submit" name='enviar' value="Crear aplicación >" >
					</td> 
				</tr>
			</table>   
		</form>   

		<!-- TERMINA Formulario para crear sub aplicaciones -->

		<br><img src="../_globales/images/separador.png"> <br><br>





		<div id="permisos_cuerpo_contenedorTabla" style="display:none;"  > <!-- ABRE permisos_cuerpo_contenedorTabla -->
			<table id="permisos_cuerpo_contenedorTabla_tablapermisos" cellspacing="8" cellpadding="0" height="141" border="0" >
				<thead>
					<tr class="tr" >
						<td style="text-align:center; font-size:17px; color:white;" colspan="18"  >Añadir o remover usuarios</td>
					</tr>
				</thead>
				<tr style="height:60px; text-align: middle; " >
					<td colspan="10">
						<form id="permisos_cuerpo_contenedorTabla_tablapermisos_formularioAñadirUsuario" > 
							<label><b> + Añadir usuarios </b></label>
							<input style="height:30px; width:320px " type="text" name="" placeholder="Digite uno o varios usuarios serparados por comas (,)" > 
							<input id="botonAñadirUsuarios" type="submit" name="" value="+">
						</form>
					</td>
					<tr>
						<td>Mauricio </td> <td> <img class="botonBorrar" src="../_globales/images/wrongicon.png"  ></td>
						<td>Mariana  </td> <td> <img class="botonBorrar"  src="../_globales/images/wrongicon.png" ></td>
						<td>N ombrelargo </td> <td> <img class="botonBorrar" src="../_globales/images/wrongicon.png"  ></td>
						<td>NombreCorte </td> <td> <img class="botonBorrar" src="../_globales/images/wrongicon.png" ></td>
						<td>Cualquiernombre </td> <td> <img class="botonBorrar" src="../_globales/images/wrongicon.png" ></td>
						<td>Unapalabra </td> <td> <img class="botonBorrar" src="../_globales/images/wrongicon.png"  ></td>
						<td>DosPalabras </td> <td> <img class="botonBorrar" src="../_globales/images/wrongicon.png" ></td>
						<td>Mauricio </td> <td> <img class="botonBorrar" src="../_globales/images/wrongicon.png"></td>
						<td>JuanCarlos </td> <td> <img class="botonBorrar" src="../_globales/images/wrongicon.png"  ></td>
					</tr>

					<tr>
						<td>Sergio </td> <td> <img class="botonBorrar" src="../_globales/images/wrongicon.png" ></td>
						<td>Mrlaa  </td> <td> <img class="botonBorrar" src="../_globales/images/wrongicon.png" ></td>
						<td>cata </td> <td> <img class="botonBorrar" src="../_globales/images/wrongicon.png"  ></td>
						<td>Nombre </td> <td> <img class="botonBorrar" src="../_globales/images/wrongicon.png" ></td>
						<td>Cuernombre </td> <td> <img class="botonBorrar" src="../_globales/images/wrongicon.png" ></td>
						<td>Upabra </td> <td> <img class="botonBorrar" src="../_globales/images/wrongicon.png"  ></td>
						<td>Dosabras </td> <td> <img class="botonBorrar" src="../_globales/images/wrongicon.png" ></td>
						<td>Maufdfdricio </td> <td> <img class="botonBorrar" src="../_globales/images/wrongicon.png" ></td>
						<td>JuanClos </td> <td> <img class="botonBorrar" src="../_globales/images/wrongicon.png" ></td>
					</tr>


					<tr>
						<td>felipe </td> <td> <img class="botonBorrar" src="../_globales/images/wrongicon.png" ></td>
						<td>Mpipea  </td> <td> <img class="botonBorrar" src="../_globales/images/wrongicon.png" ></td>
						<td>Ndfelargo </td> <td> <img class="botonBorrar" src="../_globales/images/wrongicon.png"  ></td>
						<td>breCorte </td> <td> <img class="botonBorrar" src="../_globales/images/wrongicon.png"  ></td>
						<td>Cualquiernombre </td> <td> <img class="botonBorrar" src="../_globales/images/wrongicon.png"  ></td>
						<td>Undfalabra </td> <td> <img class="botonBorrar" src="../_globales/images/wrongicon.png"></td>
						<td>DosPddalabras </td> <td> <img class="botonBorrar" src="../_globales/images/wrongicon.png"  ></td>
						<td>Mauio </td> <td> <img class="botonBorrar" src="../_globales/images/wrongicon.png" ></td>
						<td>JuCarlos </td> <td> <img class="botonBorrar" src="../_globales/images/wrongicon.png" ></td>
					</tr>





				</table> 
			</div> <!-- CIERRA permisos_cuerpo_contenedorTabla -->


			<table id="permisos_cuerpo_contenedorTabla_tablaPrincipal" cellspacing="0" cellpadding="5" border="1" >
				<thead>

					<tr style="color:white;" class="tr" >
						<td>Cod.</td>
						<td>Aplicación</td>
						<td>Sub Aplicación</td>
						<td>Fracción</td>
						<td>Usuarios</td>
					</tr>

				</thead>

				<tr>
					<td>122</td>
					<td>Ingresar Vena Diaria</td>
					<td></td>
					<td></td>
					<td><img class="editIcon" src="../_globales/images/editicon.jpg"></td>
				</tr>

				<tr>
					<td>133</td>
					<td>Ingresar Venta diaria</td>
					<td></td>
					<td>Botón borrar ventana</td>
					<td><img class="editIcon" src="../_globales/images/editicon.jpg"></td>
				</tr>

				<tr>
					<td>144</td>
					<td>Estadisticas</td>
					<td>Estadisticas Lider</td>
					<td>Botón editar</td>
					<td><img class="editIcon" src="../_globales/images/editicon.jpg"></td>
				</tr>


			</table> 





		</div>

		<?php include '../_includes-functions/footer.php';?>

	</body>
	</html>