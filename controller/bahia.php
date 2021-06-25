<?php 
    require_once("../config/conexion.php");
    require_once("../controller/ticket.php");
    require_once("../models/Bahia.php");
    require_once("../models/Interfaz.php");

    //Instancias
    $bahia = new Bahia();
    $interfaz = new Interfaz();

    //Definir variables
    $tableHead = ['no.', 'vehículo', 'Documento cliente', 'Nombres cliente', 'estado', 'descripcion', 'acciones']; //Cabecera de la tabla 
    $tableBody = [];
    $keysTable = ['Num_estacionamiento', 'id_vehiculo', 'id_cliente', 'nombres', 'Estado_estacionamiento', 'esta_descripcion']; //Llaves para acceder a los campos de la tabla
    $barraBusqueda = $interfaz->createBar('', '', 'bahia'); //Crear la barra de búsqueda para clientes
    $tipo_tabla = ['CVET', 'bahia'];

    $bahia = new Bahia();

    switch($_GET["op"]){
        case "insert":
            if($_POST['color_vehiculo'] == '') {
                $color_vehiculo = 'N/A'; 
            }else {
                $color_vehiculo = $_POST['color_vehiculo'];
            }

            if($_POST['modelo_vehiculo'] == '') {
                $modelo_vehiculo = 'N/A'; 
            }else {
                $modelo_vehiculo = $_POST['modelo_vehiculo'];
            }
            
            if($_POST['descripcion_esta'] == '') {
                $descripcion = 'N/A';
            }else{
                $descripcion = $_POST['descripcion_esta'];
            }

            $bahia->insert_aparcamiento($_POST['documento_cliente'], $_POST['nombre_cliente'], $_POST['apellido_cliente'], $_POST['telefono_cliente'], $_POST['placa_vehiculo'], $color_vehiculo, $modelo_vehiculo, $_POST['tamano_vehiculo'], $_POST['tipo_vehiculo'], $_POST['num_estacionamiento'], $descripcion, $_POST['id_usuario']);
            
             return '';
            
        break;

        case "getBahias":
            echo getBahias();
            break;
        case "deleteBahia": 
            deleteBahia();
            break;
        case "getBahiaBetween":
            echo getBahiasBetween();
            break;
            
        case "showEditarBahia":
            echo ShowUpdateForm();
            break;

        case "updateBahia": 
            return updateBahia();
            break;

        case "getBahiasActivas": 
            echo getBahiasActivas();
            break;
        case "retirarBahia": 
            return retirarBahia();
            break;
        default: 
            echo 'Petición inválida';
            break;
    }

    //Traer todas las bahías activas
    function getBahiasActivas(){
        global $bahia, $interfaz;

        $tableHead = ['id', 'no. bahia', 'vehículo', 'cliente', 'estado', 'descripcion', 'entrada', 'acciones'];
        $tableBody = [];
        $keysTable = [ 'id_estacionamiento','Num_estacionamiento', 'id_vehiculo', 'id_cliente', 'Estado_estacionamiento', 'esta_descripcion', 'fecha_creacion'];
        $tipo_tabla = ['bahia-activa', 'bahia-activa'];


        $datos = $bahia->getBahiasActivas();
    
        //Creación de la respuesta a la vista.
        if(is_array($datos) and count($datos)>0){

            foreach($datos as $row){
                array_push($tableBody, $row);
            }

            $html = $interfaz->getAlert('Mostrando <b>bahías</b> activas.','alert_success');
            $html .= $interfaz->createTable($tableHead, $tableBody, $keysTable, $tipo_tabla);
        }else{
            $html = $interfaz->getAlert('¡Oops! Al parecer aún no hay bahías activas...', 'alert_danger');
        }

        return $html;
    }

    //Retirar una bahía (Estado: Terminado)
    function retirarBahia(){
        global $bahia;

        $id_estacionamiento = $_GET['id'];
        $id_entrada = $_GET['id_entrada'];
        $id_usuario = $_GET['user_active']; //Usuario que realiza los movimientos
        
        //Retirar la bahía de los estacionamientos activos.
        $bahia->retirarBahiaActiva($id_estacionamiento, $id_entrada, $id_usuario);
        
        //Generar ticket de salida
        $id_salida = createTicketSalida($id_entrada, $id_estacionamiento, $id_usuario);
        echo $id_salida;
        return $id_salida;
    }
    //Traer bahías
    function getBahias(){
        global $bahia, $interfaz ,$tableHead, $tableBody, $keysTable, $barraBusqueda, $tipo_tabla; 

        $datos = $bahia->getBahias();
            
        //Creación de la respuesta a la vista.
        if(is_array($datos) and count($datos)>0){
            foreach($datos as $row){
                array_push($tableBody, $row); //Llenar el cuerpo de la tabla.
            }

            $html = $interfaz->createTable($tableHead, $tableBody, $keysTable, $tipo_tabla, $barraBusqueda);
        }else{

            $html = $interfaz->getAlert('¡Oops! Al parecer aún no hay registros de bahías.', 'alert_danger');
        }

        //Retornar HTML
        return $html;
    }

    //Eliminar bahía
    function deleteBahia(){
        global $bahia;

        $id = $_GET['id'];
        $user_active = $_GET['user_active'];

        $bahia->deleteBahia($id, $user_active);
    }

    //Traer bahías por condición BETWEEN (entre fechaEntrada-fecha-salida)
    function getBahiasBetween(){
        $desde = $_GET['desde'];
        $hasta = $_GET['hasta'];
        global $bahia, $interfaz, $tableHead, $tableBody, $keysTable, $tipo_tabla; 

        $datos = $bahia->getBahiaBetween($desde, $hasta);
        
        //Creación de la respuesta a la vista.
        if(is_array($datos) and count($datos)>0){
            foreach($datos as $row){
                array_push($tableBody, $row); //Llenar el cuerpo de la tabla.
            }
            $html = $interfaz->getAlert("Mostrando registros desde <b>$desde</b> hasta <b>$hasta</b>", 'alert_success');
            $html .= $interfaz->createTableQuery($tableHead, $tableBody, $keysTable, $tipo_tabla);

        }else{
            $html = $interfaz->getAlert('Ningún estacionamiento coincide con su criterio de búsqueda.; Intente ingresar una <b>fecha</b> más acertada.', 'alert_danger');
        }

        //Retornar HTML
        return $html;
    }

    //Mostrar formulario de actualizar bahías
    function showUpdateForm(){
        global $bahia, $interfaz;
        $id = $_GET['id'];
        $datos = $bahia->getBahia_x_id($id);
            
        if(is_array($datos) and count($datos)>0){
            $html = $interfaz -> createUpdateForm($datos, 'Datos bahía', 'bahia');
        }else{
            $html = $interfaz->getAlert('Ha ocurrudio un error. Por favor diríjase a la página anterior <a href="../">Haciendo click aquí</a>','alert_sm');
        }

        //Retornar HTML
        return $html;
    }

    //Actualizar clientes
    function updateBahia(){
        global $bahia;

        $id = $_GET["id"];
        $id_user = $_GET["user"];
        $bahia->updateBahia($id, $_POST['Num_estacionamiento'], $_POST['placa'], $_POST['cliente'], $_POST['Estado_estacionamiento'], $_POST['descripcion_esta'], $id_user);
        
         return '';
    }
?>