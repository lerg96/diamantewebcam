<?
include "../_includes-functions/conexion_improved.php";
include "../_includes-functions/seguridad.php"; 
include "../_includes-functions/funciones.php";
include '../_includes-functions/barraNavegacion.php';


/*SESSIONS*/
if(!isset($_SESSION['estadisticaslider_desde'])){
                                                     if(DATE('j')<16){/*Del 01 al 15*/
                                                      
                                                      $_SESSION['estadisticaslider_desde']=DATE('Y-m-01');
                                                      $_SESSION['estadisticaslider_hasta']=DATE('Y-m-d');
                                                      
                                                      }/*Del 01 al 15*/else{/*Del 16 al ultimo dia del mes*/
                            
                                                      $_SESSION['estadisticaslider_desde']=DATE('Y-m-16');
                                                      $_SESSION['estadisticaslider_hasta']=DATE('Y-m-d');
                                                      
                                                     }/*Del 16 al ultimo dia del mes*/
                                                    }


/*El usuario que ingrese a esta pagina solo puede revisar sus propias ventas*/
$_SESSION['estadisticaslider_modelo']=$_SESSION['id_usuario'];
/*Se debe poner la siguiente session para que madre de comisiones funcione correctamente*/
$_SESSION['estadisticaslider_incluir_inactivos']='1';
/*Session que permite editar una venta*/
$_SESSION['estadisticaslider_editar1']=0;
//echo $_SESSION['estadisticaslider_periodo'];

/*Boton Enviar*/
if(isset($_POST['enviar'])){/*Boton Enviar*/
                            //echo "hola";
                          
                            /*Perido Completo*/
                            $periodo_completo=$_POST['periodo_completo'];
                            //echo $periodo_completo."<br>";

                            /*Periodo Desde*/
                            $periodo_desde=$_POST['periodo_desde'];
                            //echo $periodo_desde."<br>";
                            
                            /*Periodo Hasta*/
                            $periodo_hasta=$_POST['periodo_hasta'];
                            //echo $periodo_desde."<br>";

                     
                            /*Periodos*/
                             if( ($periodo_desde!='') AND ($periodo_hasta!='') ){/*Periodo Fraccionado*/

                                              $_SESSION['estadisticaslider_desde']=$_POST['periodo_desde'];
                                              $_SESSION['estadisticaslider_hasta']=$_POST['periodo_hasta'];;
                                              
                                             
                            }/*Periodo Fraccionado*/elseif (strpos($periodo_completo, '|') != false){/*Periodo Completo*/

                                              $split_periodo=explode('|',$_POST['periodo_completo']);
                                              
                                              $_SESSION['estadisticaslider_desde']=$split_periodo['0'];
                                              $_SESSION['estadisticaslider_hasta']=$split_periodo['1'];

                                              /*Sesiones que populan la primer opcion del select -FECHA COMPLETA-*/
                                               $_SESSION['estadisticaslider_periodocompleto_select']['value']=$_POST['periodo_completo'];
                                               $fecha_ini=date_parse($_SESSION['estadisticaslider_desde']);
                                               $fecha_fin=date_parse($_SESSION['estadisticaslider_hasta']);
                                               $_SESSION['estadisticaslider_periodocompleto_select']['contenido']=substr($meses[$fecha_ini['month']-1],0,3)." ".$fecha_ini['day']." - ".substr($meses[$fecha_fin['month']-1],0,3)." ".$fecha_fin['day'].", ".$fecha_fin['year'];
                            
                            }/*Periodo Completo*/
                           

                          
}/*Boton Enviar*/
?>

<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" type="text/css" href="../_globales/styles/resetcss.css">
    <link rel="stylesheet" type="text/css" href="../_includes-functions/styles/barraNavegacion.css">
    <link rel="stylesheet" type="text/css" href="../_includes-functions/styles/footer.css">
    <link rel="stylesheet" type="text/css" href="styles/estadisticasLider.css">

    <title> Estadisticas de Ventas Modelos </title>

 


</head>
<body>

    <div id="estadisticasLider_cuerpo"> <!-- ABRE estadisticasLider_cuerpo -->

        <img id="estadisticasLider_cuerpo_estadisticasIcono" src="images/estadisticasicono.png"><h1 style="display: inline;">Estadisticas de ventas modelos</h1>

        <p id="estadisticasLider_cuerpo_primerParrafo">En este panel podrá ver las ventas realizadas en su cuenta durante periodos de tiempo específicos, seleccione la opción que más le convenga:</p><br>

            <form id="estadisticasLider_cuerpo_formulario1" method='POST' action=''>
                <table cellpadding="0" cellspacing="0"  width="650" style="" >

                  <tr>
                      <td>
                          <label>Seleccione periodo de facturacion</label>
                      </td>
                      <td>
                          <select name='periodo_completo'>
                      <?

                      /*Primera opción a seleccionar*/
                      echo "<option value='";
                      if(isset($_SESSION['estadisticaslider_periodocompleto_select']['value'])){echo $_SESSION['estadisticaslider_periodocompleto_select']['value'];}
                      echo "'>";
                      if(isset($_SESSION['estadisticaslider_periodocompleto_select']['contenido'])){echo $_SESSION['estadisticaslider_periodocompleto_select']['contenido'];}else{echo "Seleccionar";}
                      echo "</option>";

                      if(DATE('j')>16){/*Del 01 al 15*/

                            /*Mes Actual*/
                            echo "<option value='".DATE('Y-m-16')."|".DATE('Y-m-d')."'>".DATE('M 16')." - ".DATE('M d, Y')." </option>";

                      }/*Del 01 al 15*/

                            
                            /*Mes Actual*/
                            echo "<option value='".DATE('Y-m-01')."|".DATE('Y-m-15')."'>".DATE('M 01')." - ".DATE('M 15, Y')."</option>";
                            
                            /*-1 Mes*/
                            echo "<option value='".DATE('Y-m-16', strtotime("-1 months"))."|".DATE('Y-m-t', strtotime("-1 months"))."'>".DATE('M 16', strtotime("-1 months"))." - ".DATE('M t, Y', strtotime("-1 months"))."</option>";
                            echo "<option value='".DATE('Y-m-01', strtotime("-1 months"))."|".DATE('Y-m-15', strtotime("-1 months"))."'>".DATE('M 01', strtotime("-1 months"))." - ".DATE('M 15, Y', strtotime("-1 months"))."</option>";
                            
                            /*-2 Mes*/
                            echo "<option value='".DATE('Y-m-16', strtotime("-2 months"))."|".DATE('Y-m-t', strtotime("-2 months"))."'>".DATE('M 16', strtotime("-2 months"))." - ".DATE('M t, Y', strtotime("-2 months"))."</option>";
                            echo "<option value='".DATE('Y-m-01', strtotime("-2 months"))."|".DATE('Y-m-15', strtotime("-2 months"))."'>".DATE('M 01', strtotime("-2 months"))." - ".DATE('M 15, Y', strtotime("-2 months"))."</option>";
                            
                            /*-3 Mes*/
                            echo "<option value='".DATE('Y-m-16', strtotime("-3 months"))."|".DATE('Y-m-t', strtotime("-3 months"))."'>".DATE('M 16', strtotime("-3 months"))." - ".DATE('M t, Y', strtotime("-3 months"))."</option>";
                            echo "<option value='".DATE('Y-m-01', strtotime("-3 months"))."|".DATE('Y-m-15', strtotime("-3 months"))."'>".DATE('M 01', strtotime("-3 months"))." - ".DATE('M 15, Y', strtotime("-3 months"))."</option>";
                            
                            /*-4 Mes*/
                            echo "<option value='".DATE('Y-m-16', strtotime("-4 months"))."|".DATE('Y-m-t', strtotime("-4 months"))."'>".DATE('M 16', strtotime("-4 months"))." - ".DATE('M t, Y', strtotime("-4 months"))."</option>";
                            echo "<option value='".DATE('Y-m-01', strtotime("-4 months"))."|".DATE('Y-m-15', strtotime("-4 months"))."'>".DATE('M 01', strtotime("-4 months"))." - ".DATE('M 15, Y', strtotime("-4 months"))."</option>";
                            
                            /*-1 Mes*/
                            echo "<option value='".DATE('Y-m-16', strtotime("-5 months"))."|".DATE('Y-m-t', strtotime("-5 months"))."'>".DATE('M 16', strtotime("-5 months"))." - ".DATE('M t, Y', strtotime("-5 months"))."</option>";
                            echo "<option value='".DATE('Y-m-01', strtotime("-5 months"))."|".DATE('Y-m-15', strtotime("-5 months"))."'>".DATE('M 01', strtotime("-5 months"))." - ".DATE('M 15, Y', strtotime("-5 months"))."</option>";
                            
                            /*-1 Mes*/
                            echo "<option value='".DATE('Y-m-16', strtotime("-6 months"))."|".DATE('Y-m-t', strtotime("-6 months"))."'>".DATE('M 16', strtotime("-6 months"))." - ".DATE('M t, Y', strtotime("-6 months"))."</option>";
                            echo "<option value='".DATE('Y-m-01', strtotime("-6 months"))."|".DATE('Y-m-15', strtotime("-6 months"))."'>".DATE('M 01', strtotime("-6 months"))." - ".DATE('M 15, Y', strtotime("-6 months"))."</option>";

                    
                      ?>
                              

                          </select>
                      </td>
                  </tr>
                  <tr>
                      <td>
                          
                          <label>Seleccione rango de tiempo:</label>
                      </td>
                      <td>
                          <label>Desde</label>
                          <input type="date" name='periodo_desde'></input>
                      </td>
                      <td>
                          <label>Hasta</label>
                          <input type="date" name='periodo_hasta' ></input>
                      </td>
                  </tr>
                  <tr>
                  <tr>
                      <td>
                          <input class="allinputs" id="estadisticasLider_cuerpo_formulario1_verDatos" type="submit" name='enviar' value="Ver datos >" >
                      </td>
                  </tr>
              </table>   
          </form>  

          <br><br>



<!-- ABRE estadisticasLider_cuerpo_contenedorTabla -->


<?
include("../_includes-functions/madre_de_estadisticas.php");




          //print_r($suma_ventas_por_usuario);
          echo "<h1 id='estadisticasLider_cuerpo_totalVentas'>Total ventas: <b>USD $".number_format($total_ventas_modelos_usd,2,'.',',')."</b></h1>";
          //echo "<a style='cursor:pointer;' onclick=\"window.open('reporteModelos.php?usuario=$id_usuario&inicio=".$_SESSION['estadisticaslider_desde']."&final=".$_SESSION['estadisticaslider_hasta']."','',' scrollbars=yes,menubar=no,width=100, resizable=yes,toolbar=no,location=no,status=no')\">";
          //echo "<img style='margin-left:20px;'  src='../_globales/images/printericon.png'>";
          //echo "</a>";
          echo "<br>";
          echo "<h1 id='estadisticasLider_cuerpo_totalVentas'>Promedio ventas: <b>USD $".number_format($promedio_ventas_modelos_usd,2,'.',',')."</b></h1><br>";

          echo "<div id='estadisticasLider_cuerpo_deducciones'>";
                
                echo "<table>";
                //echo "<tr><td><h3>Comisión Modelos:&nbsp&nbsp</h3></td><td><h3><b>USD ".number_format($total_comisiones_modelos,2,'.',',')."</b></h3></td></tr>";
                //echo "<tr><td><h3>Comisión Lider:&nbsp&nbsp</h3></td><td><h3><b>USD ".number_format($total_comisiones_lider,2,'.',',')."</b></h3></td></tr>";
                //echo "<tr><td><h3>Comisión Referentes:&nbsp&nbsp</h3></td><td><h3><b>USD ".number_format($total_comisiones_referentes,2,'.',',')."</b></h3></td></tr>";
                //echo "<tr><td><h3>Comisión Estudio:&nbsp&nbsp</h3></td><td><h3><b>USD ".number_format($total_comisiones_estudio,2,'.',',')."</b></h3></td></tr>";
                echo "</table>";

                //echo "<div style='margin-top:10px; margin-bottom:10px;'>";
                //echo "<br><input type='checkbox' name=''> <a style='color:#700013;' href=''><img style='vertical-align:middle;' src='../_globales/images/printericonred.png'> Imprimir seleccionados</a><br>";
                //echo "</div>";

          echo "</div>";

echo "<form id='estadisticasLider_cuerpo_formulario1' method='POST' action=''>";
      
             
                          
      
      if(isset($linea1) and !empty($linea1) ){/*Si existe Linea 1*/
            
            foreach ($linea1 as $id_usuario => $lineas1) {/*Escribe Linea 1*/

                  echo "<div id='estadisticasLider_cuerpo_contenedorTabla'>";
                  echo " <div style='margin:10px;' >";
                  //echo " <input type='checkbox'>";
                  echo "<a style='cursor:pointer;' onclick=\"window.open('reporteModelos.php?usuario=$id_usuario&inicio=".$_SESSION['estadisticaslider_desde']."&final=".$_SESSION['estadisticaslider_hasta']."','',' scrollbars=yes,menubar=no,width=100, resizable=yes,toolbar=no,location=no,status=no')\">";
                  echo "<img style='margin-left:20px;'  src='../_globales/images/printericon.png'>";
                  echo "</a><br>";
                  echo "</div>";
                  echo "<table id='estadisticasLider_cuerpo_contenedorTabla_tablaEstadisticas' cellspacing='0' cellpadding='5' height='141' border='1' >";                  
                   echo "<thead><tr class='tr'>";
                                                $conteo_casillas=0;
                                                
                                                foreach ($lineas1 as $casilla) {/*Cada casilla de la primer linea de la tabla**********************************************************************************************************/
                                                      
                                                      echo "<td style='width:200px;'>";
                                                      if($conteo_casillas==0){/*Solo a la primer casilla se le pone el icono de satelite o de estudio*/
                                                                              if($modalidad[$id_usuario]=='1'){echo "<img src='../_globales/images/iconoestudio.png' alt='Estudio' title='Estudio'><br>";}
                                                                              elseif($modalidad[$id_usuario]=='2'){echo "<img src='../_globales/images/iconosatelite.png' alt='Satelite' title='Satelite'><br>";}
                                                      }/*Solo a la primer casilla se le pone el icono de satelite o de estudio*/
                                                      echo $casilla;
                                                      if($conteo_casillas==0){/*Solo a la primer casilla se le pone el icono de satelite o de estudio*/
                                                                            
                                                      }/*Solo a la primer casilla se le pone el icono de satelite o de estudio*/
                                                      echo "</td>";
                                                      $conteo_casillas++;
                                                }/*Cada casilla de la primer linea de la tabla*****************************************************************************************************************************************/
                                               
                  echo "</tr></thead>";    

                        if(isset($linea2[$id_usuario]) and !empty($linea2[$id_usuario]) ){/*Si existe Linea 2*/
                      
                                          foreach ($linea2[$id_usuario] as $lineas2) {/*Escribe Linea 2*/
                                                                                              echo "<tr>".$lineas2."</tr>";
                                                                                     }/*Escribe Linea 2*/                     
                         }/*Si existe Linea 2*/

                  echo "</table>";
                 
                  echo "<div id='estadisticaslider_cuerpo_contenedortabla_indicadoresporusuario'><!--ABRE estadisticaslider_cuerpo_contenedortabla_indicadoresporusuario-->";
                  
                 
                                    /*Se muestra la sumatoria de los dolares hechos por la modelo*/
                  echo "<p><span>Total Ventas:</span> $".number_format($suma_ventas_por_usuario_usd[$id_usuario],2,'.','.')." USD / $".number_format($suma_ventas_por_usuario_usd[$id_usuario]*$cop_val_deducido,0,'.','.')." COP</span></p>";
                  
                  /*Dias Con Inasistencias*/
                  echo "<p><span>Total Inasistencias:</span>".$conteo_rojos_por_usuario[$id_usuario]."</p>";
                  
                  /*Dias Penalizables*/
                  echo "<p><span>Total Días Penalizables:</span>  ".$dias_penalizables[$id_usuario]."</p>";
                  
                  /*Porcentaje Inicial*/
                  //echo "<p><span>Porcentaje Inicial: </span>".$pocerntaje_pago[$id_usuario]."%</p>";

                  /*Porcentaje a descontar*/
                  echo "<p><span>Porcentaje a Descontar: -</span>".$porcentaje_descontable[$id_usuario]."%</p>";

                  /*Porcentaje Final*/
                  //echo "<p><span>Porcentaje Final: </span>".$porcentaje_final[$id_usuario]."%</p>";
                  
                  
                  /*Pago Inicial*/
                  echo "<p><span>Pago a Modelo:</span> $".number_format($pago_inicial_usd[$id_usuario],2,'.','.')." USD / $".number_format($pago_inicial_usd[$id_usuario]*$cop_val_deducido,0,'.','.')." COP</p>";
                  
                  /*Pago Final*/
                  echo "<p><span>Pago con Descuentos:</span> $".number_format($pago_final_usd[$id_usuario],2,'.','.')." USD / $".number_format($pago_final_usd[$id_usuario]*$cop_val_deducido,0,'.','.')." COP</p>";

                  echo "<br>";

                  
                  echo "</div><!--CIERRA estadisticaslider_cuerpo_contenedortabla_indicadoresporusuario-->";

                  echo "</div>";
                  echo "<div><img src='../_globales/images/separador.png' style='margin-top:15px;'></div>";

              }/*Escribe Linea 1*/
                 

      }/*Si existe Linea 1*/
     
      //$linea1='';
      unset($linea1);
      unset($linea2);

echo "</form>";




?>

 <p style="margin-right:20px;" >En la siguiente tabla podrá observar el total de ganancias logradas durante toda la vida de creación de este perfil
deducida por periodos de pago. (Todos los datos se reflejan en dólares</p>
<br>

<?
 echo "<tr>";
                            
                            $inicio=DATE('Y-m-01', strtotime("-6 months"))." 00:00:00";
                            //echo $inicio."<br>";
                            $final=DATE('Y-m-t')." 23:59:59";
                            //echo $final."<br>";
                            $dias_de_ventas=$con->query("SELECT SUM(ventas.venta_usd) as suma_ventas_dia FROM ventas 
                                                          WHERE (ventas.fecha_creacion BETWEEN '".$inicio."'  AND '".$final."') AND ventas.id_usuario='".$_SESSION['id_usuario']."'")->fetch_assoc();
                            $dias_de_ventas=$dias_de_ventas['suma_ventas_dia'];
                            if(empty($dias_de_ventas)){$dias_de_ventas='0.00';}
                           

?>
<h2 style="font-size:20px;" >Gran total ganancias: <b>USD $<? echo $dias_de_ventas; ?></b> </h2>


  <table id="estadisticasLider_cuerpo_tablaGananciasDeTodaLaVida" style=" text-align:left;"  cellspacing="0" cellpadding="5" width="700" height="" border="1" >  
  <thead>
    
    <tr>
      
      <td>
        Fecha de periodo
      </td>

      <td>
        Total ganancias
      </td>

    </tr>

  </thead>



<?                    
                      /*Mes Actual***********************************************************************************************************************************************************************************************************************************************/
                      if(DATE('j')>16){/*Del 16 al Ultimo dia*/

                            /*Mes Actual*/
                            echo "<tr>";
                            echo "<td>".DATE('M 16')." - ".DATE('M d, Y')."</td>";
                            $inicio=DATE('Y-m-16')." 00:00:00";
                            //echo $inicio."<br>";
                            $final=DATE('Y-m-t')." 23:59:59";
                            //echo $final."<br>";
                            $dias_de_ventas=$con->query("SELECT SUM(ventas.venta_usd) as suma_ventas_dia FROM ventas 
                                                          WHERE (ventas.fecha_creacion BETWEEN '".$inicio."'  AND '".$final."') AND ventas.id_usuario='".$_SESSION['id_usuario']."'")->fetch_assoc();
                            $dias_de_ventas=$dias_de_ventas['suma_ventas_dia'];
                            if(empty($dias_de_ventas)){$dias_de_ventas='0.00';}
                            echo "<td>$dias_de_ventas</td>";
                            echo "</tr>";

                      }/*Del 16 al Ultimo dia*/

                            
                            
                            echo "<tr>";
                            echo "<td>".DATE('M 01')." - ".DATE('M 15, Y')."</td>";
                            $inicio=DATE('Y-m-01')." 00:00:00";
                            //echo $inicio."<br>";
                            $final=DATE('Y-m-15')." 23:59:59";
                            //echo $final."<br>";
                            $dias_de_ventas=$con->query("SELECT SUM(ventas.venta_usd) as suma_ventas_dia FROM ventas 
                                                          WHERE (ventas.fecha_creacion BETWEEN '".$inicio."'  AND '".$final."') AND ventas.id_usuario='".$_SESSION['id_usuario']."'")->fetch_assoc();
                            $dias_de_ventas=$dias_de_ventas['suma_ventas_dia'];
                            if(empty($dias_de_ventas)){$dias_de_ventas='0.00';}
                            echo "<td>$dias_de_ventas</td>";
                            echo "</tr>";
                            //var_dump($dias_de_ventas);

                            
                            /*-1 Mes***********************************************************************************************************************************************************************************************************************************************/
                            echo "<tr>";
                            echo "<td>".DATE('M 16', strtotime("-1 months"))." - ".DATE('M t, Y', strtotime("-1 months"))."</td>";
                            $inicio=DATE('Y-m-16', strtotime("-1 months"))." 00:00:00";
                            //echo $inicio."<br>";
                            $final=DATE('Y-m-t', strtotime("-1 months"))." 23:59:59";
                            //echo $final."<br>";
                            $dias_de_ventas=$con->query("SELECT SUM(ventas.venta_usd) as suma_ventas_dia FROM ventas 
                                                          WHERE (ventas.fecha_creacion BETWEEN '".$inicio."'  AND '".$final."') AND ventas.id_usuario='".$_SESSION['id_usuario']."'")->fetch_assoc();
                            $dias_de_ventas=$dias_de_ventas['suma_ventas_dia'];
                            if(empty($dias_de_ventas)){$dias_de_ventas='0.00';}
                            echo "<td>$dias_de_ventas</td>";
                            echo "</tr>";
                            //var_dump($dias_de_ventas);
                            
                            echo "<tr>";
                            echo "<td>".DATE('M 01', strtotime("-1 months"))." - ".DATE('M 15, Y', strtotime("-1 months"))."</td>";
                            $inicio=DATE('Y-m-01', strtotime("-1 months"))." 00:00:00";
                            //echo $inicio."<br>";
                            $final=DATE('Y-m-15', strtotime("-1 months"))." 23:59:59";
                            //echo $final."<br>";
                            $dias_de_ventas=$con->query("SELECT SUM(ventas.venta_usd) as suma_ventas_dia FROM ventas 
                                                          WHERE (ventas.fecha_creacion BETWEEN '".$inicio."'  AND '".$final."') AND ventas.id_usuario='".$_SESSION['id_usuario']."'")->fetch_assoc();
                            $dias_de_ventas=$dias_de_ventas['suma_ventas_dia'];
                            if(empty($dias_de_ventas)){$dias_de_ventas='0.00';}
                            echo "<td>$dias_de_ventas</td>";
                            echo "</tr>";

                            /*-2 Mes***********************************************************************************************************************************************************************************************************************************************/
                            echo "<tr>";
                            echo "<td>".DATE('M 16', strtotime("-2 months"))." - ".DATE('M t, Y', strtotime("-2 months"))."</td>";
                            $inicio=DATE('Y-m-16', strtotime("-2 months"))." 00:00:00";
                            //echo $inicio."<br>";
                            $final=DATE('Y-m-t', strtotime("-2 months"))." 23:59:59";
                            //echo $final."<br>";
                            $dias_de_ventas=$con->query("SELECT SUM(ventas.venta_usd) as suma_ventas_dia FROM ventas 
                                                          WHERE (ventas.fecha_creacion BETWEEN '".$inicio."'  AND '".$final."') AND ventas.id_usuario='".$_SESSION['id_usuario']."'")->fetch_assoc();
                            $dias_de_ventas=$dias_de_ventas['suma_ventas_dia'];
                            if(empty($dias_de_ventas)){$dias_de_ventas='0.00';}
                            echo "<td>$dias_de_ventas</td>";
                            echo "</tr>";
                            //var_dump($dias_de_ventas);
                            
                            echo "<tr>";
                            echo "<td>".DATE('M 01', strtotime("-2 months"))." - ".DATE('M 15, Y', strtotime("-2 months"))."</td>";
                            $inicio=DATE('Y-m-01', strtotime("-2 months"))." 00:00:00";
                            //echo $inicio."<br>";
                            $final=DATE('Y-m-15', strtotime("-2 months"))." 23:59:59";
                            //echo $final."<br>";
                            $dias_de_ventas=$con->query("SELECT SUM(ventas.venta_usd) as suma_ventas_dia FROM ventas 
                                                          WHERE (ventas.fecha_creacion BETWEEN '".$inicio."'  AND '".$final."') AND ventas.id_usuario='".$_SESSION['id_usuario']."'")->fetch_assoc();
                            $dias_de_ventas=$dias_de_ventas['suma_ventas_dia'];
                            if(empty($dias_de_ventas)){$dias_de_ventas='0.00';}
                            echo "<td>$dias_de_ventas</td>";
                            echo "</tr>";


                            
                            /*-3 Mes***********************************************************************************************************************************************************************************************************************************************/
                            echo "<tr>";
                            echo "<td>".DATE('M 16', strtotime("-3 months"))." - ".DATE('M t, Y', strtotime("-3 months"))."</td>";
                            $inicio=DATE('Y-m-16', strtotime("-3 months"))." 00:00:00";
                            //echo $inicio."<br>";
                            $final=DATE('Y-m-t', strtotime("-3 months"))." 23:59:59";
                            //echo $final."<br>";
                            $dias_de_ventas=$con->query("SELECT SUM(ventas.venta_usd) as suma_ventas_dia FROM ventas 
                                                          WHERE (ventas.fecha_creacion BETWEEN '".$inicio."'  AND '".$final."') AND ventas.id_usuario='".$_SESSION['id_usuario']."'")->fetch_assoc();
                            $dias_de_ventas=$dias_de_ventas['suma_ventas_dia'];
                            if(empty($dias_de_ventas)){$dias_de_ventas='0.00';}
                            echo "<td>$dias_de_ventas</td>";
                            echo "</tr>";
                            //var_dump($dias_de_ventas);
                            
                            echo "<tr>";
                            echo "<td>".DATE('M 01', strtotime("-3 months"))." - ".DATE('M 15, Y', strtotime("-3 months"))."</td>";
                            $inicio=DATE('Y-m-01', strtotime("-3 months"))." 00:00:00";
                            //echo $inicio."<br>";
                            $final=DATE('Y-m-15', strtotime("-3 months"))." 23:59:59";
                            //echo $final."<br>";
                            $dias_de_ventas=$con->query("SELECT SUM(ventas.venta_usd) as suma_ventas_dia FROM ventas 
                                                          WHERE (ventas.fecha_creacion BETWEEN '".$inicio."'  AND '".$final."') AND ventas.id_usuario='".$_SESSION['id_usuario']."'")->fetch_assoc();
                            $dias_de_ventas=$dias_de_ventas['suma_ventas_dia'];
                            if(empty($dias_de_ventas)){$dias_de_ventas='0.00';}
                            echo "<td>$dias_de_ventas</td>";
                            echo "</tr>";

                            
                            /*-4 Mes***********************************************************************************************************************************************************************************************************************************************/
                            echo "<tr>";
                            echo "<td>".DATE('M 16', strtotime("-4 months"))." - ".DATE('M t, Y', strtotime("-4 months"))."</td>";
                            $inicio=DATE('Y-m-16', strtotime("-4 months"))." 00:00:00";
                            //echo $inicio."<br>";
                            $final=DATE('Y-m-t', strtotime("-4 months"))." 23:59:59";
                            //echo $final."<br>";
                            $dias_de_ventas=$con->query("SELECT SUM(ventas.venta_usd) as suma_ventas_dia FROM ventas 
                                                          WHERE (ventas.fecha_creacion BETWEEN '".$inicio."'  AND '".$final."') AND ventas.id_usuario='".$_SESSION['id_usuario']."'")->fetch_assoc();
                            $dias_de_ventas=$dias_de_ventas['suma_ventas_dia'];
                            if(empty($dias_de_ventas)){$dias_de_ventas='0.00';}
                            echo "<td>$dias_de_ventas</td>";
                            echo "</tr>";
                            //var_dump($dias_de_ventas);
                            
                            echo "<tr>";
                            echo "<td>".DATE('M 01', strtotime("-4 months"))." - ".DATE('M 15, Y', strtotime("-4 months"))."</td>";
                            $inicio=DATE('Y-m-01', strtotime("-4 months"))." 00:00:00";
                            //echo $inicio."<br>";
                            $final=DATE('Y-m-15', strtotime("-4 months"))." 23:59:59";
                            //echo $final."<br>";
                            $dias_de_ventas=$con->query("SELECT SUM(ventas.venta_usd) as suma_ventas_dia FROM ventas 
                                                          WHERE (ventas.fecha_creacion BETWEEN '".$inicio."'  AND '".$final."') AND ventas.id_usuario='".$_SESSION['id_usuario']."'")->fetch_assoc();
                            $dias_de_ventas=$dias_de_ventas['suma_ventas_dia'];
                            if(empty($dias_de_ventas)){$dias_de_ventas='0.00';}
                            echo "<td>$dias_de_ventas</td>";
                            echo "</tr>";

                            
                            /*-5 Mes***********************************************************************************************************************************************************************************************************************************************/
                           echo "<tr>";
                            echo "<td>".DATE('M 16', strtotime("-5 months"))." - ".DATE('M t, Y', strtotime("-5 months"))."</td>";
                            $inicio=DATE('Y-m-16', strtotime("-5 months"))." 00:00:00";
                            //echo $inicio."<br>";
                            $final=DATE('Y-m-t', strtotime("-5 months"))." 23:59:59";
                            //echo $final."<br>";
                            $dias_de_ventas=$con->query("SELECT SUM(ventas.venta_usd) as suma_ventas_dia FROM ventas 
                                                          WHERE (ventas.fecha_creacion BETWEEN '".$inicio."'  AND '".$final."') AND ventas.id_usuario='".$_SESSION['id_usuario']."'")->fetch_assoc();
                            $dias_de_ventas=$dias_de_ventas['suma_ventas_dia'];
                            if(empty($dias_de_ventas)){$dias_de_ventas='0.00';}
                            echo "<td>$dias_de_ventas</td>";
                            echo "</tr>";
                            //var_dump($dias_de_ventas);
                            
                            echo "<tr>";
                            echo "<td>".DATE('M 01', strtotime("-5 months"))." - ".DATE('M 15, Y', strtotime("-5 months"))."</td>";
                            $inicio=DATE('Y-m-01', strtotime("-5 months"))." 00:00:00";
                            //echo $inicio."<br>";
                            $final=DATE('Y-m-15', strtotime("-5 months"))." 23:59:59";
                            //echo $final."<br>";
                            $dias_de_ventas=$con->query("SELECT SUM(ventas.venta_usd) as suma_ventas_dia FROM ventas 
                                                          WHERE (ventas.fecha_creacion BETWEEN '".$inicio."'  AND '".$final."') AND ventas.id_usuario='".$_SESSION['id_usuario']."'")->fetch_assoc();
                            $dias_de_ventas=$dias_de_ventas['suma_ventas_dia'];
                            if(empty($dias_de_ventas)){$dias_de_ventas='0.00';}
                            echo "<td>$dias_de_ventas</td>";
                            echo "</tr>";


                            
                            /*-6 Mes***********************************************************************************************************************************************************************************************************************************************/
                            echo "<tr>";
                            echo "<td>".DATE('M 16', strtotime("-6 months"))." - ".DATE('M t, Y', strtotime("-6 months"))."</td>";
                            $inicio=DATE('Y-m-16', strtotime("-6 months"))." 00:00:00";
                            //echo $inicio."<br>";
                            $final=DATE('Y-m-t', strtotime("-6 months"))." 23:59:59";
                            //echo $final."<br>";
                            $dias_de_ventas=$con->query("SELECT SUM(ventas.venta_usd) as suma_ventas_dia FROM ventas 
                                                          WHERE (ventas.fecha_creacion BETWEEN '".$inicio."'  AND '".$final."') AND ventas.id_usuario='".$_SESSION['id_usuario']."'")->fetch_assoc();
                            $dias_de_ventas=$dias_de_ventas['suma_ventas_dia'];
                            if(empty($dias_de_ventas)){$dias_de_ventas='0.00';}
                            echo "<td>$dias_de_ventas</td>";
                            echo "</tr>";
                            //var_dump($dias_de_ventas);
                            
                            echo "<tr>";
                            echo "<td>".DATE('M 01', strtotime("-6 months"))." - ".DATE('M 15, Y', strtotime("-6 months"))."</td>";
                            $inicio=DATE('Y-m-01', strtotime("-6 months"))." 00:00:00";
                            //echo $inicio."<br>";
                            $final=DATE('Y-m-15', strtotime("-6 months"))." 23:59:59";
                            //echo $final."<br>";
                            $dias_de_ventas=$con->query("SELECT SUM(ventas.venta_usd) as suma_ventas_dia FROM ventas 
                                                          WHERE (ventas.fecha_creacion BETWEEN '".$inicio."'  AND '".$final."') AND ventas.id_usuario='".$_SESSION['id_usuario']."'")->fetch_assoc();
                            $dias_de_ventas=$dias_de_ventas['suma_ventas_dia'];
                            if(empty($dias_de_ventas)){$dias_de_ventas='0.00';}
                            echo "<td>$dias_de_ventas</td>";
                            echo "</tr>";



                    
                      ?>

</table>



</div> <!-- CIERRA estadisticasLider_cuerpo -->

<?php include '../_includes-functions/footer.php';?>

</body>
</html>