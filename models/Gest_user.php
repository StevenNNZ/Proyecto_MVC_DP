<?php 
    class Gest_user extends Conectar{
        public function getUser($search){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT * FROM usuarios WHERE est=1 AND (documento LIKE '%$search%' OR nombre LIKE '%$search%' OR apellido LIKE '%$search%' OR Cargo LIKE '%$search%' OR estado_usuario LIKE '%$search%');";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function deleteUser($documento){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="UPDATE usuarios SET est = '0' WHERE usuarios.documento = ?";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $documento);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function getUser_x_id($documento){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT * FROM usuarios WHERE documento = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $documento);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }
    }
?>