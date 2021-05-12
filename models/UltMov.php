<?php 
    class UltMov extends Conectar{
        public function getMovLike($search){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT mov_id, mov_user,nombre, apellido, mov_descrip, mov_fecha FROM user_movimiento, usuarios WHERE mov_user=documento AND mov_user = $search ORDER BY user_movimiento.mov_fecha DESC LIMIT 20";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }
    }
?>