<!DOCTYPE html>
<html lang="es">
    
	<?php 
        require_once("../../../config/conexion.php"); 
        require_once("../../mainHead/headSub.php") 
    ?>
    <title>Editando vehículo...</title>
</head>
<body>
    <?php
        require_once("../../mainHeader/headerSub.php");    
    ?>
    </header>
    <main class="main_usuarios">
        <?php 
            if(isset($_SESSION['Cargo'])){
                $rol = $_SESSION['Cargo'];
            }
        ?>
        <h1 class="Tittle-admin">   
            <?php if($rol == 'Administrador'):?>
                <a href="../"><i class="fas fa-arrow-alt-circle-left"></i> Editar vehículo</a>
            <?php endif?>
            <?php if($rol == 'Cajero'):?>
                <a href="../../Cliente/Consultar/"><i class="fas fa-arrow-alt-circle-left"></i> Editar vehículo</a>
            <?php endif?>
        </h1>

        <input type="hidden" name="id_usuario_responsable" id="id_usuario_responsable" value="<?= $_SESSION['documento']?>">
        <input type="hidden" name="cargo_user" id="cargo_user" value="<?= $rol?>">
        <input type="hidden" name="id_cliente" id="id_vehiculo" value="<?= $_GET['id']?>">
         <div id="contenedor_resultado">
         
         </div> 
    </main>
    <?php
        require_once("../../mainFooter/footer.php");
        require_once("../../mainJS/jsSub.php");    
    ?>
    <script src="editarVehiculo.js"></script>
</body>
</html>



