<?php 
    require '../../../public/php/vendor/autoload.php';
    require_once("../../../config/conexion.php");
    require_once("../../../controller/viewPDF.php");
    require_once("../../../controller/validate_session.php");

    $desde = $_GET['desde'];
    $hasta = $_GET['hasta'];

    $html = '<title>Reporte de ventas</title>';
    $html .= getStylesReporteVenta();
    $html .= getReporteVenta($desde, $hasta);

    use Dompdf\Dompdf;
    use Dompdf\Options;
    $options = new Options();
    $options->set('defaultPaperOrientation','landscape');

    $dompdf= new Dompdf($options);
    $dompdf->load_html($html);
    $dompdf->render();
    $dompdf->stream("documento.pdf", array('Attachment' => '0'));
   
?>