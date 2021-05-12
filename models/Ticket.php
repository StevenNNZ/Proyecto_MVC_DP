<?php 
    class Ticket extends Conectar{
        public function getTicket(){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT Id_ticket_entrada, id_estacionamiento,Hora_entrada,Fecha_entrada,estado_entrada FROM ticket_entrada WHERE estado_entrada='Activo';";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }
    }
?>