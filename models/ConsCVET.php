<?php 
    class ConsCVET extends Conectar{

        /* CONSULTAS CLIENTE */
        public function getCliente(){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT * FROM cliente WHERE est = 1 LIMIT 10;";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function getCliente_x_id($documento){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT * FROM cliente WHERE documento = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $documento);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function getClienteLike($search){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT * FROM cliente WHERE est = 1 AND Documento LIKE '%$search%' OR Nombre LIKE '%$search%' OR Apellido LIKE '%$search%'";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function deleteCliente($documento, $id_usuario){
            $conectar = parent::Conexion();
            parent::set_names();
            $descrip = "Ha eliminado el <b>cliente</b> con documento: <b>$documento</b>";

            $sql="UPDATE cliente SET est = '0' WHERE cliente.Documento = ?;
            INSERT INTO user_movimiento (mov_id, mov_user, mov_descrip, mov_fecha) VALUES(NULL, ?, ?, now());";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $documento);
            $sql->bindValue(2, $id_usuario);
            $sql->bindValue(3, $descrip);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function updateCliente($id, $documento, $nombre, $apellido, $telefono, $user){
            $conectar = parent::Conexion();
            parent::set_names();

            $descrip = "Ha actualizado los datos del <b>cliente</b> con documento <b>$documento</b>";
            $sql = 'UPDATE cliente SET Documento = ?, Nombre = ?, Apellido = ?, Telefono = ? WHERE Documento = ?;
                    INSERT INTO user_movimiento(mov_id, mov_user, mov_descrip, mov_fecha) VALUES(NULL, ?, ?, now());';
            $sql = $conectar->prepare($sql);

            $sql->bindValue(1, $documento);
            $sql->bindValue(2, $nombre);
            $sql->bindValue(3, $apellido);
            $sql->bindValue(4, $telefono);
            $sql->bindValue(5, $id);
            $sql->bindValue(6, $user);
            $sql->bindValue(7, $descrip);

            $sql->execute();

            return $resultado = $sql->fetchAll();
        }

        /* CONSULTAS VEHÍCULOS */
        public function getVehiculo(){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT * FROM vehiculo WHERE est = 1  LIMIT 10;";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function getVehiculo_x_id($documento){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT * FROM vehiculo WHERE Placa = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $documento);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function getVehiculoLike($search){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT * FROM vehiculo WHERE est = 1 AND Placa LIKE '%$search%' OR Modelo_vehiculo LIKE '%$search%' OR Tamano_vehiculo LIKE '%$search%' OR Tipo_vehiculo LIKE '%$search%'";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function deleteVehiculo($placa, $id_usuario){
            $conectar = parent::Conexion();
            parent::set_names();
            $descrip = "Ha eliminado el <b>vehículo</b> con placa: <b>$placa</b>";

            $sql="UPDATE vehiculo SET est = '0' WHERE vehiculo.Placa = ?;
            INSERT INTO user_movimiento (mov_id, mov_user, mov_descrip, mov_fecha) VALUES(NULL, ?, ?, now());";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $placa);
            $sql->bindValue(2, $id_usuario);
            $sql->bindValue(3, $descrip);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function updateVehiculo($id, $placa, $color, $modelo, $size, $type, $user){
            $conectar = parent::Conexion();
            parent::set_names();

            $descrip = "Ha actualizado los datos del <b>vehículo</b> con Placa <b>$placa</b>";
            $sql = 'UPDATE vehiculo SET Placa = ?, Color_vehiculo = ?, Modelo_Vehiculo = ?, Tamano_vehiculo = ?, Tipo_vehiculo = ? WHERE Placa = ?;
                    INSERT INTO user_movimiento(mov_id, mov_user, mov_descrip, mov_fecha) VALUES(NULL, ?, ?, now());';
            $sql = $conectar->prepare($sql);

            $sql->bindValue(1, $placa);
            $sql->bindValue(2, $color);
            $sql->bindValue(3, $modelo);
            $sql->bindValue(4, $size);
            $sql->bindValue(5, $type);
            $sql->bindValue(6, $id);
            $sql->bindValue(7, $user);
            $sql->bindValue(8, $descrip);

            $sql->execute();

            return $resultado = $sql->fetchAll();
        }

        /* CONSULTAS ESTACIONAMIENTO */
        public function getEstacionamiento(){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT id_estacionamiento, Num_estacionamiento, id_vehiculo, id_cliente, Nombre, Apellido, Estado_estacionamiento, esta_descripcion, fecha_creacion FROM estacionamiento e, vehiculo, cliente WHERE id_vehiculo = Placa AND id_cliente = Documento AND e.est = 1 LIMIT 10;";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function getEstacionamiento_x_id($id){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT * FROM estacionamiento WHERE id_estacionamiento = ?;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function getEstacionamientoLike($desde, $hasta){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT id_estacionamiento, Num_estacionamiento, id_vehiculo, id_cliente, Nombre, Apellido, Estado_estacionamiento, esta_descripcion, fecha_creacion FROM estacionamiento e, vehiculo, cliente WHERE e.est = 1 AND id_vehiculo = Placa AND id_cliente = Documento AND fecha_creacion BETWEEN '$desde' AND '$hasta';";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function deleteEstacionamiento($id, $id_usuario){
            $conectar = parent::Conexion();
            parent::set_names();
            $descrip = "Ha eliminado el <b>estacionamiento</b> con id: <b>$id</b>";

            $sql="UPDATE estacionamiento SET est = '0' WHERE estacionamiento.id_estacionamiento = ?;
            INSERT INTO user_movimiento (mov_id, mov_user, mov_descrip, mov_fecha) VALUES(NULL, ?, ?, now());";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->bindValue(2, $id_usuario);
            $sql->bindValue(3, $descrip);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function updateEstacionamiento($id, $numEsta, $placa, $cliente, $estadoEsta, $descripEsta, $user){
            $conectar = parent::Conexion();
            parent::set_names();

            $descrip = "Ha actualizado los datos del <b>estaconamiento</b> con ID <b>$id</b>";
            $sql = 'UPDATE estacionamiento SET Num_estacionamiento = ?, id_vehiculo = ?, id_cliente = ?, Estado_estacionamiento = ?, esta_descripcion = ? WHERE id_estacionamiento = ?;
                    INSERT INTO user_movimiento(mov_id, mov_user, mov_descrip, mov_fecha) VALUES(NULL, ?, ?, now());';
            $sql = $conectar->prepare($sql);

            $sql->bindValue(1, $numEsta);
            $sql->bindValue(2, $placa);
            $sql->bindValue(3, $cliente);
            $sql->bindValue(4, $estadoEsta);
            $sql->bindValue(5, $descripEsta);
            $sql->bindValue(6, $id);
            $sql->bindValue(7, $user);
            $sql->bindValue(8, $descrip);

            $sql->execute();

            return $resultado = $sql->fetchAll();
        }

        /* CONSULTA CLIENTES SIN LÍMITE */
        public function getClienteWhitoutLimit(){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT Documento FROM cliente WHERE est = 1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        /* CONSULTA VEHÍCULOS SIN LÍMITE */
        public function getVehiculoWhitoutLimit(){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT Placa FROM vehiculo WHERE est = 1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }   


        /* CONSULTAS TARIFA */
        public function getTarifa(){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT * FROM tarifa WHERE est = 1 LIMIT 10;";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function getTarifa_x_id($id){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT * FROM tarifa WHERE id_tarifa = ?;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function getTarifaLike($search){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT * FROM tarifa WHERE est = 1 AND id_tarifa LIKE '%$search%' OR Tipo_vehiculo LIKE '%$search%'";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function deleteTarifa($id, $id_usuario){
            $conectar = parent::Conexion();
            parent::set_names();
            $descrip = "Ha eliminado la <b>Tarifa</b> con id: <b>$id</b>";

            $sql="UPDATE Tarifa SET est = '0' WHERE tarifa.id_tarifa = ?;
            INSERT INTO user_movimiento (mov_id, mov_user, mov_descrip, mov_fecha) VALUES(NULL, ?, ?, now());";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->bindValue(2, $id_usuario);
            $sql->bindValue(3, $descrip);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function updateTarifa($id, $tipoVehiculo, $valorTarifa, $user){
            $conectar = parent::Conexion();
            parent::set_names();

            $descrip = "Ha actualizado los datos de la <b>tarifa</b> con ID <b>$id</b>";
            $sql = 'UPDATE tarifa SET Tipo_vehiculo = ?, Valor_tarifa = ? WHERE id_tarifa = ?;
                    INSERT INTO user_movimiento(mov_id, mov_user, mov_descrip, mov_fecha) VALUES(NULL, ?, ?, now());';
            $sql = $conectar->prepare($sql);

            $sql->bindValue(1, $tipoVehiculo);
            $sql->bindValue(2, $valorTarifa);
            $sql->bindValue(3, $id);
            $sql->bindValue(4, $user);
            $sql->bindValue(5, $descrip);

            $sql->execute();

            return $resultado = $sql->fetchAll();
        }

        /* CONSULTAS BAHÍA */
        public function getBahiaActiva(){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT id_estacionamiento, Num_estacionamiento, id_vehiculo, id_cliente, Estado_estacionamiento, esta_descripcion, hora_creacion  FROM estacionamiento WHERE Estado_estacionamiento = 'Activo';";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }
        
    }
?>