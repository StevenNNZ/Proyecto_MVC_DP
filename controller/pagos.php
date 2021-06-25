<?php 

    require_once '../models/Pago.php';
    $pago = new Pago();


    function insertPago($id_salida, $tiempo, $id_tarifa, $pago_total){
        global $pago;

        //Insertar registro de pago
        $pago->insertPago($id_salida, $tiempo, $id_tarifa, $pago_total);

        //Traer el id del pago
        $results = $pago->getPago($id_salida);
        
        foreach($results as $result){
            $id_pago = $result['id_pago'];
        }

        return $id_pago;
    }
?>