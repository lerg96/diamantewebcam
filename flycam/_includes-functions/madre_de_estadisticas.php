<?

        /*Numero de dias consultados*/
        $estadisticaslider_desde=strtotime($_SESSION['estadisticaslider_desde']);
        $estadisticaslider_hasta=strtotime($_SESSION['estadisticaslider_hasta']);
        $numero_dias_consultados=$estadisticaslider_hasta-$estadisticaslider_desde;
        $numero_dias_consultados=floor($numero_dias_consultados/(60*60*24));
        
        $pagina=array();
        $id_paginas=array();
        
        /*Numero de dolares minimo para hacer asistencia en el dia*/
        $venta_minima_asistencia=0.5;

        /*Suma de todos los Modelos Consultados*/
        $total_ventas_modelos_usd=0;
        $total_comisiones_modelos_usd=0;
        $total_comisiones_lider_usd=0;
        $total_comisiones_referentes_usd=0;
        $total_comisiones_estudio_usd=0;
        $porcentaje_estudio=60;
        $porcentaje_satelite=70;

        
        

              ////////////////////
             ///////Linea 1//////
            ////////////////////

            /*Explocion de cada usuario*/
            $estadisticaslider_modelo=explode("|",$_SESSION['estadisticaslider_modelo']);
            //print_r($estadisticaslider_modelo);

            
            /*Cada usuario que fue explotado*/
            foreach ($estadisticaslider_modelo as  $id_de_usuario) {/*Cada Usuario******************************************************************************************************************************************************************************************/
                                                                   
            
                                               

            /*Cada Usuario Consultado*/
            $modelos=$con->query("SELECT * FROM usuarios WHERE id_usuario='".$id_de_usuario."'");
            while($row1=$modelos->fetch_assoc()){/*WHILE++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
                        

                        /*Se muestran o no los usuarios Inactivos*/
                        if( (($_SESSION['estadisticaslider_incluir_inactivos']=='0') and ($row1['estado']=='1')) or  (($_SESSION['estadisticaslider_incluir_inactivos']=='1') ) ){/*Si el check box de incluir modelos inactivos esta chequeado*/
                        

                      
                      $nombres=explode(' ',$row1['nombres']);
                      $apellidos=explode(' ',$row1['apellidos']); 
                      $nombre_apellido=$nombres['0']." ".$apellidos['0'];

                      /*ARRAY de la suma de la venta de cada usuario*/
                      $suma_ventas_por_usuario_usd[$row1['id_usuario']]=0;
                      /*ARRAY de la suma de las comisiones del lider de cada usuario*/
                      $suma_comisioneslider_por_usuario_usd[$row1['id_usuario']]=0;
                      /*ARRAY de la suma de las comisiones del referente de cada usuario*/
                      $suma_comisionesreferente_por_usuario_usd[$row1['id_usuario']]=0;
                     

                      /*ARRAY con el conteo de los dias ROJOS*/
                      $conteo_rojos_por_usuario[$row1['id_usuario']]=0;

                      $linea1[$row1['id_usuario']][]="<a style='text-decoration:none;color:white;' href='../entrevistas/entrevistas.php?editar_usuario=".$row1['id_usuario']."' name='".$row1['id_usuario']."' ><span class='span'>".$nombre_apellido." (".ucfirst($row1['usuario']).")</span></a>";

                               /*Se cojen las paginas trabajadas en ese periodo por ese usuario y se ponen en una Array*/
                               $paginas=$con->query("SELECT DISTINCT(paginas.id_pagina) as id_paginas,paginas.nombre_pagina FROM ventas LEFT JOIN paginas ON (ventas.id_pagina=paginas.id_pagina) 
                               WHERE (ventas.fecha_creacion BETWEEN '".$_SESSION['estadisticaslider_desde']." 00:00:00' AND '".$_SESSION['estadisticaslider_hasta']." 23:59:59')
                               AND ventas.id_usuario='".$row1['id_usuario']."' ");
                                while($row2=$paginas->fetch_assoc()){/*WHILE----------------------------------------------------------------------------------------------------------------*/
                                    
                                      //if(!isset($pagina[$row2['nombre_pagina']])){$pagina[$row2['nombre_pagina']]='';}
                                      //if($row2['venta_usd']==''){$row2['venta_usd']=2}
                                     
                                    $id_paginas[$row2['nombre_pagina']]=$row2['id_paginas'];
                                    //echo "<td>->".$row2['nombre_pagina']."</td>";
                                    
                                   
                                }/*WHILE--------------------------------------------------------------------------------------------------------------------------------------------------*/

                                /*Se cojen las ventas del usuario hechas en ese periodo y se agrupan por dias*/
                                $dias_de_ventas=$con->query("SELECT ventas.*,SUM(ventas.venta_usd) as suma_ventas_dia FROM ventas 
                                WHERE (ventas.fecha_creacion BETWEEN '".$_SESSION['estadisticaslider_desde']." 00:00:00' AND '".$_SESSION['estadisticaslider_hasta']." 23:59:59')
                                AND ventas.id_usuario='".$row1['id_usuario']."' GROUP BY DAY(ventas.fecha_creacion)");
                                while($row3=$dias_de_ventas->fetch_assoc()){/*WHILE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/


                                  /*Dia de la semana*/
                                  $timestamp = strtotime($row3['fecha_creacion']);
                                  $dia_de_la_semana=date("w", $timestamp);     

                                  /*Verificamos si el dia es dia de fiesta*/
                                  $dia_de_fiesta=$con->query("SELECT * FROM dias_festivos WHERE fecha_festiva = DATE('".$row3['fecha_creacion']."')")->fetch_assoc();
                                  $dia_de_fiesta=$dia_de_fiesta['fecha_festiva'];

                                  
                                  /*Verifica si el día consultado es hoy*/
                                  $fecha_consultada=(date_format(date_create($row3['fecha_creacion']),'Y-m-d'));
                                  

                                  /*Si no hizo ventas y el dia no es Sabado ni Domingo*/
                                  if( ($row3['suma_ventas_dia']<=$venta_minima_asistencia) and ( ($dia_de_la_semana!='0') and ($dia_de_la_semana!='6') ) and empty($dia_de_fiesta) and $lafechaencolombia!=$fecha_consultada and $row1['modalidad']!=2)
                                  {$color_segun_asistencia="style='background-color:#ffbfbf;'";$conteo_rojos_por_usuario[$row1['id_usuario']]+=1;}
                                  else{$color_segun_asistencia="";}

                                  /*Se pone la variable del dia festivo*/
                                  if(!empty($dia_de_fiesta)){$imagen_festivo="<img src='../_globales/images/festivo.png' width='20px'>";}else{$imagen_festivo="";}

                                  /*Columna Fecha*/
                                  $fecha_columna=date_parse($row3['fecha_creacion']);
                                  $fecha_columna1= $fecha_columna['day']." ".substr($meses[$fecha_columna['month']-1], 0,3)." ".$fecha_columna['year']."<br>".$dias[$dia_de_la_semana];
                                   


                                  /////////////////////
                                  ///////Linea 1//////
                                  ///////////////////

                                   $linea1[$row1['id_usuario']][].=$fecha_columna1.$imagen_festivo;



                                    if(isset($id_paginas)){/*Isset*/          
                                          
                                          /*Por cada pagina se hace la consulta*/
                                          foreach ($id_paginas as $nombre_pagina => $id_pagina) {/*Foreach*/
                                                     
                                                    /*Se hace la consulta de ventas de cada una de las paginas que se trabajaron en ese periodo por el usuario*/
                                                    $ventas_dia=$con->query("SELECT * FROM ventas WHERE DATE(fecha_creacion)=DATE('".$row3['fecha_creacion']."') AND id_usuario='".$row1['id_usuario']."' AND id_pagina='".$id_pagina."'");
                                                      
                                                      
                                                      /*identificador unico*/
                                                      $fecha_identificador=explode(' ',$row3['fecha_creacion']);
                                                      $identificador_unico=$fecha_identificador['0']."-".$row1['id_usuario']."-".$id_pagina;
                                                      
                                                     
                                                      
                                                                                          
                                                      if(!isset($linea2[$row1['id_usuario']][$id_pagina])){$linea2[$row1['id_usuario']][$id_pagina]="<td><img src='../_globales/images/paginas/$id_pagina.jpg' style='max-width:100px;'></td>";}
                                                      if($ventas_dia->num_rows > 0){/*Si existe record*/
                                                       
                                                      
                                                      $ventas_dia=$ventas_dia->fetch_assoc();

                                                          /*Creacion de fecha para columnas*/
                                                          $fecha=date_parse($ventas_dia['fecha_creacion']);
                                                          $fecha=$fecha['day']." ".$meses[$fecha['month']];
                                                          $pagina[$nombre_pagina][$fecha]=$ventas_dia['venta_usd'];

                                                          

                                                          /*Sumatoria de las ventas por usuario*/
                                                          $suma_ventas_por_usuario_usd[$row1['id_usuario']]+=$ventas_dia['venta_usd'];

                                                          /*Sumatoria de las Comisiones del lider por Usuario*/
                                                          $suma_comisioneslider_por_usuario_usd[$row1['id_usuario']]+=$ventas_dia['venta_usd']*($ventas_dia['porcent_lider']*0.01);

                                                          /*Sumatoria de las Comisiones del Referente por Usuario*/
                                                          $suma_comisionesreferente_por_usuario_usd[$row1['id_usuario']]+=$ventas_dia['venta_usd']*($ventas_dia['porcent_referente']*0.01);
                                                          
                                                           
                                                           
                                                            ////////////////////
                                                           ///////Linea 2//////
                                                          ////////////////////

                                                          if($identificador_unico==$_SESSION['estadisticaslider_editar1']){/*Boton editar*/

                                                                  $linea2[$row1['id_usuario']][$id_pagina].="<td $color_segun_asistencia><input class='typeNumber' style='width:75px;' step='0.01' type='number' name='v_editar2' value='".number_format($ventas_dia['venta_usd'],2,'.',',')."'></input><button class='editnumber' type='submit' name='editar2' value='$identificador_unico'>></button></td>";
                                                           
                                                           }/*Boton editar*/else{/*Boton editar*/
                                                                 
                                                                 $linea2[$row1['id_usuario']][$id_pagina].="<td $color_segun_asistencia>".number_format($ventas_dia['venta_usd'],2,'.',',')." USD <button type='submit' value='$identificador_unico' name='editar1' style='border-style:none;background:none;color:#FFF;cursor:pointer;padding:0px,1px,0px,1px;'><img src='../_globales/images/editicon.jpg'></button></td>";

                                                           }/*Boton editar*/
                                                          
    
                                                      }/*Si existe record*/else{/*Si NO existe record*/

                                                          if($identificador_unico==$_SESSION['estadisticaslider_editar1']){/*Boton editar*/

                                                           $linea2[$row1['id_usuario']][$id_pagina].="<td $color_segun_asistencia><input class='typeNumber' style='width:75px;' name='v_editar2' step='0.01' type='number' value='0'></input> <button class='editnumber' type='submit' name='editar2' value='$identificador_unico'>></button></td>";
                                                          
                                                          }/*Boton editar*/else{/*Boton editar*/

                                                            $linea2[$row1['id_usuario']][$id_pagina].="<td $color_segun_asistencia>0.00 USD <button type='submit' value='$identificador_unico' style='border-style:none;background:none;color:#FFF;cursor:pointer;padding:0px,1px,0px,1px;' name='editar1'><img src='../_globales/images/editicon.jpg'></button></td>";

                                                          }/*Boton editar*/

                                                      }/*Si NO existe record*/
                                                     
                                                    
                                          
                                          }/*Foreach*/
                                         
                                     }/*Isset*/

                                 
                                       
                                        
                                  $color_segun_asistencia='';

                                }/*WHILE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/          

                                unset($id_paginas);                                
                                        
            
                                
                               

                   //////////////////////
                  /*Datos por Usuario*/
                  /////////////////////

                  /*Modalidad*/
                  $modalidad[$row1['id_usuario']]=$row1['modalidad'];

                  /*Nombres*/
                  $nombres_usuario[$row1['id_usuario']]=$nombre_apellido;

                  /*Estudio*/
                  $estudio_usuario[$row1['id_usuario']]=$row1['id_estudio'];


                  /*Porcentaje a Pagar*/
                  if($modalidad[$row1['id_usuario']]==1){$pocerntaje_pago[$row1['id_usuario']]=$porcentaje_estudio;}
                  elseif($modalidad[$row1['id_usuario']]==2){$pocerntaje_pago[$row1['id_usuario']]=$porcentaje_satelite;}
                  else{$pocerntaje_pago[$row1['id_usuario']]=0.0;}

                  
                  ///////////////////////
                  /*Totales por Modelo*/
                  //////////////////////

                  /*Dias Con Inasistencias*/
                  $inasistencias[$row1['id_usuario']]=0;
                  $inasistencias[$row1['id_usuario']]=$conteo_rojos_por_usuario[$row1['id_usuario']];
                                    
                  /*Dias Penalizables*/
                  $dias_penalizables[$row1['id_usuario']]=$conteo_rojos_por_usuario[$row1['id_usuario']]-1;
                  if($dias_penalizables[$row1['id_usuario']]<0){$dias_penalizables[$row1['id_usuario']]=0;}
                  
                                   
                  /*Porcentaje a descontar*/
                  $porcentaje_descontable[$row1['id_usuario']]=0;
                  $porcentaje_descontable[$row1['id_usuario']]=$dias_penalizables[$row1['id_usuario']]*10;

                  /*Porcentaje a descontar*/
                  $porcentaje_final[$row1['id_usuario']]=$pocerntaje_pago[$row1['id_usuario']]-$porcentaje_descontable[$row1['id_usuario']];
                  if($porcentaje_final[$row1['id_usuario']]>=100){$porcentaje_final[$row1['id_usuario']]=100;}
                  
                  /*INICIAL*/                 
                  /*Pago Inicial USD*/
                  $pago_inicial_usd[$row1['id_usuario']]=$suma_ventas_por_usuario_usd[$row1['id_usuario']]*(($pocerntaje_pago[$row1['id_usuario']])*0.01);

                  
                  
                  /*FINAL*/                 
                  /*Pago Final USD*/
                  $pago_final_usd[$row1['id_usuario']]=abs($suma_ventas_por_usuario_usd[$row1['id_usuario']]*(($porcentaje_final[$row1['id_usuario']])*0.01));

                  

                  
                  //////////////////////
                  /*Totales Generales*/
                  /////////////////////
                  
                  /*Ventas Totales*/
                  $total_ventas_modelos_usd+=$suma_ventas_por_usuario_usd[$row1['id_usuario']];

                  /*Promedio de Ventas*/
                  /*Para evitar el error de division por 0*/
                  if(($total_ventas_modelos_usd<1) or ($numero_dias_consultados<1)){$promedio_ventas_modelos_usd=0;}
                  else{$promedio_ventas_modelos_usd=$total_ventas_modelos_usd/$numero_dias_consultados;}

                  
                  /*Comision de todas las modelos*/
                  $total_comisiones_modelos_usd+=$pago_final_usd[$row1['id_usuario']];
               
                  /*Comision de Lider*/
                  $total_comisiones_lider_usd+=$suma_comisioneslider_por_usuario_usd[$row1['id_usuario']];
                 
                  /*Comision de Referentes*/
                  $total_comisiones_referentes_usd+=$suma_comisionesreferente_por_usuario_usd[$row1['id_usuario']];
                  
                  /*Comision de Estudio*/
                  $total_comisiones_estudio_usd=$total_ventas_modelos_usd-$total_comisiones_modelos_usd-$total_comisiones_lider_usd-$total_comisiones_referentes_usd;
                 

                  
                 
                  

                  
            }/*Si el check box de incluir modelos inactivos esta chequeado*/
            }/*WHILE++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
            
}/*Cada Usuario*************************************************************************************************************************************************************************************************************************************************/

?>