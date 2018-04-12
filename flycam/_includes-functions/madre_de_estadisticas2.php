<?

        /*Numero de dias consultados*/
        $estadisticaslider_desde=strtotime($_SESSION['estadisticaslider_desde']);
        //echo $_SESSION['estadisticaslider_desde']."<br>";
        $estadisticaslider_hasta=strtotime($_SESSION['estadisticaslider_hasta']);
        //echo $_SESSION['estadisticaslider_hasta']."<br>";
        
        /*Modelos consultados*/
        //echo $_SESSION['estadisticaslider_modelo']."<br>";

       
        /*Populacion de array con dias de fiesta*/
        $dias_festivos=array();
        $dias_de_fiesta=$con->query("SELECT * FROM dias_festivos");
        while($row1=$dias_de_fiesta->fetch_assoc()){/*while*/
                    $dias_festivos[]=$row1['fecha_festiva'];
        }/*while*/

        /*Populacion de array de Paginas*/
        $paginas_nombres=array();
        $paginas_con=$con->query("SELECT * FROM paginas");
        while($row1=$paginas_con->fetch_assoc()){/*while*/
                    $paginas_nombres[$row1['id_pagina']]=$row1['nombre_pagina'];
        }/*while*/

        
        /*Numero de dolares minimo para hacer asistencia en el dia*/
        $venta_minima_asistencia=0.5;

        /*Suma de todos los Modelos Consultados*/
        $total_ventas_modelos_usd=0;
        $total_comisiones_modelos_usd=0;
        $total_comisiones_lider_usd=0;
        $total_comisiones_referentes_usd=0;
        $total_comisiones_estudio_usd=0;


        
        
                       /*Se hace la consulta de ventas de cada una de las paginas que se trabajaron en ese periodo por los usuarios consultados*/
                       $ventas_dia=$con->query("
                                                SELECT usuarios.nombres,usuarios.apellidos,usuarios.usuario,lideres.usuario as usuario_lider,referentes.usuario as usuario_referente,date(ventas.fecha_creacion) as fecha,paginas.id_pagina,ventas.* FROM ventas 
                                                LEFT JOIN usuarios usuarios ON (usuarios.id_usuario=ventas.id_usuario)
                                                LEFT JOIN paginas ON (paginas.id_pagina=ventas.id_pagina)
                                                LEFT JOIN usuarios lideres ON (lideres.id_usuario=ventas.id_lider)
                                                LEFT JOIN usuarios referentes ON (referentes.id_usuario=ventas.id_referente)

                                                /*Atencion toca poner 23:59:59 en a ultima fecha, de lo contrario no coje la data de la ultima fecha*/
                                                WHERE (ventas.fecha_creacion BETWEEN '".$_SESSION['estadisticaslider_desde']."' AND '".$_SESSION['estadisticaslider_hasta']." 23:59:59') 
                                                AND ventas.id_usuario in (".$_SESSION['estadisticaslider_modelo'].")

                                                ORDER BY usuarios.id_usuario,ventas.id_pagina,ventas.fecha_creacion asc
                                              ");
                       
                       
                      $info_celda=array();
                      $fechas_unicas=array();
                      $info_totales=array();

                      
                      /*Se ponen las ARRAYS en 0 para ser llenadas mas abajo*/
                      
                      /*ARRAY de la suma de las comisiones del lider de cada usuario*/
                      $suma_comisioneslider_por_usuario_usd[$row1['id_usuario']]=0;
                      /*ARRAY de la suma de las comisiones del referente de cada usuario*/
                      $suma_comisionesreferente_por_usuario_usd[$row1['id_usuario']]=0;
                 

                      /*ARRAY con el conteo de los dias ROJOS*/
                      $conteo_rojos_por_usuario[$row1['id_usuario']]=0;

                       
                       
                      while($row1=$ventas_dia->fetch_assoc()){/*WHILE**********************************************************************************************/ 

                           // /*TOTALES GENERALES*/
                           // /*Sumatoria de las ventas por usuario*/
                           // $suma_ventas_por_usuario_usd[$row1['id_usuario']]+=$row1['venta_usd'];
                           // /*Comision de todas las modelos*/
                           // $total_comisiones_modelos_usd+=$pago_final_usd[$row1['id_usuario']];
                           // /*Comision de Lider*/
                           // $total_comisiones_lider_usd+=$suma_comisioneslider_por_usuario_usd[$row1['id_usuario']];
                           // /*Comision de Referentes*/
                           // $total_comisiones_referentes_usd+=$suma_comisionesreferente_por_usuario_usd[$row1['id_usuario']];
                           // /*Comision de Estudio*/
                           // $total_comisiones_estudio_usd=$total_ventas_modelos_usd-$total_comisiones_modelos_usd-$total_comisiones_lider_usd-$total_comisiones_referentes_usd;

                           
                       
                            /*Se explotan los nombres y los apellidos para poder usar el primero de cada uno*/
                            $nombres=explode(' ',$row1['nombres']);
                            $apellidos=explode(' ',$row1['apellidos']);
                            
                            ////////////////
                            /*$Info_totales*/
                            //////////////

                            /*PAGINAS*/
                            /*Dolares Por Pagina*/
                            if(!isset($info_totales['dolares_por_pagina'][$row1['id_pagina']])){$info_totales['dolares_por_pagina'][$row1['id_pagina']]=0;}
                            $info_totales['dolares_por_pagina'][$row1['id_pagina']]+=$row1['venta_usd'];
                            /*Dolares paginas Totales*/
                            if(!isset($info_totales['dolares_paginas_totales'])){$info_totales['dolares_paginas_totales']=0;}
                            $info_totales['dolares_paginas_totales']+=$row1['venta_usd'];

                            /*LIDERES*/
                            /*Dolares por Lider*/
                            if(!isset($info_totales['dolares_por_lider'][$row1['id_lider']]['venta'])){$info_totales['dolares_por_lider'][$row1['id_lider']]['venta']=0;}
                            $info_totales['dolares_por_lider'][$row1['id_lider']]['venta']+=$row1['venta_usd']*$row1['porcent_lider']/100;
                            $info_totales['dolares_por_lider'][$row1['id_lider']]['usuario_lider']=$row1['usuario_lider'];
                            /*Dolares Lideres Totales*/
                            if(!isset($info_totales['dolares_lideres_totales'])){$info_totales['dolares_lideres_totales']=0;}
                            $info_totales['dolares_lideres_totales']+=$row1['venta_usd']*$row1['porcent_lider']/100;
                           
                            /*REFERENTES*/
                            /*Dolares por Referente*/
                            if(!isset($info_totales['dolares_por_referente'][$row1['id_referente']]['venta'])){$info_totales['dolares_por_referente'][$row1['id_referente']]['venta']=0;}
                            $info_totales['dolares_por_referente'][$row1['id_referente']]['venta']+=$row1['venta_usd']*$row1['porcent_referente']/100;
                            $info_totales['dolares_por_referente'][$row1['id_referente']]['usuario_referente']=$row1['usuario_referente'];
                            /*Dolares Referentes Totales*/
                            if(!isset($info_totales['dolares_referentes_totales'])){$info_totales['dolares_referentes_totales']=0;}
                            $info_totales['dolares_referentes_totales']+=$row1['venta_usd']*$row1['porcent_referente']/100;
                            
                            /*Dolares por Estudio*/
                            if(!isset($info_totales['dolares_por_estudio'][$row1['id_estudio']])){$info_totales['dolares_por_estudio'][$row1['id_estudio']]=0;}
                            $info_totales['dolares_por_estudio'][$row1['id_estudio']]+=$row1['venta_usd'];

                            /*Dolares Totales*/
                            if(!isset($info_totales['dolares_totales'])){$info_totales['dolares_totales']=0;}
                            $info_totales['dolares_totales']+=$row1['venta_usd'];

                            
                            ///////////////////
                            /*$fechas_unicas*/
                            /////////////////
                            /*Estas son las fechas para la primera fila de fechas que no se repiten*/
                            if(!in_array($row1['fecha'], $fechas_unicas, true)){/*Si la fecha no existe en la array*/
                                            array_push($fechas_unicas, $row1['fecha']);
                            }/*Si la fecha no existe en la array*/

                            /*La siguiente funcion ayuda a que la fila de fechas unicas salga en orden.*/
                            sort($fechas_unicas);
                            
                            ////////////////
                            /*$Info_celda*/
                            //////////////
                            /*Se ponen los nombres en la array general*/
                            $info_celda[$row1['id_usuario']]['nombre']=$nombres['0']." ".$apellidos['0'];

                            /*Se pone el usuario en la array general*/
                            $info_celda[$row1['id_usuario']]['usuario']=$row1['usuario'];

                            /*Ventas en USD*/
                            $info_celda[$row1['id_usuario']][$row1['id_pagina']][$row1['fecha']]['venta']=$row1['venta_usd'];

                            /*Porcentajes*/
                            $info_celda[$row1['id_usuario']][$row1['id_pagina']][$row1['fecha']]['porcentaje']=$row1['porcent_modelo'];

                            /*Identificador Unico*/
                            $info_celda[$row1['id_usuario']][$row1['id_pagina']][$row1['fecha']]['identificador']=$row1['fecha']."-".$row1['id_usuario']."-".$row1['id_pagina'];
                       

                      }/*WHILE**********************************************************************************************/          


                    //echo "<pre>";
                    //print_r($info_celda);
                    //echo "</pre>";
                    //
                    //echo "<pre>";
                    //print_r($info_totales);
                    //echo "</pre>";
                    
                    // echo "<pre>";
                    // print_r($fechas_unicas);
                    // echo "</pre>";


                     
                      


            


?>