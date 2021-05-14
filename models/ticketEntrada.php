<?php 
    class Prueba extends Conectar{
        public function insertTicket(){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT MAX(id_estacionamiento) FROM estacionamiento";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            $validacion_esta=$sql->fetchAll();
            foreach ($validacion_esta as $row){
                $vali_esta = $row["id_estacionamiento"]; //Recuperar el atributo requerido.
                $vali_esta++;
                break;
            }
            $sql = "INSERT INTO ticket_entrada (Id_ticket_entrada, id_estacionamiento, Hora_entrada, Fecha_entrada, estado_entrada) VALUES (NULL, ?, curtime(), curdate(), 'Activo')";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $vali_esta);
            $sql->execute();
        }
    }

?>