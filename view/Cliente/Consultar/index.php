<!DOCTYPE html>
<html lang="es">
    
	<?php 
        require_once("../../../config/conexion.php"); 
        require_once("../../mainHead/headSub.php") 
    ?>
    <title>Gestionar usuarios</title>
</head>
<body>
    <?php
        require_once("../../mainHeader/headerSub.php");    
    ?>
    </header>
    <main class="main_cvet">
        <h1 class="Tittle-admin"><i class="fab fa-elementor"></i> Consultar cliente/vehículo</h1>
        <div class="contenedor__consultas">
            <div class="contenedor__consultas__cuerpo">
                <div class="contenedor__consultas--item">
                    <i class="fas fa-users icon_cvet"></i>
                    <span class="consultas_cantidad usuarios" id="info_cliente"><i class="fas fa-info"></i></span>
                    <br><br><a href="#" class="button_cvet" id="Consultar_cliente">Consultar</a>
                </div>
                <div class="contenedor__consultas--item">
                    <i class="fas fa-car icon_cvet"></i>
                    <span class="consultas_cantidad vehiculos" id="info_vehiculo"><i class="fas fa-info"></i></span>
                    <br><br><a href="#" class="button_cvet" id="Consultar_vehiculo">Consultar</a>
                </div>
            </div>
        </div>
         <div id="contenedor_resultado">
         
         </div> 
    </main>
    <?php
        require_once("../../mainFooter/footer.php");
        require_once("../../mainJS/jsSub.php");    
    ?>
    <script src="consultar.js"></script>
</body>
</html>



