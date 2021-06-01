<!DOCTYPE html>
<html lang="es">
    
	<?php 
        require_once("../../../config/conexion.php"); 
        require_once("../../mainHead/headSub.php") 
    ?>
    <title>Editando cliente...</title>
</head>
<body>
    <?php
        require_once("../../mainHeader/headerSub.php");    
    ?>
    </header>
    <main class="main_usuarios">
        <h1 class="Tittle-admin">
            <a href="../"><i class="fas fa-arrow-alt-circle-left"></i> Editar tarifa</a>
        </h1>
        <input type="hidden" name="id_usuario_responsable" id="id_usuario_responsable" value="<?php echo $_SESSION['documento']?>">
        <input type="hidden" name="id_tarifa" id="id_tarifa" value="<?php echo $_GET['id']?>">
         <div id="contenedor_resultado">
         
         </div> 
    </main>
    <?php
        require_once("../../mainFooter/footer.php");
        require_once("../../mainJS/jsSub.php");    
    ?>
    <script src="editarTarifa.js"></script>
</body>
</html>



