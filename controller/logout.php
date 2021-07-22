<?php 
    require_once("../config/conexion.php");

    function destroySession(){
        session_destroy();
        header("location:".Conectar::ruta());
    }

    destroySession();
?>