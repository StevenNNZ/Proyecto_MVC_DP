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
        <h1 class="Tittle-admin"><i class="fas fa-book"></i> Reporte de tickets</h1>
        <div class="contenedor-main">
            <div class="contenedor-main_barra-busqueda">
                <!-- <label class="contenedor-main_barra-busqueda__label-busqueda">Búsqueda <i class="fas fa-search"></i></label> -->
                <label class="contenedor-main_barra-busqueda__label" for="desde"> Desde:</label>
                <input class="contenedor-main_barra-busqueda__search" type="date" id="desde">
                <input class="contenedor-main_barra-busqueda__search" type="time" id="desde_hora">
                <label class="contenedor-main_barra-busqueda__label" for="hasta">Hasta:</label>
                <input class="contenedor-main_barra-busqueda__search" type="date" id="hasta">
                <input class="contenedor-main_barra-busqueda__search" type="time" id="hasta_hora">
                <input class="contenedor-main_barra-busqueda__button" type="submit" value="Consultar" id="consultar_reportes">
            </div>
            <div class="contenedor_table_principal--reporte_venta">
                <div id="contenedor_resultado">
                    <div class='alert alert_success alert_sm' id='contenedor-alerta-reportes_venta' style='animation-delay: .2s;margin:0 auto;margin-bottom:10px'>
                        <div class='alert--icon'>
                            <i class='fas fa-bell'></i>
                        </div>
                        <div class='alert--content'>
                            Mostrando registros desde <b>$desde</b> hasta <b>$hasta</b>
                        </div>
                        <div class='alert--close'>
                            <i class='far fa-times-circle'></i>
                        </div>
                    </div>
                    <table class="contenedor-table__table">
                            <thead class="contenedor-table__thead">
                                <tr class="contenedor-table__tr--principal">
                                    <th>ID</th>
                                    <th>NOMBRE</th>
                                    <th>APELLIDO</th>
                                    <th>PLACA</th>
                                    <th>DATOS ENTRADA</th>
                                    <th>DATOS SALIDA</th>
                                    <th>TIEMPO SERVICIO</th>
                                    <th>TOTAL PAGO</th>
                                </tr>
                            </thead>
                            <tbody class="contenedor-table__tbody">
                                        <tr>
                                            <td>5</td>
                                            <td>Steven</td>
                                            <td>Nuñez</td>
                                            <td>VCH 205</td>
                                            <td>29/04/2021<br>15:00</td>
                                            <td>29/04/2021<br>18:10</td>
                                            <td>3 horas 10 minutos</td>
                                            <td>$6000</td>
                                        </tr>
                                        <tr>
                                            <td class="total_pagos" colspan="7">Total pagos</td>
                                            <td colspan="1">$12.000</td>
                                        </tr>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>  

    </main>

    <?php require_once("../mainFooter/footer.php");?>
    <?php require_once("../mainJS/js.php");?>
</body>
</html>



