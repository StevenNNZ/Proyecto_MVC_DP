<?php 
    class Ticket extends Conectar{
        public function getTicketEntrada(){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT * FROM ticket_entrada WHERE estado_entrada='Activo' ORDER BY Id_ticket_entrada DESC;";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function getTicketSalida(){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT Id_ticket, Hora_entrada, Fecha_entrada, Fecha_salida, Hora_salida, estado_salida, cajero FROM ticket_salida, ticket_entrada WHERE estado_entrada='Activo' and Detalles_entrada = Id_ticket_entrada";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }
    }
?>