<?php 
    require_once("../../config/conexion.php"); 
    require_once("../../controller/validate_session.php");
    require_once("../../controller/validate_admin.php");
?>

<!DOCTYPE html>
<html lang="es">
    <?php require_once("../mainHead/head.php"); ?>
    <title>Consultar CVET</title>
</head>
<body>
    <?php
        require_once("../mainHeader/header.php");    
    ?>
    </header>
    <main class="main_cvet">
        <h1 class="Tittle-admin">
        <a href="../home"><i class="fas fa-arrow-alt-circle-left"></i> Consultas CVTE</a>
        </h1>
        <div class="contenedor__consultas">
            <div class="contenedor__consultas__cuerpo">
                <div class="contenedor__consultas--item">
                    <i class="fas fa-users icon_cvet"></i>
                    <span class="consultas_cantidad usuarios" id="info_cliente"><i class="fas fa-info"></i></span>
                    <br><br><a class="button_cvet" id="Consultar_cliente">Consultar</a>
                </div>
                <div class="contenedor__consultas--item">
                    <i class="fas fa-car icon_cvet"></i>
                    <span class="consultas_cantidad vehiculos" id="info_vehiculo"><i class="fas fa-info"></i></span>
                    <br><br><a class="button_cvet" id="Consultar_vehiculo">Consultar</a>
                </div>
                <div class="contenedor__consultas--item duo">
                    <i class="fas fa-car icon_cvet--duo"></i><i class="fas fa-building icon_cvet--duo"></i>
                    <span class="consultas_cantidad estacionamientos" id="info_estacionamiento"><i class="fas fa-info"></i></span>
                    <br><br><a class="button_cvet" id="Consultar_estacionamiento">Consultar</a>
                </div>
                <div class="contenedor__consultas--item">
                    <i class="fas fa-clipboard icon_cvet"></i>
                    <span class="consultas_cantidad tarifas" id="info_tarifa"><i class="fas fa-info"></i></span>
                    <br><br><a class="button_cvet" id="Consultar_tarifas">Consultar</a>
                </div>
            </div>
        </div>
         <div id="contenedor_resultado">
         
         </div> 
    </main>
    <?php
        require_once("../mainFooter/footer.php");
        require_once("../mainJS/js.php");    
    ?>
    <script src="consultasCVET.js"></script>
</body>
</html>



