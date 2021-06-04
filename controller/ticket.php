<?php 
    require_once("../config/conexion.php");
    require_once("../models/Ticket.php");

    $ticket = new Ticket();

    switch($_GET["op"]){
        //Listar tickets de entrada
        case "listar_ticketE":
            $html="";
            $datos = $ticket->getTicketEntrada();
            
            if(is_array($datos) and count($datos)>0){
                $html.="
                <div class='alert alert_success alert_sm' id='contenedor-alerta-reportes_venta' style='animation-delay: .2s;margin:20px auto;'>
                    <div class='alert--icon'>
                        <i class='fas fa-bell'></i>
                    </div>
                    <div class='alert--content'>
                        Mostrando <b>tickets de entrada</b> activos.
                    </div>
                </div>";
                $html.="
                <div class='table-responsive'>
                <table class='contenedor-table__table'>
                    <thead class='contenedor-table__thead'>
                        <tr class='contenedor-table__tr--principal'>
                            <th>ID</th>
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
                                            <a target='_BLANK' href='../pdfTickEntrada?id=$row[Id_ticket_entrada]' onclick='terminarTicketEntrada($row[Id_ticket_entrada])'><i id='print' class='fas fa-print icon' title='Imprimir ticket ingreso'></i></a>
                                        </td>
                                    </tr>";
                }
                
                $html.="
                    </tbody>
                    </table>
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
                        ¡Oops! Al parecer aún no se ha registrado <b>Tickets de entrada</b>.
                    </div>
                </div>";
                echo $html;
            }
        break;

        //Listar tickets de salida
        case "listar_ticketS":
            $html="";
            $datos = $ticket->getTicketsalida();
            
            if(is_array($datos) and count($datos)>0){
                $html.="
                <div class='alert alert_success alert_sm' id='contenedor-alerta-reportes_venta' style='animation-delay: .2s;margin:20px auto;'>
                    <div class='alert--icon'>
                        <i class='fas fa-bell'></i>
                    </div>
                    <div class='alert--content'>
                        Mostrando <b>tickets de salida</b> activos.
                    </div>
                </div>";
                $html.="
                <div class='table-responsive'>
                <table class='contenedor-table__table'>
                    <thead class='contenedor-table__thead'>
                        <tr class='contenedor-table__tr--principal'>
                            <th>ID</th>
                            <th>ENTRADA</th>
                            <th>SALIDA</th>
                            <th>ESTADO</th>
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
                                        <td>$row[estado_salida]</td>
                                        <td>$row[cajero]</td>
                                        <td>
                                            <a href='#' onclick='getTicketSalida($row[Id_ticket])'><i id='print' class='fas fa-print icon' title='Imprimir ticket salida'></i></a>
                                        </td>
                                    </tr>";
                }
                
                $html.="
                    </tbody>
                    </table>
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
                        ¡Oops! Al parecer aún no se ha registrado <b>Tickets de salida</b>.
                    </div>
                </div>";
                echo $html;
            }
        break;

        //Desactivar tickets de entrada
        case "terminarTicketE":
            $id = $_GET['id'];
            $user_active = $_GET['user_active'];

            $ticket->terminarTicketE($id, $user_active);
        break;
        
        //Desactivar tickets de salida
        case "terminarTicketS":
            $id = $_GET['id'];
            $user_active = $_GET['user_active'];

            $ticket->terminarTicketS($id, $user_active);
        break;
    }
?>