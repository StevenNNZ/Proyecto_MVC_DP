<?php 
    function validarSesionAdmin(){
        if(isset($_SESSION['Cargo']) && $_SESSION['Cargo'] != 'Administrador'){
            header("location:".Conectar::ruta()."view/home");
        }
    }
    validarSesionAdmin();
?>