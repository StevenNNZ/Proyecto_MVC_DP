<?php 
    require '../../../public/php/vendor/autoload.php';
    require_once("../../../controller/viewPDF.php");

    $html = getStylesTicket();
    
    if(isset($_GET['id_ticket_salida'])){
        $html.= showTicketSalida($_GET['id_ticket_salida']);
    }else{
        $html = 'Hubo un error...';
    }
    

    use Dompdf\Dompdf;

    $dompdf= new Dompdf();
    $dompdf->load_html($html);
    $dompdf->render();
    $dompdf->stream("documento.pdf", array('Attachment' => '0'));
   
?>