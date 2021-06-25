<?php 
    require_once("../config/conexion.php");
    require_once("../models/Reporte_venta.php");
    require_once("../models/Interfaz.php");

    // Instancias
    $reportesVenta = new Reporte_venta();
    $interfaz = new Interfaz();

    //Validación variable superglobal
    switch($_GET["op"]){
        case "reporteVenta":
            getReporteVenta();
        break;
    }

    //Funciones
    function getReporteVenta(){
        //Variables globales
        global $reportesVenta;
        global $interfaz;

        //Elementos de la tabla
        $tableHead = ['id', 'documento', 'nombre', 'apellido', 'placa', 'entrada', 'salida', 'tiempo servicio', 'total pago'];
        $tableBody = [];
        $keysTable = ['id_reporte', 'Documento', 'Nombre', 'Apellido', 'Placa', 'entrada', 'salida', 'tiempo_servicio', 'Pago_total'];
        $tipo_tabla = ['reporte_venta', ''];
        //Varibales superglobales
        $desde = $_GET['desde'];
        $hasta = $_GET['hasta'];

        //Traer reportes modelo
        $datos = $reportesVenta->getReporte_venta($desde, $hasta);
            
        //Creación de la respuesta a la vista.
        if(is_array($datos) and count($datos)>0){
            //Traer alerta
            $html = $interfaz->getAlert("Mostrando registros desde <b>$desde</b> hasta <b>$hasta</b>", 'alert_success');

            //Iterar sobre los datos de reportesVenta
            foreach($datos as $row){
                array_push($tableBody, $row); //Llenar el cuerpo de la tabla.
            }

            //Crear el botón de imprimir
            $btnPrint = "<a id='icon_print-reporteVenta' target='_blank' href='../viewPDF/pdfRepVta/?desde=$desde&hasta=$hasta' ><i class='fas fa-print'></i></a> ";

            //Crear la tabla
            $html.= $interfaz->createTable($tableHead, $tableBody, $keysTable, $tipo_tabla, $btnPrint);
            
            //Retornar la respuesta
            echo $html;
        }else{
            //Crear alerta
            $html = $interfaz->getAlert('No hemos encontrado ningún registro. Asegúrese de haber introducido la <b>fecha</b> correcta.', 'alert_danger');

            echo $html;
        }
    }

    function insertReporteVenta($id_pago){
        global $reportesVenta;

        $reportesVenta->insertReporteVenta($id_pago);
    }
?>