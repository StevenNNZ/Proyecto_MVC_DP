<?php 

    class Pago extends Conectar{
        public function insertPago($id_salida, $tiempo, $id_tarifa, $pago) {
            $conectar = parent::Conexion();
            parent::set_names();

            $sql = "INSERT INTO pagos VALUES (NULL,?,?,?,?)";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_salida);
            $sql->bindValue(2, $tiempo);
            $sql->bindValue(3, $id_tarifa);
            $sql->bindValue(4, $pago);

            $sql->execute();

            // print_r($sql->errorInfo());

            return $resultado = $sql->fetchAll();
        }

        public function getPago($id_salida){
            $conectar = parent::Conexion();

            $sql = "SELECT id_pago FROM pagos WHERE Detalles_salida = ?";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_salida);
            $sql->execute();

            return $resultado = $sql->fetchAll();
        }
    }


?>