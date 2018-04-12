<? include "../_includes-functions/conexion_improved.php";
include "../_includes-functions/seguridad.php"; 
include "../_includes-functions/funciones.php";
include '../_includes-functions/barraNavegacion.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>

	<link rel="stylesheet" type="text/css" href="../_globales/styles/resetcss.css">
	<link rel="stylesheet" type="text/css" href="../_includes-functions/styles/barraNavegacion.css">
	<link rel="stylesheet" type="text/css" href="../_includes-functions/styles/footer.css">
	<link rel="stylesheet" type="text/css" href="styles/formularioPlantilla.css">

</head>

<body>

	<div id="formularioPlantilla" >

		<h1 style="margin-bottom:25px;" ><img style="margin-right:10px; vertical-align:bottom;" src="../_globales/images/disenoperfiles.png">Diseños de perfil</h1>

		<form id="formularioPlantilla_formulario1" >

			<fieldset id="formularioPlantilla_formulario1_estilos">

				<table cellpadding="0" cellspacing="0" border="0" >  

					<tr>

						<td>
							<input type="radio" name="seleccionarEstilo" id="1" checked > <label for="1" ></label><img style="vertical-align:middle" src="../_globales/images/estilosdisenos/aquarela.jpg"> 
						</td>

						<td>
							<input type="radio" name="seleccionarEstilo" id="2"> <label for="2" ></label><img style="vertical-align:middle" src="../_globales/images/estilosdisenos/ilovecats.jpg">
						</td> 

						<td>
							<input type="radio" name="seleccionarEstilo" id="3"> <label for="3" ></label><img style="vertical-align:middle" src="../_globales/images/estilosdisenos/flowers.jpg">
						</td> 

					</tr>

				</table>

			</fieldset>

			<br> <img src="../_globales/images/separador.png">

			<p style="margin-top:15px" >En esta aplicación podrá optener un diseño predeterminado bastante llamativo para su perfil de chaturbate. Tan solo debe ingresar toda la información ubicada en el siguiente formulario y escoger el diseño que más se adapte a su personalidad.</p>

			<fieldset id="formularioPlantilla_formulario1_titulo">

				<legend>1. Nombre de usuario (titulo)</legend>

				<input class="allinputs" type="text" name="" style="width:370px;" placeholder="Ingrese aquí usuario de chaturbate" maxlength="33" >

			</fieldset>

			<fieldset id="formularioPlantilla_formulario1_sobreMi" >

				<legend>2. Sobre mi (about me)</legend>

				<textarea rows="7" cols="90" placeholder="Un texto de inspiración sobre sus gustos personales..." maxlength="830" ></textarea>

			</fieldset>

			<fieldset id="formularioPlantilla_formulario1_reglas" >

				<legend>3. Reglas de la sala (room rules) *Ingrese almenos 7 reglas: </legend>

				<table cellpadding="0" cellspacing="0" border="0" >

					<tr>
						<td>
							<input class="allinputs" type="text" style="width:423px; margin-right:15px;" name="" placeholder="Regla No.1"  maxlength="72"  >
						</td>
						<td>
							<input class="allinputs"  type="text" style="width:423px; margin-right:15px; " name="" placeholder="Regla No.2"  maxlength="72"  >
						</td>
					</tr>

					<tr>
						<td>
							<input class="allinputs" type="text" style="width:423px;" name="" placeholder="Regla No.3"  maxlength="72"  >
						</td>
						<td>
							<input class="allinputs" type="text" style="width:423px" name="" placeholder="Regla No.4"  maxlength="72"  >
						</td>
					</tr>

					<tr>
						<td>
							<input class="allinputs" type="text" style="width:423px" name="" placeholder="Regla No.5"  maxlength="72"  >
						</td>
						<td>
							<input class="allinputs" type="text" style="width:423px" name="" placeholder="Regla No.6"  maxlength="72"  >
						</td>
					</tr>

					<tr>
						<td>
							<input class="allinputs" type="text" style="width:423px" name="" placeholder="Regla No.7"  maxlength="72"  >
						</td>
						<td>
							<input class="allinputs" type="text" style="width:423px" name="" placeholder="Regla No.8"  maxlength="72"  >
						</td>
					</tr>

					<tr>
						<td>
							<input class="allinputs" type="text" style="width:423px" name="" placeholder="Regla No.9"  maxlength="72"  >
						</td>
						<td>
							<input class="allinputs" type="text" style="width:423px" name="" placeholder="Regla No.10"  maxlength="72"  >
						</td>
					</tr>

					<tr>
						<td>
							<input class="allinputs" type="text" style="width:423px" name="" placeholder="Regla No.11"  maxlength="72"  >
						</td>
						<td>
							<input class="allinputs" type="text" style="width:423px" name="" placeholder="Regla No.12"  maxlength="72"  >
						</td>
					</tr>

					<tr>
						<td>
							<input class="allinputs" type="text" style="width:423px" name="" placeholder="Regla No.13"  maxlength="72"  >
						</td>
						<td>
							<input class="allinputs" type="text" style="width:423px" name="" placeholder="Regla No.14"  maxlength="72"  >
						</td>
					</tr>

				</table>

			</fieldset>

			<fieldset id="formularioPlantilla_formulario1_menu" >

				<legend>4. Menú de tokens (tokens menu) Ingrese almenos 6 opciones: </legend>

				<table cellpadding="0" cellspacing="0" border="0" >

					<tr>
						<td>
							<input class="allinputs" type="text" style="width:423px; margin-right:15px;" name="" placeholder="Servicio No.1"  maxlength="40"  >
						</td>
						<td>
							<input class="allinputs"  type="text" style="width:423px; margin-right:15px; " name="" placeholder="Servicio No.2"  maxlength="40"  >
						</td>
					</tr>

					<tr>
						<td>
							<input class="allinputs" type="text" style="width:423px;" name="" placeholder="Servicio No.3"  maxlength="40"  >
						</td>
						<td>
							<input class="allinputs" type="text" style="width:423px" name="" placeholder="Servicio No.4"  maxlength="40"  >
						</td>
					</tr>

					<tr>
						<td>
							<input class="allinputs" type="text" style="width:423px" name="" placeholder="Servicio No.5"  maxlength="40"  >
						</td>
						<td>
							<input class="allinputs" type="text" style="width:423px" name="" placeholder="Servicio No.6"  maxlength="40"  >
						</td>
					</tr>

					<tr>
						<td>
							<input class="allinputs" type="text" style="width:423px" name="" placeholder="Servicio No.7"  maxlength="40"  >
						</td>
						<td>
							<input class="allinputs" type="text" style="width:423px" name="" placeholder="Servicio No.8"  maxlength="40"  >
						</td>
					</tr>

					<tr>
						<td>
							<input class="allinputs" type="text" style="width:423px" name="" placeholder="Servicio No.9"  maxlength="40"  >
						</td>
						<td>
							<input class="allinputs" type="text" style="width:423px" name="" placeholder="Servicio No.10"  maxlength="40"  >
						</td>
					</tr>

					<tr>
						<td>
							<input class="allinputs" type="text" style="width:423px" name="" placeholder="Servicio No.11"  maxlength="40"  >
						</td>
						<td>
							<input class="allinputs" type="text" style="width:423px" name="" placeholder="Servicio No.12"  maxlength="40"  >
						</td>
					</tr>

				

				</table>

			</fieldset>

			<fieldset id="formularioPlantilla_formulario1_privados" >

				<legend>4. Paquetes de show privado (Privates show packets)</legend>

				<label><b style="color:#4a4a4a" >Paquete de privado 1:</b></label>
				<span>Cantidad de minutos</span> <input class="allinputs" type="number" name="" style="width:70px" placeholder="0" > <span>Precio en tokens</span> <input  class="allinputs"  type="number" name="" style="width:70px" placeholder="0" >
				<br>
				<label><b style="color:#4a4a4a" >Paquete de privado 2:</b></label>
				<span>Cantidad de minutos</span> <input class="allinputs" type="number" name="" style="width:70px" placeholder="0" > <span>Precio en tokens</span> <input  class="allinputs"  type="number" name="" style="width:70px" placeholder="0" >
				<br>
				<label><b style="color:#4a4a4a" >Paquete de privado 3:</b></label>
				<span>Cantidad de minutos</span> <input class="allinputs" type="number" name="" style="width:70px" placeholder="0" > <span>Precio en tokens</span> <input  class="allinputs"  type="number" name="" style="width:70px" placeholder="0" >

			</fieldset>

			<fieldset id="formularioPlantilla_formulario1_fotos" >

				<legend>5. Suba almenos 6* fotografías personales tipo selfie</legend>

				<img src="../_globales/images/imagendemuestradisenoperfiles.jpg"><br>

				<label><b style="color:#4a4a4a" >Precio por el paquete de fotos</b></label>
				<input class="allinputs" type="number" name="" style="width:70px" placeholder="0" >

				<table cellpadding="0" cellspacing="12" border="0" >

					<tr>
						<td><label>Foto 1</label></td>
						<td><input type="file" name=""></td>
						<td><label>Foto 2</label></td>
						<td><input type="file" name=""></td>
					</tr>

					<tr>
						<td><label>Foto 1</label></td>

						<td><input type="file" name=""></td>
						<td><label>Foto 2</label></td>
						<td><input type="file" name=""></td>
					</tr>

					<tr>
						<td><label>Foto 1</label></td>

						<td><input type="file" name=""></td>
						<td><label>Foto 2</label></td>
						<td><input type="file" name=""></td>
					</tr>

				</table>

			</fieldset>

			<fieldset id="formularioPlantilla_formulario1_redes1" >

				<legend>6. Lista de deseos de Amazon, y redes sociales</legend>
				<p style="margin-top:10px; margin-bottom:10px;" >Ingrese a continuación las URL correspondientes. Si no sabe como hacerlo  <b>mire el siguiente tutorial.</b></p>

				<table cellspacing="5" >
					<tr>
						<td><img src="../_globales/images/redes/amazon.jpg"></td>
						<td><input class="biginput" type="text" name="" placeholder="http://amzn.com/w/3FPGJSXDU"></td>
					</tr>
					<tr>
						<td><img src="../_globales/images/redes/twitter.jpg"></td>
						<td><input class="biginput" type="text" name="" placeholder="https://twitter.com/nombremodelo"></td>
					</tr>
					<tr>
						<td><img src="../_globales/images/redes/instagram.jpg"></td>
						<td><input class="biginput" type="text" name="" placeholder="https://instagram.com/usuariomodelo"></td>
					</tr>
					<tr>
						<td><img src="../_globales/images/redes/facebook.jpg"></td>
						<td><input class="biginput" type="text" name="" placeholder="https://www.facebook.com/usuariomodelo"></td>
					</tr>
				</table>

			</fieldset>

			<fieldset id="formularioPlantilla_formulario1_redes2">

				<legend>7. Vende snapchat y whatsapp (Sell your snapchat and whatsapp) : </legend>
				<p style="margin-top:10px; margin-bottom:10px;" >Ingrese el precio de las redes privadas que desea vender.</p>

				<table cellspacing="5" >
					<tr>
						<td><img style="vertical-align:middle;" src="../_globales/images/redes/snapchat.jpg"><b style="margin-left:10px; font-family: HelveticaNeueLTStd-Lt" >Precio en tokens (Snapchat)</b></td>
						<td><input class="allinputs" type="text" name="" placeholder="0" style="width:80px;" ></td>
					</tr>

					<tr>
						<td><img style="vertical-align:middle;" src="../_globales/images/redes/whatsapp.jpg"><b style="margin-left:10px; font-family: HelveticaNeueLTStd-Lt" >Precio en tokens (Whatsapp)</b></td>
						<td><input class="allinputs" type="text" name="" placeholder="0" style="width:80px;" ></td>
					</tr>	

				</table>

			</fieldset>

			<fieldset  id="formularioPlantilla_formulario1_contenidoPersonaliado" >

				<legend>8. Venta de videos y fotos personalizadas (Sell personalized photos and videos)</legend>
				<p style="margin-top:10px; margin-bottom:10px;" >Con este modulo podrá vender fotos y videos a sus clientes. Solo configure el precio y la cantidad de fotos o duración del video.</p>

				<label><b style="color:#4a4a4a" >Video porsonalizado:</b></label>
				<span>Cantidad de minutos del video</span> <input class="allinputs" type="number" name="" style="width:70px" placeholder="0" > <span>Precio en tokens</span> <input  class="allinputs"  type="number" name="" style="width:70px" placeholder="0" >
				<br>
				<label><b style="color:#4a4a4a" >Paquete de fotos personalizadas:</b></label>
				<span>Cantidad de fotos</span> <input class="allinputs" type="number" name="" style="width:70px" placeholder="0" > <span>Precio en tokens</span> <input  class="allinputs"  type="number" name="" style="width:70px" placeholder="0" >

			</fieldset>

			<input style="width:415px; margin-top:60px; margin-bottom:50px;" class="bigcta" id="formularioPlantilla_formulario1_generarplantilla" type="submit" name='enviar' value="Generar Plantilla >" ></input>

		</form>

	</div>

	<?php include '../_includes-functions/footer.php';?>

</body>
</html>