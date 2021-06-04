<?php 
    require_once("../../config/conexion.php");
    require_once("../../models/Ticket.php");
    function getReporte($id){
        $ticket = new ReporteTicket();
            $html="";
            // Método getReporte_ticket --> recibe el id requerido para la consulta sql.
            $datos = $ticket->getTicket_x_id($id);
            
            //Creación de la respuesta a la vista.
            if(is_array($datos) and count($datos)>0){
                $html.="
                <div class='contenedorTicket'>
                    <div class='header'>
                        <h1>Digital Parking</h1>
                        <p>Cra 50 # 26 - Paloquemao</p>
                        <p>Nit: 165856215441</span></p>
                        <p class='negrita'>Ticket de salida</p>
                    </div>";
                foreach($datos as $row){
                    $html.="
                    <div class='info'>
                        <p>
                            <span class='negrita'>No. Ticket:</span><span class='content-info1'>105</span>
                        </p>
                        <p>
                            <span class='negrita'>No. Estacionamiento:</span><span class='content-info2'>5</span>
                        </p>
                        <p>
                            <span class='negrita'>Placa:</span><span class='content-info3'>BGT345</span>
                        </p>
                        <p>
                            <span class='negrita'>Documento:</span><span class='content-info4'>100789235</span>
                        </p>
                    </div>
                    <div class='detalles_tiempo'>
                        <h2>Fecha y hora de ingreso</h2>
                        <span id='fecha'>27/10/2016</span> <span id='hora'>6:57:00 pm</span>
            
                        <h2>Fecha y hora de salida</h2>
                        <span id='fecha'>27/10/2016</span> <span id='hora'>6:57:00 pm</span>
            
                        <h2>Tiempo transcurrido</h2>
                        <span id='fecha'>2h 3min 30seg</span>
                    </div>

                    <div class='venta'>
                        <p>Valor venta: <span>$9.800</span></p>
                    </div>
    
                    <div class='footerTicket'>
                        <h2>Atendido por: <span>Andrea Quiroga</span></h2>
                        <h2 class='fecha'>Fecha: <span>15/05/2021</span></h2>
                    </div>";
                }
                
                $html.="</div>";
                //Finalmente se escribe o retorna lo que hemos almacenado en la variable $html
                return $html;
            }
    }

    function getTicketEntrada($id){
            $ticketE = new Ticket();
            $html="";
            // Método getReporte_venta --> recibe la fecha desde y la fecha hasta requeridos para la consulta sql.
            $datos = $ticketE->getTicketEntrada_x_id($id);
            
            //Creación de la respuesta a la vista.
            if(is_array($datos) and count($datos)>0){
                foreach($datos as $row){
                    $fechaEntrada = date_create($row['Fecha_entrada']);
                    $fechaEntrada = date_format($fechaEntrada,"d/M/Y");
                    $fechaCreacion = date_create($row['Fecha_creacion']);
                    $fechaCreacion = date_format($fechaCreacion,"d/M/Y");
                    $html.="
                    <div class='contenedorTicket'>
                        <div class='header'>
                            <h1>Digital Parking</h1>
                            <p>Cra 50 # 26 - Paloquemao</p>
                            <p>Nit: 165856215441</span></p>
                            <p class='negrita'>Ticket de entrada</p>
                        </div>

                        <div class='info'>
                            <p>
                                <span class='negrita'>No. Ticket:</span><span class='content-info1'>$row[Id_ticket_entrada]</span>
                            </p>
                            <p><span class='negrita'>No. Estacionamiento:</span><span class='content-info2'>$row[Num_estacionamiento]</span></p>
                            <p><span class='negrita'>Placa:</span><span class='content-info3'>$row[id_vehiculo]</span></p>
                            <p><span class='negrita'>Documento:</span><span class='content-info4'>$row[id_cliente]</span></p>

                        </div>

                        <div class='detalles_tiempo'>
                            <h2>Fecha y hora de ingreso</h2>
                            <span id='fecha'>$fechaEntrada</span> <span id='hora'>$row[Hora_entrada]</span>
                            
                        </div>
                        
                        <div class='footerTicket'>
                            <h2>Atendido por: <span>$row[nombre] $row[apellido]</span></h2>
                            <h2 class='fecha'>Fecha: <span>$fechaCreacion</span></h2>
                        </div>
                    </div>
                    ";
                }
                //Finalmente se escribe o retorna lo que hemos almacenado en la variable $html
                return $html;
            }
    }


    //Crear salida (PAGO TOTAL, TIEMPO SERVICIO, ETC)
    function createSalida($id_entrada, $id){
        $ticketS = new Ticket();

        //Recuperar el id del ticket de salida
        $ticketSalida = $ticketS->getTicketSalida_x_id($id_entrada);
        foreach($ticketSalida as $row){
            $id_ticket = $row['Id_ticket'];
            $fechaSalida = $row['Fecha_salida'];
            $horaSalida = $row['Hora_salida'];
            $cajero = $row['nombreCajero'];
            $fechaRegistro = $row['fechaRegistro'];
        }

        
        $datosEntrada = $ticketS->getTicketEntrada_x_id($id_entrada);
        foreach($datosEntrada as $row){
            $noEstacionamiento = $row['Num_estacionamiento'];
            $vehiculo = $row['id_vehiculo'];
            $cliente = $row['id_cliente'];
            $fechaEntrada = $row['Fecha_entrada'];
            $horaEntrada = $row['Hora_entrada'];
        }

        //Calcular el tiempo de servicio mediante sql
        $datos = $ticketS->calcularTiempo($id_entrada);
        foreach($datos as $row){
            $cantidadDias = $row['Diferencia_fechas'];
            $tiempoServicio = $row['Diferencia_Horas'];
        }
        //Convertir el tiempo de servicio a un formato de tiempo.
        $totalServicio = strtotime($tiempoServicio);

        $H = date('H', $totalServicio);//Horas
        $i = date('i', $totalServicio);//Minutos
        $s = date('s', $totalServicio);//Segundos

        //Tiempo total de servicio en string
        $tiempoTotal = "$cantidadDias"."d $H"."h $i"."min $s"."seg";

        //Recuperar el tipo de vehículo desde el estacionamiento
        $tipoVehiculo = $ticketS->getTipoVehiculo_x_id($id);
        foreach($tipoVehiculo as $row){
            $tipoVehiculo = $row['Tipo_vehiculo'];
        }
        
        //Recuperar el valor de la tarifa acorde al tipo de vehículo.
        $tarifa = $ticketS->getValorTarifa_x_tipo($tipoVehiculo);
        foreach($tarifa as $row){
            $idTarifa = $row['id_tarifa'];
            $valorTarifa = $row['Valor_tarifa'];
        }

        $valorSegundo = 0;
        $valorMinuto = 0;
        $valorHora = 0;
        $valorDias = 0;

        //Valor a pagar por segundos
        if($s > 0){
            $valorSegundo = $valorTarifa;
        }

        //Valor a pagar por minutos
        if($i > 0){
            $valorMinuto= ($valorTarifa*$i);
        }

        //Valor a pagar por minutos
        if($H > 0){
            $valorHora = ((60*$H)*$valorTarifa);
        }

        //Valor a pagar por minutos
        if($cantidadDias > 0){
            $valorDias = (((24*$cantidadDias)*60)*$valorTarifa);
        }
        //Pago final
        $pagoFinal = $valorSegundo+$valorMinuto+$valorHora+$valorDias;
        $pagoFinal = $pagoFinal;//Formato de número US


        //formato para todas las fechas
        //Fecha de salida bahía
        $fechaSalida = date_create($fechaSalida); 
        $fechaSalida = date_format($fechaSalida,"d/M/Y");

        //Fecha de entrada bahía
        $fechaEntrada = date_create($fechaEntrada);
        $fechaEntrada = date_format($fechaEntrada,"d/M/Y");

        //Fecha de registro Ticekt salida
        $fechaRegistro = date_create($fechaRegistro);
        $fechaRegistro = date_format($fechaRegistro,"d/M/Y");

        //Registrar el pago en la base de datos
        $ticketS->registrarPago($id_ticket, $tiempoTotal, $idTarifa, $pagoFinal);

        //Recolectar el id del pago
        $id_pago = $ticketS->getPagos_x_idSalida($id_ticket);
        foreach($id_pago as $row){
            $id_pago = $row['id_pago'];
        }

        //Crear el reporte de venta.
        $ticketS->createReporteVenta($id_pago);


        //Body del ticket en PDF
        $html = "
        <div class='contenedorTicket'>
            <div class='header'>
                <h1>Digital Parking</h1>
                <p>Cra 50 # 26 - Paloquemao</p>
                <p>Nit: 165856215441</span></p>
                <p class='negrita'>Ticket de salida</p>
            </div>
    
            <div class='info'>
                <p>
                    <span class='negrita'>No. Ticket:</span><span class='content-info1'>$id_ticket</span>
                </p>
                <p><span class='negrita'>No. Estacionamiento:</span><span class='content-info2'>$noEstacionamiento</span></p>
                <p><span class='negrita'>Placa:</span><span class='content-info3'>$vehiculo</span></p>
                <p><span class='negrita'>Tipo Vehículo:</span><span class='content-info5'>$tipoVehiculo</span></p>
                <p><span class='negrita'>Documento:</span><span class='content-info4'>$cliente</span></p>
                <p><span class='negrita'>Valor tarifa:</span><span class='content-info6'>$valorTarifa</span></p>
    
            </div>
    
            <div class='detalles_tiempo'>
                <h2>Fecha y hora de ingreso</h2>
                <span id='fecha'>$fechaEntrada</span> <span id='hora'>$horaEntrada</span>
                
                <h2>Fecha y hora de salida</h2>
                <span id='fecha'>$fechaSalida</span> <span id='hora'>$horaSalida</span>
                
                <h2>Tiempo transcurrido</h2>
                <span id='fecha'>$tiempoTotal</span>
            </div>
    
            <div class='venta'>
                <p>Valor venta: <span>$".number_format($pagoFinal)."</span></p>
            </div>
            
            <div class='footerTicket'>
                <h2>Atendido por: <span>$cajero</span></h2>
                <h2 class='fecha'>Fecha: <span>$fechaRegistro</span></h2>
            </div>
        </div>
        ";

        return $html;
    }

    function showTicketSalida($id_salida){
        $ticketS = new Ticket();

        $datos = $ticketS->getCompleteExitTicket($id_salida);

        foreach($datos as $row){
            $id_ticket = $row['Id_ticket'];
            $noEstacionamiento = $row['Num_estacionamiento'];
            $vehiculo = $row['id_vehiculo'];
            $tipoVehiculo = $row['Tipo_vehiculo'];
            $cliente = $row['id_cliente'];
            $valorTarifa = $row['Valor_tarifa'];
            $fechaEntrada = $row['Fecha_entrada'];
            $horaEntrada = $row['Hora_entrada'];
            $fechaSalida = $row['Fecha_salida'];
            $horaSalida = $row['Hora_salida'];
            $tiempoTotal = $row['tiempo_servicio'];
            $pagoFinal = $row['Pago_total'];
            $cajero = $row['Cajero'];
            $fechaRegistro = $row['fechaRegistro'];

        }

    
        //formato para todas las fechas
        //Fecha de salida bahía
        $fechaSalida = date_create($fechaSalida); 
        $fechaSalida = date_format($fechaSalida,"d/M/Y");

        //Fecha de entrada bahía
        $fechaEntrada = date_create($fechaEntrada);
        $fechaEntrada = date_format($fechaEntrada,"d/M/Y");

        //Fecha de registro Ticekt salida
        $fechaRegistro = date_create($fechaRegistro);
        $fechaRegistro = date_format($fechaRegistro,"d/M/Y");
        
        //Body del ticket
        $html = "
        <div class='contenedorTicket'>
            <div class='header'>
                <h1>Digital Parking</h1>
                <p>Cra 50 # 26 - Paloquemao</p>
                <p>Nit: 165856215441</span></p>
                <p class='negrita'>Ticket de salida</p>
            </div>
    
            <div class='info'>
                <p>
                    <span class='negrita'>No. Ticket:</span><span class='content-info1'>$id_ticket</span>
                </p>
                <p><span class='negrita'>No. Estacionamiento:</span><span class='content-info2'>$noEstacionamiento</span></p>
                <p><span class='negrita'>Placa:</span><span class='content-info3'>$vehiculo</span></p>
                <p><span class='negrita'>Tipo Vehículo:</span><span class='content-info5'>$tipoVehiculo</span></p>
                <p><span class='negrita'>Documento:</span><span class='content-info4'>$cliente</span></p>
                <p><span class='negrita'>Valor tarifa:</span><span class='content-info6'>$valorTarifa</span></p>
    
            </div>
    
            <div class='detalles_tiempo'>
                <h2>Fecha y hora de ingreso</h2>
                <span id='fecha'>$fechaEntrada</span> <span id='hora'>$horaEntrada</span>
                
                <h2>Fecha y hora de salida</h2>
                <span id='fecha'>$fechaSalida</span> <span id='hora'>$horaSalida</span>
                
                <h2>Tiempo transcurrido</h2>
                <span id='fecha'>$tiempoTotal</span>
            </div>
    
            <div class='venta'>
                <p>Valor venta: <span>$".number_format($pagoFinal)."</span></p>
            </div>
            
            <div class='footerTicket'>
                <h2>Atendido por: <span>$cajero</span></h2>
                <h2 class='fecha'>Fecha: <span>$fechaRegistro</span></h2>
            </div>
        </div>
        ";

        return $html;
    }
?>