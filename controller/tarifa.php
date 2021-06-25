<?php 
    require_once("../config/conexion.php");
    require_once("../models/Tarifa.php");
    require_once("../models/Interfaz.php");

    //Instancias
    $tarifa = new Tarifa();
    $interfaz = new Interfaz();

    //Definir variables
    $tableHead = ['id', 'tipo', 'valor', 'acciones']; //Cabecera de la tabla 
    $tableBody = [];
    $keysTable = ['id_tarifa', 'Tipo_vehiculo', 'Valor_tarifa']; //Llaves para acceder a los campos de la tabla
    $barraBusqueda = $interfaz->createBar('Buscar una tarifa...', 'search_tarifa'); //Crear la barra de búsqueda para clientes
    $tipo_tabla = ['CVET', 'tarifa'];

    switch($_GET["op"]){
        case "insert":
            $tarifa->insert_tarifa($_GET['tipo'], $_GET['valor']);
            break;

        case "getTarifas": 
            $crud = !isset($_GET['crud']);
            echo getTarifas($crud);
            break;

        case "deleteTarifa": 
            deleteTarifa();
            break;
        case "consultaTarifas": 
            echo getTarifasLike();
            break;
        case "showEditarTarifa":
            echo showUpdateForm();
            break;
        case "updateTarifa": 
            return updateTarifa();
            break;
    }

    //Traer tarifas
    function getTarifas($crud = true){
        global $tarifa, $interfaz, $tableHead, $tableBody, $keysTable, $barraBusqueda, $tipo_tabla; 

        $datos = $tarifa->getTarifas(10);
            
        //Creación de la respuesta a la vista.
        if(is_array($datos) and count($datos)>0){
            foreach($datos as $row){
                array_push($tableBody, $row); //Llenar el cuerpo de la tabla.
            }

            $html = $interfaz->createTable($tableHead, $tableBody, $keysTable, $tipo_tabla, $barraBusqueda, $crud);
        }else{

            $html = $interfaz->getAlert('¡Oops! Al parecer aún no hay registros de tarifas...', 'alert_danger');
        }

        //Retornar HTML 
        return $html;
    }

    //Eliminar tarifa
    function deleteTarifa(){
        global $tarifa;

        $id = $_GET['id'];
        $user_active = $_GET['user_active'];

        $tarifa->deleteTarifa($id, $user_active);
    }

    //Traer tarifas por condición SQL
    function getTarifasLike(){
        $search = $_GET['search'];
        global $tarifa, $interfaz, $tableHead, $tableBody, $keysTable, $barraBusqueda, $tipo_tabla; 

        $datos = $tarifa->getTarifaLike($search);
            
        //Creación de la respuesta a la vista.
        if(is_array($datos) and count($datos)>0){
            foreach($datos as $row){
                array_push($tableBody, $row); //Llenar el cuerpo de la tabla.
            }
            $html = $interfaz->createTableQuery($tableHead, $tableBody, $keysTable, $tipo_tabla);
        }else{
            $html = $interfaz->getAlert("Ninguna tarifa coincide con &#39;<b>$search</b>&#39;&#46; Intente ingresar una búsqueda más acertada.", 'alert_danger');
        }

        //Retornar HTML
        return $html;
    }

    //Mostrar formulario de actualizar tarifas
    function showUpdateForm(){
        global $tarifa, $interfaz;
        $id = $_GET['id'];
        $datos = $tarifa->getTarifa_x_id($id);
            
        if(is_array($datos) and count($datos)>0){
            $html = $interfaz -> createUpdateForm($datos, 'Datos Tarifa', 'tarifa');
        }else{
            $html = $interfaz->getAlert('Ha ocurrudio un error. Por favor diríjase a la página anterior <a href="../">Haciendo click aquí</a>','alert_sm');
        }

        //Retornar HTML
        return $html;
    }

    //Actualizar una tarifa
    function updateTarifa(){
        global $tarifa;

        $id = $_GET['id'];
        $id_user = $_GET['user'];
        $tarifa->updateTarifa($id, $_POST['tipo_vehiculo'], $_POST['valor_tarifa'], $id_user);
        
        return '';
    }
?>