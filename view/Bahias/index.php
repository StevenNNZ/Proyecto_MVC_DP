<?php 
	require_once("../../config/conexion.php");
	require_once("../../controller/validate_session.php");
?>
<!DOCTYPE html>
<html lang="es">
	<?php require_once("../mainHead/head.php") ?>
    <title>Bahías activas</title>
</head>
<body>
    <?php
        require_once("../mainHeader/header.php");    
    ?>
    </header>
    <main class="main_cvet">
        <h1 class="Tittle-admin">
            <a href="../home/"><i class="fas fa-arrow-alt-circle-left"></i> Bahías activas</a>
        </h1>
         <div id="contenedor_resultado">
         
         </div> 
    </main>
    <?php
        require_once("../mainFooter/footer.php");
        require_once("../mainJS/js.php");    
    ?>
    <script src="consultaBahias.js"></script>
</body>
</html>



