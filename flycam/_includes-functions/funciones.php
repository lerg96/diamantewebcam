<? 
/*PUBLIC IP*/
function get_real_ip()
{

    if (isset($_SERVER["HTTP_CLIENT_IP"]))
    {
        return $_SERVER["HTTP_CLIENT_IP"];
    }
    elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
    {
        return $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
    {
        return $_SERVER["HTTP_X_FORWARDED"];
    }
    elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
    {
        return $_SERVER["HTTP_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_FORWARDED"]))
    {
        return $_SERVER["HTTP_FORWARDED"];
    }
    else
    {
        return $_SERVER["REMOTE_ADDR"];
    }
}

/*Ramdom Number Basado en Fecha y Hora Actual*/
function numero_hora_actual(){/*1*/
	$numero=$lahoraencolombia= date ("Y-m-d-H-i-s",time());
	return $numero;
}/*1*/

/*Quitar Brs*/
function quitar_brs($text){/*1*/
	$numero=$lahoraencolombia= date ("Y-m-d-H-i-s",time());
	$breaks = array("<br />","<br>","<br/>");  
    $texto = str_ireplace($breaks, "", $text); 
	return $texto;
}/*1*/


////////////////////////////////////////////////
function saldo_resta($archivo,$valor){
										   if(file_exists($archivo)) {
		                                   $handle = fopen($archivo, 'r');
		                	               $saldo  = (int)fread($handle, 10)-$valor;
		                  	               $handle = fopen($archivo, 'w');
		            		               fwrite($handle, $saldo);
		            		               fclose($handle);
	                                                              }
																//Crea el archivo con el valor actual 
										   else{
											
		                                   $handle = fopen($archivo, 'w+');
		                                   $saldo = $valor;		
		                                   fwrite($handle, $saldo);
		                                   fclose($handle);
	                                           }
                                           return $saldo;
										   
										   }
										   
///////////////////////////////////////////////////////////////////////////////////////////////////////////////										   
function saldo_suma($archivo,$valor){
										   if(file_exists($archivo)) {
		                                   $handle = fopen($archivo, 'r');
		                	               $saldo  = (int)fread($handle, 10)+$valor;
		                  	               $handle = fopen($archivo, 'w');
		            		               fwrite($handle, $saldo);
		            		               fclose($handle);
	                                                              }
																//Crea el archivo con el valor actual 
										   else{
											
		                                   $handle = fopen($archivo, 'w+');
		                                   $saldo = $valor;		
		                                   fwrite($handle, $saldo);
		                                   fclose($handle);
	                                           }
                                           return $saldo;
										  
										   }			
///////////////////////////////////////////////////////////////////////////////////////////////////////////////										   
function leer_saldo($archivo){
	$handle=fopen($archivo,'r');
	$saldo=(int) fread($handle,10);
	return $saldo;
	}						   
										   
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
function echo_mes_anterior(){
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
if($_SESSION['mes']==1){/*1.2*/$fecha_mes_antes=$meses[($_SESSION['mes'])+10]." ".($_SESSION['ano']-1)." No tiene Gastos Mensuales";}/*1.2*/
else{/*1.3*/$fecha_mes_antes=$meses[($_SESSION['mes'])-2]." ".$_SESSION['ano']." No tiene Gastos Mensuales";}/*1.3*/
return $fecha_mes_antes;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function return_gastos_anterior(){/*FUN*/
if($_SESSION['mes']==1){/*1.2*/$gastos_anterior=($_SESSION['mes']+11)."_".($_SESSION['ano']-1)."_gastos";}/*1.2*/
                 else{/*1.3*/$gastos_anterior=($_SESSION['mes']-1)."_".$_SESSION['ano']."_gastos";}/*1.3*/
return $gastos_anterior;
}/*FUN*/
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
function return_mes_anterior(){
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
if($_SESSION['mes']==1){/*1.2*/$fecha_mes_antes=$meses[($_SESSION['mes'])+10]." ".($_SESSION['ano']-1);}/*1.2*/
else{/*1.3*/$fecha_mes_antes=$meses[($_SESSION['mes'])-2]." ".$_SESSION['ano'];}/*1.3*/
return $fecha_mes_antes;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
function si_mes_actual_o_siguiente(){/*1*/

/*Variable mes_ano Siguiente*/
if($_SESSION['mes']==12){/*1.2*/$fecha_mes_siguiente="1"."_".date("Y")+1;}/*1.2*/
else{/*1.3*/$fecha_mes_siguiente=(date("n")+1)."_".date("Y");}/*1.3*/

/*variable mes_ano seleccionado*/
$fecha_mes_seleccionado=$_SESSION['mes']."_".$_SESSION['ano'];

/*Variable mes_ano actual*/
$fecha_mes_actual=date("n")."_".date("Y");

/*si es mes actual o siguiente*/
if(($fecha_mes_seleccionado==$fecha_mes_actual)or($fecha_mes_seleccionado==$fecha_mes_siguiente)){return "1";}else{return "0";}
}/*1*/
///////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*APLICACION: PLANEACION*/
/*tabla: mediano y largo plazo*/

function fechas_mediano_y_largo($d1) {

$d1=date_create($d1);
$d2=date_create(DATE('Y-m-d H:i:s'));

$diferencia=date_diff($d2,$d1);
 
if(($diferencia->format("%R"))=='-'){$pre="<span style='font-weight: bold;'>Vencio Hace:</span> ";}else if(($diferencia->format("%R"))=='+'){$pre="<span style='font-weight: bold;'>Vence en:</span> ";}
/*para que no me alerte undefined variable*/
if(!isset($losanos)){$losanos='';}
if(($diferencia->format("%Y"))>=1){$losanos=" ".($diferencia->format("%Y"))." A&ntildeos y";}
if(($diferencia->format("%Y"))==1){$losanos=" ".($diferencia->format("%Y"))." A&ntildeo y";}
if(($diferencia->format("%Y"))<'10'){$losanos=str_replace("0","",$losanos);}

if(($diferencia->format("%M"))<1){$losmeses="";}
if(($diferencia->format("%M"))>1){$losmeses=" ".($diferencia->format("%M"))." Meses y";}
if(($diferencia->format("%M"))==1){$losmeses=" ".($diferencia->format("%M"))." Mes y";}
if(($diferencia->format("%M"))!=='10'){$losmeses=str_replace("0","",$losmeses);}


$losdias=" ".($diferencia->format("%d"))." Dias ";


return $pre.$losanos.$losmeses.$losdias;



} 

///////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*APLICACION: PLANEACION*/
/*tabla: metas cumplidas y cancelaciones*/

function cumplidas_y_cancelaciones($d1) {
//$d1 es la fecha a calcular y $d2 es la fecha de hoy
$d1=date_create($d1);
$d2=date_create(DATE('Y-m-d H:i:s'));

//aqui se hace la diferencia de las 2 fechas
$diferencia=date_diff($d2,$d1);
/*para que no me alerte undefined variable*/
if(!isset($losanos)){$losanos='';}
/*para que no me alerte undefined variable*/
if(!isset($losmeses)){$losmeses='';}
/*para que no me alerte undefined variable*/
if(!isset($losdias)){$losdias='';}
//si la diferencia da resultado negativo el prefijo es: Hace Y si la diferencia da resultado positivo el prefijo es: Dentro de
if(($diferencia->format("%R"))=='-'){$pre=" Hace:</span> ";}else if(($diferencia->format("%R"))=='+'){$pre=" Dentro de:</span> ";}

//si el año es mayor o igual a 1 entonces se declara la variable $losanos
if(($diferencia->format("%Y"))>=1){$losanos="y ".($diferencia->format("%Y"))." A&ntildeos ";}
//si el año es a 1 entonces se declara la variable $losanos con el prefijo AÑO (en singular)
if(($diferencia->format("%Y"))==1){$losanos="y ".($diferencia->format("%Y"))." A&ntildeo ";}
//si el año es menor que 10 entonces se remueve el cero que precede al numero. osea 1 y no 01.
if(($diferencia->format("%Y"))<'10'){$losanos=str_replace("0","",$losanos);}

//si el mes es mayor o igual a 1 entonces se declara la variable $losmeses
if(($diferencia->format("%M"))>=1){$losmeses="y ".($diferencia->format("%M"))." Meses ";}
//si el mes es a 1 entonces se declara la variable $losmeses con el prefijo MES (en singular)
if(($diferencia->format("%M"))==1){$losmeses="y ".($diferencia->format("%M"))." Mes ";}
//si el mes es menor que 10 entonces se remueve el cero que precede al numero. osea 1 y no 01.
if(($diferencia->format("%M"))!=='10'){$losmeses=str_replace("0","",$losmeses);}

//Se declara la variable $losdias que determina el numero de dias
$losdias=" ".($diferencia->format("%d"))." Dias ";
//si el mes es a 1 entonces se declara la variable $losmeses con el prefijo MES (en singular)
if(($diferencia->format("%d"))==1){$losdias=" ".($diferencia->format("%d"))." Dia ";}

//devuelve el resultado
if((($diferencia->format("%d"))==0) and (($diferencia->format("%Y"))==0) and (($diferencia->format("%M"))==0))
{return " </span>Hoy";}
else{return $pre.$losdias.$losmeses.$losanos;}//el espan se cierra porque lo abrio creado o cumplido (segun el caso) en planeacion.php



} 
		
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*APLICACION: PLANEACION*/
/*Validadacion de mediano y largo plazo*/

function validacion_mediano_y_largo($d1,$plazo) {/*1*/


$d1=date_create($d1);
$d2=date_create(DATE('Y-m-d H:i:s'));

$diferencia=date_diff($d2,$d1);

if($plazo=='Mediano_plazo'){
                              $tiempo=$diferencia->format("%R");
							      $losanos=$diferencia->format("%Y");
                              $losmeses=$diferencia->format("%M");
                              $losdias=$diferencia->format("%d");

                              if( ( ($losanos>=1) or ($losmeses>=1) )  and  ( ($losanos==0) and ($losmeses<6) ) and ($tiempo=="+") )
							                                             {return "ok";}
																	      else{return "no";}
}

else if($plazo=='Largo_plazo'){
                              $tiempo=$diferencia->format("%R");
                              $losanos=$diferencia->format("%Y");
                              $losmeses=$diferencia->format("%M");
                              $losdias=$diferencia->format("%d");

                              if( ( ($losanos>=1) or ($losmeses>=6) )  and  ( ($losanos>=0) and ($losmeses<12) ) and ($tiempo=="+") )
							                                             {return "ok";}
																	      else{return "no";}
}
}/*1*/ 		
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*APLICACIONES QUE SE ALTERAN SI MODIFICA LA FUNCION: TAREAS Y cron_job_feedback_web_enviador Y cron_job_pedidor_feedback_compradores*/
/*HACE CUANTO dias, mes y años*/
/*esta funcion fue copiada de planeacion (mas arriba)*/


function fechas_mediano_y_largo_tareas($d1) {
/*para que no me alerte undefined variable*/
if(!isset($losanos)){$losanos='';}
/*para que no me alerte undefined variable*/
if(!isset($losmeses)){$losmeses='';}
/*para que no me alerte undefined variable*/
if(!isset($losdias)){$losdias='';}
$d1=date_create($d1);
$d2=date_create(DATE('Y-m-d H:i:s'));

$diferencia=date_diff($d2,$d1);
 
if(($diferencia->format("%R"))=='-'){$pre="<span style='font-weight: bold;'>hace:</span> ";}else{$pre='';}

if(($diferencia->format("%Y"))>=1){$losanos=" ".($diferencia->format("%Y"))." A&ntildeos y";}
if(($diferencia->format("%Y"))==1){$losanos=" ".($diferencia->format("%Y"))." A&ntildeo y";}
if(($diferencia->format("%Y"))<'10'){$losanos=str_replace("0","",$losanos);}

if(($diferencia->format("%M"))>=1){$losmeses=" ".($diferencia->format("%M"))." Meses y";}
if(($diferencia->format("%M"))==1){$losmeses=" ".($diferencia->format("%M"))." Mes y";}
if(($diferencia->format("%M"))!=='10'){$losmeses=str_replace("0","",$losmeses);}

$losdias=" ".($diferencia->format("%d"))." Dias ";



//devuelve el resultado
if((($diferencia->format("%d"))==0) and (($diferencia->format("%Y"))==0) and (($diferencia->format("%M"))==0)){return "Hoy";}
else if((($diferencia->format("%d"))==1) and (($diferencia->format("%Y"))==0) and (($diferencia->format("%M"))==0)){return "Ayer";}
else{return $pre.$losanos.$losmeses.$losdias;}//el espan se cierra porque lo abrio creado o cumplido (segun el caso) en planeacion.php

}

/*APLICACION: INVENTARIO*/
/*HACE CUANTOS DIAS NO SE HACE INVENTARIO*/
function hace_cuantos_dias($d1) {

$d1=date_create($d1);
$d2=date_create(date('Y-m-d H:i:s'));

$diferencia=date_diff($d2,$d1);

$losdias=($diferencia->format("%d"));

if(($diferencia->format("%Y"))>0){$losdias=30;}

if(($diferencia->format("%M"))>0){$losdias=30;}

return $losdias;

}
//////////////////////////////////////////////////////////////////////
////APLICACION ESPERANDO - CALCULA NUMERO DE DIAS ENTR 2 FECHAS//////
////////////////////////////////////////////////////////////////////
/*PARECIDA A LA FUNCION ANTERIOR PERO NO IGUAL*/

function hace_cuantos_dias_2($fecha_creacion,$recordar_en) {/*1*/
/*Se cogen ambas fechas*/
$d1=date_create($fecha_creacion);
$d2=date_create(date('Y-m-d H:i:s'));
/*Hacemos diferenciacion de fechas*/
$intervalo=date_diff($d1, $d2);
/*Diferencia de fechas por dias*/
$intervalo=$intervalo->format('%a');
/*A la diferencia de las fechas se le suman */
$dentro_de=$recordar_en-$intervalo;
return $dentro_de;
}/*1*/


///////////////////////////////////////////////
/*DIFERENCIA DE HORA ACTUAL Y HORA DE LLEGADA SEGUN HORARIO - en minutos*/
/*EMPLEADOS_ASISTENCIAS*/

function temprano_tarde_o_inasistencia($hora_horario) {

$hora_horario=strtotime($hora_horario);
$hora_actual=strtotime(DATE('Y-m-d H:i:s'));

$diferencia=round(abs($hora_actual - $hora_horario) / 60,2);

$minutos=$diferencia;
 
return $minutos;

}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////PRESTAMOS BANCOS///////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function return_tabla_anterior(){/*FUN*/
if($_SESSION['bancos_mes']==1){/*1.2*/$gastos_anterior="proveedores_prestamos_bancos_".($_SESSION['bancos_mes']+11)."_".($_SESSION['bancos_ano']-1);}/*1.2*/
                 else{/*1.3*/$gastos_anterior="proveedores_prestamos_bancos_".($_SESSION['bancos_mes']-1)."_".$_SESSION['bancos_ano'];}/*1.3*/
return $gastos_anterior;
}/*FUN*/
///////////////////////
function return_mes_anterior_bancos(){
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
if($_SESSION['bancos_mes']==1){/*1.2*/$fecha_mes_antes=$meses[($_SESSION['bancos_mes'])+10]." ".($_SESSION['bancos_ano']-1);}/*1.2*/
else{/*1.3*/$fecha_mes_antes=$meses[($_SESSION['bancos_mes'])-2]." ".$_SESSION['bancos_ano'];}/*1.3*/
return $fecha_mes_antes;
}
/////////////////////////////////////////
/////////ENCRYPT - DECRYPT//////////////
///////////////////////////////////////
/*Constante*/
define("encr_key","!#$%&/(m)=Q");/*Definimos constante*/
$encr_key=encr_key;/*Pasamos constante a una variable*/
/*encrypt_decrypt('$str','$tipo',$encr_key);*/

/*Funcion*/
function encrypt_decrypt($str,$tipo,$encr_key){/*1*/
	
	if($tipo==1){/*encrypt*/
				
				$string_f=rtrim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256,$encr_key,$str,MCRYPT_MODE_ECB)));
	}/*encrypt*/
	
	elseif($tipo==2){/*decrypt*/
	
				$string_f=rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256,$encr_key,base64_decode($str),MCRYPT_MODE_ECB));
	}/*decrypt*/
	return $string_f;
}/*1*/

/////////////////////////////////////////
//////////////FECHAS////////////////////
///////////////////////////////////////
/*Funcion 1*/
function fecha1($fecha){/*1*/
global $meses;
$fecha=date_parse($fecha);
$fecha=$fecha['day']."-".substr($meses[$fecha['month']-1],0,3)."-".$fecha['year'];
return $fecha;	
}/*1*/

//////////////////////////////////////////////////////////////////////////////////
//////////////BARRA NAVEGADORA DE LINKS DE LA MISMA APLICACION////////////////////
//////////////////////////////////////////////////////////////////////////////////

function crear_navegadora($id_seguridad){/*1*/
	$sub_apps=array();
	global $con;
	global $push;
	/*Cogemos la Id de la Aplicacion*/
	$get_id_aplicacion=$con->query("SELECT id_aplicacion FROM seguridad_sub_aplicaciones WHERE id_seguridad='$id_seguridad'")->fetch_assoc();
	$id_aplicacion=$get_id_aplicacion['id_aplicacion'];
	
	/*Si hay push solo se muestran las que tienen push 0*/
	if($push=='on'){$condicion="AND push='0'";}else{$condicion="";}
	
	/*Cogemos las sub_aplicaciones hermanas de la sub_aplicacion actual*/
	$get_sub_aplicaciones=$con->query("SELECT * FROM seguridad_sub_aplicaciones WHERE id_aplicacion='$id_aplicacion' AND inicio='1' AND id_seguridad NOT IN ($id_seguridad) $condicion");
	echo "<div style='margin:10px 0px 20px 0px;text-align:center;'>";
	while($row = $get_sub_aplicaciones->fetch_assoc()){/*while***********/
		
		/*Permisos Aplicaciones*/
		$permisos_aplicaciones=array();
		$id=explode("|",$row['id_usuario']);
		if(in_array($_SESSION['id_usuario'],$id)){echo "| <a class='parrafo_light' href='../".$row['direccion']."'>".$row['descripcion']."</a> | ";}
		unset($id);
	
	}/*while************************************************************/
	echo "</div>";
	
	//return $sub_apps;	

}/*1*/

///////////////////////////////////////////////////////////////////////////////////
//////////////////HORARIOS (La Diferencia En Horas Entre 2 Horas)//////////////////
//////////////////////////////////////////////////////////////////////////////////
function diferencia_entre_2_horas($entrada,$salida){/*1*/
	
	/*Cogemos los primeros 2 numeros de la hora*/
	$entrada=substr($entrada,0,2);
	//echo $entrada."<br>";
	/*Cogemos los primeros 2 numeros de la hora*/
	$salida=substr($salida,0,2);
	//echo $salida."<br>";
	
	/*La hora debe ser numerica y la sentrada menor que la salida*/
	if((is_numeric($entrada) and is_numeric($salida))and($entrada<$salida)){$horas_t=$salida-$entrada;}else{$horas_t=0;}
	

	return $horas_t;


}/*1*/
///////////////////////////////////////////////////////////////////////////////////
//////////////////Tiempo De Descanso Segun Tiempo Trabajado//////////////////
//////////////////////////////////////////////////////////////////////////////////
function tiempo_de_descanso($horas_t){/*1*/
	
	
	/*Calculo de descanso*/
	$tiempo_de_descanso=($horas_t/8)*0.5;
	return $tiempo_de_descanso;


}/*1*/
///////////////////////////////////////////////////////////////////////////////////
////////////Numero de Horas Trabajadas Semanalmente Segun Usuario/////////////////
///////////////////////////////////////////////////////////////////////////////// 
function consulta_numero_de_horas_trabajadas_semanales($id_usuario){/*1*/

/*Conexión*/
global $con;

	/*CONSULTA DE ENTRADAS*/ 
	$entradas=$con->query("SELECT * FROM asistencia_horarios WHERE id_usuario='$id_usuario' AND tipo='1'")->fetch_assoc();
	/*CONSULTA DE SALIDAS*/ 
	$salidas=$con->query("SELECT * FROM asistencia_horarios WHERE id_usuario='$id_usuario' AND tipo='2'")->fetch_assoc();
	
		$ht_lunes=diferencia_entre_2_horas($entradas['lunes'],$salidas['lunes']);
		//echo $ht_lunes."<br>";
		$ht_martes=diferencia_entre_2_horas($entradas['martes'],$salidas['martes']);
		//echo $ht_martes."<br>";
		$ht_miercoles=diferencia_entre_2_horas($entradas['miercoles'],$salidas['miercoles']);
		//echo $ht_miercoles."<br>";
		$ht_jueves=diferencia_entre_2_horas($entradas['jueves'],$salidas['jueves']);
		//echo $ht_jueves."<br>";
		$ht_viernes=diferencia_entre_2_horas($entradas['viernes'],$salidas['viernes']);
		//echo $ht_viernes."<br>";
		$ht_sabado=diferencia_entre_2_horas($entradas['sabado'],$salidas['sabado']);
		//echo $ht_sabado."<br>";
		$ht_domingo=diferencia_entre_2_horas($entradas['domingo'],$salidas['domingo']);
		//echo $ht_domingo."<br>";

	$horas_trabajadas_semanales=$ht_lunes+$ht_martes+$ht_miercoles+$ht_jueves+$ht_viernes+$ht_sabado+$ht_domingo;
	
	return round($horas_trabajadas_semanales);
	}/*1*/

///////////////////////////////////////////////////////////////////////////////////
/////////PUT/Subir Archivo Individual a www.palmatecnologia.com////////////////////
///////////////////////////////////////////////////////////////////////////////// 
function subir_archivo_individual_ftp($folder_remoto,$archivo_ubicacion,$ftp_server,$ftp_user,$ftp_pass){/*1*/
								
								// establecer una conexión o finalizarla
								$conn_id = ftp_connect($ftp_server,21) or die("No se pudo conectar a $ftp_server"); 

								// intentar iniciar sesión
								if (@ftp_login($conn_id, $ftp_user, $ftp_pass)) {/*Log in*/
								$_SESSION['alerta_ok'][]="Conectado correctamente a servidor remoto www.palmatecnologia.com";
								}/*Log in*/ else {/*Log in*/
								$_SESSION['alerta'][]="No se pudo conectar al servidor remoto www.palmatecnologia.com";
								}/*Log in*/
								
								//Para que no de error de conexion
								ftp_pasv($conn_id, true);

								$basename_archivo_local= basename($archivo_ubicacion);
								//echo $basename_archivo_local."<br>";
								$realpath_archivolocal=realpath($archivo_ubicacion);
								//echo $realpath_archivolocal."<br>";
								//echo $folder_remoto."<br>";
								//Poner Archivo
								ftp_put($conn_id, "$folder_remoto$basename_archivo_local", "$realpath_archivolocal", FTP_BINARY);
							
								// cerrar la conexión ftp
								ftp_close($conn_id);
		
	}/*1*/

///////////////////////////////////////////////////////////////////////////////////
/////////Elminiar Archivo Individual a www.palmatecnologia.com////////////////////
///////////////////////////////////////////////////////////////////////////////// 
function eliminar_archivo_individual_ftp($folder_remoto,$archivo_ubicacion,$ftp_server,$ftp_user,$ftp_pass){/*1*/
								
								// establecer una conexión o finalizarla
								$conn_id = ftp_connect($ftp_server,21) or die("No se pudo conectar a $ftp_server"); 

								// intentar iniciar sesión
								if (@ftp_login($conn_id, $ftp_user, $ftp_pass)) {/*Log in*/
								$_SESSION['alerta_ok'][]="Conectado correctamente a servidor remoto www.palmatecnologia.com";
								}/*Log in*/ else {/*Log in*/
								$_SESSION['alerta'][]="No se pudo conectar al servidor remoto www.palmatecnologia.com";
								}/*Log in*/
								
								$basename_archivo_local= basename($archivo_ubicacion);
								//echo $basename_archivo_local."<br>";
								//echo $folder_remoto."<br>";
								//Poner Archivo
								ftp_delete($conn_id, "$folder_remoto$basename_archivo_local");
								
								// cerrar la conexión ftp
								ftp_close($conn_id);
		
	}/*1*/
	
///////////////////////////////////////////////////////////////////////////////////
////////////////Hacer sitemap en www.palmatecnologia.com//////////////////////////
///////////////////////////////////////////////////////////////////////////////// 	
function run_sitemap_maker($dir_sitemap_maker){/*1*/
							
							//echo $dir_sitemap_maker;
							$respuestas_sitemap_maker=file_get_contents("$dir_sitemap_maker");	
							$respuestas_sitemap_maker=explode("|",$respuestas_sitemap_maker);
							//var_dump($respuestas_sitemap_maker);
							foreach($respuestas_sitemap_maker as $alerta){/*foreach*/
								if(!preg_match("/<h1/",$alerta)){
																if(preg_match("/NO/",$alerta)){$_SESSION['alerta'][]=$alerta;
																}else{
																$_SESSION['alerta_ok'][]=$alerta;}
																}
							}/*foreach*/
}/*1*/

///////////////////////////////////////////////////////////////////////////////////
//////////////////////Editar Nombre de Productos//////////////////////////////////
///////////////////////////////////////////////////////////////////////////////// 	
function editar_nombre_productos($nuevonomproducto){/*1*/
							
								$nuevonomproducto=trim(strtoupper(preg_replace("/[^0-9a-zA-Z\s+]/",'',$nuevonomproducto)));
								/*Se remueben las palabras prohibidas*/
								$prohibidas = array('LOS','LAS','DE','DEL','Y','O','PERO','DE','EL','LA','UN','UNO','UNOS','UNAS','PARA');
								foreach($prohibidas as $prohibida){/*Foreach*/
									if(preg_match("/\b($prohibida)\b/",$nuevonomproducto)){/*if pregmatch*/
																						$match=true;
																						echo $prohibida."<br>";
																					}/*if pregmatch*/
									}/*Foreach*/
								
								if($match==true){/*Si hubo un match de palabras prohibidas*/
											$nuevonomproducto=preg_replace("/\b(".implode('|',$prohibidas).")\b/",'',$nuevonomproducto);
											$_SESSION['alerta'][]="Las siguientes palabras no son permitidas en el nombre y han sido removidas: ".implode(', ',preg_replace('/\//','',$prohibidas)).".";
								}/*Si hubo un match de palabras prohibidas*/
								
								/*Remueve espacios en blanco donde hay mas de 1 espacio en blanco entre palabras*/
								$nuevonomproducto=preg_replace('/\s+/', ' ',$nuevonomproducto);
								return $nuevonomproducto;
}/*1*/
?>