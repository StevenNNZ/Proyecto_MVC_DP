<?php 
    class ReporteTicket extends Conectar{

        public function getReporteTicket($desde, $desdeH, $hasta, $hastaH ){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT Id_ticket, Fecha_salida, Hora_salida, Fecha_entrada, Hora_entrada, estado_salida, cajero FROM ticket_entrada te, ticket_salida ts WHERE Detalles_entrada = Id_ticket_entrada AND te.Fecha_entrada AND ts.Fecha_salida BETWEEN '$desde' AND '$hasta' And te.Hora_entrada AND ts.Hora_salida BETWEEN '$desdeH' AND '$hastaH';";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }
    }
?>