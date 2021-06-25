<?php 
    require_once("../config/conexion.php");
    require_once("../models/Cliente.php");
    require_once("../models/Interfaz.php");

    //Instancias
    $cliente = new Cliente();
    $interfaz = new Interfaz();

    //Definir variables
    $tableHead = ['documento', 'nombre', 'apellido', 'telefono', 'acciones']; //Cabecera de la tabla 
    $tableBody = [];
    $keysTable = ['Documento', 'Nombre', 'Apellido', 'Telefono']; //Llaves para acceder a los campos de la tabla
    $barraBusqueda = $interfaz->createBar('Buscar un cliente...', 'search_cliente'); //Crear la barra de búsqueda para clientes
    $tipo_tabla = ['CVET', 'clients'];

    //Inicializar funciones por cada caso
    switch($_GET["op"]){
        case "getClientes":
            $eliminar = !isset($_GET['eliminar']);
            echo GetClientes($eliminar);
            break;
        case "deleteCliente":
            deleteCliente();
            break;
        case "consultaClientes":
            $eliminar = !isset($_GET['eliminar']);
            echo getClientesLike($eliminar);
            break;
        case "showEditarCliente":
            echo showUpdateForm();
            break;
        case "updateCliente":
            return updateCliente();
            break;
        default:
            break;
    }

    //Traer clientes
    function getClientes($eliminar=true){
        global $cliente, $interfaz, $tableHead, $tableBody, $keysTable, $barraBusqueda, $tipo_tabla; 

        $datos = $cliente->getClientes(10);
            
        //Creación de la respuesta a la vista.
        if(is_array($datos) and count($datos)>0){
            foreach($datos as $row){
                array_push($tableBody, $row); //Llenar el cuerpo de la tabla.
            }

            $html = $interfaz->createTable($tableHead, $tableBody, $keysTable, $tipo_tabla, $barraBusqueda, $eliminar);
        }else{

            $html = $interfaz->getAlert('¡Oops! Al parecer aún no hay registros de clientes.', 'alert_danger');
        }

        //Retornar HTML
        return $html;
    }

    //Eliminar clientes
    function deleteCliente(){
        global $cliente;

        $documento = $_GET['documento'];
        $user_active = $_GET['user_active'];

        $cliente->deleteCliente($documento, $user_active);
    }

    //Traer clientes por condición SQL
    function getClientesLike($eliminar= true){
        $search = $_GET['search'];
        global $cliente, $interfaz, $tableHead, $tableBody, $keysTable, $barraBusqueda, $tipo_tabla; 

        $datos = $cliente->getClienteLike($search);
            
        //Creación de la respuesta a la vista.
        if(is_array($datos) and count($datos)>0){
            foreach($datos as $row){
                array_push($tableBody, $row); //Llenar el cuerpo de la tabla.
            }
            $html = $interfaz->createTableQuery($tableHead, $tableBody, $keysTable, $tipo_tabla,'',$eliminar);
        }else{
            $html = $interfaz->getAlert("Ningún cliente coincide con &#39;<b>$search</b>&#39;&#46; Intente ingresar una búsqueda más acertada.", 'alert_danger');
        }

        //Retornar HTML
        return $html;
    }

    //Mostrar formulario de actualizar clientes
    function showUpdateForm(){
        global $cliente, $interfaz;
        $documento = $_GET['documento'];
        $datos = $cliente->getCliente_x_id($documento);
            
        if(is_array($datos) and count($datos)>0){
            $html = $interfaz -> createUpdateForm($datos, 'Datos cliente', 'cliente');
        }else{
            $html = $interfaz->getAlert('Ha ocurrudio un error. Por favor diríjase a la página anterior <a href="../">Haciendo click aquí</a>','alert_sm');
        }

        //Retornat HTML
        return $html;
    }

    //Actualizar clientes
    function updateCliente(){
        global $cliente;

        $documento = $_GET["id"];
        $id_user = $_GET["user"];
        $cliente->updateCliente($documento, $_POST['documento_cliente'], $_POST['nombre_cliente'], $_POST['apellido_cliente'], $_POST['telefono_cliente'], $id_user);
        
        return '';
    }
?>