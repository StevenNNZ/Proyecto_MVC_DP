<?php 
    require_once ('Usuario.php');
    class Tarifa extends Conectar{

        //Registrar tarifa
        public function insert_tarifa($tipo, $valor){
            //Llamado al método conexión a base de datos.
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="INSERT INTO tarifas (id_tarifa, Tipo_vehiculo, Valor_tarifa, est) VALUES (NULL,?,?, 1);";

            //Asignación de parámetros para sentencia SQL
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tipo);
            $sql->bindValue(2, $valor);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Traer tarifas
        public function getTarifas($limit=0){
            $conectar = parent::Conexion();

            if($limit>0){
                $sql="SELECT id_tarifa, Tipo_vehiculo, CONCAT('$', Valor_tarifa) AS Valor_tarifa FROM tarifas WHERE est = 1 LIMIT $limit;";
            }else{
                $sql="SELECT id_tarifa, Tipo_vehiculo, CONCAT('$', Valor_tarifa) AS Valor_tarifa FROM tarifas WHERE est = 1;";
            }
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Traer tarifa por id
        public function getTarifa_x_id($id){
            $conectar = parent::Conexion();

            $sql="SELECT * FROM tarifas WHERE id_tarifa = ?;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Traer tarifa por campo/letra similar ó igual
        public function getTarifaLike($search){
            $conectar = parent::Conexion();

            $sql="SELECT * FROM tarifas WHERE est = 1 AND (id_tarifa LIKE '%$search%' OR Tipo_vehiculo LIKE '%$search%' OR Valor_tarifa LIKE '%$search%')";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Eliminar tarifa por id
        public function deleteTarifa($id, $id_usuario){
            $usuario = new Usuario();
            $conectar = parent::Conexion();

            $sql="UPDATE tarifas SET est = '0' WHERE tarifas.id_tarifa = ?;";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->execute();

            //Registrar movimiento
            $mov = "Ha eliminado la <b>Tarifa</b> con id: <b>$id</b>";
            $usuario->insertMovimiento($id_usuario, $mov);

            return $resultado=$sql->fetchAll();
        }

        //Actualizar tarifa por id
        public function updateTarifa($id, $tipoVehiculo, $valorTarifa, $id_usuario){
            $usuario = new Usuario();
            $conectar = parent::Conexion();
            parent::set_names();

            $sql = 'UPDATE tarifas SET Tipo_vehiculo = ?, Valor_tarifa = ? WHERE id_tarifa = ?;';
            $sql = $conectar->prepare($sql);

            $sql->bindValue(1, $tipoVehiculo);
            $sql->bindValue(2, $valorTarifa);
            $sql->bindValue(3, $id);

            $sql->execute();

            //Registrar movimiento
            $mov = "Ha actualizado los datos de la <b>tarifa</b> con ID <b>$id</b>";
            $usuario->insertMovimiento($id_usuario, $mov);

            return $resultado = $sql->fetchAll();
        }

        //Traer arifa por id
        public function getValorTarifa_x_tipo($tipo){
            $conectar = parent::Conexion();

            $sql = "SELECT id_tarifa, Valor_tarifa FROM tarifas WHERE Tipo_vehiculo = ? LIMIT 1;";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tipo);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }
    }
?>