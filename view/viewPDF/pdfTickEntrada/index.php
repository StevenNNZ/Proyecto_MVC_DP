<?php 
    require '../../../public/php/vendor/autoload.php';
    require_once("../../../controller/viewPDF.php");

    $html = getStylesTicket();

    if(isset($_GET['id'])){
        $html .= getTicketEntrada($_GET['id']);
    }elseif(isset($_GET['doc'])){
        $html .= getTicketEntradaByCliente($_GET['doc']);
    }
    
    

    use Dompdf\Dompdf;
    
    $dompdf= new Dompdf();
    $dompdf->load_html($html);
    $dompdf->render();
    $dompdf->stream("documento.pdf", array('Attachment' => '0'));
   
?>