<?
/*Sesion*/
session_start();

/*Includes*/
include "../_includes-functions/conexion_improved.php";
include "../_includes-functions/funciones.php";

/*Verificacion de si es Android, 8100, 7100*/
//$useragent=$_SERVER['HTTP_USER_AGENT'];
//$esandroid = strpos($useragent,"Android");
//if($esandroid == true){/*if es Android*/$_SESSION['es_android']=true;}/*if es Android*/



if(isset($_POST['enviar'])){/*Post*/
			


			
			$usuario_in=strtolower(trim($_POST['usuario']));
			//echo $usuario_in."<br>";
			
			$password_in=strtolower(trim($_POST['password']));
			//echo $password_in."<br>";

			/*Si Usuario no es 0*/
			if($usuario_in!=''){/*Si Se Anota Usuario*/

						if(isset($_SESSION['verificacion_base_datos2'])){/*Se pudo conectar a la base de datos del estudio1*/
									//echo "hey1<br>";

									if($_SESSION['verificacion_base_datos2']==true){/*Se pudo conectar a la base de datos del estudio2*/
												//echo "hey2<br>";			
												
												/*Selection of Level of the user*/
												$data=$con->query("SELECT * FROM usuarios WHERE usuario='$usuario_in' AND estado =1");
												
												/*Si Existe Usuario*/
												if($data->num_rows > 0){
															$data=$data->fetch_assoc();
															$password=$data['password'];
															
															/*SE PONE LA COOKIE DEL ULTIMO USUARIO*/
															$last_user_time = time()+31536000;
															$last_user_value = $usuario_in;
															setcookie("last_user",$last_user_value, $last_user_time, "/");
															
															/*Comparing Passwords*/
															if($password==$password_in){/*if hay match*/
																	
																	/*Sesiones*/
																	$_SESSION['logueado']=true;
																	$_SESSION['nombre']=$data['nombres'];
																	$_SESSION['usuario']=$data['usuario'];
																	$_SESSION['nivel']=$data['nivel'];
																	$_SESSION['id_usuario']=$data['id_usuario'];
																	$_SESSION['permiso_de_acceso']='yes';
																	
																	//if($esandroid == true){/*if es Android*/
																	//			$expiretime = time()+60*60*24*30;
																	//			$name_cookie ="LongValue";
																	//			$value_cookie =$usuario;
																	//			setcookie($value_name,$value_name, $expiretime, '/');
																	//			echo"LOG IN CORRECTO ANDROID: $usuario_in";
																	//			echo"<script>window.location.href='../ventas/ventas.php'</script>";
																	//			die();
																	//}/*if es Android*/else{/*Es PC*/
																				echo"LOG IN CORRECTO PC: $usuario_in</br>";
																				echo"<script>window.location.href='../ventas/ventas.php'</script>";
																				die();
																	//}/*Es PC*/
																																				  
															}/*if hay match*/
															else {/*if hay match*/ 
																		$_SESSION['alerta'][]='Usuario y/o Contraseña INVALIDOS!!!';
																		/*Se borra la session de la misma para que permita volver a iniciar session*/
																		unset($_SESSION['nombre_base']);
															}/*if hay match*/
												
												}/*Si Existe Usuario*/
												else {/*Si Existe Usuario*/ 
															$_SESSION['alerta'][]='Usuario NO Existe!!!';
															/*Se borra la session de la misma para que permita volver a iniciar session*/
															unset($_SESSION['nombre_base']);
						
												}/*Si Existe Usuario*/

									}/*Se pudo conectar a la base de datos del estudio1*/

						}/*Se pudo conectar a la base de datos del estudio2*/
			
			}/*Si Se Anota Usuario*/
			else {/*Si Se Anota Usuario*/ 
						$_SESSION['alerta'][]='Usuario no puede estar vacio!!!';
						/*Se borra la session de la misma para que permita volver a iniciar session*/
						unset($_SESSION['nombre_base']);
		}/*Si Se Anota Usuario*/
}/*Post*/

/*codigo de marcada de asistencia con scanner*/
//include "../empleados/asistencia_con_scanner.php";

?>

<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" type="text/css" href="../_globales/styles/resetcss.css">
        <LINK rel="stylesheet" type="text/css" href="styles/login.css"  >

            <title></title>

        

        </head>
        <body>
			
           <nav id="usuario_barraNavegacion"> 
               <a id="usuario_barraNavegacion_logomodelos" href=""><img src="../_globales/images/logomarilyn.png"></a>
               <!--
               <a href="" > <img id="usuario_barraNavegacion_botonRegistro" src="images/botonregistro.png"></a>
               -->
               <!--
               <img id="usuario_barraNavegacion_whatsapp" src="images/whatsapp.png">
               -->
           </nav>

           <form action="" method='POST' id="usuario_formularioInicioSesion">

            <h1 id="usuario_formularioInicioSesion_titulo">Inicio de sesión</h1>
            
			<?
			include "../_includes-functions/foreach_alerta.php";
			?>


 <select id="usuario_formularioInicioSesion_select" name='estudio' style="  width: 223px;text-align: center;border-style: unset;color: #484848;padding: 3px;border-width: 0px;" > 
 <option value='Seleccione Un Estudio'>Seleccione Un Estudio</option>";
<?			
echo"111111";
			/*Dependiendo del Servidor separametrizan ciertos liks y permisos de acceso*/
			if(preg_match("/192.168.0.121|192.168.0.110|192.168.0.122|localhost|192.168.0.123|192.168.0.124|192.168.0.125|192.168.0.126|192.168.0.127|:86|:85|:84|:83|:82/",$_SERVER['HTTP_HOST'])){/*Prueba*/
		
						$con = new mysqli('localhost','flycam_user','Tao74857485','base_estudios1');
						if($con->connect_errno > 0){/*Posible error*/
													die('No se pudo conectar a la base de datos1, llama a Mauricio Cel: 3003139330. Error: '. $con->connect_error .'');
						}/*Posible error*/
			}/*Prueba*/else{/*Produccion*/

						$con = new mysqli('107.180.56.178','flycam_user','Tao74857485','base_estudios1');
						if($con->connect_errno > 0){/*Posible error*/
													die('No se pudo conectar a la base de datos1, llama a Mauricio Cel: 3003139330. Error: '. $con->connect_error .'');
						}/*Posible error*/
			}/*Produccion*/

			/*Populacion de Select con estudios existentes*/
			$popu_estudios=$con->query("SELECT * from bases_datos");
			while ($row=$popu_estudios->fetch_assoc()) {/*While*/
			
			echo "<option value='".$row['id_base_dato']."'>".$row['nombre_estudio']."</option>";

			}/*While*/
?>
            


            </select> <br><br>

            <input id="usuario_formularioInicioSesion_usuario" autocomplete='off' <? if(isset($_COOKIE['last_user'])){echo "value='".$_COOKIE['last_user']."'";} ?> maxlength="20" onkeypress='return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode = 188))' placeholder="Usuario" type="text" name="usuario" ></input> <br>
            <input id="usuario_formularioInicioSesion_password" autocomplete='off' maxlength="11" onkeypress='return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 13))' autocomplete='off' placeholder="Contraseña" type="password" name="password" ></input>
            <br><br>
            
            <a id="usuario_formularioInicioSesion_reestablecercontraseña" href="">No recuerdo mi contraseña</a>
            <br>
            <input id="usuario_formularioInicioSesion_iniciarSesion" value="Iniciar Sesión" name='enviar' type="submit"> 

            <p style="margin-bottom: 20px; text-align:center;" id="usuario_formularionInicioSesion_parraforegistro" >¿Aun no tiene cuenta en Marilyn?  <a href="">Click Aquí</a><br>
                para comunicarte con nosotros y abrir tu propia cuenta.</p>

            </form>


        </body>
        </html>