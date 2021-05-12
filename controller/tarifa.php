<?php 
    require_once("../config/conexion.php");
    require_once("../models/Tarifa.php");

    $tarifa = new Tarifa();

    switch($_GET["op"]){
        case "insert":
            $tarifa->insert_tarifa($_GET['tipo'], $_GET['valor']);
        break;
    }
?>