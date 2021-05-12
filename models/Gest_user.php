<?php 
    class Gest_user extends Conectar{
        public function getUser($search){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT * FROM usuarios WHERE documento LIKE '%$search%' OR nombre LIKE '%$search%' OR apellido LIKE '%$search%' OR Cargo LIKE '%$search%' OR estado_usuario LIKE '%$search%';";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }
    }
?>