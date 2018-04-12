<?
include "../_includes-functions/conexion_improved.php";
include "../_includes-functions/seguridad.php";
include "../_includes-functions/funciones.php";
include '../_includes-functions/barraNavegacion.php';

if(isset($_POST['activar'])){/*Activar Usuario*/
                            $id_usuario=$_POST['activar'];
                            $activar=$con->query("UPDATE usuarios SET estado=1 WHERE id_usuario=$id_usuario");

                            if(!$activar){$_SESSION['alerta'][]="No se pudo activar el usuario.";}else{$_SESSION['alerta_ok'][]="El usuario se activo correctamente.";}
}/*Activar Usuario*/

if(isset($_POST['modalidad'])){/*Activar Usuario*/
                            if( ($_POST['modalidad']=='1') ){/*Estudio*/
                                    $_SESSION['aspirantes_modalidad']='estudio';
                                    $_SESSION['aspirantes_modalidad_query']="(modalidad='1' OR modalidad='1|2' OR modalidad='2|1')";

                            }/*Estudio*/elseif( ($_POST['modalidad']=='2') ){/*Satelite*/
                                     $_SESSION['aspirantes_modalidad']='satelite';
                                    $_SESSION['aspirantes_modalidad_query']="(modalidad='2' OR modalidad='1|2' OR modalidad='2|1')";

                            }/*Satelite*/elseif( ($_POST['modalidad']=='Todos') ){/*Ambos*/
                                     $_SESSION['aspirantes_modalidad']='Todos';
                                    $_SESSION['aspirantes_modalidad_query']="(modalidad='1' OR modalidad='2' OR modalidad='1|2' OR modalidad='2|1')";

                            }/*Ambos*/
}/*Activar Usuario*/

if(isset($_POST['reservar'])){/*Activar Usuario*/
                            $id_usuario=$_POST['reservar'];
                            $reservar=$con->query("INSERT INTO usuarios_solicitudes(id_usuario_reserva,fecha_creacion,id_usuario,id_lider,estado) VALUES (default,'$lahoraencolombia',$id_usuario,".$_SESSION['id_usuario'].",1)");
                            
                            if(!$reservar){$_SESSION['alerta'][]="No se pudo reservar el usuario.";}else{$_SESSION['alerta_ok'][]="El usuario se Reservó correctamente.";}
}/*Activar Usuario*/


/*Definicion de estados en un Array para mostrarlos en la columna de estado*/
$estados=array();
$estados[1]="<p style='color:#2B4900; font-weight:bolder;' ><img style='vertical-align:middle;' src='../_globales/images/goodjobicon2.png'> Trabajando";
$estados[2]="<p style='color:#2B4900; font-weight:bolder;' ><img type='image' src='../_globales/images/iconodesactivar.png' id='modelos_cuerpo_formulario2_desactivar'> Inactivo";
$estados[3]="<p style='color:#2B4900; font-weight:bolder;' ><img type='image' src='../_globales/images/iconodesactivar.png' id='modelos_cuerpo_formulario2_desactivar'> Rechazado";
$estados[4]="<p style='color:#2b2fb9; font-weight:bolder;' ><img type='image' width='22px' src='../_globales/images/pause.png' id='modelos_cuerpo_formulario2_desactivar'> Pausado";



/*Populacion de Array con todos los estudios*/
$estudios=array();
$popu_estudios=$con->query("SELECT * from estudios");
while ($row=$popu_estudios->fetch_assoc()) {/*While*/
        $estudios[$row['id_estudio']]=$row['nombre_estudio'];
}/*While*/


if(!isset($_SESSION['aspirantes_modalidad'])){$_SESSION['aspirantes_modalidad']='Todos';}
if(!isset($_SESSION['aspirantes_modalidad_query'])){$_SESSION['aspirantes_modalidad_query']="(modalidad='1' OR modalidad='2' OR modalidad='1|2' OR modalidad='2|1')";;}
//echo $_SESSION['aspirantes_modalidad']."<br>";
//echo $_SESSION['aspirantes_modalidad_query']."<br>";

?>
<!DOCTYPE html>
<html>
<head>

	<link rel="stylesheet" type="text/css" href="../_globales/styles/resetcss.css">
	<link rel="stylesheet" type="text/css" href="../_includes-functions/styles/barraNavegacion.css">
	<link rel="stylesheet" type="text/css" href="../_includes-functions/styles/footer.css">
	<link rel="stylesheet" type="text/css" href="styles/aspirantes.css">

	<title>
		
        
	</title>

<style>
a{text-decoration: none;}
#post_div
{
display:none;
}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script> 
$(document).ready(function(){
  $(".show").click(function(){
    $("#post_div").slideToggle("slow");
    
   });
});
</script>

</head>
<body>

	<div id="aspirantes_cuerpo">

		<img id="aspirantes_cuerpo_bolsaIcono" src="images/bolsaicono.png"><h1 style="display: inline;">Bolsa de aspirantes</h1>
    <form id="aspirantes_cuerpo_formulario1" action='' method='POST'>
      <select name='modalidad' onchange="this.form.submit()">
        <option value='<? echo $_SESSION['aspirantes_modalidad']; ?>'><? echo ucfirst($_SESSION['aspirantes_modalidad']); ?></option>
        <? if($_SESSION['aspirantes_modalidad']!='Todos'){ echo "<option value='Todos'>Todos</option>";}?>
        <? if($_SESSION['aspirantes_modalidad']!='estudio'){ echo "<option value='1'>Estudio</option>";}?>
        <? if($_SESSION['aspirantes_modalidad']!='satelite'){ echo "<option value='2'>Satelite</option>";}?>
        
      </select>
    </form>
    <br>
    <p id="aspirantes_cuerpo_primerParrafo">Aquí podrá encontdar una lista de apirantes para modelos webcam. Están organizados del más recientes al más antiguo. Seleccione el que más le convenga.</p><br>

     
<?include "../_includes-functions/foreach_alerta.php"; ?>

<div style="margin-bottom:15px;" ><img id="aspirantes_cuerpo_bolsaIcono" src="../_globales/images/personicon.png"><h2 style="display: inline; font-size:30px">Esta semana:</h2></div>


      <table style="text-align: center ;width: 100%; padding-right: 20px; border:0px;" cellspacing="0" cellpadding="0" border="1" >

      <form action='' method='POST' id="aspirantes_cuerpo_formulario2">

<?
///////////////////////////////////////
//////////////ESTA SEMANA//////////////
//////////////////////////////////////
$conteo=1;

$select_bolsa=$con->query("SELECT * FROM usuarios WHERE ".$_SESSION['aspirantes_modalidad_query']." AND YEARWEEK(fecha_creacion) = YEARWEEK(NOW()) ORDER BY id_usuario DESC");
while($row=$select_bolsa->fetch_assoc()){/****************************************************************************While**********************************************************************************************/
        $nombres=explode(' ',$row['nombres']);
        $apellidos=explode(' ',$row['apellidos']);
        $edad=floor((time() - strtotime($row['fecha_de_nacimiento'])) / 31556926);
        
        /*Se verifica la disponibilidad de las imagenes y se muestra la más propicia*/
        if (@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_fotos_perfil/'.$row['id_usuario'].'.jpg')) {$image="../_globales/images/".$_SESSION['nombre_base']."_fotos_perfil/".$row['id_usuario'].".jpg";}
        elseif (@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_cedulas_mano/'.$row['id_usuario'].'.jpg')) {$image="../_globales/images/".$_SESSION['nombre_base']."_cedulas_mano/".$row['id_usuario'].".jpg";}
        else{$image='../_globales/images/no_image.png';}
        
        /*Formateo de la columna de fecha*/
        $fecha_column=date_parse($row['fecha_creacion']);
        $fecha_column=$fecha_column['day']." / ".substr($meses[$fecha_column['month']-1], 0,3);
        
        /*Checkeo Youtube*/
        if ($row['url_entrevista']!='' and strlen($row['url_entrevista'])>'5'){/*Checkeo Youtube*/
                    $yt_link="<a href='".$row['url_entrevista']."' target='_blank'><img class='img' id='aspirantes_cuerpo_formulario2_botonyoutube' src='../_globales/images/youtubeicon.png' id='aspirantes_cuerpo_formulario2_botonyoutube.png'></a>";
        }/*Checkeo Youtube*/else{/*Checkeo Youtube*/
                    $yt_link="<img class='img' id='aspirantes_cuerpo_formulario2_botonyoutube' src='../_globales/images/youtubeicongris.png' id='aspirantes_cuerpo_formulario2_botonyoutube.png'>";
        }/*Checkeo Youtube*/

        /*Disponibilidad*/
        $dispo_r=array(         1 => "&#9729;",//Mañana
                                2 => "&#9788;",//Tarde
                                3 => "&#9790;",//Noche
                            );
        $termi='';
        $disponibilidad=explode('|',$row['disponibilidad']);
        foreach ($disponibilidad as $term ) {/*Foreach*/
                if(isset($dispo_r[$term])){$termi.=" ".$dispo_r[$term];}
        }/*Foreach*/

        /*Checkeo solicitudes de reserva*/
        $select_reserva=$con->query("SELECT usuarios_solicitudes.fecha_creacion,usuarios.usuario FROM usuarios_solicitudes 
                                    LEFT JOIN usuarios ON (usuarios_solicitudes.id_lider=usuarios.id_usuario)
                                    WHERE usuarios_solicitudes.id_usuario=".$row['id_usuario']." 
                                    AND usuarios_solicitudes.estado=1 
                                    AND usuarios_solicitudes.fecha_creacion > DATE_SUB(NOW(), INTERVAL 24 HOUR)
                                    ORDER BY usuarios_solicitudes.fecha_creacion DESC LIMIT 1");
        
        if($row['estado']!='0'){/*Si el usuario ya fue activado*/

                if($row['estado']=='1'){echo "<tr style='background-color:#EBFFD7;'>";}elseif( ($row['estado']=='2') or ($row['estado']=='3')){echo "<tr style='background-color:#fff0f0;'>";}
                echo "<td><number>$conteo.</number></td>";
                echo "<td><img class='img' src='$image' style='width: 120px;'></td>";
                echo "<td><a href='../entrevistas/entrevistas.php?editar_usuario=".$row['id_usuario']."'><span class='span'>".$nombres['0']." ".$apellidos['0']." (".$row['usuario'].")  $termi</span></a></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><p class='p'>$fecha_column</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><b class='b'>Edad</b></td>";
                echo "<td><p class='p'>$edad</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td>$yt_link</td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><p class='p' id='p'>".$row['ciudad']."</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td>".$estados[$row['estado']]." en ";
                if(isset($estudios[$row['id_estudio']])){echo ucwords($estudios[$row['id_estudio']]);}else{echo "Desconocido";}
                echo "!</p></td>";
                echo "<td>";
                if($row['modalidad']=='1'){echo "<img src='../_globales/images/iconoestudio.png' alt='Estudio'>";}
                elseif($row['modalidad']=='2'){echo "<img src='../_globales/images/iconosatelite.png' alt='Satelite'>";}
                elseif($row['modalidad']=='1|2'){echo "<img src='../_globales/images/iconoambos.png' alt='Ambos'>";}
                echo "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td colspan='20'>";
                echo "<img src='images/separador.png'>";
                echo "</td>";
                echo "</tr>";

        }/*Si el usuario ya fue activado*/elseif($select_reserva->num_rows > 0){/*Existe reserva*/

        /*Fecha Solicitud*/
        $select_reserva=$select_reserva->fetch_assoc();
        $fecha_ultima_reserva=$select_reserva['fecha_creacion'];

        /*Hace cuanto se hizo la solicitud*/
        $diferencia_ultima_reserva=fechas_mediano_y_largo_tareas($fecha_ultima_reserva);
                    
        
                echo "<tr style='background-color:#F3F4F4;'>";
                echo "<td><number>$conteo.</number></td>";
                echo "<td><img class='img' src='$image' style='width: 120px;'></td>";
                echo "<td><a href='../entrevistas/entrevistas.php?editar_usuario=".$row['id_usuario']."'><span class='span'>".$nombres['0']." ".$apellidos['0']." (".$row['usuario'].") $termi</span></a></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><p class='p'>$fecha_column</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><b class='b' >Edad</b></td>";
                echo "<td><p class='p'>$edad</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td>$yt_link</td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><p class='p' id='p'>".$row['ciudad']."</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><p id='solicitadoPor'>Para ".ucfirst($select_reserva['usuario'])."<br>";
                echo "<img style='vetical-align:middle' src='../_globales/images/stopwatch.png'>  $diferencia_ultima_reserva</p></td>";
                echo "<td>";
                if($row['modalidad']=='1'){echo "<img src='../_globales/images/iconoestudio.png' alt='Estudio'>";}
                elseif($row['modalidad']=='2'){echo "<img src='../_globales/images/iconosatelite.png' alt='Satelite'>";}
                elseif($row['modalidad']=='1|2'){echo "<img src='../_globales/images/iconoambos.png' alt='Ambos'>";}
                echo "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td colspan='20'>";
                echo "<img src='../_globales/images/separador.png'>";
                echo "</td>";
                echo "</tr>";
        
       }/*Existe reserva*/else{/*Existe reserva*/

                echo "<tr>";
                echo "<td><number>$conteo.</number></td>";
                echo "<td><img class='img' src='$image' style='max-width: 120px;'></td>";
                echo "<td><a href='../entrevistas/entrevistas.php?editar_usuario=".$row['id_usuario']."'><span class='span'>".$nombres['0']." ".$apellidos['0']." (".$row['usuario'].") $termi</span></a></td>";
                 echo "<td><span class='span'>|</span></td>";
                echo "<td><p class='p'>$fecha_column</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><b class='b' >Edad</b></td>";
                echo "<td><p class='p'>$edad</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td>$yt_link</td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><p class='p' id='p'>".$row['ciudad']."</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><button id='aspirantes_cuerpo_formulario2_activar' class='input' type='submit' name='reservar' value='".$row['id_usuario']."'>Solicitar</button></td>";
                echo "<td>";
                if($row['modalidad']=='1'){echo "<img src='../_globales/images/iconoestudio.png' alt='Estudio'>";}
                elseif($row['modalidad']=='2'){echo "<img src='../_globales/images/iconosatelite.png' alt='Satelite'>";}
                elseif($row['modalidad']=='1|2'){echo "<img src='../_globales/images/iconoambos.png' alt='Ambos'>";}
                echo "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td colspan='20'>";
                echo "<img src='images/separador.png'>";
                echo "</td>";
                echo "</tr>";

       
}/*Existe reserva*/


        
        unset($diferencia_ultima_reserva);
        unset($formateo_diferencia);
        /*Esta fecha es la fecha de la ultima persona de la tabla, y se utiliza mas abajo para la consulta de los antiguos*/
        $ultima_fecha=$row['fecha_creacion'];
        $conteo++;
}/****************************************************************************While**********************************************************************************************/
?>


                

        </form>

        </table>

        <div style="margin-bottom:15px; margin-top:15px;" ><img id="aspirantes_cuerpo_bolsaIcono" src="../_globales/images/personicon.png" > <h2 style=" display:inline; font-size:30px">Semana pasada:</h2></div>

<br>

    <table style="text-align: center ;width: 100%; padding-right: 20px; border:0px;" cellspacing="0" cellpadding="0" border="1" >

      <form action='' method='POST' id="aspirantes_cuerpo_formulario2">

<?
////////////////////////////////////////
////////////SEMANA PASADA//////////////
//////////////////////////////////////

$conteo=1;

$select_bolsa=$con->query("SELECT * FROM usuarios WHERE ".$_SESSION['aspirantes_modalidad_query']." AND YEARWEEK(fecha_creacion, 1) = YEARWEEK( CURDATE() - INTERVAL 1 WEEK, 1) ORDER BY id_usuario DESC");
while($row=$select_bolsa->fetch_assoc()){/****************************************************************************While**********************************************************************************************/
        $nombres=explode(' ',$row['nombres']);
        $apellidos=explode(' ',$row['apellidos']);
        $edad=floor((time() - strtotime($row['fecha_de_nacimiento'])) / 31556926);
       
        /*Se verifica la disponibilidad de las imagenes y se muestra la más propicia*/
        if (@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_fotos_perfil/'.$row['id_usuario'].'.jpg')) {$image="../_globales/images/".$_SESSION['nombre_base']."_fotos_perfil/".$row['id_usuario'].".jpg";}
        elseif (@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_cedulas_mano/'.$row['id_usuario'].'.jpg')) {$image="../_globales/images/".$_SESSION['nombre_base']."_cedulas_mano/".$row['id_usuario'].".jpg";}
        else{$image='../_globales/images/no_image.png';}
        
         /*Formateo de la columna de fecha*/
        $fecha_column=date_parse($row['fecha_creacion']);
        $fecha_column=$fecha_column['day']." / ".substr($meses[$fecha_column['month']-1], 0,3);

        /*Checkeo Youtube*/
        if ($row['url_entrevista']!='' and strlen($row['url_entrevista'])>'5'){/*Checkeo Youtube*/
                    $yt_link="<a href='".$row['url_entrevista']."' target='_blank'><img class='img' id='aspirantes_cuerpo_formulario2_botonyoutube' src='../_globales/images/youtubeicon.png' id='aspirantes_cuerpo_formulario2_botonyoutube.png'></a>";
        }/*Checkeo Youtube*/else{/*Checkeo Youtube*/
                    $yt_link="<img class='img' id='aspirantes_cuerpo_formulario2_botonyoutube' src='../_globales/images/youtubeicongris.png' id='aspirantes_cuerpo_formulario2_botonyoutube.png'>";
        }/*Checkeo Youtube*/

        /*Disponibilidad*/
        $dispo_r=array(         1 => "&#9729;",//Mañana
                                2 => "&#9788;",//Tarde
                                3 => "&#9790;",//Noche
                            );
        $termi='';
        $disponibilidad=explode('|',$row['disponibilidad']);
        foreach ($disponibilidad as $term ) {/*Foreach*/
                if(isset($dispo_r[$term])){$termi.=" ".$dispo_r[$term];}
        }/*Foreach*/


        /*Checkeo solicitudes*/
        $select_reserva=$con->query("SELECT usuarios_solicitudes.fecha_creacion,usuarios.usuario FROM usuarios_solicitudes 
                                    LEFT JOIN usuarios ON (usuarios_solicitudes.id_lider=usuarios.id_usuario)
                                    WHERE usuarios_solicitudes.id_usuario=".$row['id_usuario']." 
                                    AND usuarios_solicitudes.fecha_creacion > DATE_SUB(NOW(), INTERVAL 24 HOUR)
                                    AND usuarios_solicitudes.estado=1 
                                    ORDER BY usuarios_solicitudes.fecha_creacion DESC LIMIT 1");
        
        
        if($row['estado']!='0'){/*Si el usuario ya fue activado*/

                if($row['estado']=='1'){echo "<tr style='background-color:#EBFFD7;'>";}elseif( ($row['estado']=='2') or ($row['estado']=='3')){echo "<tr style='background-color:#fff0f0;'>";}
                echo "<td><number>$conteo.</number></td>";
                echo "<td><img class='img' src='$image' style='width: 120px;'></td>";
                echo "<td><a href='../entrevistas/entrevistas.php?editar_usuario=".$row['id_usuario']."'><span class='span'>".$nombres['0']." ".$apellidos['0']." (".$row['usuario'].") $termi</span></a></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><p class='p'>$fecha_column</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><b class='b' >Edad</b></td>";
                echo "<td><p class='p'>$edad</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td>$yt_link</td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><p class='p' id='p'>".$row['ciudad']."</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td>".$estados[$row['estado']]." en ";
                if(isset($estudios[$row['id_estudio']])){echo ucwords($estudios[$row['id_estudio']]);}else{echo "Desconocido";}
                echo "!</p></td>";
                echo "<td>";
                if($row['modalidad']=='1'){echo "<img src='../_globales/images/iconoestudio.png' alt='Estudio'>";}
                elseif($row['modalidad']=='2'){echo "<img src='../_globales/images/iconosatelite.png' alt='Satelite'>";}
                elseif($row['modalidad']=='1|2'){echo "<img src='../_globales/images/iconoambos.png' alt='Ambos'>";}
                echo "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td colspan='20'>";
                echo "<img src='images/separador.png'>";
                echo "</td>";
                echo "</tr>";

        }/*Si el usuario ya fue activado*/elseif($select_reserva->num_rows > 0){/*Existe reserva*/

        /*Fecha Solicitud*/
        $select_reserva=$select_reserva->fetch_assoc();
        $fecha_ultima_reserva=$select_reserva['fecha_creacion'];

        /*Hace cuanto se hizo la solicitud*/
        $diferencia_ultima_reserva=fechas_mediano_y_largo_tareas($fecha_ultima_reserva);
                    
        
                echo "<tr style='background-color:#F3F4F4;'>";
                echo "<td><number>$conteo.</number></td>";
                echo "<td><img class='img' src='$image' style='width: 120px;'></td>";
                echo "<td><a href='../entrevistas/entrevistas.php?editar_usuario=".$row['id_usuario']."'><span class='span'>".$nombres['0']." ".$apellidos['0']." (".$row['usuario'].") $termi</span></a></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><p class='p'>$fecha_column</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><b class='b' >Edad</b></td>";
                echo "<td><p class='p'>$edad</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td>$yt_link</td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><p class='p' id='p'>".$row['ciudad']."</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><p id='solicitadoPor'>Para ".ucfirst($select_reserva['usuario'])."<br>";
                echo "<img style='vetical-align:middle' src='../_globales/images/stopwatch.png'>  $diferencia_ultima_reserva</p></td>";
               echo "<td>";
                if($row['modalidad']=='1'){echo "<img src='../_globales/images/iconoestudio.png' alt='Estudio'>";}
                elseif($row['modalidad']=='2'){echo "<img src='../_globales/images/iconosatelite.png' alt='Satelite'>";}
                elseif($row['modalidad']=='1|2'){echo "<img src='../_globales/images/iconoambos.png' alt='Ambos'>";}
                echo "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td colspan='20'>";
                echo "<img src='../_globales/images/separador.png'>";
                echo "</td>";
                echo "</tr>";
        
       }/*Existe reserva*/else{/*Existe reserva*/

                echo "<tr>";
                echo "<td><number>$conteo.</number></td>";
                echo "<td><img class='img' src='$image' style='max-width: 120px;'></td>";
                echo "<td><a href='../entrevistas/entrevistas.php?editar_usuario=".$row['id_usuario']."'><span class='span'>".$nombres['0']." ".$apellidos['0']." (".$row['usuario'].") $termi</span></a></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><p class='p'>$fecha_column</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><b class='b' >Edad</b></td>";
                echo "<td><p class='p'>$edad</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td>$yt_link</td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><p class='p' id='p'>".$row['ciudad']."</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><button id='aspirantes_cuerpo_formulario2_activar' class='input' type='submit' name='reservar' value='".$row['id_usuario']."'>Solicitar</button></td>";
                echo "<td>";
                if($row['modalidad']=='1'){echo "<img src='../_globales/images/iconoestudio.png' alt='Estudio'>";}
                elseif($row['modalidad']=='2'){echo "<img src='../_globales/images/iconosatelite.png' alt='Satelite'>";}
                elseif($row['modalidad']=='1|2'){echo "<img src='../_globales/images/iconoambos.png' alt='Ambos'>";}
                echo "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td colspan='20'>";
                echo "<img src='images/separador.png'>";
                echo "</td>";
                echo "</tr>";

       
}/*Existe reserva*/


        
        unset($diferencia_ultima_reserva);
        unset($formateo_diferencia);
        /*Esta fecha es la fecha de la ultima persona de la tabla, y se utiliza mas abajo para la consulta de los antiguos*/
        $ultima_fecha=$row['fecha_creacion'];
        $conteo++;
}/****************************************************************************While**********************************************************************************************/
?>


                

        </form>

        </table>
     
    <div id="aspirantes_cuerpo_contenedor_verAntiguos" style='margin:30px;' >
    <input type='image' src="../_globales/images/verantiguos.png" id='aspirantes_cuerpo_verAntiguos' class='show' >
    </div>


<div id='post_div'><!--ABRE post_div-->

      <table style="text-align: center ;width: 100%; padding-right: 20px; border:0px;" cellspacing="0" cellpadding="0" border="1" >

      <form action='' method='POST' id="aspirantes_cuerpo_formulario2">


<?
/**************************************************************************Antiguos*****************************************************************************************************/
////////////////////////////////////////
///////////////ANTIGUOS////////////////
//////////////////////////////////////

$conteo=1;

/*La fecha desde cuando se deben escoger los usuarios, esta variable se debe crear al final de las consultas de la semana actual o la semana pasada*/
if(!isset($ultima_fecha)){$ultima_fecha=$lahoraencolombia;}
//echo $ultima_fecha;

$select_bolsa=$con->query("SELECT * FROM usuarios WHERE  ".$_SESSION['aspirantes_modalidad_query']." AND fecha_creacion < '$ultima_fecha' ORDER BY fecha_creacion DESC");
while($row=$select_bolsa->fetch_assoc()){/****************************************************************************While**********************************************************************************************/
        $nombres=explode(' ',$row['nombres']);
        $apellidos=explode(' ',$row['apellidos']);
        $edad=floor((time() - strtotime($row['fecha_de_nacimiento'])) / 31556926);
        
        /*Se verifica la disponibilidad de las imagenes y se muestra la más propicia*/
        if (@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_fotos_perfil/'.$row['id_usuario'].'.jpg')) {$image="../_globales/images/".$_SESSION['nombre_base']."_fotos_perfil/".$row['id_usuario'].".jpg";}
        elseif (@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_cedulas_mano/'.$row['id_usuario'].'.jpg')) {$image="../_globales/images/".$_SESSION['nombre_base']."_cedulas_mano/".$row['id_usuario'].".jpg";}
        else{$image='../_globales/images/no_image.png';}

        
        /*Formateo de la columna de fecha*/
        $fecha_column=date_parse($row['fecha_creacion']);
        $fecha_column=$fecha_column['day']." / ".substr($meses[$fecha_column['month']-1], 0,3);

        /*Checkeo Youtube*/
        if ($row['url_entrevista']!='' and strlen($row['url_entrevista'])>'5'){/*Checkeo Youtube*/
                    $yt_link="<a href='".$row['url_entrevista']."' target='_blank'><img class='img' id='aspirantes_cuerpo_formulario2_botonyoutube' src='../_globales/images/youtubeicon.png' id='aspirantes_cuerpo_formulario2_botonyoutube.png'></a>";
        }/*Checkeo Youtube*/else{/*Checkeo Youtube*/
                    $yt_link="<img class='img' id='aspirantes_cuerpo_formulario2_botonyoutube' src='../_globales/images/youtubeicongris.png' id='aspirantes_cuerpo_formulario2_botonyoutube.png'>";
        }/*Checkeo Youtube*/
        
        /*Disponibilidad*/
        $dispo_r=array(         1 => "&#9729;",//Mañana
                                2 => "&#9788;",//Tarde
                                3 => "&#9790;",//Noche
                            );
        $termi='';
        $disponibilidad=explode('|',$row['disponibilidad']);
        foreach ($disponibilidad as $term ) {/*Foreach*/
                if(isset($dispo_r[$term])){$termi.=" ".$dispo_r[$term];}
        }/*Foreach*/
        
        /*Checkeo solicitudes*/
        $select_reserva=$con->query("SELECT usuarios_solicitudes.fecha_creacion,usuarios.usuario FROM usuarios_solicitudes 
                                    LEFT JOIN usuarios ON (usuarios_solicitudes.id_lider=usuarios.id_usuario)
                                    WHERE usuarios_solicitudes.id_usuario=".$row['id_usuario']." 
                                    AND usuarios_solicitudes.estado=1 
                                    AND usuarios_solicitudes.fecha_creacion > DATE_SUB(NOW(), INTERVAL 24 HOUR)
                                    ORDER BY usuarios_solicitudes.fecha_creacion DESC LIMIT 1");
        

        if($row['estado']!='0'){/*Si el usuario ya fue activado*/

                if($row['estado']=='1'){echo "<tr style='background-color:#EBFFD7;'>";}elseif( ($row['estado']=='2') or ($row['estado']=='3')){echo "<tr style='background-color:#fff0f0;'>";}
                echo "<td><number>$conteo.</number></td>";
                echo "<td><img class='img' src='$image' style='width: 120px;'></td>";
                echo "<td><a href='../entrevistas/entrevistas.php?editar_usuario=".$row['id_usuario']."'><span class='span'>".$nombres['0']." ".$apellidos['0']." (".$row['usuario'].") $termi</span></a></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><p class='p'>$fecha_column</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><b class='b' >Edad</b></td>";
                echo "<td><p class='p'>$edad</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td>$yt_link</td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><p class='p' id='p'>".$row['ciudad']."</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td>".$estados[$row['estado']]." en ";
                if(isset($estudios[$row['id_estudio']])){echo ucwords($estudios[$row['id_estudio']]);}else{echo "Desconocido";}
                echo "!</p></td>";
                echo "<td>";
                if($row['modalidad']=='1'){echo "<img src='../_globales/images/iconoestudio.png' alt='Estudio'>";}
                elseif($row['modalidad']=='2'){echo "<img src='../_globales/images/iconosatelite.png' alt='Satelite'>";}
                elseif($row['modalidad']=='1|2'){echo "<img src='../_globales/images/iconoambos.png' alt='Ambos'>";}
                echo "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td colspan='20'>";
                echo "<img src='images/separador.png'>";
                echo "</td>";
                echo "</tr>";

        }/*Si el usuario ya fue activado*/elseif($select_reserva->num_rows > 0){/*Existe reserva*/

                    /*Fecha Solicitud*/
                    $select_reserva=$select_reserva->fetch_assoc();
                    $fecha_ultima_reserva=$select_reserva['fecha_creacion'];

                    /*Hace cuanto se hizo la solicitud*/
                    $diferencia_ultima_reserva=fechas_mediano_y_largo_tareas($fecha_ultima_reserva);



                echo "<tr style='background-color:#F3F4F4;'>";
                echo "<td><number>$conteo.</number></td>";
                echo "<td><img class='img' src='$image' style='width: 120px;'></td>";
                echo "<td><a href='../entrevistas/entrevistas.php?editar_usuario=".$row['id_usuario']."'><span class='span'>".$nombres['0']." ".$apellidos['0']." (".$row['usuario'].") $termi</span></a></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><p class='p'>$fecha_column</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><b class='b'>Edad</b></td>";
                echo "<td><p class='p'>$edad</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td>$yt_link</td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><p class='p' id='p'>".$row['ciudad']."</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><p id='solicitadoPor'>Para ".ucfirst($select_reserva['usuario'])."<br>";
                echo "<img style='vetical-align:middle' src='../_globales/images/stopwatch.png'>  $diferencia_ultima_reserva</p></td>";
                echo "<td>";
                if($row['modalidad']=='1'){echo "<img src='../_globales/images/iconoestudio.png' alt='Estudio'>";}
                elseif($row['modalidad']=='2'){echo "<img src='../_globales/images/iconosatelite.png' alt='Satelite'>";}
                elseif($row['modalidad']=='1|2'){echo "<img src='../_globales/images/iconoambos.png' alt='Ambos'>";}
                echo "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td colspan='20'>";
                echo "<img src='../_globales/images/separador.png'>";
                echo "</td>";
                echo "</tr>";
        
        }/*Existe reserva*/else{/*Existe reserva*/

                echo "<tr>";
                echo "<td><number>$conteo.</number></td>";
                echo "<td><img class='img' src='$image' style='max-width: 120px;'></td>";
                echo "<td><a href='../entrevistas/entrevistas.php?editar_usuario=".$row['id_usuario']."'><span class='span'>".$nombres['0']." ".$apellidos['0']." (".$row['usuario'].") $termi</span></a></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><p class='p'>$fecha_column</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><b class='b'>Edad</b></td>";
                echo "<td><p class='p'>$edad</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td>$yt_link</td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><p class='p' id='p'>".$row['ciudad']."</p></td>";
                echo "<td><span class='span'>|</span></td>";
                echo "<td><button id='aspirantes_cuerpo_formulario2_activar' class='input' type='submit' name='reservar' value='".$row['id_usuario']."'>Solicitar</button></td>";
                echo "<td>";
                if($row['modalidad']=='1'){echo "<img src='../_globales/images/iconoestudio.png' alt='Estudio'>";}
                elseif($row['modalidad']=='2'){echo "<img src='../_globales/images/iconosatelite.png' alt='Satelite'>";}
                elseif($row['modalidad']=='1|2'){echo "<img src='../_globales/images/iconoambos.png' alt='Ambos'>";}
                echo "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td colspan='20'>";
                echo "<img src='images/separador.png'>";
                echo "</td>";
                echo "</tr>";

        }/*Existe reserva*/



        unset($conteo_solicitudes);
        unset($diferencia_ultima_reserva);
        $conteo++;
}/****************************************************************************While**********************************************************************************************/
?>

        </form>

        </table>
</div><!--CIERRA post_div-->

  </div>

  <?php include '../_includes-functions/footer.php';?>

</body>
</html>