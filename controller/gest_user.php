<?php 
    require_once("../config/conexion.php");
    require_once("../models/Gest_user.php");

    $reportesVenta = new Gest_user();

    switch($_GET["op"]){
        case "combo":
            $search = $_GET['search'];
            $html="";
            $datos = $reportesVenta->getUser($search);
            
            if(is_array($datos) and count($datos)>0){
                $html.="
                <table class='contenedor-table__table'>
                    <thead class='contenedor-table__thead'>
                        <tr class='contenedor-table__tr--principal tabla_gestion-usuarios'>
                            <th>DOCUMENTO</th>
                            <th>NOMBRE</th>
                            <th>APELLIDO</th>
                            <th>CORREO</th>
                            <th>CARGO</th>
                            <th>ESTADO</th>
                            <th>Últ. Ingreso</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody class='contenedor-table__tbody'>";
                
                foreach($datos as $row){
                    $html.="
                                    <tr>
                                        <td>$row[documento]</td>
                                        <td>$row[nombre]</td>
                                        <td>$row[apellido]</td>
                                        <td>$row[correo]</td>
                                        <td>$row[Cargo]</td>
                                        <td>$row[estado_usuario]</td>
                                        <td>$row[ultimo_ingreso]</td>
                                        <td>
                                            <a href='#'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar Usuario'></i></a>
                                            ";
                    if($row['estado_usuario']=='Activo'){
                        $html.="<a href='#'><i id='bloquear' class='fas fa-user-alt-slash icon_tabla' title='Desactivar Usuario'></i></a>";
                    }else{
                        $html.="<a href='#'><i id='activar' class='fas fa-user-check icon_tabla' title='Activar usuario'></i></a>";
                    }
                    
                    $html.="        <a href='#'><i id='edit' class='far fa-edit icon_tabla' title='Editar Usuario'></i></a>
                                </td>
                            </tr>";
                }
                
                $html.="
                    </tbody>
                    </table>";
                //Finalmente se escribe o retorna lo que hemos almacenado en la variable $html
                echo $html;
            }else{
                $html.="
                <div class='alert alert_danger alert_sm' id='contenedor-alerta-reportes_venta' style='animation-delay: .2s;margin:0 auto;'>
                    <div class='alert--icon'>
                        <i class='fas fa-bell'></i>
                    </div>
                    <div class='alert--content'>
                        No hemos encontrado ningún registro. Asegúrese de haber introducido la <b>información</b> correcta.
                    </div>
                </div>";
                echo $html;
            }
        break;
    }
?>