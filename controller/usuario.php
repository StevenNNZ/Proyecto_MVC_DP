<?php 
    require_once("../config/conexion.php");
    require_once("../models/Usuario.php");
    require_once("../models/Interfaz.php");

    $usuario = new Usuario();
    $interfaz = new Interfaz();

    switch($_GET['op']){
        case 'insert': 
            registrar();
        break;

        case 'getUsuarios': 
            echo getUsers();
        break;

        case "delete":
            deleteUser();
        break;

        case "showEditarUsuario":
            echo formUpdateUser();
        break;

        case "activarUser":
            activeUser();
        break;

        case "desactivarUser":
            desactiveUser();
        break;

        case "updateUser":
            updateUser();
            return '';
        break;

        case "ultimos_movimientos": 
            echo consultarMovimientos();
            break;

        default:
            break;
    }
    

    //Registrar usuario
    function registrar(){
        global $usuario;
        
        $respuesta = $usuario->insertUser($_POST['documento'], $_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['cargo'], $_POST['password']);
        echo $respuesta;

        return $respuesta;
    }

    //Traer usuarios
    function getUsers(){
        global $usuario;
        global $interfaz;
        
        //elementos tabla
        $tableHead = ['documento', 'nombre', 'apellido', 'correo', 'cargo', 'estado', 'ingreso', 'acciones'];
        $tableBody = [];
        $keysTable = ['documento', 'nombre', 'apellido', 'correo', 'Cargo', 'estado_usuario', 'ultimo_ingreso'];
        $tipo_tabla = ['usuarios', 'users'];
        $search = $_GET['search'];
        $datos = $usuario->getUsers($search);
        
        if(is_array($datos) and count($datos)>0){
            foreach($datos as $row){
                array_push($tableBody, $row);
            }

            //Crear tabla de usuarios
            $html = $interfaz->createTable($tableHead, $tableBody, $keysTable, $tipo_tabla);
        }else{ 
            //Traer la alerta de error
            $html = $interfaz->getAlert('No hemos encontrado ningún registro. Asegúrese de haber introducido la <b>información</b> correcta.', 'alert_danger');

            
        }
        //Retornar el HTML
        return $html;
    }

    //Eliminar usuarios
    function deleteUser(){
        global $usuario;

        $documento = $_GET['documento'];
        $user_active = $_GET['user_active'];

        $usuario->deleteUser($documento, $user_active);
    }

    //Mostra formulario de actualizar usuarios
    function formUpdateUser(){
        global $usuario;
        global $interfaz;

        $documento = $_GET['documento'];

        $datos = $usuario->getUser_x_id($documento);
        if(is_array($datos) and count($datos)>0){
            $html = $interfaz->createUpdateForm( $datos, 'Datos usuario', 'usuario' );
            
        }else{
            $html = $interfaz->getAlert('No hemos encontrado ningún registro. Asegúrese de haber introducido la <b>información</b> correcta.', 'alert_danger');
        }

        //Insertar HTML
        return $html;
    }
    
    //Activar usuarios
    function activeUser(){
        global $usuario;

        $documento = $_GET['documento'];
        $user_active = $_GET['user_active'];

        $usuario->activarUser($documento, $user_active);
    }
    
    //Desactivar usuarios
    function desactiveUser(){
        global $usuario;

        $documento = $_GET['documento'];
        $user_active = $_GET['user_active'];

        $usuario->desactivarUser($documento, $user_active);
    }
    
    //Actualizar usuarios
    function updateUser(){
        global $usuario;

        $id = $_GET['id'];
        $id_user = $_GET['user'];
        
        $usuario->updateUser($id, $_POST['nombre_usuario'], $_POST['apellido_usuario'], $_POST['email_usuario'], $_POST['cargo'], $_POST['contrasena_usuario'], $id_user);
         
    }

    function consultarMovimientos(){
        global $usuario;
        global $interfaz;
        $search = $_GET['search'];

        //elementos tabla
        $tableHead = ['id', 'documento', 'nombres', 'descripción', 'fecha'];
        $tableBody = [];
        $keysTable = ['mov_id', 'documento', 'nombres', 'mov_descrip', 'mov_fecha'];
        $tipo_tabla = ['usuarios', ''];
        $search = $_GET['search'];;

        $datos = $usuario->getMovimientos($search);
        
        //Creación de la respuesta a la vista.
        if(is_array($datos) and count($datos)>0){
            foreach($datos as $row){
                array_push($tableBody, $row);
            }
            $html = $interfaz->createTable($tableHead, $tableBody, $keysTable, $tipo_tabla);
        }else{
            $html = $interfaz->getAlert('Al parecer este <b>usuario</b> no ha realizado acciones, o no existe.', 'alert_danger');
           
        }

        // retornar html
        return $html;
    }
?>