<?php 
    require '../../public/php/vendor/autoload.php';
    require_once("../../controller/ticketPDF.php");
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

    .info .content-info5{
        padding-left: 112px;
    }

    .info .content-info6{
        padding-left: 133px;
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

    if(isset($_GET['id_ticket_salida'])){
        $html.= showTicketSalida($_GET['id_ticket_salida']);
    }else{
        $id = $_GET['id'];
        $id_entrada = $_GET['id_entrada'];
        $html.= createSalida($id_entrada, $id);
    }
    

    use Dompdf\Dompdf;

    $dompdf= new Dompdf();
    $dompdf->load_html($html);
    $dompdf->render();
    $dompdf->stream("documento.pdf", array('Attachment' => '0'));
   
?>