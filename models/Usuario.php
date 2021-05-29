<?php 
    class Usuario extends Conectar{
        
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
    }

?>