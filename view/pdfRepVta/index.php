<?php 
    require '../../public/lib/php/vendor/autoload.php';
    require_once("../../controller/pdfReporteVenta.php");
    $desde = $_GET['desde'];
    $hasta = $_GET['hasta'];
    $html = '
    <style>
    .contenedor-table__table{
        margin: 0px auto;
        border-collapse: collapse;
        width: 80%;
        height: 50px;
        font-family: Helvetica;
    }
    
    /* Estilos tabla head */
    .contenedor-table__thead{
        border: 2px solid #1992b1;
    }
    
    /* Estilos campos de la cabecera */
    .contenedor-table__tr--principal{
        font-size: 20px;
        color: rgb(255, 255, 255);
    } 
    
    /* Estilos elementos de la cabecera, por etiqueta */
    th{
        background: #1992b1;
        position: sticky;
        top: -1px;
        height: 50px;
        padding: 0 10px;
    }
    
    .tabla_reporte-ventas th{
        min-width:100px ;
    }
    
    .tabla_gestion-usuarios th{
        min-width:100px ;
    }
    .contenedor-table__tbody{
        background: rgb(255, 255, 255);
        border: 2px solid #1992b1;
        border-top: none;
    }
    
    /* Estilos tbody */
    tbody{
        border: 1px solid rgb(83, 83, 83);
    }
    
    
    /* Estilos elementos del cuerpo tabla por etiqueta */
    td{
        border: 1px solid rgba(83, 83, 83, 0.582);
        padding: 1px 10px;
        text-align: center;
        height: 45px;
        max-width: 40px;
        overflow: hidden;
        overflow-x:auto;
    }
    
    td::-webkit-scrollbar{
        height: 3px;
        background: rgb(73, 72, 72);
    }
    td::-webkit-scrollbar-thumb{
        background: rgb(184, 181, 181);
        border-radius: 5px;
    }
    
    /* Estilo tabla de reporte de ventas (Sumatoria de pagos) */
    .total_pagos{
        text-align: right;
        text-transform: uppercase;
        font-size: 25px;
        background: #1992b1;
        color: #fff;
        font-weight: bold;
    }
    
    .sumatoria_total_pagos{
        font-size: 20px;
        /* background: #1993b18e; */
        /* color: #fff; */
        font-weight: bold;
        
    }
    </style>';
    $html .= getReporte($desde, $hasta);
    

    use Dompdf\Dompdf;
    use Dompdf\Options;
    $options = new Options();
    $options->set('defaultPaperOrientation','landscape');

    $dompdf= new Dompdf($options);
    $dompdf->load_html($html);
    $dompdf->render();
    $dompdf->stream("documento.pdf", array('Attachment' => '0'));
   
?>