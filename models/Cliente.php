<?php 
    require_once 'Usuario.php';

    class Cliente extends Conectar{
        //Validar clientes registrados
        public function validateCliente($documento){
            $conectar = parent::Conexion();
            //Consulta cliente existente
            $sql="SELECT Documento FROM clientes WHERE Documento =?;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $documento);
            $sql->execute();
            return $validacion_cliente=$sql->fetchAll();
        }
        
        //Insertar cliente
        public function setCliente($documento, $nombre, $apellido, $telefono, $id_usuario){
            $Usuario = new Usuario(); //Instancia clase usuario

            $conectar = parent::Conexion();

            $sql="INSERT INTO clientes (Documento, Nombre, Apellido, Telefono, est) VALUES (?,?,?,?, 1);";

            //Asignación de parámetros para sentencia SQL
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $documento);
            $sql->bindValue(2, $nombre);
            $sql->bindValue(3, $apellido);
            $sql->bindValue(4, $telefono);
        
            $sql->execute();

            //Registrar movimiento
            $mov = "Ha agregado un nuevo <b>cliente</b> con documento: <b>$documento</b>";
            $Usuario->insertMovimiento($id_usuario, $mov);

            return $resultado=$sql->fetchAll();
        }

        //Traer clientes
        public function getClientes($limit = false){
            $conectar = parent::Conexion();
            
            if(!$limit){
                $sql="SELECT * FROM clientes WHERE est = 1 LIMIT $limit;";
            }else{
                $sql="SELECT * FROM clientes WHERE est = 1;";
            }
            
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Trare cliente por id
        public function getCliente_x_id($documento){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT * FROM clientes WHERE documento = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $documento);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Traer cliente por letra digitada
        public function getClienteLike($search){
            $conectar = parent::Conexion();

            $sql="SELECT * FROM clientes WHERE est = 1 AND (Documento LIKE '%$search%' OR Nombre LIKE '%$search%' OR Apellido LIKE '%$search%')";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Elimninar cliente por id
        public function deleteCliente($documento, $id_usuario){
            $usuario = new Usuario();

            $conectar = parent::Conexion();
            

            $sql="UPDATE clientes SET est = '0' WHERE clientes.Documento = ?;";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $documento);
            $sql->execute();

            $mov = "Ha eliminado el <b>cliente</b> con documento: <b>$documento</b>";
            $usuario->insertMovimiento($id_usuario, $mov);

            return $resultado=$sql->fetchAll();
        }   

        //Actualizar cliente por id
        public function updateCliente($id, $documento, $nombre, $apellido, $telefono, $id_usuario){
            $usuario = new Usuario();
            $conectar = parent::Conexion();
            parent::set_names();

            $sql = 'UPDATE clientes SET Documento = ?, Nombre = ?, Apellido = ?, Telefono = ? WHERE Documento = ?;';
            $sql = $conectar->prepare($sql);

            $sql->bindValue(1, $documento);
            $sql->bindValue(2, $nombre);
            $sql->bindValue(3, $apellido);
            $sql->bindValue(4, $telefono);
            $sql->bindValue(5, $id);

            $sql->execute();

            //Registrar movimiento
            $mov = "Ha actualizado los datos del <b>cliente</b> con documento <b>$documento</b>";
            $usuario->insertMovimiento($id_usuario, $mov);

            return $resultado = $sql->fetchAll();
        }
    }
?>