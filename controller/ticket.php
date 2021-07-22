<?php 
    require_once("../config/conexion.php");
    require_once("../models/Ticket.php");
    require_once("../models/Tarifa.php");
    require_once("../controller/pagos.php");
    require_once("../controller/reporte_venta.php");
    require_once("../models/Vehiculo.php");
    require_once("../models/Interfaz.php");

    $ticket = new Ticket();
    $tarifa = new Tarifa();
    $vehiculo = new Vehiculo();
    $interfaz = new Interfaz();

    //Definir variables
    $tableHead = ['id', 'entrada', 'salida', 'cajero', 'estado', 'acciones']; //Cabecera de la tabla 
    $tableBody = [];
    $keysTable = ['Id_ticket', 'entrada', 'salida', 'cajero', 'estado_salida']; //Llaves para acceder a los campos de la tabla
    $tipo_tabla = ['ticket', 'reporteTicket'];

    switch($_GET["op"]){
        case "listar_ticketE":
           echo getTicketsEntrada();
        break;

        case "listar_ticketS":
            echo getTicketsSalida();
        break;

        case "terminarTicketE":
            terminarTicketEntrada();
        break;

        case "getReporteTickets":
            echo getReporteTickets();
        break;

        case "terminarTicketSalida":
            terminarTicketSalida();
        break;

        case "deleteTicketSalida": 
            deleteTicketSalida();
        break;

        case "activarTicketSalida":
            activarTicketSalida();
        break;
    }


    //FUNCIONES

    //Traer tickets de entrada
    function getTicketsEntrada(){
        global $ticket, $interfaz;

        $datos = $ticket->getTicketsEntrada();
            
        if(is_array($datos) and count($datos)>0){

            $tableHeadEntrada = ['id', 'estacionamiento', 'Hora entrada', 'Fecha entrada', 'estado', 'acciones']; //Cabecera de la tabla 
            $tableBodyEntrada = [];
            $keysTableEntrada = ['Id_ticket_entrada', 'id_estacionamiento', 'Hora_entrada', 'Fecha_entrada', 'estado_entrada']; //Llaves para acceder a los campos de la tabla
            $tipo_tabla = ['ticket', 'ticket-entrada'];


            $html= $interfaz->getAlert('Mostrando <b>tickets de entrada</b> activos.','alert_success');

            foreach($datos as $row){
                array_push($tableBodyEntrada, $row); //Llenar cuerpo de tabla entrada
            }

            $html .= $interfaz->createTable($tableHeadEntrada, $tableBodyEntrada, $keysTableEntrada, $tipo_tabla);
        }else{
            $html= $interfaz->getAlert('¡Oops! Al parecer aún no se ha registrado <b>Tickets de entrada</b>.','alert_danger');
        }

        return $html;
    }

    //Traer tickets de salida
    function getTicketsSalida(){
        global $ticket, $interfaz;

        $datos = $ticket->getTicketsalida();
            
            if(is_array($datos) and count($datos)>0){
                $tableHeadSalida = ['id', 'entrada', 'salida', 'estado', 'cajero', 'acciones']; //Cabecera de la tabla 
                $tableBodySalida = [];
                $keysTableSalida = ['Id_ticket', 'entrada', 'salida', 'estado_salida', 'cajero']; //Llaves para acceder a los campos de la tabla
                $tipo_tabla = ['ticket', 'ticket-salida'];
                $html = $interfaz->getAlert('Mostrando <b>tickets de salida</b> activos.', 'alert_success');

                foreach($datos as $row){
                    array_push($tableBodySalida, $row);
                }

                $html .= $interfaz->createTable($tableHeadSalida, $tableBodySalida, $keysTableSalida, $tipo_tabla);
            }else{
                $html = $interfaz->getAlert('¡Oops! Al parecer aún no se ha registrado <b>Tickets de salida</b>.', 'alert_danger');
            }

            return $html;
    }

    //Finalizar tickets de entrada (Estado Terminado)
    function terminarTicketEntrada(){
        global $ticket;

        $id = $_GET['id'];
        $user_active = $_GET['user_active'];
        $ticket->terminarTicketE($id, $user_active);
    }
    //Traer un reporte de tickets de salida
    function getReporteTickets(){
        global $ticket, $interfaz, $tableHead, $tableBody, $keysTable, $tipo_tabla;

        $desde = $_GET['desde'];
        $desdeH = $_GET['desdeH'];
        $hasta = $_GET['hasta'];
        $hastaH = $_GET['hastaH'];

        // Recibe la fecha desde y la fecha hasta requeridos para la consulta sql.
        $datos = $ticket->getTicketSalidaBetween($desde, $desdeH, $hasta, $hastaH);
        
        //Creación de la respuesta a la vista.
        if(is_array($datos) and count($datos)>0){
            $html = $interfaz->getAlert("Mostrando registros desde <b>$desdeH $desde</b> hasta <b>$hastaH $hasta</b>",'alert_success');

            foreach($datos as $row){
                array_push($tableBody, $row);
                
            }
            $html .= $interfaz->createTable($tableHead, $tableBody, $keysTable, $tipo_tabla);
        }else{
            $html = $interfaz->getAlert(' No hemos encontrado ningún registro. Asegúrese de haber introducido la <b>fecha</b> correcta.', 'alert_danger');

        }

        //Retornar el html
        return $html;
    }

    //eliminar ticket de salida
    function deleteTicketSalida(){
        global $ticket;

        $id = $_GET['id'];
        $user = $_GET['user_active'];
        $ticket->deleteTicketSalida($id, $user);
    }

    //Activar tickets de salida (Estado activo)
    function activarTicketSalida(){
        global $ticket;

        $id = $_GET['id'];
        $user = $_GET['user_active'];
        $ticket->activarTicketSalida($id, $user);
    }

    //Finalizar tickets de salida (Estado Terminado)
    function terminarTicketSalida(){
        global $ticket;

        $id = $_GET['id'];
        $user_active = $_GET['user_active'];
        $ticket->terminarTicketSalida($id, $user_active);
    }

    //Se encarga de crear el ticket de salida. Retorna el id de salida.
    function createTicketSalida($id_entrada, $id_estacionamiento, $id_usuario){

        $datos = calcularSalida($id_entrada, $id_estacionamiento, $id_usuario);

        //Variables para insertar registro de pago
        $id_salida = $datos[0];
        $id_tarifa = $datos[1][0];
        $tiempo_servicio = $datos[1][1];
        $total_pagar = $datos[1][2];

        //Insertar pago, retorna el id del pago
        $id_pago = insertPago($id_salida, $tiempo_servicio, $id_tarifa, $total_pagar);

        //Insertar un reporte de la venta.
        insertReporteVenta($id_pago);

        return $id_salida;
    }

    //Calcula todos los datos necesarios para registrar el ticket
    function calcularSalida($id_entrada, $id_estacionamiento, $id_usuario){
        //Insertar ticket de salida
        insertTicketSalida($id_entrada, $id_usuario);

        //Traer los datos de salida
        $id_salida = getIDSalida($id_entrada);

        //Traer los datos de tarifa, tiempo y pago
        $detalles_pago = getDetallesPago($id_entrada, $id_estacionamiento);

        return [$id_salida, $detalles_pago];
    }

    //Insertar ticket de salida
    function insertTicketSalida($id_entrada, $id_usuario){
        global $ticket;

        $ticket->setTicketSalida($id_entrada, $id_usuario);
    }

    //Traer el Id de ticket salida
    function getIDSalida($id_entrada){
        global $ticket;

        //Recuperar el id del ticket de salida
        $ticketSalida = $ticket->getTicketSalida_x_id($id_entrada);

        if(count($ticketSalida)>0){
            foreach($ticketSalida as $row){
                $id_ticket = $row['Id_ticket'];
            }
        }
        
        return $id_ticket;
    }

    function getDetallesPago($id_entrada, $id_estacionamiento){        
        //Traer el id y valor de la tarifa
        $detallesTarifa= getDetallesTarifa($id_estacionamiento);
        $id_tarifa = $detallesTarifa[0];
        $valor_tarifa = $detallesTarifa[1];

        //Traer el tiempo de servicio y el pago final
        $datos_pago = calcularDetallesPago($id_entrada, $valor_tarifa);
        $tiempo_servicio = $datos_pago[0];
        $pago_total = $datos_pago[1];


        return [$id_tarifa, $tiempo_servicio, $pago_total];
    }

    function calcularDetallesPago($id_entrada, $valor_tarifa){
        //Traer todos los detalles del tiempo [TiempoServicio, horas, minutos, segundos, cantidadDias]
        $detalles_tiempo = getTiempoServicio($id_entrada);
        $tiempo_servicio = $detalles_tiempo[0]; //Recuperar el tiempo de servicio en formato string

        //Calcular el pago final, retorna el valor a pagar.
        $pago_total = calcularPagoFinal($valor_tarifa, $detalles_tiempo[1], $detalles_tiempo[2], $detalles_tiempo[3], $detalles_tiempo[4]);

        
        return [$tiempo_servicio, $pago_total];
    }

    //Calcular el tiempo de servicio
    function getTiempoServicio($id_entrada){
        global $ticket;
        
        $datos = $ticket->getDiffTime($id_entrada);
        // var_dump($datos);

        if(is_array($datos) && count($datos)>0){

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
        }

        return [$tiempoTotal, $H, $i, $s, $cantidadDias];
    }

    //Traer el valor y id de la tarifa
    function getDetallesTarifa($id_estacionamiento){
        global $ticket, $tarifa, $vehiculo;

        //Recuperar el tipo de vehículo desde el estacionamiento
        $datos = $vehiculo->getTipoVehiculo_x_id($id_estacionamiento);

        if(is_array($datos) && count($datos)>0){

            foreach($datos as $row){
                $tipoVehiculo = $row['Tipo_vehiculo'];
            }
            
            //Recuperar el valor de la tarifa acorde al tipo de vehículo.
            $tarifa = $tarifa->getValorTarifa_x_tipo($tipoVehiculo);

            if(is_array($tarifa) && count($tarifa)>0){

                foreach($tarifa as $row){
                    $idTarifa = $row['id_tarifa'];
                    $valorTarifa = $row['Valor_tarifa'];
                }
            }
        }

        return [$idTarifa, $valorTarifa];
    }

    //Calcula el valor final a pagar
    function calcularPagoFinal($valorTarifa, $H, $i, $s, $cantidadDias){
        //Definir valores por segundo/minuto/hora/dia
        $valorSegundo = 0; $valorMinuto = 0; $valorHora = 0; $valorDias = 0;

        //Valor a pagar por segundos
        if($s > 0){
            //Se asigna el valor de segundos, que es equivalente al valor de la tarifa, la cual se basa en (Valor por minuto)
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

        return $pagoFinal;
    }

    
?>