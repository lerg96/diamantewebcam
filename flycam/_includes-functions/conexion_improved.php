<?
/*si no hay session se comienza*/
if(session_id()==''){
session_start();
}

/*Dependiendo del Servidor separametrizan ciertos liks y permisos de acceso*/
if(preg_match("/192.168.0.121|192.168.0.110|192.168.0.122|localhost|192.168.0.123|192.168.0.124|192.168.0.125|192.168.0.126|192.168.0.127|:86|:85|:84|:83|:82/",$_SERVER['HTTP_HOST'])){/*Prueba*/
	echo "<h1 style='Position:absolute;top:0px;right:0px;font-size:20px;background-color:bisque;'>SERVIDOR DE PRUEBA</h1>";

				//echo "Prueba<br>";
				/*Si no existe $_SESSION[id_estudio] Se conecta a base de datos "Estudios" para consultar el nombre de la base de datos del estudio requerido por el usuario en el select del login*/
				if(!isset($_SESSION['nombre_base']) and isset($_POST['estudio'])){/*Si no existe $_SESSION[id_estudio]*/
							
							//echo "Si hay estudio y no se envio<br>";
							/*Conexion a base de datos 1*/
							$con = new mysqli('localhost','mwcc','Tao74857485','base_estudios');
							
							/*Manejo de errores de conexion*/
							if($con->connect_errno > 0){/*Posible error*/
										die('No se pudo conectar a la base de datos1, llama a Mauricio Cel: 3003139330. Error: '. $con->connect_error .'');
							}/*Posible error*/
							
							/*Verificacion de la base de datos seleccionada por el usuario en el SELECT*/
							if(isset($_POST['estudio']) and is_numeric($_POST['estudio']) ){/*Si se envio un $_POST['id_estudio'] y es numerico*/
									
										/*Selection of name of database*/
										$estudio=$con->query("SELECT * FROM bases_datos WHERE id_base_dato='".$_POST['estudio']."' AND estado =1");
										
										/*Si Se puede traer el nomnbre de la base de datos*/
										if($estudio->num_rows > 0){/*Si exite base de datos inscrita*/
							
													$data=$estudio->fetch_assoc();
													
			
													$_SESSION['nombre_base']=$data['nombre_base'];
			
													
										}/*Si exite base de datos inscrita*/
										else{/*Si exite base de datos inscrita*/
			
													$_SESSION['alerta'][]='El estudio No existe.';
			
										}/*Si exite base de datos inscrita*/
			
							}/*Si se envio un $_POST['id_estudio'] y es numerico*/
							else{/*Si NO se envio un $_POST['id_estudio'] y NO es numerico*/
			
										$_SESSION['alerta'][]='Debes seleccionar un estudio';
				
							}/*Si NO se envio un $_POST['id_estudio'] y NO es numerico*/
			

				}/*Si no existe $_SESSION[id_estudio]*/


							
							/*DATOS PARA CONEXION A BASE DE DATOS2*/
							$conexion_sitios['mwcc']='http://192.168.0.108/';
							//echo $conexion_sitios['mwcc'];
							/*DataBase*/
							$conexion_sitios['database_user']='mwcc';
							//echo $conexion_sitios['database_user'];
							/*Base de datos del estudio de estudio*/
							if(isset($_SESSION['nombre_base'])){
								$conexion_sitios['database_name']=$_SESSION['nombre_base'];/*Este es el nombre de estudio extraido de la base de datos1*/
								//echo $conexion_sitios['database_name'];
							}
							$conexion_sitios['database_pass']='Tao74857485';
							//echo $conexion_sitios['database_pass'];
							/*DataBase*/
							$conexion_sitios['database_dir']='localhost';
							//echo $conexion_sitios['database_dir'];


				
				


	
/*Prueba*/}else{/*Producion*/
				
				/*Si no existe $_SESSION[id_estudio] Se conecta a base de datos "Estudios" para consultar el nombre de la base de datos del estudio requerido por el usuario en el select del login*/
				if(!isset($_SESSION['nombre_base']) and isset($_POST['estudio'])){/*Si no existe $_SESSION[id_estudio]*/
							
							/*Conexion a base de datos 1*/
							$con = new mysqli('107.180.56.178','flycam_user','Tao74857485','base_estudios');
							
							/*Manejo de errores de conexion*/
							if($con->connect_errno > 0){/*Posible error*/
										die('No se pudo conectar a la base de datos1, llama a Mauricio Cel: 3003139330. Error: '. $con->connect_error .'');
							}/*Posible error*/
							
							/*Verificacion de la base de datos seleccionada por el usuario en el SELECT*/
							if(isset($_POST['estudio']) and is_numeric($_POST['estudio']) ){/*Si se envio un $_POST['id_estudio'] y es numerico*/
									
										/*Selection of name of database*/
										$estudio=$con->query("SELECT * FROM bases_datos WHERE id_base_dato='".$_POST['estudio']."' AND estado =1");
										
										/*Si Se puede traer el nomnbre de la base de datos*/
										if($estudio->num_rows > 0){/*Si exite base de datos inscrita*/
							
													$data=$estudio->fetch_assoc();
												
			
													$_SESSION['nombre_base']=$data['nombre_base'];
			
													
										}/*Si exite base de datos inscrita*/
										else{/*Si exite base de datos inscrita*/
			
													$_SESSION['alerta'][]='El estudio No existe.';
			
										}/*Si exite base de datos inscrita*/
			
							}/*Si se envio un $_POST['id_estudio'] y es numerico*/
							else{/*Si NO se envio un $_POST['id_estudio'] y NO es numerico*/
			
										$_SESSION['alerta'][]='Debes seleccionar un estudio';
				
							}/*Si NO se envio un $_POST['id_estudio'] y NO es numerico*/
			
			
				}/*Si no existe $_SESSION[id_estudio]*/


							
							/*DATOS PARA CONEXION A BASE DE DATOS2*/
							$conexion_sitios['mwcc']='http://wwww.modeloswebcam.com.co/';
							//echo $conexion_sitios['mwcc'];
							/*DataBase*/
							$conexion_sitios['database_user']='flycam_user';
							//echo $conexion_sitios['database_user'];
							/*Base de datos del estudio de estudio*/
							if(isset($_SESSION['nombre_base'])){
								$conexion_sitios['database_name']=$_SESSION['nombre_base'];/*Este es el nombre de estudio extraido de la base de datos1*/
								//echo $conexion_sitios['database_name'];
							}
							$conexion_sitios['database_pass']='Tao74857485';
							//echo $conexion_sitios['database_pass'];
							/*DataBase*/
							$conexion_sitios['database_dir']='107.180.56.178';
							//echo $conexion_sitios['database_dir'];
}/*Producion*/


//echo "<pre>";
//print_r($conexion_sitios);
//echo "</pre>";

date_default_timezone_set("America/Bogota");


/*CONEXION A BASE DE DATOS 2*/
if(isset($_SESSION['nombre_base'])){/*Si hay un nombre de estudio*/
//echo $_SESSION['nombre_base']."<br>";
			/*CHECKEAMOS SI LA BASE DE DATOS DEL ESTUDIO EXISTE*/
			$con = new mysqli($conexion_sitios['database_dir'],$conexion_sitios['database_user'],$conexion_sitios['database_pass']);
			$estudio=$con->query("SHOW DATABASES LIKE '".$_SESSION['nombre_base']."';");
			if($estudio->num_rows > 0){/*La base de datos si existe*/

						/*La base de datos si existe*/
						//echo "La base de datos2 si existe";
						
						/*CONEXION A BASE DE DATOS 2*/
						$con = new mysqli($conexion_sitios['database_dir'],$conexion_sitios['database_user'],$conexion_sitios['database_pass'],$conexion_sitios['database_name']);
						
						if($con->connect_errno > 0){/*Error*/
									include ('../usuario/boton_log_out.php');
									die('No se pudo conectar a la base de datos2, llama a Mauricio Cel: 3003139330. Error: '. $con->connect_error .'');
						}/*Error*/else{/*ok*/
									/*Variable que se tiene para verificar que si se pudo conectar a la base de datos del estudio*/
									$_SESSION['verificacion_base_datos2']=true;
									//print_r($_SESSION['verificacion_base_datos2'])."<br>";
						}/*ok*/




			}/*La base de datos si existe*/
			else{/*No existe la Base de datos*/

				/*Ya que no existe la base de datos del estudio se borra la session de la misma para que permita volver a iniciar session*/
				unset($_SESSION['nombre_base']);

			}/*No existe la Base de datos*/
			


}/*Si hay un nombre de estudio*/
//die();

//PHP FECHA Y HORA DE COLOMBIA
date_default_timezone_set("America/Bogota");
$lahoraencolombia= date ("Y-m-d H:i:s",time());

//PHP FECHA DE COLOMBIA
date_default_timezone_set("America/Bogota");
$lafechaencolombia= date ("Y-m-d");

/*ARRAYS DE FECHAS*/
$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

/*FECHA PARA LA TABLA DE CIERRE- EJEMPLO: 11-REBRERO.1154*/
$fecha_de_dia=date("d")."-".$meses[date("m")-1]."-".date("Y");

/*HORA INFORMATIVA EJ: 06:10 PM*/
$ya=date("h:i a");

/*PRECIO DEL DOLLAR*/
$cop_val = file_get_contents("http://dolar.wilkinsonpc.com.co/widgets/gratis/dolar-cop-usd-3.html"); 
$cop_val = explode('<div id="widget_valor">',$cop_val);
$cop_val = substr($cop_val['1'],1,6);
$cop_val = str_replace(',','',$cop_val);
$cop_val = str_replace('.','',$cop_val);
$cop_val_inicial = (int) $cop_val;
$cop_val_deducido = $cop_val-300;

?>