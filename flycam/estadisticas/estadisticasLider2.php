<?
include "../_includes-functions/conexion_improved.php";
include "../_includes-functions/seguridad.php"; 
include "../_includes-functions/funciones.php";
include '../_includes-functions/barraNavegacion.php';



if(isset($_POST['enviar'])){/*Boton Enviar*/
                            
                          
                            /*Perido Completo*/
                            $periodo_completo=$_POST['periodo_completo'];
                            //echo $periodo_completo."<br>";

                            /*Periodo Desde*/
                            $periodo_desde=$_POST['periodo_desde'];
                            //echo $periodo_desde."<br>";
                            
                            /*Periodo Hasta*/
                            $periodo_hasta=$_POST['periodo_hasta'];
                            //echo $periodo_desde."<br>";

                            /*Modelo*/
                            $modelo=$_POST['modelo'];
                            //echo $modelo."<br>";

                            /*Mostrar Inactivos*/
                            if(isset($_POST['mostrar_inactivos'])){$mostrar_inactivos=$_POST['mostrar_inactivos'];}else{$mostrar_inactivos='0';}
                            //echo  $mostrar_inactivos."<br>";
                            
                           

                            /*Periodos*/
                             if( ($periodo_desde!='') AND ($periodo_hasta!='') ){/*Periodo Fraccionado*/

                                              $_SESSION['estadisticaslider_desde']=$_POST['periodo_desde'];
                                              $_SESSION['estadisticaslider_hasta']=$_POST['periodo_hasta'];

                                                                                           
                                          
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
                           

                             /*Modelos*/
                            if(strpos($modelo, 'estudio') !== false){/*Estudio*/
                                                
                                                 /*Se elimina el contenido de la session*/
                                                $_SESSION['estadisticaslider_modelo']="";
                                                
                                                /*Explotamos el valor de la option*/
                                                $modelo_exp=explode('|',$modelo);

                                                /*Consulta que popula la session*/
                                                $modelos=$con->query("SELECT * FROM usuarios WHERE id_estudio=".$modelo_exp['1']." ORDER BY usuario");
                                                while($row1=$modelos->fetch_assoc()){/*WHILE++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
                                                                                    $_SESSION['estadisticaslider_modelo'][]=$row1['id_usuario'];
                                                }/*WHILE++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

                                                 $_SESSION['estadisticaslider_modelo']= "'".implode("','", $_SESSION['estadisticaslider_modelo'])."'";

                                                /*Sesiones que populan la primer opcion del select*/  
                                                $_SESSION['estadisticaslider_modelo_select']['value']=$modelo;
                                                $_SESSION['estadisticaslider_modelo_select']['contenido']=ucwords($modelo_exp['2']);
                            
                            }/*Estudio*/

                            /*Mostrar Inactivos*/
                            $_SESSION['estadisticaslider_incluir_inactivos']=$mostrar_inactivos;
                          
}/*Boton Enviar*/

if(isset($_POST['editar1'])){/*Boton Enviar*/
                            
                          
                            $_SESSION['estadisticaslider_editar1']=$_POST['editar1'];/*redireccionamos al log in*/

                            /*Llevamos al usuario al usuario que quiere editar*/
                            $unique_code_x=explode('-',$_POST['editar1']);
                            $id_usuario=$unique_code_x['3'];
                            //echo '$id_usuario: '.$id_usuario."<br>";
                            echo"<script> window.location.href='#".$id_usuario."';</script>";


                           
                          
}/*Boton Enviar*/

if(isset($_POST['editar2'])){/*Boton Enviar*/

                            

                            $venta_usd=$_POST['v_editar2'];
                            //echo '$venta_usd: '.$venta_usd."<br>";
                            $unique_code=$_POST['editar2'];
                            //echo '$unique_code: '.$unique_code."<br>";
                            $unique_code_x=explode('-',$unique_code);
                            $id_usuario=$unique_code_x['3'];
                            //echo '$id_usuario: '.$id_usuario."<br>";
                            $id_pagina=$unique_code_x['4'];
                            //echo '$id_pagina: '.$id_pagina."<br>";
                            $fecha_creacion=$unique_code_x['0']."-".$unique_code_x['1']."-".$unique_code_x['2']." 00:00:00";
                            //echo '$fecha_creacion: '.$fecha_creacion."<br>";

                            /*$id_estudio, $id_lider, $porcent_lider, $id_referente, $porcent_referente*/
                            $data=$con->query("SELECT usuarios.*,estudios.* FROM usuarios 
                                              LEFT JOIN estudios ON (usuarios.id_estudio=estudios.id_estudio) 
                                              WHERE usuarios.id_usuario='$id_usuario'
                                              ")->fetch_assoc();

                            

                            $id_estudio=$data['id_estudio'];
                            if($id_estudio==''){$id_estudio=0;}
                            //echo '$id_estudio: '.$id_estudio."<br>";
                            
                            $id_lider=$data['id_lider'];
                            if($id_lider==''){$id_lider=0;}
                            //echo '$id_lider: '.$id_lider."<br>";
                            
                            $porcent_lider=$data['porcent_lider'];
                            if($porcent_lider==''){$porcent_lider=0;}
                            //echo '$porcent_lider: '.$porcent_lider."<br>";
                            
                            $id_referente=$data['id_referente'];
                            if($id_referente==''){$id_referente=0;}
                            //echo '$id_referente: '.$id_referente."<br>";
                            
                            if($id_referente!='0'){$porcent_referente='2.5';}else{$porcent_referente='0.0';}
                           //echo '$porcent_referente: '.$porcent_referente."<br>";

                            
                            $update=$con->query("INSERT INTO ventas(id_venta,fecha_creacion,unique_code,id_usuario,id_estudio,id_pagina,id_lider,porcent_lider,id_referente,porcent_referente,venta_usd) 
                            VALUES (default,'$fecha_creacion','$unique_code',$id_usuario,$id_estudio,$id_pagina,$id_lider,$porcent_lider,$id_referente,$porcent_referente,$venta_usd)
                            ON DUPLICATE KEY UPDATE venta_usd=$venta_usd;
                              ");

                            if($update){ $_SESSION['estadisticaslider_editar1']='';
                                          echo"<script> window.location.href='#".$id_usuario."';</script>";
                                          
                                        }
                           
                          
}/*Boton Enviar*/


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
//echo $_SESSION['estadisticaslider_desde']."<br>";
//echo $_SESSION['estadisticaslider_hasta']."<br>";
     



if(!isset($_SESSION['estadisticaslider_modelo'])){$_SESSION['estadisticaslider_modelo']='';}
//echo $_SESSION['estadisticaslider_modelo']."<br>";
if(!isset($_SESSION['estadisticaslider_editar1'])){$_SESSION['estadisticaslider_editar1']='';}
//echo $_SESSION['estadisticaslider_editar1']."<br>";
if(!isset($_SESSION['estadisticaslider_incluir_inactivos'])){$_SESSION['estadisticaslider_incluir_inactivos']="0";}
//echo $_SESSION['estadisticaslider_incluir_inactivos']."<br>";


?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../_globales/styles/resetcss.css">
    <link rel="stylesheet" type="text/css" href="../_includes-functions/styles/barraNavegacion.css">
    <link rel="stylesheet" type="text/css" href="../_includes-functions/styles/footer.css">
    <link rel="stylesheet" type="text/css" href="styles/estadisticasLider.css">

    <title>Estadisticas Lider</title>
</head>
<body>

    <div id="estadisticasLider_cuerpo">

        <img id="estadisticasLider_cuerpo_estadisticasIcono" src="../_globales/images/estadisticasicono.png"><h1 style="display: inline;">Estadisticas de venta lideres</h1>

        <p id="estadisticasLider_cuerpo_primerParrafo">En este panel podrá ver las ventas de una sola modelo o de todas sus modelos en periodos
            de tiempo específicos, seleccione la opción que más le convenga:</p><br>

            <form id="estadisticasLider_cuerpo_formulario1" method='POST' action=''>
                <table cellpadding="0" cellspacing="0"  width="650" style="" >
                 
                  <tr>
                      <td>
                          
                          <label>Ver estadisticas de :</label>
                      
                  </td>
                  <td>
                      <select name='modelo'>
                      <?

                      /*Valores de la opción que fue previamente seleccionada*/
                      echo "<option value='";
                      if(isset($_SESSION['estadisticaslider_modelo_select']['value'])){echo $_SESSION['estadisticaslider_modelo_select']['value'];}
                      echo "'>";
                      if(isset($_SESSION['estadisticaslider_modelo_select']['contenido'])){echo $_SESSION['estadisticaslider_modelo_select']['contenido'];}else{echo "Seleccionar";}
                      echo "</option>";
                      
                      /*Opcion de todas la modelos*/
                      echo "<option value='all'>Todas Las Modelos</option>";
                      
                      /*Populacion de los selects con todos los estudios*/
                      $popu_estudios=$con->query("SELECT * from estudios");
                      while ($row=$popu_estudios->fetch_assoc()) {/*While*/
                      echo "<option value='estudio|".$row['id_estudio']."|".$row['nombre_estudio']."'>".ucfirst($row['nombre_estudio'])."</option>";
                      }/*While*/
                      ?>


                         
                      </select>
                  </td>
                  </tr>
                          
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
                      <td>
                           <label>Inactivos:</label>
                      </td>
                      <td>
                          <input type="checkbox" name="mostrar_inactivos" value="1" >Incluir modelos Inactivos<br>
                      </td>
                      <td>
                           
                      </td>
                      <td>
                           
                      </td>
                  </tr>
                  <tr>
                      <td>
                          <input class="allinputs" id="estadisticasLider_cuerpo_formulario1_verDatos" type="submit" name='enviar' value="Ver datos >" >
                      </td>
                  </tr>


              </table>   
          </form>  

          <br><img src="images/separador.png"> <br><br>



                 

        
<?
include("../_includes-functions/madre_de_estadisticas2.php");

 if(isset($_SESSION['estadisticaslider_modelo_select']['value'])){/*Si se seleccionó un modelo*/

          //print_r($suma_ventas_por_usuario);
          echo "<h1 id='estadisticasLider_cuerpo_totalVentas'>Total ventas: <b>USD $".number_format($total_ventas_modelos_usd,2,'.',',')."</b></h1>";
          //echo "<a href=''><img style='margin-left:20px;'  src='../_globales/images/printericon.png'></a>";
          echo "<br>";
          echo "<h1 id='estadisticasLider_cuerpo_totalVentas'>Promedio ventas: <b>USD $".number_format($promedio_ventas_modelos_usd,2,'.',',')."</b></h1><br>";
          
          echo "<div id='estadisticasLider_cuerpo_deducciones'>";
                
                echo "<table>";
                echo "<tr><td><h3>Porcentaje Modelos Estudio:&nbsp&nbsp</h3></td><td><h3><b>";
                echo $porcentaje_estudio;
                echo "%</b></h3></td></tr>";
                echo "<tr><td><h3>Porcentaje Modelos Satelites:&nbsp&nbsp</h3></td><td><h3><b>";
                echo $porcentaje_satelite;
                echo "%</b></h3></td></tr>";
                echo "<tr><td><h3>Comisión Modelos:&nbsp&nbsp</h3></td><td><h3><b>USD ".number_format($total_comisiones_modelos_usd,2,'.',',')." / $".number_format($total_comisiones_modelos_usd*$cop_val_deducido,0,'.','.')." COP</b></h3></td></tr>";
                echo "<tr><td><h3>Comisión Lider:&nbsp&nbsp</h3></td><td><h3><b>USD ".number_format($total_comisiones_lider_usd,2,'.',',')." / $".number_format($total_comisiones_lider_usd*$cop_val_deducido,0,'.','.')." COP</b></h3></td></tr>";
                echo "<tr><td><h3>Comisión Referentes:&nbsp&nbsp</h3></td><td><h3><b>USD ".number_format($total_comisiones_referentes_usd,2,'.',',')." / $".number_format($total_comisiones_referentes_usd*$cop_val_deducido,0,'.','.')." COP</b></h3></td></tr>";
                echo "<tr><td><h3>Comisión Estudio:&nbsp&nbsp</h3></td><td><h3><b>USD ".number_format($total_comisiones_estudio_usd,2,'.',',')." / $".number_format($total_comisiones_estudio_usd*$cop_val_deducido,0,'.','.')." COP</b></h3></td></tr>";
                echo "</table>";

                echo "<div style='margin-top:10px; margin-bottom:10px;'>";
                //echo "<br><input type='checkbox' name=''> <a style='color:#700013;' href=''><img style='vertical-align:middle;' src='../_globales/images/printericonred.png'> Imprimir seleccionados</a><br>";
                echo "</div>";

          echo "</div>";

echo "<form id='estadisticasLider_cuerpo_formulario1' method='POST' action=''>";
      
             
                          
      
      if(isset($linea1) and !empty($linea1) ){/*Si existe Linea 1*/
            
            foreach ($linea1 as $id_usuario => $lineas1) {/*Escribe Linea 1*/

                  
                  echo "<div id='estadisticasLider_cuerpo_contenedorTabla'>";
                  
                  echo "<div style='margin:10px;'>";
                  //echo "<input type='checkbox'>";
                  echo "<a style='cursor:pointer;' onclick=\"window.open('reporteModelos.php?usuario=$id_usuario&inicio=".$_SESSION['estadisticaslider_desde']."&final=".$_SESSION['estadisticaslider_hasta']."','',' scrollbars=yes,menubar=no,width=100, resizable=yes,toolbar=no,location=no,status=no')\">";
                  echo "<img style='vertical-align:middle;' src='../_globales/images/printericon.png'>";
                  echo "</a>";
                  echo "</div>";
                  echo "<table id='estadisticasLider_cuerpo_contenedorTabla_tablaEstadisticas' cellspacing='0' cellpadding='5' height='141' border='1' >";                  
                  echo "<thead><tr class='tr'>";
                                                $conteo_casillas=0;
                                                
                                                foreach ($lineas1 as $casilla) {/*Cada casilla de la primer linea de la tabla**********************************************************************************************************/
                                                      
                                                      echo "<td style='width:140px;'>";
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
                 echo "</div>";
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

                  /*Comisiones Lider*/
                  echo "<p><span>Comisiones Lider:</span> $".number_format($suma_comisioneslider_por_usuario_usd[$id_usuario],2,'.','.')." USD / $".number_format($suma_comisioneslider_por_usuario_usd[$id_usuario]*$cop_val_deducido,0,'.','.')." COP</p>";

                  /*Comisiones Lider*/
                  //echo "<p><span>Comisiones Referente:</span> $".number_format($suma_comisionesreferente_por_usuario_usd[$id_usuario],2,'.','.')." USD / $".number_format($suma_comisionesreferente_por_usuario_usd[$id_usuario]*$cop_val_deducido,0,'.','.')." COP</p>";

                  
                  echo "</div><!--CIERRA estadisticaslider_cuerpo_contenedortabla_indicadoresporusuario-->";

                  
                  echo "<div><img src='../_globales/images/separador.png' style='margin-top:15px;'></div>";

              }/*Escribe Linea 1*/
                 

      }/*Si existe Linea 1*/
     
      //$linea1='';
      unset($linea1);
      unset($linea2);

echo "</form>";

}/*Si se seleccionó un modelo*/






      ?>





<?php include '../_includes-functions/footer.php';?>

</body>
</html>