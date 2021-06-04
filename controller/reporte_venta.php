<?php 
    require_once("../config/conexion.php");
    require_once("../models/Reporte_venta.php");

    // Instancia clase Reporte_venta
    $reportesVenta = new Reporte_venta();

    switch($_GET["op"]){
        case "combo":
            $desde = $_GET['desde'];
            $hasta = $_GET['hasta'];
            $html="";
            $datos = $reportesVenta->getReporte_venta($desde, $hasta);
            
            
            //Creación de la respuesta a la vista.
            if(is_array($datos) and count($datos)>0){
                $totalPagos = 0;
                floatval($totalPagos);
                $html.="
                <div class='alert alert_success alert_sm' id='contenedor-alerta-reportes_venta' style='animation-delay: .2s;margin:0 auto;margin-bottom:10px'>
                    <div class='alert--icon'>
                        <i class='fas fa-bell'></i>
                    </div>
                    <div class='alert--content'>
                        Mostrando registros desde <b>$desde</b> hasta <b>$hasta</b>
                    </div>
                </div>
                <div class='contenedor_resultado_consultas' style='text-align:right'>
                <a id='icon_print-reporteVenta' target='_blank' href='../pdfRepVta/?desde=$desde&hasta=$hasta' ><i class='fas fa-print'></i></a>
                <div id='contenedor_tabla-general'>
                <div class='table-responsive'>
                <table class='contenedor-table__table'>
                    <thead class='contenedor-table__thead'>
                        <tr class='contenedor-table__tr--principal tabla_reporte-ventas'>
                            <th>ID</th>
                            <th>DOCUMENTO</th>
                            <th>NOMBRE</th>
                            <th>APELLIDO</th>
                            <th>PLACA</th>
                            <th>ENTRADA</th>
                            <th>SALIDA</th>
                            <th>TIEMPO SERVICIO</th>
                            <th>TOTAL PAGO</th>
                        </tr>
                    </thead>
                    <tbody class='contenedor-table__tbody'>";
                
                foreach($datos as $row){
                    $totalPagos+=floatval($row['Pago_total']);
                    // $tipo = number_format($row['Pago_total']);
                    $html.="
                                    <tr>
                                        <td>$row[id_reporte]</td>
                                        <td>$row[Documento]</td>
                                        <td>$row[Nombre]</td>
                                        <td>$row[Apellido]</td>
                                        <td>$row[Placa]</td>
                                        <td>$row[Fecha_entrada]<br>$row[Hora_entrada]</td>
                                        <td>$row[Fecha_salida]<br>$row[Hora_salida]</td>
                                        <td>$row[tiempo_servicio]</td>
                                        <td>$".number_format($row['Pago_total'])."</td>
                                    </tr>";
                }
                
                $html.="
                        <tr>
                            <td class='total_pagos' colspan='8'>Totales consulta</td>
                            <td class='sumatoria_total_pagos'>$".number_format($totalPagos)."</td>
                        </tr>
                    </tbody>
                    </table>
                    </div>
                    </div>";
                //Finalmente se escribe o retorna lo que hemos almacenado en la variable $html
                echo $html;
            }else{
                $html.="
                <div class='alert alert_danger alert_sm' id='contenedor-alerta-reportes_venta' style='animation-delay: .2s;margin:0 auto;'>
                    <div class='alert--icon'>
                        <i class='fas fa-bell'></i>
                    </div>
                    <div class='alert--content'>
                        No hemos encontrado ningún registro. Asegúrese de haber introducido la <b>fecha</b> correcta.
                    </div>
                </div>";
                echo $html;
            }
        break;
    }
?>