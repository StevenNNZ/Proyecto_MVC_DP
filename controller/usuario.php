<?php 
    require_once("../config/conexion.php");
    require_once("../models/Usuario.php");
    function registrar(){
    $usuario = new Usuario();

        switch($_GET["op"]){
            case "insert":
                $respuesta = $usuario->insertUser($_POST['documento'], $_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['cargo'], $_POST['password']);
                echo $respuesta;
                break;
            }
            return $respuesta;
    }

    registrar();
?>