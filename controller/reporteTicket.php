<?php 
    require_once("../config/conexion.php");
    require_once("../models/ReporteTicket.php");

    $reportesTicket = new ReporteTicket();

    switch($_GET["op"]){
        case "combo":
            $desde = $_GET['desde'];
            $desdeH = $_GET['desdeH'];
            $hasta = $_GET['hasta'];
            $hastaH = $_GET['hastaH'];
            $html="";
            // Método getReporte_venta --> recibe la fecha desde y la fecha hasta requeridos para la consulta sql.
            $datos = $reportesTicket->getReporteTicket($desde, $desdeH, $hasta, $hastaH);
            
            
            //Creación de la respuesta a la vista.
            if(is_array($datos) and count($datos)>0){
                $html.="
                <div class='alert alert_success alert_sm' id='contenedor-alerta-reportes_venta' style='animation-delay: .2s;margin:0 auto;margin-bottom:10px'>
                    <div class='alert--icon'>
                        <i class='fas fa-bell'></i>
                    </div>
                    <div class='alert--content'>
                        Mostrando registros desde <b>$desdeH $desde</b> hasta <b>$hastaH $hasta</b>
                    </div>
                </div>
                <div class='contenedor_resultado_consultas'>
                <div id='contenedor_tabla-general'>
                <div class='table-responsive'>
                <table class='contenedor-table__table'>
                    <thead class='contenedor-table__thead'>
                        <tr class='contenedor-table__tr--principal tabla_reporte-ventas'>
                            <th>ID</th>
                            <th>ENTRADA</th>
                            <th>SALIDA</th>
                            <th>CAJERO</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class='contenedor-table__tbody'>";
                
                foreach($datos as $row){
                    $html.="
                                    <tr>
                                        <td>$row[Id_ticket]</td>
                                        <td>$row[Hora_entrada]<br>$row[Fecha_entrada]</td>
                                        <td>$row[Hora_salida]<br>$row[Fecha_salida]</td>
                                        <td>$row[cajero]</td>
                                        <td>
                                            <a href='#' onclick='deleteTicket($row[Id_ticket])' id='$row[Id_ticket]'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar ticket'></i></a>
                                            <a href='../pdfRepTck/?id=$row[Id_ticket]' target='_blank' ><i id='btn-ticket' class='fas fa-eye icon_tabla' title='Visualizar ticket'></i></a>
                                            
                                        </td>
                                    </tr>";
                }
                
                $html.="
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

        case "deleteTicket": 
            $id = $_GET['id'];
            $user = $_GET['user_active'];
            $reportesTicket->deleteTicket($id, $user);
        break;
    }
?>