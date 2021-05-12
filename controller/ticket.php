<?php 
    require_once("../config/conexion.php");
    require_once("../models/Ticket.php");

    $ticket = new Ticket();

    switch($_GET["op"]){
        case "listar_ticket":
            $html="";
            $datos = $ticket->getTicket();
            
            if(is_array($datos) and count($datos)>0){
                $html.="
                <table class='contenedor-table__table'>
                    <thead class='contenedor-table__thead'>
                        <tr class='contenedor-table__tr--principal'>
                            <th>TICKET ID</th>
                            <th>ID ESTACIONAMIENTO</th>
                            <th>HORA ENTRADA</th>
                            <th>FECHA ENTRADA</th>
                            <th>ESTADO</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class='contenedor-table__tbody'>";
                foreach($datos as $row){
                    $html.="
                                    <tr>
                                        <td>$row[Id_ticket_entrada]</td>
                                        <td>$row[id_estacionamiento]</td>
                                        <td>$row[Hora_entrada]</td>
                                        <td>$row[Fecha_entrada]</td>
                                        <td>$row[estado_entrada]</td>
                                        <td>
                                            <a target='_BLANK' href='#'><i id='print' class='fas fa-print icon' title='Imprimir ticket ingreso'></i></a>
                                        </td>
                                    </tr>";
                }
                
                $html.="
                    </tbody>
                    </table>";
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