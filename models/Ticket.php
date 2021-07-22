<?php 
    require_once ('Usuario.php');
    class Ticket extends Conectar{

        //Insertar ticket de entrada
        public function setTicketEntrada($id_usuario, $id_estacionamiento){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql = "INSERT INTO tickets_entrada (Id_ticket_entrada, id_estacionamiento, Hora_entrada, Fecha_entrada, estado_entrada, Fecha_creacion, cajero) VALUES (NULL, ?, curtime(), curdate(), 'Activo', curdate(), ?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_estacionamiento);
            $sql->bindValue(2, $id_usuario);
            $sql->execute();
        }

        //Insertar ticket de salida
        public function setTicketSalida($id_entrada, $id_usuario){
            $conectar = parent::Conexion();

            $sql="INSERT INTO tickets_salida VALUES (NULL, ?, CURDATE(), CURTIME(), 'Activo', ?, CURDATE(), 1)";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_entrada);
            $sql->bindValue(2, $id_usuario);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Traer tickets de entrada
        public function getTicketsEntrada(){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT * FROM tickets_entrada WHERE estado_entrada='Activo' ORDER BY Id_ticket_entrada DESC;";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Traer ticket de entrada por id
        public function getTicketEntrada_x_id($id){
            $conectar = parent::Conexion();
            
            $sql="SELECT e.Num_estacionamiento, e.id_vehiculo, e.id_cliente, te.Hora_entrada, te.Fecha_entrada, CONCAT(u.nombre, ' ', u.apellido) AS 'cajero', te.Fecha_creacion FROM tickets_entrada te, usuarios u, estacionamientos e WHERE cajero = documento AND te.id_estacionamiento = e.id_estacionamiento AND Id_ticket_entrada = ?";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Trer ticket por documento de cliente 
        public function getTicketEntradaByCliente($documento){
            $conectar = parent::Conexion();
            
            $sql="SELECT te.id_ticket_entrada, e.Num_estacionamiento, e.id_vehiculo, e.id_cliente, te.Hora_entrada, te.Fecha_entrada, CONCAT(u.nombre, ' ', u.apellido) AS 'cajero', te.Fecha_creacion FROM tickets_entrada te, usuarios u, estacionamientos e WHERE cajero = documento AND te.id_estacionamiento = e.id_estacionamiento AND id_cliente = ? ORDER BY Id_ticket_entrada DESC LIMIT 1;";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $documento);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Traer tickets de salida
        public function getTicketSalida(){
            $conectar = parent::Conexion();

            $sql="SELECT Id_ticket, CONCAT(Hora_entrada, ' ' ,Detalles_entrada) AS 'entrada', te.id_estacionamiento, Fecha_entrada, CONCAT(Fecha_salida, ' ' ,Hora_salida) AS 'salida', estado_salida, CONCAT(c.nombre, ' ', c.apellido) AS 'cajero' FROM tickets_salida ts, tickets_entrada te, usuarios c WHERE ts.est = 1 AND estado_salida='Activo' and Detalles_entrada = Id_ticket_entrada AND ts.cajero = c.documento;";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Traer tickets de salida con condición SQL (BETWEEN)
        public function getTicketSalidaBetween($desde, $desdeH, $hasta, $hastaH ){
            $conectar = parent::Conexion();

            $sql="SELECT Id_ticket, CONCAT(Fecha_salida, '<br>' ,Hora_salida) AS salida, CONCAT(Fecha_entrada, '<br>' ,Hora_entrada) AS entrada, estado_salida, ts.cajero FROM tickets_entrada te, tickets_salida ts WHERE est = 1 AND Detalles_entrada = Id_ticket_entrada AND te.Fecha_entrada AND ts.Fecha_salida BETWEEN '$desde' AND '$hasta' And te.Hora_entrada AND ts.Hora_salida BETWEEN '$desdeH' AND '$hastaH';";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Traer tickets de salida por id
        public function getTicketSalida_x_id($id){
            $conectar = parent::Conexion();

            $sql="SELECT Id_ticket, Fecha_salida, Hora_salida, CONCAT(nombre, ' ', apellido) AS 'nombreCajero', ts.fechaRegistro FROM tickets_salida ts, tickets_entrada te, usuarios WHERE Detalles_entrada = Id_ticket_entrada AND ts.cajero = documento AND Detalles_entrada = ? ORDER BY Id_ticket DESC LIMIT 1 ";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->execute();

            // var_dump($sql->errorInfo());
            return $resultado=$sql->fetchAll();
        }

        //Desactivar ticket de entrada
        public function terminarTicketE($id, $id_usuario){
            $usuario = new Usuario(); //Instancia clase usuario
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="UPDATE tickets_entrada SET estado_entrada = 'Terminado' WHERE Id_ticket_entrada = ?;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->execute();

            $mov = "Ha cerrado el <b>ticket de entrada</b> con id <b>$id</b>";
            $usuario->insertMovimiento($id_usuario, $mov);
            
            return $resultado=$sql->fetchAll();
        }

        //Desactivar ticket de salida
        public function terminarTicketSalida($id, $id_usuario){
            $usuario = new Usuario(); //Instancia clase usuario

            $conectar = parent::Conexion();
            parent::set_names();
            
            $sql="UPDATE tickets_salida SET estado_salida = 'Terminado' WHERE Id_ticket = ?;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->execute();

            //Registrar movimiento
            $mov = "Ha cerrado el <b>ticket de salida</b> con id <b>$id</b>";
            $usuario->insertMovimiento($id_usuario, $mov);

            return $resultado=$sql->fetchAll();
        }

        //Traer la diferencia de tiempo entre el ticket de entrada y de salida
        public function getDiffTime($id){
            $conectar = parent::Conexion();

            $sql="SELECT DATEDIFF(Fecha_salida, Fecha_entrada) AS 'Diferencia_fechas', IF(Hora_entrada > Hora_salida, TIMEDIFF(Hora_entrada, Hora_salida), TIMEDIFF(Hora_salida, Hora_entrada)) AS 'Diferencia_Horas' FROM tickets_entrada te, tickets_salida ts WHERE Detalles_entrada = ? AND Detalles_entrada = Id_ticket_entrada";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Obtener el ticket de salida completo desde la base de datos
        public function getCompleteExitTicket($id_ticket){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT ts.Id_ticket, e.Num_estacionamiento, e.id_vehiculo, 
                         v.Tipo_vehiculo, e.id_cliente, t.Valor_tarifa, te.Fecha_entrada, 
                         te.Hora_entrada, ts.Fecha_salida, ts.Hora_salida, p.tiempo_servicio, 
                         p.Pago_total, CONCAT(u.nombre,' ',u.apellido) AS 'Cajero', ts.fechaRegistro 
                    FROM tickets_salida ts, tickets_entrada te, usuarios u, estacionamientos e, vehiculos v, tarifas t, pagos p 
                    WHERE e.id_vehiculo = v.Placa AND te.id_estacionamiento = e.id_estacionamiento 
                    AND ts.cajero = u.documento AND te.Id_ticket_entrada = ts.Detalles_entrada 
                    AND ts.Id_ticket = p.Detalles_salida AND p.Id_tarifa = t.id_tarifa 
                    AND ts.Id_ticket = ?;";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_ticket);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }
       
        //Eliminar ticket de salida
        public function deleteTicketSalida($id, $id_usuario){
            $usuario = new Usuario(); //Instancia clase usuario

            $conectar = parent::Conexion();
            parent::set_names();

            $sql = 'UPDATE tickets_salida SET est = 0 WHERE Id_ticket = ?';
            $sql= $conectar->prepare($sql);

            $sql->bindValue(1, $id);

            $sql->execute();

            //Registrar movimiento
            $mov = "Ha eliminado el <b>ticket de salida</b> con id: <b>$id</b>";
            $usuario->insertMovimiento($id_usuario, $mov);

            return $resultado=$sql->fetchAll();
        }

        //Activar ticket de salida
        public function activarTicketSalida($id, $user){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql = "UPDATE tickets_salida SET estado_salida = 'Activo' WHERE Id_ticket = ?";
            $sql= $conectar->prepare($sql);

            $sql->bindValue(1, $id);

            $sql->execute();

            return $resultado=$sql->fetchAll();
        }
    }
?>