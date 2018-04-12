<?
include "../_includes-functions/conexion_improved.php";
include "../_includes-functions/seguridad.php"; 
include "../_includes-functions/funciones.php";
include '../_includes-functions/barraNavegacion.php';

/*PARAMETRIZACION*/
/*Numero de dolares minimo para hacer asistencia en el dia*/
$venta_minima_asistencia=0.5;
/*Dias Libres*/
$dias_no_laborables=array(6,7);//Sabados y Domingos (Donde lunes es 1 y domingo es 7)


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
                            /*Se elimina el contenido de la session y se vuelve a crear*/
                            unset($_SESSION['estadisticaslider_modelo']); // $foo is gone
                            $_SESSION['estadisticaslider_modelo'] = array(); // $foo is here again

                            if($modelo=='all'){/*Todas las modelos*/
                                                
                                                /*Consulta que popula la session*/
                                                $modelos=$con->query("SELECT * FROM usuarios ORDER BY usuario");
                                                while($row1=$modelos->fetch_assoc()){/*WHILE++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
                                                                                     $_SESSION['estadisticaslider_modelo'][]=$row1['id_usuario'];
                                                }/*WHILE++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
                                                
                                                /*Se organiza la array para poner en consulta Mysql*/
                                                $_SESSION['estadisticaslider_modelo']=implode(",",$_SESSION['estadisticaslider_modelo']);
                                               

                                                /*Sesiones que populan la primer opcion del select*/
                                                $_SESSION['estadisticaslider_modelo_select']['value']=$modelo;
                                                $_SESSION['estadisticaslider_modelo_select']['contenido']='Todas Las Modelos';
                           
                            /*Todas las modelos*/}elseif (strpos($modelo, 'estudio') !== false){/*Estudio*/
                                                
                                                /*Se elimina el contenido de la session y se vuelve a crear*/
                                                unset($_SESSION['estadisticaslider_modelo']); // $foo is gone
                                                $_SESSION['estadisticaslider_modelo'] = array(); // $foo is here again
                                                
                                                /*Explotamos el valor de la option*/
                                                $modelo_exp=explode('|',$modelo);

                                                /*Consulta que popula la session*/
                                                $modelos=$con->query("SELECT * FROM usuarios WHERE id_estudio=".$modelo_exp['1']." ORDER BY usuario");
                                                while($row1=$modelos->fetch_assoc()){/*WHILE++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
                                                                                    $_SESSION['estadisticaslider_modelo'][]=$row1['id_usuario'];
                                                }/*WHILE++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

                                                /*Se organiza la array para poner en consulta Mysql*/
                                                $_SESSION['estadisticaslider_modelo']=implode(",",$_SESSION['estadisticaslider_modelo']);
                                               
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

                            if($update){ 

                                          $_SESSION['estadisticaslider_editar1_antes']=$_SESSION['estadisticaslider_editar1'];
                                          $_SESSION['estadisticaslider_editar1']='';
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
/*Si no se ha seleccionado una modelo*/   
if(!isset($_SESSION['estadisticaslider_modelo'])){$_SESSION['estadisticaslider_modelo']='0';}
//echo $_SESSION['estadisticaslider_modelo']."<br>";
if(!isset($_SESSION['estadisticaslider_editar1'])){$_SESSION['estadisticaslider_editar1']='';}
//echo $_SESSION['estadisticaslider_editar1']."<br>";
if(!isset($_SESSION['estadisticaslider_editar1_antes'])){$_SESSION['estadisticaslider_editar1_antes']='';}
//echo $_SESSION['estadisticaslider_editar1_antes']."<br>";
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

    <script>
      $(document).ready(function(){
      $(".iluminado")
      .fadeIn(500).fadeOut(500).
      fadeIn(500).fadeOut(500).
      fadeIn(500).fadeOut(500).
      fadeIn(500).fadeOut(500).
      fadeIn(500).fadeOut(500).
      fadeOut(500).fadeIn(500).
      fadeIn(500);
      });
    </script>



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
    
echo "<div id='estadisticasLider_cuerpo_deducciones'>";




echo "<table>";

/*TOTALES PAGINAS*/
echo "<tr><td><h3>Ventas Paginas:&nbsp&nbsp</h3></td><td><h3><b>USD ".number_format($info_totales['dolares_paginas_totales'],2,'.',',')." / $".number_format($info_totales['dolares_paginas_totales']*$cop_val_deducido,0,'.','.')." COP</b></h3></td></tr>";

/*Echo del total por pagina*/
foreach ($info_totales['dolares_por_pagina'] as $id_pagina => $dolares) {
  
  echo "<tr>";
  echo "<td><div class='tooltip'><img src='../_globales/images/info_icon.png' width='14px' alt='info_icon'><span class='tooltiptext'>Esta es la sumatoria de las ventas en $paginas_nombres[$id_pagina]</span></div>";
  echo "<h3> Ventas ".$paginas_nombres[$id_pagina].":</h3></td>";
  echo "<td><h3><b>USD ".number_format($dolares,2,'.',',')." / $".number_format($dolares*$cop_val_deducido,0,'.','.')." COP</b></h3></td>";
  echo "</tr>";
}
//print_r($info_totales);
echo "<td></td>";



/*TOTALES LIDERES*/
echo "<tr><td><h3>Comisiones de Lideres:&nbsp&nbsp</h3></td><td><h3><b>USD ".number_format($info_totales['dolares_lideres_totales'],2,'.',',')." / $".number_format($info_totales['dolares_lideres_totales']*$cop_val_deducido,0,'.','.')." COP</b></h3></td></tr>";

foreach ($info_totales['dolares_por_lider'] as $id_lider => $resultado) {
  if($resultado['venta']>0){/*Si la comision del lider es mayor a 0 se muestra de lo contrario no*/
        echo "<tr>";
        echo "<td><div class='tooltip'><img src='../_globales/images/info_icon.png' width='14px' alt='info_icon'><span class='tooltiptext'>Comisiones de venta de ".ucfirst($resultado['usuario_lider']).". Ya que fue lider cuando se anotó la venta.</      span></div>";
        echo "<h3> Comisión ".ucfirst($resultado['usuario_lider']).":</h3></td>";
        echo "<td><h3><b>USD ".number_format($resultado['venta'],2,'.',',')." / $".number_format($resultado['venta']*$cop_val_deducido,0,'.','.')." COP</b></h3></td>";
        echo "</tr>";
  }/*Si la comision del lider es mayor a 0 se muestra de lo contrario no*/
}
//print_r($info_totales);

/*TOTALES REFERENTES*/
echo "<tr><td><h3>Comisiones de Referentes:&nbsp&nbsp</h3></td><td><h3><b>USD ".number_format($info_totales['dolares_referentes_totales'],2,'.',',')." / $".number_format($info_totales['dolares_referentes_totales']*$cop_val_deducido,0,'.','.')." COP</b></h3></td></tr>";

foreach ($info_totales['dolares_por_referente'] as $id_lider => $resultado) {
  if($resultado['venta']>0){/*Si la comision del referente es mayor a 0 se muestra de lo contrario no*/
        echo "<tr>";
        echo "<td><div class='tooltip'><img src='../_globales/images/info_icon.png' width='14px' alt='info_icon'><span class='tooltiptext'>Comisiones de venta de ".ucfirst($resultado['usuario_referente']).". Ya que fue referente cuando se anotó la       venta.</span></div>";
        echo "<h3> Comisión ".ucfirst($resultado['usuario_referente']).":</h3></td>";
        echo "<td><h3><b>USD ".number_format($resultado['venta'],2,'.',',')." / $".number_format($resultado['venta']*$cop_val_deducido,0,'.','.')." COP</b></h3></td>";
        echo "</tr>";
  }/*Si la comision del referente es mayor a 0 se muestra de lo contrario no*/
}
//print_r($info_totales);

//echo "<tr><td><h3>Comisión Modelos:&nbsp&nbsp</h3></td><td><h3><b>USD ".number_format($total_comisiones_modelos_usd,2,'.',',')." / $".number_format($total_comisiones_modelos_usd*$cop_val_deducido,0,'.','.')." COP</b></h3></td></tr>";
//echo "<tr><td><h3>Comisión Estudio:&nbsp&nbsp</h3></td><td><h3><b>USD ".number_format($total_comisiones_estudio_usd,2,'.',',')." / $".number_format($total_comisiones_estudio_usd*$cop_val_deducido,0,'.','.')." COP</b></h3></td></tr>";


echo "</table>";

                

echo "</div>";


      
    /*ARRAY de la suma de la venta de cada usuario*/
    $suma_ventas_por_usuario_usd=array();

    /*Array de la suma de ventas por dia por usuario*/
    $suma_ventas_por_dia_por_usuario=array();

                          /*CADA USUARIO*/
                          foreach ($info_celda as $id_usuario => $id_pagina) {/*usuario*----------------------------------------------------------------------------------------------------------------------/

                                /*Numero de Insasitencias por usuario*/
                                $numero_de_inasistencias[$id_usuario]=0;

                                /*COMIENZO DE LA TABLA*/
                                echo "<div id='estadisticasLider_cuerpo_contenedorTabla'>";
                                echo "<div style='margin:10px;'>";
                                //echo "<input type='checkbox'>";
                                echo "<a style='cursor:pointer;' onclick=\"window.open('reporteModelos.php?usuario=$id_usuario&inicio=".$_SESSION['estadisticaslider_desde']."&final=".$_SESSION['estadisticaslider_hasta']."','',' scrollbars=yes,menubar=no,width=100, resizable=yes,toolbar=no,location=no,status=no')\">";
                                echo "<img style='vertical-align:middle;' src='../_globales/images/printericon.png'>";
                                echo "</a>";
                                echo "</div>";
                                echo "<table id='estadisticasLider_cuerpo_contenedorTabla_tablaEstadisticas' cellspacing='0' cellpadding='5'  border='1' >";

                               
                               
                                //echo "<tr><td>".$id_pagina['nombre']."</td></tr>";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<td>";
                                echo "<a id='$id_usuario' target='_blank' href='../entrevistas/entrevistas.php?editar_usuario=".$id_usuario."' style='text-decoration:none;'>";
                                echo "<span style='color:white;font-family: HelveticaNeueLTStd-Lt;'>".$info_celda[$id_usuario]['nombre']."<br>(".$info_celda[$id_usuario]['usuario'].")</span>";
                                echo "</a>";
                                echo "</td>";
                                /////////////////////////////////////////////////
                                /*CONTRUCCION DE PRIMER FILA CON FECHAS UNICAS*/
                                /////////////////////////////////////////////////

                                foreach ($fechas_unicas as $fecha_unica) {/*Fila Fechas Unicas***********************************************************************************************************************/
                                        

                                      

                                      /*TDs de la primer fila*/  
                                      echo "<td>".date_format(date_create("$fecha_unica"),"d/M/Y")." ".$dias[date('w', strtotime($fecha_unica))]."</td>";
                                            
                                }/*Fila Fechas Unicas*****************************************************************************************************************************************************************/
                                echo "</tr>";
                                echo "</thead>";
                                
                                ////////////////////////////////////////
                                /*CONSTRUCCION DE UNA FILA POR PAGINA*/
                                ////////////////////////////////////////
                                foreach ($id_pagina as $id_pagina => $fecha) {/*Por cada Pagina*////////////////////////////////////////////////////////////////////////////////////////////////////

                                      
                                              
                                      
                                      /*Aclaración: puse en la array general ($info_celda) el nombre de la pagina junto con cada fecha, por eso toda excluir el nombre en el for each*/
                                      if(is_numeric($id_pagina)){/*Si no es nombre*/
                                      echo "<tr>";
                                      echo "<td>";
                                      /*Imagenes de Paginas o Nombres de Paginas*/
                                      if (@getimagesize('../_globales/images/'.$_SESSION['nombre_base'].'_paginas/'.$id_pagina.'.png')){
                                                                                                                                          echo "<img src='../_globales/images/".$_SESSION['nombre_base']."_paginas/$id_pagina.png' width='100px'>";}
                                                                                                                                          else{
                                                                                                                                          echo $paginas_nombres[$id_pagina];
                                                                                                                                          }
                                      
                                      echo "</td>";
                                                  
                                            /*VALOR DE FECHAS - Dolares*/
                                            foreach ($fechas_unicas as $uni_date) {/*Por cada fecha */

                                                              ///////////////////////////////////////
                                                              /////CONSTRUCCION PARA LA CELDA///////
                                                              /////////////////////////////////////                                                     
                                                              /*Si la información de la fecha que se está consultando no existe en la array entonces se pone el VALOR 0*/
                                                              if(isset($info_celda[$id_usuario][$id_pagina][$uni_date])){$vl=$info_celda[$id_usuario][$id_pagina][$uni_date]['venta'];}else{$vl='0.00';}

                                                              /*Si la información de la fecha que se está consultando no existe en la array entonces se pone el PORCENTAJE 0*/
                                                              if(isset($info_celda[$id_usuario][$id_pagina][$uni_date])){$pr=$info_celda[$id_usuario][$id_pagina][$uni_date]['porcentaje'];}else{$pr='0.00';}

                                                              /*Si la información de la fecha que se está consultando no existe en la array entonces se crea un IDENTIFICADOR artificial*/
                                                              if(isset($info_celda[$id_usuario][$id_pagina][$uni_date])){$identificador=$info_celda[$id_usuario][$id_pagina][$uni_date]['identificador'];}
                                                              else{$identificador=$uni_date."-".$id_usuario."-".$id_pagina;}
                                                              
                                                              
                                                              ///////////////////////////////////////
                                                              ///////////ECHO LA CELDA//////////////
                                                              /////////////////////////////////////
                                                              /*ECHO del contenido de la celda*/
                                                              if($identificador!=$_SESSION['estadisticaslider_editar1']){/*Valor y Boton*/
                                                                    echo "<td>";
                                                                    
                                                                    if($identificador==$_SESSION['estadisticaslider_editar1_antes']){/*Este es el que dispara la div morada que pareciera que parpadeara*/
                                                                         echo "<div class='iluminado' style='background-color:#C14080;'>";
                                                                    }/*Este es el que dispara la div morada que pareciera que parpadeara*/

                                                                            echo "<form method='POST' action=''>";
                                                                              echo number_format($vl,2,'.',',');
                                                                              echo "<button type='submit' value='".$identificador."' name='editar1' style='border-style:none;background:none;color:#FFF;cursor:pointer;padding:0px,1px,0px,1px;'><img src='../_globales/images/editicon.jpg'>";
                                                                            echo "</form>";
                                                                    
                                                                    if($identificador!=$_SESSION['estadisticaslider_editar1_antes']){/*Este es el que dispara la div morada que pareciera que parpadeara*/
                                                                          echo "</div>";
                                                                    }/*Este es el que dispara la div morada que pareciera que parpadeara*/
                                                                    
                                                                    echo "</td>";
                                                              }/*Valor y Boton*/else{/*Valor dentro de text box*/
                                                                echo "<td style='background-color:#810B45;''>";
                                                                echo "<form method='POST' action=''>";
                                                                    echo "<input class='typeNumber iluminado' style='width:75px;' step='0.01' type='number' name='v_editar2' value='".number_format($vl,2,'.',',')."' autofocus='autofocus'></input>";
                                                                    echo "<button class='editnumber' type='submit' name='editar2' value='".$identificador."'>></button>";
                                                                echo "</form>";
                                                                echo "</td>";
                                                              }/*Valor dentro de text box*/
                                                              
                                                              
                                                              ////////////////////////////////////////
                                                              //////SUMATORIAS PARA LOS TOTALE/S/////
                                                              //////////////////////////////////////
                                                              
                                                              /*ACTIVO o INACTIVO en esa fecha*/
                                                              /*La siguiente ARRAY alcmaena datos que ayudan a identificar si en esa fecha el usuario estuvo activo o inactivo*/
                                                              if(isset($info_celda[$id_usuario][$id_pagina][$uni_date])){$activo_o_inactivo[$id_usuario][$uni_date][]=1;}else{$activo_o_inactivo[$id_usuario][$uni_date][]=0;}
                                                              
                                                              /*Suma de total de ventas por usuario*/
                                                              if(!isset($suma_ventas_por_usuario_usd[$id_usuario])){$suma_ventas_por_usuario_usd[$id_usuario]=0;}
                                                              $suma_ventas_por_usuario_usd[$id_usuario]+=$vl;

                                                              /*Suma de total de ventas por USUARIO por PAGINA*/
                                                              if(!isset($suma_ventas_por_usuario_pagina[$id_usuario][$id_pagina])){$suma_ventas_por_usuario_pagina[$id_usuario][$id_pagina]=0;}
                                                              $suma_ventas_por_usuario_pagina[$id_usuario][$id_pagina]+=$vl;
                                                              
                                                              /*Suma de total de pago por usuario*/
                                                              if(!isset($suma_de_pago_por_usuario_usd[$id_usuario])){$suma_de_pago_por_usuario_usd[$id_usuario]=0;}
                                                              $suma_de_pago_por_usuario_usd[$id_usuario]+=$vl*$pr/100;

                                                              /*Suma del total de cada dia del usuario*/
                                                              if(!isset($suma_ventas_por_dia_por_usuario[$id_usuario][$uni_date])){$suma_ventas_por_dia_por_usuario[$id_usuario][$uni_date]=0;}
                                                              $suma_ventas_por_dia_por_usuario[$id_usuario][$uni_date]+=$vl;

                                                             
                                                        
                                            }/*Por cada fecha */     
                                      echo "</tr>";               
                                      }/*Si no es nombre*/

                                          
                                }/*Por cada Pagina*/////////////////////////////////////////////////////////////////////////////////////////////////////
                                
                                /*CONSTRUCCION DE LA FILA DE TOTALES*/
                                echo "<tr>";
                                echo "<td>Total</td>";
                                foreach ($fechas_unicas as $fecha_unica) {/*Por cada fecha - Ultima hilera de los totales*/

                                      /*Se saca el valor total por cada usuario por cada dia*/
                                      $valor=$suma_ventas_por_dia_por_usuario[$id_usuario][$fecha_unica];

                                      /*Verificamos si el dia fue festivo o no laborable (Osea Sabado o Domingo) - Siempre tiene prioridad mostrar si el día fue festivo. O si es penalizable el dia*/
                                      if(!in_array(1,$activo_o_inactivo[$id_usuario][$fecha_unica])){/*Estaba*/$imagen_descriptiva="<img src='../_globales/images/icono_usuario_inactivo.png' width='20px'>";}
                                      elseif(in_array($fecha_unica,$dias_festivos)){/*Festivo*/$imagen_descriptiva="<img src='../_globales/images/festivo.png' width='20px'>";}/*Festivo*/
                                      elseif(in_array(date('N', strtotime($fecha_unica)),$dias_no_laborables)){/*Descanso*/$imagen_descriptiva="<img src='../_globales/images/dia_libre.png' width='20px'>";}/*Descanso*/
                                      elseif($valor<$venta_minima_asistencia){/*Penalizacion*/$imagen_descriptiva="<img src='../_globales/images/cautioniconred.png' width='20px'>";$numero_de_inasistencias[$id_usuario]++;}/*Penalizacion*/
                                      else{/*Normal*/$imagen_descriptiva="";}/*Normal*/

                                      /*Se muestra el valor total por cada usuario por cada dia*/
                                      echo "<td>";
                                      echo number_format($valor,2,'.','.')." $imagen_descriptiva";
                                      echo "</td>";

                                }/*Por cada fecha - Ultima hilera de los totales*/

                                echo "</tr>";
                                                                          
                                       echo "</table>";
                                       echo "</div>";

                                      


                        echo "<div id='estadisticaslider_cuerpo_contenedortabla_indicadoresporusuario'><!--ABRE estadisticaslider_cuerpo_contenedortabla_indicadoresporusuario-->";
                        
                        
                        /*Totales por PAGINA*/
                        foreach ($suma_ventas_por_usuario_pagina[$id_usuario] as $page => $tot_page) {/*Totales por Pagina*/
                              echo "<p><span>".$paginas_nombres[$page].": </span>$tot_page USD</p>";
                        }/*Totales por Pagina*/

                        echo "<br>";
                        
                        /*Se muestra la sumatoria de los dolares hechos por la modelo*/
                        echo "<p><span>Total Ventas:</span> $".number_format($suma_ventas_por_usuario_usd[$id_usuario],2,'.','.')." USD / $".number_format($suma_ventas_por_usuario_usd[$id_usuario]*$cop_val_deducido,0,'.','.')." COP</span></p>";
                        
                        /*Se muestran el total de inasistencias por el usuario*/
                        echo "<p><span>Total Inasistencias:</span>".$numero_de_inasistencias[$id_usuario]."</p>";
                        
                        /*Dias Penalizables*/
                        $dias_penalizables[$id_usuario]=$numero_de_inasistencias[$id_usuario]-1;
                        if($dias_penalizables[$id_usuario]<0){$dias_penalizables[$id_usuario]=0;}
                        echo "<p><span>Total Días Penalizables:</span>  ".$dias_penalizables[$id_usuario]."</p>";
                        
                            
                        /*Pago a modelo*/
                        echo "<p><span>Pago a Modelo:</span> $".number_format($suma_de_pago_por_usuario_usd[$id_usuario],2,'.','.')." USD / $".number_format($suma_de_pago_por_usuario_usd[$id_usuario]*$cop_val_deducido,0,'.','.')." COP</p>";
                        
                        /*Porcentaje a descontar*/
                        $porcentaje_descontable[$id_usuario]=$dias_penalizables[$id_usuario]*10;
                        echo "<p><span>Porcentaje a Descontar (Sobre las Ventas): -</span>".$porcentaje_descontable[$id_usuario]."%</p>";

                        /*Pago a modelo con descuentos*/
                        $suma_de_pago_descontado_por_usuario_usd[$id_usuario]=$suma_de_pago_por_usuario_usd[$id_usuario]-($suma_ventas_por_usuario_usd[$id_usuario]*$porcentaje_descontable[$id_usuario]/100);
                        echo "<p><span>Pago con Descuentos:</span> $".number_format($suma_de_pago_descontado_por_usuario_usd[$id_usuario],2,'.','.')." USD / $".number_format($suma_de_pago_descontado_por_usuario_usd[$id_usuario]*$cop_val_deducido,0,'.','.')." COP</p>";
      
                        echo "<br>";
      
                        /*Comisiones Lider*/
                        //echo "<p><span>Comisiones Lider:</span> $".number_format($suma_comisioneslider_por_usuario_usd[$id_usuario],2,'.','.')." USD /      $".number_format($suma_comisioneslider_por_usuario_usd[$id_usuario]*$cop_val_deducido,0,'.','.')." COP</p>";
      
                        /*Comisiones Referentes*/
                        //echo "<p><span>Comisiones Referente:</span> $".number_format($suma_comisionesreferente_por_usuario_usd[$id_usuario],2,'.','.')." USD /      $".number_format($suma_comisionesreferente_por_usuario_usd[$id_usuario]*$cop_val_deducido,0,'.','.')." COP</p>";
      
                        
                        echo "</div><!--CIERRA estadisticaslider_cuerpo_contenedortabla_indicadoresporusuario-->";
      
                        
                        echo "<div><img src='../_globales/images/separador.png' style='margin-top:15px;'></div>";

                  }/*usuario---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/  


                     

  
                 



                 


echo "</form>";

}/*Si se seleccionó un modelo*/






      ?>





<?php include '../_includes-functions/footer.php';?>

</body>
</html>