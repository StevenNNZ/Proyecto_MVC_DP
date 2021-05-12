<!DOCTYPE html>
<html lang="es">
    <?php 
	    require_once("../../config/conexion.php");
        require_once("../mainHead/head.php");
    ?>
    <title>Consulta tickets</title>
</head>
<body>
    <?php require_once("../mainHeader/header.php") ?>
    </header>
    <main>  
        <h1 class="Tittle-admin"><i class="fas fa-book"></i> Consultar Ticket</h1>
        <div class="contenedor-main">
            <div class="contenedor_table_principal--ticket">
                <div id="contenedor_resultado"></div>
            </div>
        </div>  

    </main>

    <?php require_once("../mainFooter/footer.php");?>
    <?php require_once("../mainJS/js.php");?>
    <script src="consultarTicket.js"></script>
</body>
</html>



