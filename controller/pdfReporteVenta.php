<?php 
    require_once("../../config/conexion.php");
    require_once("../../models/Reporte_venta.php");
    function getReporte($desde, $hasta){
        $reportesVenta = new Reporte_venta();
        /* $desde = $_GET['desde'];
            $hasta = $_GET['hasta']; */
            $html="";
            // Método getReporte_venta --> recibe la fecha desde y la fecha hasta requeridos para la consulta sql.
            $datos = $reportesVenta->getReporte_venta($desde, $hasta);
            
            
            //Creación de la respuesta a la vista.
            if(is_array($datos) and count($datos)>0){
                $totalPagos=0;
                $html.="
                <div class='contenedor_resultado_consultas' style='text-align:right'>
                <div id='contenedor_tabla-general'>
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
                    $totalPagos+=$row['Pago_total'];
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
                            <td class='total_pagos' colspan='7'>Totales consulta</td>
                            <td class='sumatoria_total_pagos' colspan='2'>$".number_format($totalPagos)."</td>
                        </tr>
                    </tbody>
                    </table>
                    </div>";
                //Finalmente se escribe o retorna lo que hemos almacenado en la variable $html
                return $html;
            }
    }
?>