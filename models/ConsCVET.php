<?php 
    class ConsCVET extends Conectar{
        public function getCliente(){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT * FROM cliente LIMIT 10;";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function getClienteLike($search){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT * FROM cliente WHERE Documento LIKE '%$search%' OR Nombre LIKE '%$search%' OR Apellido LIKE '%$search%'";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function getVehiculo(){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT * FROM vehiculo LIMIT 10;";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function getVehiculoLike($search){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT * FROM vehiculo WHERE Placa LIKE '%$search%' OR Modelo_vehiculo LIKE '%$search%' OR Tamano_vehiculo LIKE '%$search%' OR Tipo_vehiculo LIKE '%$search%'";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function getEstacionamiento(){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT Num_estacionamiento, id_vehiculo, id_cliente, Nombre, Apellido, Estado_estacionamiento, esta_descripcion, fecha_creacion FROM estacionamiento, vehiculo, cliente WHERE id_vehiculo = Placa AND id_cliente = Documento LIMIT 10;";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function getEstacionamientoLike($desde, $hasta){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT Num_estacionamiento, id_vehiculo, id_cliente, Nombre, Apellido, Estado_estacionamiento, esta_descripcion, fecha_creacion FROM estacionamiento, vehiculo, cliente WHERE id_vehiculo = Placa AND id_cliente = Documento AND fecha_creacion BETWEEN '$desde' AND '$hasta';";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function getTarifa(){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT * FROM tarifa LIMIT 10;";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function getTarifaLike($search){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT * FROM tarifa WHERE id_tarifa LIKE '%$search%' OR Tipo_vehiculo LIKE '%$search%'";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

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