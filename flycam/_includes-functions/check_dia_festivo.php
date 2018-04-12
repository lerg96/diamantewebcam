<?
include "../_includes-functions/conexion_improved.php";

/*Conteo de los usuarios que vendieron el dia de hoy*/
$conteo_usuarios_que_vendieron=0;

/*Cojemos el numero de usuarios activos*/
$conteo_usuarios_activos=$con->query("SELECT COUNT(DISTINCT(ventas.id_usuario)) as conteo FROM ventas 
											INNER JOIN usuarios ON (ventas.id_usuario=usuarios.id_usuario)
											AND usuarios.estado='1'")->fetch_assoc();
$conteo_activos=$conteo_usuarios_activos['conteo'];
//echo "Conteo Activos: ".$conteo_activos."<br>";

/*Cojemos cada uno de los usuarios que ingresaro ventas hoy*/
$usuarios_con_ventas_hoy=$con->query("SELECT SUM(ventas.venta_usd) as suma_ventas_hoy,COUNT(usuarios.id_usuario) as numero_de_usuarios FROM ventas 
									INNER JOIN usuarios ON (ventas.id_usuario=usuarios.id_usuario) 
									WHERE DATE(ventas.fecha_creacion)=CURDATE() 
									AND usuarios.estado='1' 
									GROUP BY ventas.id_usuario
									ORDER BY `ventas`.`id_usuario` ASC");

                                while($row1=$usuarios_con_ventas_hoy->fetch_assoc()){/*WHILE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
                                
                                		if($row1['suma_ventas_hoy']>5){$conteo_usuarios_que_vendieron++;}

                                }/*WHILE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/

//echo "conteo Usuarios que Vendieron: ".$conteo_usuarios_que_vendieron."<br>";

$porcentaje_de_los_que_vendieron=($conteo_usuarios_que_vendieron*100)/$conteo_activos;
echo "Porcentaje de los que vinieron: ".$porcentaje_de_los_que_vendieron."<br>";

if($porcentaje_de_los_que_vendieron<50){echo "Es dia festivo";}else{echo "Es dia Corriente";}

?>