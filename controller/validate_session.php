<?php 
    function validarSesion(){
        if(!isset($_SESSION['documento'])){
            header("location:".Conectar::ruta());
        }
    }
    validarSesion();
?>