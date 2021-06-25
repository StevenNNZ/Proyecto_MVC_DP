<?php 
    require_once("../../../config/conexion.php");
    require_once("../../../models/Reporte_venta.php");
    require_once("../../../models/Ticket.php");
    require_once("../../../models/Interfaz.php");
    require_once("../../../models/Pago.php");
    require_once("../../../models/Reporte_venta.php");

    //Instancias de clases
    $reportesVenta = new Reporte_venta();
    $interfaz = new Interfaz();
    $ticket = new Ticket();

    function getReporteVenta($desde, $hasta){
        //Variables
        global $reportesVenta;
        global $interfaz;

        //Elementos de la tabla
        $tableHead = ['id', 'documento', 'nombre', 'apellido', 'placa', 'entrada', 'salida', 'tiempo servicio', 'total pago'];
        $tableBody = [];
        $keysTable = ['id_reporte', 'Documento', 'Nombre', 'Apellido', 'Placa', 'entrada', 'salida', 'tiempo_servicio', 'Pago_total'];
        $tipo_tabla = ['reporte_venta', ''];

        // Traer los reportes de venta
        $datos = $reportesVenta->getReporte_venta($desde, $hasta);
    
        //Creación de la respuesta a la vista.
        if(is_array($datos) and count($datos)>0){
            //Iterar sobre los datos de reportesVenta
            foreach($datos as $row){
                array_push($tableBody, $row); //Llenar el cuerpo de la tabla.
            }
            
            // var_dump($tableBody);
            //Crear la tabla
            $html = $interfaz->createTable($tableHead, $tableBody, $keysTable, $tipo_tabla);
            
            //Retornar la respuesta
            return $html;
        }
    }

    function getTicketEntrada($id){
        global $ticket, $interfaz;
        $datos = $ticket->getTicketEntrada_x_id($id);
        
        //Creación de la respuesta a la vista.
        if(is_array($datos) and count($datos)>0){
            foreach($datos as $row){
                $datos = [
                    $id,
                    $row['Num_estacionamiento'],
                    $row['id_vehiculo'],
                    $row['id_cliente'],
                    $interfaz->formatearFecha($row['Fecha_entrada']),
                    $row['Hora_entrada'],
                    $row['cajero'],
                    $interfaz->formatearFecha($row['Fecha_creacion'])
                ];
                break;
            }

            $html = $interfaz->createTicket('entrada', $datos);

            //retornar html
            return $html;
        }
    }

    function getTicketEntradaByCliente($documento){
        global $ticket, $interfaz;
        $datos = $ticket->getTicketEntradaByCliente($documento);
        
        //Creación de la respuesta a la vista.
        if(is_array($datos) and count($datos)>0){
            foreach($datos as $row){
                $datos = [
                    $row['id_ticket_entrada'],
                    $row['Num_estacionamiento'],
                    $row['id_vehiculo'],
                    $row['id_cliente'],
                    $interfaz->formatearFecha($row['Fecha_entrada']),
                    $row['Hora_entrada'],
                    $row['cajero'],
                    $interfaz->formatearFecha($row['Fecha_creacion'])
                ];
                break;
            }

            $html = $interfaz->createTicket('entrada', $datos);

            //retornar html
            return $html;
        }
    }

    function getStylesReporteVenta(){
        $styles = "
        <style>
            .contenedor-table__table{
                margin: 0px auto;
                border-collapse: collapse;
                width: 80%;
                height: 50px;
                font-family: Helvetica;
            }
            
            /* Estilos tabla head */
            .contenedor-table__thead{
                border: 2px solid #1992b1;
            }
            
            /* Estilos campos de la cabecera */
            .contenedor-table__tr--principal{
                font-size: 20px;
                color: rgb(255, 255, 255);
            } 
            
            /* Estilos elementos de la cabecera, por etiqueta */
            th{
                background: #1992b1;
                position: sticky;
                top: -1px;
                height: 50px;
                padding: 0 10px;
            }
            
            .tabla_reporte-ventas th{
                min-width:100px ;
            }
            
            .tabla_gestion-usuarios th{
                min-width:100px ;
            }
            .contenedor-table__tbody{
                background: rgb(255, 255, 255);
                border: 2px solid #1992b1;
                border-top: none;
            }
            
            /* Estilos tbody */
            tbody{
                border: 1px solid rgb(83, 83, 83);
            }
            
            
            /* Estilos elementos del cuerpo tabla por etiqueta */
            td{
                border: 1px solid rgba(83, 83, 83, 0.582);
                padding: 1px 10px;
                text-align: center;
                height: 45px;
                max-width: 40px;
                overflow: hidden;
                overflow-x:auto;
            }
            
            td::-webkit-scrollbar{
                height: 3px;
                background: rgb(73, 72, 72);
            }
            td::-webkit-scrollbar-thumb{
                background: rgb(184, 181, 181);
                border-radius: 5px;
            }
            
            /* Estilo tabla de reporte de ventas (Sumatoria de pagos) */
            .total_pagos{
                text-align: right;
                text-transform: uppercase;
                font-size: 25px;
                background: #1992b1;
                color: #fff;
                font-weight: bold;
            }
            
            .sumatoria_total_pagos{
                font-size: 20px;
                /* background: #1993b18e; */
                /* color: #fff; */
                font-weight: bold;
                
            }
        </style>";

        return $styles;
    }

    function getStylesTicket(){
        $styles = '
        <style>
        .negrita{
            font-weight: bold;
        }
        
        .contenedorTicket{
            border: 1px dashed #000;
            width: 400px;
            margin: 0px auto;
            padding: 30px;
            font-family:Verdana, Geneva, Tahoma, sans-serif;
        }
        .header{
            text-align: center;
            margin-top: -20px;
            border-bottom: 1px solid #ccc;
            margin-bottom: 50px;
            padding-bottom: 10px;
        }
        
        .header h1{
            text-align: center;
        }
        
        .header p{
            line-height: 5px;
        }
        
        .info{
            border-bottom: 1px dashed #000;
        }
        
        .info .negrita{
        width: 200px;
        }
        
        .info .content-info1{
            padding-left: 132px;
        }
        
        .info .content-info2{
            padding-left: 52px;
        }
        
        .info .content-info3{
            padding-left: 168px;
        }
        
        .info .content-info4{
            padding-left: 67px;
        }

        .info .content-info5{
            padding-left: 105px;
        }

        .info .content-info6{
            padding-left: 124px;
        }
        
        .detalles_tiempo{
            padding-bottom: 30px;
            border-bottom: 1px dashed #000;
        }
        
        .detalles_tiempo h2{
            font-size: 18px;
        }
        
        .detalles_tiempo span{
            padding-right: 50px;
            padding-left: 20px;
        }
        
        .venta{
            margin-top: 20px;
            border: 2px dashed grey;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .footerTicket{
            border-top: 1px dashed #000;
            font-size: 10px;
            text-align: right;
        
        }
        
        .footerTicket .fecha{
            font-size: 13px;
            font-style: italic;
        }
        </style>';

        return $styles;
    }

    function showTicketSalida($id_salida){
        global $ticket, $interfaz;
        
        $datos = $ticket->getCompleteExitTicket($id_salida);

        if(is_array($datos) && count($datos)>0){
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
            $fechaSalida = $interfaz->formatearFecha($fechaSalida);
            $fechaEntrada = $interfaz->formatearFecha($fechaEntrada);
            $fechaRegistro = $interfaz->formatearFecha($fechaRegistro);
    
            //Datos a enviar para crear el ticket de salida
            $datos = [
                $id_ticket, $noEstacionamiento, $vehiculo, 
                $tipoVehiculo, $cliente, $valorTarifa, 
                $fechaEntrada, $horaEntrada, $fechaSalida, 
                $horaSalida, $tiempoTotal, $pagoFinal, 
                $cajero, $fechaRegistro
            ];
    
            $html = $interfaz->createTicket('salida', $datos); //Devuelve el ticket
        }else{
            $html = 'No hay datos disponibles...';
        }

        return $html;
    }
?>