<?php 
    class Reporte_venta extends Conectar{

        public function insertReporteVenta($id_pago){
            $conectar = parent::Conexion();

            $sql = "INSERT INTO reportes_ventas VALUES(NULL, ?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_pago);

            $sql->execute();

            return $resultado = $sql->fetchAll();
        }


        public function getReporte_venta($desde, $hasta){
            $conectar = parent::Conexion();
            
            $sql="SELECT id_reporte, Documento, Nombre, Apellido, Placa, 
                         CONCAT(Hora_entrada,'<br>',Fecha_entrada) AS entrada, 
                         CONCAT(Hora_salida, '<br>', Fecha_salida) AS salida, 
                         tiempo_servicio, Pago_total 
                  FROM   reportes_ventas, estacionamientos e, clientes, 
                         vehiculos, tickets_entrada te, tickets_salida ts, pagos  
                  WHERE  id_pago = Detalles_pago AND Detalles_salida=Id_ticket 
                  AND    Detalles_entrada = Id_ticket_entrada AND te.id_estacionamiento = e.id_estacionamiento 
                  AND    id_vehiculo = Placa AND id_cliente = Documento 
                  AND    te.Fecha_entrada AND ts.Fecha_salida 
                  BETWEEN '$desde' AND '$hasta';";
                  
            $sql=$conectar->prepare($sql);
            $sql->execute();
            
            return $resultado=$sql->fetchAll();
        }
    }
?>