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

        public function deleteUser($documento, $id_usuario){
            $conectar = parent::Conexion();
            parent::set_names();
            $descrip = "Ha eliminado el <b>usuario</b> con documento: <b>$documento</b>";

            $sql="UPDATE usuarios SET est = '0' WHERE usuarios.documento = ?;
            INSERT INTO user_movimiento (mov_id, mov_user, mov_descrip, mov_fecha) VALUES(NULL, ?, ?, now());";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $documento);
            $sql->bindValue(2, $id_usuario);
            $sql->bindValue(3, $descrip);
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

        public function activarUser($documento, $id_user){
            $conectar = parent::Conexion();
            parent::set_names();

            $descrip = "Ha activado el <b>usuario</b> con documento: <b>$documento</b>";

            $sql="UPDATE usuarios SET estado_usuario = 'Activo' WHERE usuarios.documento = ?;
            INSERT INTO user_movimiento (mov_id, mov_user, mov_descrip, mov_fecha) VALUES(NULL, ?, ?, now());";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $documento);
            $sql->bindValue(2, $id_user);
            $sql->bindValue(3, $descrip);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function desactivarUser($documento, $id_user){
            $conectar = parent::Conexion();
            parent::set_names();
            $descrip = "Ha desactivado el <b>usuario</b> con documento: <b>$documento</b>";

            $sql="UPDATE usuarios SET estado_usuario = 'Bloqueado' WHERE usuarios.documento = ?;
            INSERT INTO user_movimiento (mov_id, mov_user, mov_descrip, mov_fecha) VALUES(NULL, ?, ?, now());";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $documento);
            $sql->bindValue(2, $id_user);
            $sql->bindValue(3, $descrip);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        public function updateUser($id, $nombre, $apellido, $email, $cargo, $contrasena, $user){
            $conectar = parent::Conexion();
            parent::set_names();
            $descrip = "Ha actualizado los datos del <b>usuario</b> con documento: <b>$id</b>";
            $sql="UPDATE usuarios SET nombre = ?, apellido = ?, correo = ?, Cargo = ?, contrasena = ? WHERE usuarios.documento = ?;INSERT INTO user_movimiento (mov_id, mov_user, mov_descrip, mov_fecha) VALUES(NULL, ?, ?, now());";

            $sql=$conectar->prepare($sql);

            $sql->bindValue(1, $nombre);
            $sql->bindValue(2, $apellido);
            $sql->bindValue(3, $email);
            $sql->bindValue(4, $cargo);
            $sql->bindValue(5, $contrasena);
            $sql->bindValue(6, $id);
            $sql->bindValue(7, $user);
            $sql->bindValue(8, $descrip);
            
            $sql->execute();
            
            return $resultado=$sql->fetchAll();
        }
    }
?>