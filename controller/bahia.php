<?php 
    require_once("../config/conexion.php");
    require_once("../models/Bahia.php");

    $bahia = new Bahia();

    switch($_GET["op"]){
        case "insert":
            $bahia->insert_bahia($_POST['documento_cliente'], $_POST['nombre_cliente'], $_POST['apellido_cliente'], $_POST['telefono_cliente'], $_POST['placa_vehiculo'], $_POST['color_vehiculo'], $_POST['modelo_vehiculo'], $_POST['tamano_vehiculo'], $_POST['tipo_vehiculo'], $_POST['num_estacionamiento'], $_POST['descripcion_esta'], $_POST['id_usuario']);
            // echo $bahia;
             $bahia->insertTicket($_POST['id_usuario']);
             return '';
            
        break;
    }
?>