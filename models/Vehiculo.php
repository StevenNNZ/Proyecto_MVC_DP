<?php
    require_once 'Usuario.php';
    class Vehiculo extends Conectar{
        
         //Validar vehículos registrados
         public function validateVehiculo($placa){
            $conectar = parent::Conexion();
            //Consulta vehículo existente
            $sql="SELECT Placa FROM vehiculos WHERE Placa =?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $placa);
            $sql->execute();
            return $validacion_vehiculo=$sql->fetchAll();
        }

        //Insertar vehículos
        public function insertVehiculo($placa, $color_vehiculo, $modelo_vehiculo, $tamano_vehiculo, $tipo_vehiculo, $id_usuario){
            $usuario = new Usuario(); //Instancia clase usuario
            $conectar = parent::Conexion();

            $sql= "INSERT INTO vehiculos (Placa, Color_vehiculo, Modelo_vehiculo, Tamano_vehiculo, Tipo_vehiculo, est) VALUES (?, ?, ?, ?, ?, 1);";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $placa);
            $sql->bindValue(2, $color_vehiculo);
            $sql->bindValue(3, $modelo_vehiculo);
            $sql->bindValue(4, $tamano_vehiculo);
            $sql->bindValue(5, $tipo_vehiculo);
            
            $sql->execute();

            //Registrar movimiento
            $mov = "Ha agregado un nuevo <b>vehículo</b> con placa: <b>$placa</b>";
            $usuario->insertMovimiento($id_usuario, $mov);


            return $resultado=$sql->fetchAll();
        }

        /* Traer vehículos */
        public function getVehiculos($limit = false){
            $conectar = parent::Conexion();

            if($limit){
                $sql="SELECT * FROM vehiculos WHERE est = 1  LIMIT $limit;";
            }else{
                $sql="SELECT * FROM vehiculos WHERE est = 1;";
            }

            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        /* Traer vehículo por id */
        public function getVehiculo_x_id($documento){
            $conectar = parent::Conexion();

            $sql="SELECT * FROM vehiculos WHERE Placa = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $documento);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Traer vehículo por letra digitada
        public function getVehiculoLike($search){
            $conectar = parent::Conexion();

            $sql="SELECT * FROM vehiculos WHERE est = 1 AND (Placa LIKE '%$search%' OR Modelo_vehiculo LIKE '%$search%' OR Tamano_vehiculo LIKE '%$search%' OR Tipo_vehiculo LIKE '%$search%' OR Color_vehiculo LIKE '%$search%')";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Eliminar vehículo por id
        public function deleteVehiculo($placa, $id_usuario){
            $usuario = new Usuario(); //Instancia clase usuario
            $conectar = parent::Conexion();

            $sql="UPDATE vehiculos SET est = '0' WHERE vehiculos.Placa = ?;";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $placa);
            $sql->execute();

            $mov = "Ha eliminado el <b>vehículo</b> con placa: <b>$placa</b>";
            $usuario->insertMovimiento($id_usuario, $mov);

            return $resultado=$sql->fetchAll();
        }

        //Actualizar vehículo por id
        public function updateVehiculo($id, $placa, $color, $modelo, $size, $type, $id_usuario){
            $usuario = new Usuario();
            $conectar = parent::Conexion();
            parent::set_names();

            $sql = 'UPDATE vehiculos SET Placa = ?, Color_vehiculo = ?, Modelo_Vehiculo = ?, Tamano_vehiculo = ?, Tipo_vehiculo = ? WHERE Placa = ?;';
            $sql = $conectar->prepare($sql);

            $sql->bindValue(1, $placa);
            $sql->bindValue(2, $color);
            $sql->bindValue(3, $modelo);
            $sql->bindValue(4, $size);
            $sql->bindValue(5, $type);
            $sql->bindValue(6, $id);

            $sql->execute();

            $mov = "Ha actualizado los datos del <b>vehículo</b> con Placa <b>$placa</b>";
            $usuario->insertMovimiento($id_usuario, $mov);

            return $resultado = $sql->fetchAll();
        }

        //Traer tipo de vehiculo por id
        public function getTipoVehiculo_x_id($id){
            $conectar = parent::Conexion();

            $sql = "SELECT Tipo_vehiculo FROM estacionamientos e, vehiculos v WHERE id_estacionamiento = ? AND id_vehiculo = Placa;";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }
    }
?>