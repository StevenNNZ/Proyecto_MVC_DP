<!DOCTYPE html>
<html lang="es">
    
	<?php 
        require_once("../../../config/conexion.php"); 
        require_once("../../mainHead/headSub.php") 
    ?>
    <title>Editando...</title>
</head>
<body>
    <?php
        require_once("../../mainHeader/headerSub.php");    
    ?>
    </header>
    <main class="main_cvet">
        <h1 class="Tittle-admin"><i class="fab fa-elementor"></i> Editar usuario</h1>
            <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_GET['id']?>">
         <div id="contenedor_resultado">
         
         </div> 
    </main>
    <?php
        require_once("../../mainFooter/footer.php");
        require_once("../../mainJS/jsSub.php");    
    ?>
    <script src="editarUsuario.js"></script>
</body>
</html>



