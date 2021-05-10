<?php 
    class Bahia extends Conectar{

        public function insert_bahia($documento, $nombre, $apellido, $telefono, $placa, $color_vehiculo, $modelo_vehiculo, $tamano_vehiculo, $tipo_vehiculo, $noEstacionamiento, $descripcion, $id_usuario){
            //Llamado al método conexión a base de datos.
            $conectar = parent::Conexion();
            parent::set_names();
            //Consulta cliente existente
            $sql="SELECT Documento FROM cliente WHERE Documento =?;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $documento);
            $sql->execute();
            $validacion_cliente=$sql->fetchAll();

            //Consulta vehículo existente.
            $sql="SELECT Placa FROM vehiculo WHERE Placa =?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $placa);
            $sql->execute();
            $validacion_vehiculo=$sql->fetchAll();
            //Validación cliente existente.
            if(is_array($validacion_cliente) and count($validacion_cliente)==0){

                //Consulta id_estacionamiento de la tabla estacionamiento
                $sql="SELECT id_estacionamiento FROM estacionamiento ORDER BY id_estacionamiento DESC LIMIT 1";
                $sql=$conectar->prepare($sql);
                $sql->execute();
                $validacion_esta=$sql->fetchAll();
                foreach ($validacion_esta as $row){
                    $vali_esta = $row["id_estacionamiento"]; //Recuperar el atributo requerido.
                    $vali_esta++;
                    break;
                }

                //Sentencia SQL para agregar cliente, vehiculo, estacionamiento y sus últimos movimientos correspondientes.
                $sql="INSERT INTO cliente (Documento, Nombre, Apellido, Telefono) VALUES (?,?,?,?);
                INSERT INTO vehiculo (Placa, Color_vehiculo, Modelo_vehiculo, Tamano_vehiculo, Tipo_vehiculo) VALUES (?, ?, ?, ?, ?);
                INSERT INTO estacionamiento (id_estacionamiento, Num_estacionamiento, id_vehiculo, id_cliente, Estado_estacionamiento, esta_descripcion) VALUES (NULL, ?,?,?,'Activo',?);
                INSERT INTO user_movimiento (mov_id, mov_user, mov_descrip, mov_fecha) VALUES(NULL, ?, ?, now());
                INSERT INTO user_movimiento (mov_id, mov_user, mov_descrip, mov_fecha) VALUES(NULL, ?, ?, now());
                INSERT INTO user_movimiento (mov_id, mov_user, mov_descrip, mov_fecha) VALUES(NULL, ?, ?, now());";
                
                //Descripciones de últimos movimientos.
                $descripcion_mov1 = "Ha agregado un nuevo Cliente con Documento: $documento";
                $descripcion_mov2 = "Ha agregado un nuevo Vehiculo con Placa: $placa";
                $descripcion_mov3 = "Ha agregado un nuevo Estacionamiento con ID: $vali_esta";

                //Asignación de parámetros para sentencia SQL
                $sql=$conectar->prepare($sql);
                $sql->bindValue(1, $documento);
                $sql->bindValue(2, $nombre);
                $sql->bindValue(3, $apellido);
                $sql->bindValue(4, $telefono);
                $sql->bindValue(5, $placa);
                $sql->bindValue(6, $color_vehiculo);
                $sql->bindValue(7, $modelo_vehiculo);
                $sql->bindValue(8, $tamano_vehiculo);
                $sql->bindValue(9, $tipo_vehiculo);
                $sql->bindValue(10, $noEstacionamiento);
                $sql->bindValue(11, $placa);
                $sql->bindValue(12, $documento);
                $sql->bindValue(13, $descripcion);
                $sql->bindValue(14, $id_usuario);
                $sql->bindValue(15, $descripcion_mov1); //últ. Mov Add client
                $sql->bindValue(16, $id_usuario);
                $sql->bindValue(17, $descripcion_mov2);//últ. Mov Add Vehículo
                $sql->bindValue(18, $id_usuario);
                $sql->bindValue(19, $descripcion_mov3);//últ. Mov Add Estacionamiento
                $sql->execute();
                return $resultado=$sql->fetchAll();
            }else if(is_array($validacion_vehiculo) and count($validacion_vehiculo)==0){
                //Bloque a ejecutar en caso de que el cliente ya exista.
                $sql="SELECT id_estacionamiento FROM estacionamiento ORDER BY id_estacionamiento DESC LIMIT 1";
                $sql=$conectar->prepare($sql);
                $sql->execute();
                $validacion_esta=$sql->fetchAll();
                foreach ($validacion_esta as $row){
                    $vali_esta = $row["id_estacionamiento"];
                    $vali_esta++;
                    break;
                }
                    
                //Sentencia SQL para agregar  vehiculo, estacionamiento y sus últimos movimientos correspondientes.
                    $sql="INSERT INTO vehiculo (Placa, Color_vehiculo, Modelo_vehiculo, Tamano_vehiculo, Tipo_vehiculo) VALUES (?, ?, ?, ?, ?);
                    INSERT INTO estacionamiento (id_estacionamiento, Num_estacionamiento, id_vehiculo, id_cliente, Estado_estacionamiento, esta_descripcion) VALUES (NULL, ?,?,?,'Activo',?);
                    INSERT INTO user_movimiento (mov_id, mov_user, mov_descrip, mov_fecha) VALUES(NULL, ?, ?, now());
                    INSERT INTO user_movimiento (mov_id, mov_user, mov_descrip, mov_fecha) VALUES(NULL, ?, ?, now())";

                    $descripcion_mov1 = "Ha agregado un nuevo Vehículo con Placa: $placa";
                    $descripcion_mov2 = "Ha agregado un nuevo Estacionamiento con ID: $vali_esta";
                    $sql=$conectar->prepare($sql);
                    $sql->bindValue(1, $placa);
                    $sql->bindValue(2, $color_vehiculo);
                    $sql->bindValue(3, $modelo_vehiculo);
                    $sql->bindValue(4, $tamano_vehiculo);
                    $sql->bindValue(5, $tipo_vehiculo);
                    $sql->bindValue(6, $noEstacionamiento);
                    $sql->bindValue(7, $placa);
                    $sql->bindValue(8, $documento);
                    $sql->bindValue(9, $descripcion);
                    $sql->bindValue(10, $id_usuario);
                    $sql->bindValue(11, $descripcion_mov1);//últ. Mov Add Vehículo
                    $sql->bindValue(12, $id_usuario);
                    $sql->bindValue(13, $descripcion_mov2);//últ. Mov Add Estacionamiento
                    $sql->execute();
                    return $resultado=$sql->fetchAll();
            }else{
                //Bloque a ejecutar en caso de que el cliente y el vehículo ya existan.
                $sql="SELECT id_estacionamiento FROM estacionamiento ORDER BY id_estacionamiento DESC LIMIT 1";
                $sql=$conectar->prepare($sql);
                $sql->execute();
                $validacion_esta=$sql->fetchAll();
                foreach ($validacion_esta as $row){
                    $vali_esta = $row["id_estacionamiento"];
                    $vali_esta++;
                    break;
                }
                
                //Sentencia SQL para agregar estacionamiento y sus últimos movimientos correspondientes.
                $sql="INSERT INTO estacionamiento (id_estacionamiento, Num_estacionamiento, id_vehiculo, id_cliente, Estado_estacionamiento, esta_descripcion) VALUES (NULL, ?,?,?,'Activo',?);
                INSERT INTO user_movimiento (mov_id, mov_user, mov_descrip, mov_fecha) VALUES(NULL, ?, ?, now());";

                $descripcion_mov = "Ha agregado un nuevo Estacionamiento con ID: $vali_esta";
                $sql=$conectar->prepare($sql);
                $sql->bindValue(1, $noEstacionamiento);
                $sql->bindValue(2, $placa);
                $sql->bindValue(3, $documento);
                $sql->bindValue(4, $descripcion);
                $sql->bindValue(5, $id_usuario);
                $sql->bindValue(6, $descripcion_mov);//últ. Mov Add Estacionamiento
                $sql->execute(); 

               return $resultado=$sql->fetchAll();
            }
        }
    }
?>