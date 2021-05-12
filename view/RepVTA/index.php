<!DOCTYPE html>
<html lang="es">
    <?php 
	    require_once("../../config/conexion.php");
        require_once("../mainHead/head.php");
    ?>
    <title>Reportes de venta</title>
</head>
<body>
    <?php require_once("../mainHeader/header.php") ?>
    </header>
    <main>  
        <h1 class="Tittle-admin"><i class="fas fa-book"></i> Reportes de venta</h1>
        <div class="contenedor-main">
            <div class="contenedor-main_barra-busqueda">
                <label class="contenedor-main_barra-busqueda__label-busqueda">Búsqueda <i class="fas fa-search"></i></label>
                <label class="contenedor-main_barra-busqueda__label" for="desde"> Desde:</label>
                <input class="contenedor-main_barra-busqueda__search" type="date" id="desde">
                <label class="contenedor-main_barra-busqueda__label" for="hasta">Hasta:</label>
                <input class="contenedor-main_barra-busqueda__search" type="date" id="hasta">
                <input class="contenedor-main_barra-busqueda__button" type="submit" value="Consultar" id="consultar_reportes">
            </div>
            <div class="contenedor_table_principal--reporte_venta">
                <div id="contenedor_resultado" class="table-responsive">
                
                </div>
            </div>
        </div>  

    </main>

    <?php require_once("../mainFooter/footer.php");?>
    <?php require_once("../mainJS/js.php");?>
    <script src="reportes_ventas.js"></script>
</body>
</html>



