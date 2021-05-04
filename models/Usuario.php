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
                    header("Location:".conectar::ruta()."index.php?m=2");
                    exit();
                }else{

                    $sql = "SELECT * From usuarios WHERE documento=? AND contrasena=?";
                    $stmt=$conectar->prepare($sql);
                    $stmt->bindValue(1, $documento);
                    $stmt->bindValue(2, sha1($password));
                    $stmt->execute();
                    $resultado = $stmt->fetch();
                    if($resultado['estado_usuario'] == 'Bloqueado'){
                        header("Location:".Conectar::ruta()."index.php?m=3");
                        exit();
                    }else{

                        if(is_array($resultado) and count($resultado)>0){
                            $_SESSION["documento"]=$resultado["documento"];
                            $_SESSION["nombre"]=$resultado["nombre"];
                            $_SESSION["apellido"]=$resultado["apellido"];
                            $_SESSION["Cargo"]=$resultado["Cargo"];
                            header("Location:".Conectar::ruta()."view/Home/");
                            exit();
                        }else{
                            header("Location:".Conectar::ruta()."index.php?m=1");
                            exit();
                        }
                    }

                }
            }
        }
    }

?>