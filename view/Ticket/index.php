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
        <h1 class="Tittle-admin">
                <a href="../home/"><i class="fas fa-arrow-alt-circle-left"></i> Consultar Ticket</a>
        </h1>
        <div class="contenedor__consultas">
            <div class="contenedor__consultas__cuerpo">
                <div class="contenedor__consultas--item">
                    <i class="fas fa-clipboard-check icon_cvet"></i>
                    <i class="fas fa-arrow-left icon_cvet_arrow"></i>
                    <span class="consultas_cantidad ticket_entrada" id="info_ticketE"><i class="fas fa-info"></i></span>
                    <br><br><a class="button_cvet" id="Consultar_ticketE">Consultar</a>
                </div>
                <div class="contenedor__consultas--item">
                    <i class="fas fa-clipboard-check icon_cvet"></i>
                    <i class="fas fa-arrow-right icon_cvet_arrow"></i>
                    <span class="consultas_cantidad ticket_salida" id="info_ticketS"><i class="fas fa-info"></i></span>
                    <br><br><a class="button_cvet" id="Consultar_ticketS">Consultar</a>
                </div>
            </div>
        </div>
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



