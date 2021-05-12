<?php 
    class Tarifa extends Conectar{

        public function insert_tarifa($tipo, $valor){
            //Llamado al método conexión a base de datos.
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="INSERT INTO tarifa (id_tarifa, Tipo_vehiculo, Valor_tarifa) VALUES (NULL,?,?);";

            //Asignación de parámetros para sentencia SQL
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tipo);
            $sql->bindValue(2, $valor);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }
    }
?>