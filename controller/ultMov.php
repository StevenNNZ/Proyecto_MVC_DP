<?php 
    require_once("../config/conexion.php");
    require_once("../models/UltMov.php");

    $ultMov = new UltMov();
    switch($_GET["op"]){
       
    case "consultaMovimiento":
        $search = $_GET['search'];
        $html="";

        $datos_cons = $ultMov->getMovLike($search);
        
        //Creación de la respuesta a la vista.
        if(is_array($datos_cons) and count($datos_cons)>0){
            $html.="
            <div class='table-responsive'>
                <table class='contenedor-table__table'>
                    <thead class='contenedor-table__thead'>
                        <tr class='contenedor-table__tr--principal'>
                            <th>ID</th>
                            <th>DOCUMENTO</th>
                            <th>NOMBRES</th>
                            <th>DESCRIPCIÓN</th>
                            <th>FECHA</th>
                        </tr>
                    </thead>
                    <tbody class='contenedor-table__tbody'>";
            
            foreach($datos_cons as $row){
                $html.="
                                <tr>
                                    <td>$row[mov_id]</td>
                                    <td>$row[mov_id]</td>
                                    <td>$row[nombre]<br>$row[apellido]</td>
                                    <td>$row[mov_descrip]</td>
                                    <td>$row[mov_fecha]</td>
                                </tr>";
            }
            
            $html.="
                </tbody>
                </table>
                </div>";
            //Finalmente se escribe o retorna lo que hemos almacenado en la variable $html
            echo $html;
        }else{
            $html.="
            <div class='alert alert_danger alert_sm' id='contenedor-alerta-reportes_venta' style='animation-delay: .2s;margin:0 auto;'>
                <div class='alert--icon'>
                    <i class='fas fa-bell'></i>
                </div>
                <div class='alert--content'>
                    Al parecer este <b>usuario</b> no ha realizado acciones, o no existe.
                </div>
            </div>";
            echo $html;
        }
    break;
    }
?>