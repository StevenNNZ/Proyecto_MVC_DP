<?php 
    require_once("../../config/conexion.php");
    require_once("../../controller/validate_session.php");
    require_once("../../controller/validate_admin.php");
?>

<!DOCTYPE html>
<html lang="es">
    <?php require_once("../mainHead/head.php")?>
    <title>Movimientos usuarios</title>
</head>
<body>
    <?php
        require_once("../mainHeader/header.php");    
    ?>
    </header>
    <main class="main_usuarios">
        <h1 class="Tittle-admin">
            <a href="../home"><i class="fas fa-arrow-alt-circle-left"></i> Últimos movimientos</a>
        </h1>
        <div class="contenedor-main">
            <div class="contenedor-main_barra-busqueda_usuario">
                <select class="contenedor-main_barra-busqueda_select">
                    <option value="">Documento</option>
                </select>
                <input class="contenedor-main_barra-busqueda__search_texto ultMov" type="text" id="search_movimiento" name="search_movimiento" placeholder="Buscar movimientos de usuario...">
                <input class="contenedor-main_barra-busqueda__button ultMovBtn" type="submit" value="Consultar" id="consultar_reportes">
            </div>
            <div class="contenedor_table_principal--reporte_venta">
                <div id="contenedor_resultado">
                    
                </div>
            </div>
        </div>
    </main>
    <?php
        require_once("../mainFooter/footer.php");
        require_once("../mainJS/js.php");    
    ?>
    <script src="ultimosMovimientos.js"></script>
</body>
</html>



