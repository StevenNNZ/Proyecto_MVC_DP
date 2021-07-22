<?php 
    require '../../../public/php/vendor/autoload.php';
    require_once("../../../config/conexion.php");
    require_once "../../../controller/pdfReporteVenta.php";
    require_once("../../../controller/validate_session.php");

    $desde = $_GET['id'];
    $html = '
    <style>
    .negrita{
        font-weight: bold;
    }
    
    .contenedorTicket{
        border: 1px dashed #000;
        width: 400px;
        margin: 0px auto;
        padding: 30px;
        font-family:Verdana, Geneva, Tahoma, sans-serif;
    }
    .header{
        text-align: center;
        margin-top: -20px;
        border-bottom: 1px solid #ccc;
        margin-bottom: 50px;
        padding-bottom: 10px;
    }
    
    .header h1{
        text-align: center;
    }
    
    .header p{
        line-height: 5px;
    }
    
    .info{
        border-bottom: 1px dashed #000;
    }
    
    .info .negrita{
       width: 200px;
    }
    
    .info .content-info1{
        padding-left: 140px;
    }
    
    .info .content-info2{
        padding-left: 59px;
    }
    
    .info .content-info3{
        padding-left: 175px;
    }
    
    .info .content-info4{
        padding-left: 128px;
    }
    
    
    
    .detalles_tiempo{
        padding-bottom: 30px;
        border-bottom: 1px dashed #000;
    }
    
    .detalles_tiempo h2{
        font-size: 18px;
    }
    
    .detalles_tiempo span{
        padding-right: 50px;
        padding-left: 20px;
    }
    
    .venta{
        margin-top: 20px;
        border: 2px dashed grey;
        text-align: center;
        margin-bottom: 30px;
    }
    
    .footerTicket{
        border-top: 1px dashed #000;
        font-size: 10px;
        text-align: right;
    
    }
    
    .footerTicket .fecha{
        font-size: 13px;
        font-style: italic;
    }
    </style>';

    $html.="
    <div class='contenedorTicket'>
        <div class='header'>
            <h1>Digital Parking</h1>
            <p>Cra 50 # 26 - Paloquemao</p>
            <p>Nit: 165856215441</span></p>
            <p class='negrita'>Ticket de salida</p>
        </div>

        <div class='info'>
            <p>
                <span class='negrita'>No. Ticket:</span><span class='content-info1'>105</span>
            </p>
            <p><span class='negrita'>No. Estacionamiento:</span><span class='content-info2'>5</span></p>
            <p><span class='negrita'>Placa:</span><span class='content-info3'>BGT345</span></p>
            <p><span class='negrita'>Documento:</span><span class='content-info4'>100789235</span></p>

        </div>

        <div class='detalles_tiempo'>
            <h2>Fecha y hora de ingreso</h2>
            <span id='fecha'>27/10/2016</span> <span id='hora'>6:57:00 pm</span>
            
            <h2>Fecha y hora de salida</h2>
            <span id='fecha'>27/10/2016</span> <span id='hora'>6:57:00 pm</span>
            
            <h2>Tiempo transcurrido</h2>
            <span id='fecha'>2h 3min 30seg</span>
        </div>

        <div class='venta'>
            <p>Valor venta: <span>$9.800</span></p>
        </div>
        
        <div class='footerTicket'>
            <h2>Atendido por: <span>Andrea Quiroga</span></h2>
            <h2 class='fecha'>Fecha: <span>28/05/2021</span></h2>
        </div>
    </div>
    ";
    

    use Dompdf\Dompdf;
    //use Dompdf\Options;
    // $options = new Options();
    // $options->set('defaultPaperOrientation','landscape');

    $dompdf= new Dompdf();
    $dompdf->load_html($html);
    $dompdf->render();
    $dompdf->stream("documento.pdf", array('Attachment' => '0'));
   
?>