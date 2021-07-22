<?php 
    class Usuario extends Conectar{

        //Traer todos los usuarios
        public function getAllUsers(){
            $conectar = parent::Conexion();

            $sql="SELECT * FROM usuarios WHERE est=1 ";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Traer usuarios por búsqueda
        public function getUsers($search){
            $conectar = parent::Conexion();

            $sql="  SELECT * FROM usuarios 
                    WHERE est=1 AND (documento LIKE '%$search%' OR nombre LIKE '%$search%' 
                    OR apellido LIKE '%$search%' OR Cargo LIKE '%$search%' OR estado_usuario LIKE '%$search%');";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Eliminar usuario
        public function deleteUser($documento, $id_usuario){
            $conectar = parent::Conexion();

            $sql="UPDATE usuarios SET est = '0' WHERE usuarios.documento = ?;";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $documento);
            $sql->execute();

            //Registrar movimiento
            $mov = "Ha eliminado el <b>usuario</b> con documento: <b>$documento</b>";
            $this->insertMovimiento($id_usuario, $mov);

            return $resultado=$sql->fetchAll();
        }

        //Traer usuario por documento
        public function getUser_x_id($documento){
            $conectar = parent::Conexion();

            $sql="SELECT * FROM usuarios WHERE documento = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $documento);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }

        //Activar un usuario
        public function activarUser($documento, $id_usuario){
            $conectar = parent::Conexion();
            parent::set_names();


            $sql="UPDATE usuarios SET estado_usuario = 'Activo' WHERE usuarios.documento = ?;";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $documento);
            $sql->execute();

            //Registrar movimiento
            $mov = "Ha activado el <b>usuario</b> con documento: <b>$documento</b>";
            $this->insertMovimiento($id_usuario, $mov);

            return $resultado=$sql->fetchAll();
        }
        
        //Desactivar un usuartio
        public function desactivarUser($documento, $id_usuario){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="UPDATE usuarios SET estado_usuario = 'Bloqueado' WHERE usuarios.documento = ?;";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $documento);
            $sql->execute();

            //Registrar movimiento
            $mov = "Ha desactivado el <b>usuario</b> con documento: <b>$documento</b>";
            $this->insertMovimiento($id_usuario, $mov);

            return $resultado=$sql->fetchAll();
        }

        //Actualizar un usuario
        public function updateUser($id, $nombre, $apellido, $email, $cargo, $contrasena, $id_usuario){
            $conectar = parent::Conexion();
            parent::set_names();    

            $sql="  UPDATE usuarios 
                    SET nombre = ?, apellido = ?, correo = ?, Cargo = ?, contrasena = ? 
                    WHERE usuarios.documento = ?";

            $sql=$conectar->prepare($sql);

            $sql->bindValue(1, $nombre);
            $sql->bindValue(2, $apellido);
            $sql->bindValue(3, $email);
            $sql->bindValue(4, $cargo);
            $sql->bindValue(5, $contrasena);
            $sql->bindValue(6, $id);
            
            $sql->execute();

            //Registrar movimiento
            $mov = "Ha actualizado los datos del <b>usuario</b> con documento: <b>$id</b>";
            $this->insertMovimiento($id_usuario, $mov);
            
            return $resultado=$sql->fetchAll();
        }
        
        //Validar usuario para iniciar sesión
        public function login(){
            $conectar = parent::conexion();
            parent::set_names();
            if(isset($_POST["enviar"])){
                $documento = $_POST["documento"];
                $password = $_POST["password"];
                $estado = "";
                
                if(empty($documento) and empty($password)){
                    header("Location:".conectar::ruta()."?m=2");
                    exit();
                }else{

                    $sql = "SELECT * From usuarios WHERE documento=? AND contrasena=?";
                    $stmt=$conectar->prepare($sql);
                    $stmt->bindValue(1, $documento);
                    $stmt->bindValue(2, sha1($password));
                    $stmt->execute();
                    $resultado = $stmt->fetch();
                    if($resultado['estado_usuario'] == 'Bloqueado'){
                        header("Location:".Conectar::ruta()."?m=3");
                        exit();
                    }else{

                        if(is_array($resultado) and count($resultado)>0){
                            $_SESSION["documento"]=$resultado["documento"];
                            $_SESSION["nombre"]=$resultado["nombre"];
                            $_SESSION["apellido"]=$resultado["apellido"];
                            $_SESSION["Cargo"]=$resultado["Cargo"];
                            $_SESSION["hora_ingreso"]=$resultado["ultimo_ingreso"];
                            $sql = ("UPDATE usuarios SET ultimo_ingreso = NOW() WHERE documento = $documento;");
                            $conectar->query($sql);
                            header("Location:".Conectar::ruta()."view/Home/");
                            exit();
                        }else{
                            header("Location:".Conectar::ruta()."?m=1");
                            exit();
                        }
                    }

                }
            }
        }

        //Ingresar un usuario
        public function insertUser($documento, $nombre, $apellido, $email, $cargo, $password){
            $conectar = parent::Conexion();
            parent::set_names();
            //Consulta correo usuario existente.
            $sql="SELECT correo FROM usuarios WHERE correo=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $email);
            $sql->execute();
            $validacion_email=$sql->fetchAll();
            
            $sql="SELECT documento FROM usuarios WHERE documento=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $documento);
            $sql->execute();
            $validacion_documento=$sql->fetchAll();
            //Validación cliente existente.
            if(is_array($validacion_email) and count($validacion_email)==0 and is_array($validacion_documento) and count($validacion_documento)==0){
                $sql="INSERT INTO usuarios (documento, nombre, apellido, correo, Cargo, contrasena, estado_usuario, ultimo_ingreso, est) VALUES (?,?,?,?,?,?, 'Bloqueado', '', 1);";

                $sql=$conectar->prepare($sql);
                $sql->bindValue(1, $documento);
                $sql->bindValue(2, $nombre);
                $sql->bindValue(3, $apellido);
                $sql->bindValue(4, $email);
                $sql->bindValue(5, $cargo);
                $sql->bindValue(6, sha1($password));
                $sql->execute(); 

            //    return $resultado=$sql->fetchAll();
                $resultado = 1;
            }else{
                $resultado = 0;
            }
             return $resultado;
        }

        //Insertar movimientos
        public function insertMovimiento($id_usuario, $descripcion_mov){
            $conectar = parent::Conexion();

            $sql = "INSERT INTO user_movimientos (mov_id, mov_user, mov_descrip, mov_fecha) VALUES(NULL, ?, ?, now());";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_usuario);
            $sql->bindValue(2, $descripcion_mov); //últ. Mov 

            $sql->execute();
        }

        //Traer los últimos movimientos
        public function getMovimientos($documento){
            $conectar = parent::Conexion();
            parent::set_names();

            $sql="SELECT mov_id, documento, mov_user, CONCAT(nombre,' ',apellido) AS nombres, mov_descrip, mov_fecha FROM user_movimientos, usuarios WHERE mov_user=documento AND mov_user = $documento ORDER BY user_movimientos.mov_fecha DESC LIMIT 20";
            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado=$sql->fetchAll();
        }
    }

?>