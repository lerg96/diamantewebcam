<?
//include "../_includes-funciones/foreach_alerta.php";


/*Alerta OK*/
if(isset($_SESSION['alerta_ok'])){/*Si hay alertas*/
foreach($_SESSION['alerta_ok'] as $alerta_ok){/*foreach cada alerta*/

echo "<div style='margin-bottom: 7px;'><img src='../../marilyn/_globales/images/goodjobicon.png'><b style='margin-left:3px;font-family:HelveticaNeueLTStd-Bd;color:#10BF10;'>Bien hecho! </b><p style='color:#10BF10;display:inline; font-family:HelveticaNeueLTStd-Lt; font-weight: lighter;' >$alerta_ok</p></div><br>";

}/*foreach cada alerta*/
unset($_SESSION['alerta_ok']);
}/*Si hay alertas*/

/*Alerta*/
if(isset($_SESSION['alerta'])){/*Si hay alertas*/
foreach($_SESSION['alerta'] as $alerta){/*foreach cada alerta*/

echo "<div  style='margin-bottom:7px;'><img src='../../marilyn/_globales/images/wrongicon.png'><b style='margin-left:3px;font-family:HelveticaNeueLTStd-Bd;color:#FF0019;'>Algo anda mal* </b><p style='color:#FF0019;display:inline; font-family:HelveticaNeueLTStd-Lt;font-weight:lighter;'>$alerta</p></div>";

}/*foreach cada alerta*/
unset($_SESSION['alerta']);
$exist_alert='1';/*Si esta variable existe es porque Session Alerta existio a pesar de habarle hecho unset. Usada en el boton de cerrar el dia del modulo de facturacion.*/
}/*Si hay alertas*/
?>