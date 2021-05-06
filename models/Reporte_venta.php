<?php 
    //Se crea la clase categoria que hereda de la clase Conectar
    class Reporte_venta extends Conectar{
        public function getReporte_venta($desde, $hasta){
            $conectar = parent::Conexion();
            parent::set_names();
            //Se declara la variable sql y se le asigna la consulta sql
            $sql="SELECT id_reporte, Documento, Nombre, Apellido, Placa, Hora_entrada, Fecha_entrada, Hora_salida, Fecha_salida, tiempo_servicio, Pago_total FROM reporte_venta, estacionamiento e, cliente, vehiculo, ticket_entrada te, ticket_salida ts, pago  WHERE id_pago = Detalles_pago AND Detalles_salida=Id_ticket AND Detalles_entrada = Id_ticket_entrada AND te.id_estacionamiento = e.id_estacionamiento AND id_vehiculo = Placa AND id_cliente = Documento And te.Fecha_entrada AND ts.Fecha_salida BETWEEN '$desde' AND '$hasta';";
            //Se asgina la variable $conectar y se llama el método prepare(), se le envia la consulta por medio de los parámetros
            $sql=$conectar->prepare($sql);
            //Se ejecuta la sentencia sql
            $sql->execute();
            //Se retorna la variable resultado, la cual se le asigna la variable sql, la cual llama el metodo fetchAll() Este método trae todo lo que la conexion sql ha podido recuperar. 
            return $resultado=$sql->fetchAll();
        }
    }
?>