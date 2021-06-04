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

        public function getTicketEntrada_x_id($id){
            $conectar = parent::Conexion();
            parent::set_names();
            
            $sql="SELECT te.Id_ticket_entrada, e.Num_estacionamiento, e.id_vehiculo, e.id_cliente, te.Hora_entrada, te.Fecha_entrada, u.nombre, u.apellido, te.Fecha_creacion FROM ticket_entrada te, usuarios u, estacionamiento e WHERE cajero = documento AND te.id_estacionamiento = e.id_estacionamiento AND Id_ticket_entrada = ?";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function getTicketSalida(){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT Id_ticket, Hora_entrada, Detalles_entrada, te.id_estacionamiento, Fecha_entrada, Fecha_salida, Hora_salida, estado_salida, ts.cajero FROM ticket_salida ts, ticket_entrada te WHERE est = 1 AND estado_salida='Activo' and Detalles_entrada = Id_ticket_entrada";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function getTicketSalida_x_id($id){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT Id_ticket, Fecha_salida, Hora_salida, CONCAT(nombre, ' ', apellido) AS 'nombreCajero', ts.fechaRegistro FROM ticket_salida ts, ticket_entrada te, usuarios WHERE Detalles_entrada = Id_ticket_entrada AND ts.cajero = documento AND Detalles_entrada = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Desactivar ticket de entrada
        public function terminarTicketE($id, $user){
            $conectar = parent::Conexion();
            parent::set_names();
            $descrip = "Ha cerrado el <b>ticket de entrada</b> con id <b>$id</b>";
            $sql="UPDATE ticket_entrada SET estado_entrada = 'Terminado' WHERE Id_ticket_entrada = ?;
                INSERT INTO user_movimiento VALUES(NULL, ?, ?, now())";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->bindValue(2, $user);
            $sql->bindValue(3, $descrip);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Desactivar ticket de salida
        public function terminarTicketS($id, $user){
            $conectar = parent::Conexion();
            parent::set_names();
            $descrip = "Ha cerrado el <b>ticket de salida</b> con id <b>$id</b>";
            $sql="UPDATE ticket_salida SET estado_salida = 'Terminado' WHERE Id_ticket = ?;
                INSERT INTO user_movimiento VALUES(NULL, ?, ?, now())";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->bindValue(2, $user);
            $sql->bindValue(3, $descrip);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function calcularTiempo($id){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT DATEDIFF(Fecha_salida, Fecha_entrada) AS 'Diferencia_fechas', IF(Hora_entrada > Hora_salida, TIMEDIFF(Hora_entrada, Hora_salida), TIMEDIFF(Hora_salida, Hora_entrada)) AS 'Diferencia_Horas' FROM ticket_entrada te, ticket_salida ts WHERE Detalles_entrada = ? AND Detalles_entrada = Id_ticket_entrada";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function getTipoVehiculo_x_id($id){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql = "SELECT Tipo_vehiculo FROM estacionamiento e, vehiculo v WHERE id_estacionamiento = ? AND id_vehiculo = Placa;";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function getValorTarifa_x_tipo($tipo){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql = "SELECT id_tarifa, Valor_tarifa FROM tarifa WHERE Tipo_vehiculo = ? LIMIT 1;";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tipo);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function registrarPago($id_ticket, $tiempoTotal, $idTarifa, $pagoFinal){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="INSERT INTO pagos VALUES (NULL, ?, ?, ?, ?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_ticket);
            $sql->bindValue(2, $tiempoTotal);
            $sql->bindValue(3, $idTarifa);
            $sql->bindValue(4, $pagoFinal);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Obtener el ticket de salida completo desde la base de datos
        public function getCompleteExitTicket($id_ticket){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT ts.Id_ticket, e.Num_estacionamiento, e.id_vehiculo, v.Tipo_vehiculo, e.id_cliente, t.Valor_tarifa, te.Fecha_entrada, te.Hora_entrada, ts.Fecha_salida, ts.Hora_salida, p.tiempo_servicio, p.Pago_total, CONCAT(u.nombre,' ',u.apellido) AS 'Cajero', ts.fechaRegistro FROM ticket_salida ts, ticket_entrada te, usuarios u, estacionamiento e, vehiculo v, tarifa t, pagos p WHERE e.id_vehiculo = v.Placa AND te.id_estacionamiento = e.id_estacionamiento AND te.cajero = u.documento AND te.Id_ticket_entrada = ts.Detalles_entrada AND ts.Id_ticket = p.Detalles_salida AND p.Id_tarifa = t.id_tarifa AND ts.Id_ticket = ?;";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_ticket);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function getPagos_x_idSalida($id_salida){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT id_pago FROM pagos WHERE Detalles_salida = ?";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_salida);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function createReporteVenta($id_pago){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="INSERT INTO reporte_venta VALUES(NULL, ?)";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_pago);
            $sql->execute();
        }
    }
?>