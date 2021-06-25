<?php 
    require_once("../config/conexion.php");
    require_once("../models/Vehiculo.php");
    require_once("../models/Interfaz.php");

    //Instancias
    $vehiculo = new Vehiculo();
    $interfaz = new Interfaz();

    //Variables
    $tableHead = ['placa', 'color', 'modelo', 'tamaño', 'tipo', 'acciones']; //Cabecera de la tabla 
    $tableBody = [];
    $keysTable = ['Placa', 'Color_vehiculo', 'Modelo_vehiculo','Tamano_vehiculo', 'Tipo_vehiculo']; //Llaves para acceder a los campos de la tabla
    $barraBusqueda = $interfaz->createBar('Buscar un vehículo...', 'search_vehiculo'); //Crear la barra de búsqueda para clientes
    $tipo_tabla = ['CVET', 'vehicle']; //Tipo de tabla [0] = Tipo tabla general [1] = Tipo tabla específica


    //Inicializar funciones por cada caso
    switch($_GET["op"]){
        case "getVehiculos":
            $eliminar = !isset($_GET['eliminar']);
            echo GetVehiculos($eliminar);
            break;
        case "deleteVehiculo":
            deleteVehiculo();
            break;
        case "consultaVehiculos":
            $eliminar = !isset($_GET['eliminar']);
            echo getVehiculosLike($eliminar);
            break;
        case "showEditarVehiculo":
            echo showUpdateForm();
            break;
        case "updateVehiculo":
            return updateVehiculo();
            break;
    }

    //Traer vehículos
    function getVehiculos($eliminar = true){
        global $vehiculo;
        global $interfaz;
        global $tableHead;
        global $tableBody;
        global $keysTable; 
        global $barraBusqueda; 
        global $tipo_tabla; 

        $datos = $vehiculo->getVehiculos(10);
    
        //Creación de la respuesta a la vista.
        if(is_array($datos) and count($datos)>0){
            foreach($datos as $row){
                array_push($tableBody, $row); //Llenar el cuerpo de la tabla.
            }
            
            $html = $interfaz->createTable($tableHead, $tableBody, $keysTable, $tipo_tabla, $barraBusqueda, $eliminar);

            //Retornar el html
            echo $html;
        }else{
            $html = $interfaz->getAlert('¡Oops! Al parecer aún no hay registros de vehículos.', 'alert_danger');

            //Retornar el html
            echo $html;
        }

    }

    //Eliminar Vehículos
    function deleteVehiculo(){
        global $vehiculo;

        $placa = $_GET['placa'];
        $user_active = $_GET['user_active'];

        $vehiculo->deleteVehiculo($placa, $user_active);
    }

    //Traer Vehículos por condición SQL (LIKE)
    function getVehiculosLike($eliminar = true){
        $search = $_GET['search'];
        global $vehiculo;
        global $interfaz;
        global $tableHead;
        global $tableBody;
        global $keysTable; 
        global $tipo_tabla; 

        $datos_cons = $vehiculo->getVehiculoLike($search);
    
        //Creación de la respuesta a la vista.
        if(is_array($datos_cons) and count($datos_cons)>0){
            foreach($datos_cons as $row){
                array_push($tableBody, $row);
            }
            $html = $interfaz->createTableQuery($tableHead, $tableBody, $keysTable, $tipo_tabla, '' , $eliminar);
        
        }else{
            $html = $interfaz->getAlert(" Ningún vehículo coincide con &#39;<b>$search</b>&#39;&#46; Intente ingresar una búsqueda más acertada.", 'alert_danger');
        }

        return $html;
    }

    //Mostrar formulario de actualizar Vehículos
    function showUpdateForm(){
        global $vehiculo;
        global $interfaz;
        $placa = $_GET['placa'];
        $datos = $vehiculo->getVehiculo_x_id($placa);
            
        if(is_array($datos) and count($datos)>0){
            $html = $interfaz -> createUpdateForm($datos, 'Datos vehículo', 'vehiculo');
        }else{
            $html = $interfaz->getAlert('Ha ocurrudio un error. Por favor diríjase a la página anterior <a href="../">Haciendo click aquí</a>','alert_sm');
        }

        //Retornar HTML
        return $html;
    }

    //Actualizar Vehículos
    function updateVehiculo(){
        global $vehiculo;

        $placa = $_GET['id'];
        $id_user = $_GET['user'];
        $vehiculo->updateVehiculo($placa, $_POST['placa'], $_POST['color_vehiculo'], $_POST['modelo_vehiculo'], $_POST['tamano_vehiculo'], $_POST['tipo_vehiculo'], $id_user);
        
        return '';
    }

    
?>