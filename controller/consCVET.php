<?php 
    require_once("../config/conexion.php");
    require_once("../models/ConsCVET.php");
    require_once("../models/Ticket.php");

    // Instancia clase Consultas CVET (Clientes, Vehiculos, Estacionamientos, Tarifas)
    $consCVET = new ConsCVET();

    switch($_GET["op"]){
        case "cliente":
            $html="";

            $datos = $consCVET->getCliente();
            
            //Creación de la respuesta a la vista.
            if(is_array($datos) and count($datos)>0){
                $html.="
                <div class='contenedor_resultado_consultas'>
                <div class='contenedor-main_barra-busqueda_cvet'>
                    <label class='contenedor-main_barra-busqueda__label-busqueda_usuario'><i class='fas fa-search'></i></label>
                    <input class='contenedor-main_barra-busqueda__search_texto' type='text' id='search_cliente' name='search_cliente' placeholder='Buscar un cliente...'>
                </div>
                <div id='contenedor_tabla-general'>
                <div class='table-responsive'>
                    <table class='contenedor-table__table'>
                        <thead class='contenedor-table__thead'>
                            <tr class='contenedor-table__tr--principal'>
                                <th>DOCUMENTO</th>
                                <th>NOMBRE</th>
                                <th>APELLIDO</th>
                                <th>TELEFONO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody class='contenedor-table__tbody'>";
                
                foreach($datos as $row){
                    $html.="
                                    <tr>
                                        <td>$row[Documento]</td>
                                        <td>$row[Nombre]</td>
                                        <td>$row[Apellido]</td>
                                        <td>$row[Telefono]</td>
                                        <td>
                                            <a href='#' onclick='deleteCliente($row[Documento])' id='$row[Documento]'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar cliente'></i></a>
                                            <a href='#' onclick='updateCliente($row[Documento])' id='$row[Documento]'><i id='edit' class='far fa-edit icon_tabla' title='Editar cliente'></i></a>
                                        </td>
                                    </tr>";
                }
                
                $html.="
                    </tbody>
                    </table>
                    </div>
                    </div>
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
                        ¡Oops! Al parecer aún no hay registros de clientes.
                    </div>
                </div>";
                echo $html;
            }
        break;

        case "deleteCliente":
            $documento = $_GET['documento'];
            $user_active = $_GET['user_active'];

            $consCVET->deleteCliente($documento, $user_active);
        break;

        case "consultaCliente":
            $search = $_GET['search'];
            $html="";

            $datos_cons = $consCVET->getClienteLike($search);
            
            //Creación de la respuesta a la vista.
            if(is_array($datos_cons) and count($datos_cons)>0){
                $html.="
                <div class='table-responsive'>
                    <table class='contenedor-table__table'>
                        <thead class='contenedor-table__thead'>
                            <tr class='contenedor-table__tr--principal'>
                                <th>DOCUMENTO</th>
                                <th>NOMBRE</th>
                                <th>APELLIDO</th>
                                <th>TELEFONO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody class='contenedor-table__tbody'>";
                
                foreach($datos_cons as $row){
                    $html.="
                                    <tr>
                                        <td>$row[Documento]</td>
                                        <td>$row[Nombre]</td>
                                        <td>$row[Apellido]</td>
                                        <td>$row[Telefono]</td>
                                        <td>
                                        <a href='#' onclick='deleteCliente($row[Documento])' id='$row[Documento]'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar cliente'></i></a>
                                        <a href='#' onclick='updateCliente($row[Documento])' id='$row[Documento]'><i id='edit' class='far fa-edit icon_tabla' title='Editar cliente'></i></a>
                                        </td>
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
                        Ningún cliente coincide con &#39;<b>$search</b>&#39;&#46; Intente ingresar una búsqueda más acertada.
                    </div>
                </div>";
                echo $html;
            }
        break;

        case "showEditarCliente":
            $documento = $_GET['documento'];
            $html="";
            $datos = $consCVET->getCliente_x_id($documento);
            
            if(is_array($datos) and count($datos)>0){
                $html.="
                <div class='container_edit'>
                    <div class='content-form_edit'>
                        <form method='post' id='form_editar' class='formulario'>
                            <fieldset class='fieldset'><legend class='legend-principal'>Datos cliente</legend>
                                <div class='contenido-cliente'>";
                
                foreach($datos as $row){
                    $html.="
                                    <div class='input-contenedor-edit'>
                                        <i class='fas fa-id-card icon_formularios_registro'></i>
                                        <input type='number' class='input_registrar' name='documento_cliente' id='documento_cliente' placeholder='Número documento *' value='$row[Documento]' required>
                                    </div>
                                    <div class='input-contenedor-edit'>
                                        <i class='fas fa-user icon_formularios_registro'></i>
                                        <input type='text' class='input_registrar' name='nombre_cliente' id='nombre_cliente' placeholder='Nombre *' value='$row[Nombre]' required>
                                    </div>
                                    <div class='input-contenedor-edit'>
                                        <i class='far fa-user icon_formularios_registro'></i>
                                        <input type='text' class='input_registrar' name='apellido_cliente' id='apellido_cliente' placeholder='Apellido *' value='$row[Apellido]' required>
                                    </div>
                                    <div class='input-contenedor-edit'>
                                        <i class='fas fa-phone icon_formularios_registro'></i>
                                        <input type='number' class='input_registrar' name='telefono_cliente' id='telefono_cliente' placeholder='Telefono *' value='$row[Telefono]' required>
                                    </div>";
                }
                
                $html.="
                                    <div class='button-contenedor'>
                                        <input class='button reset' type='reset' name='btn-limpiar' value='Limpiar'>
                                        <button type='submit' name='action' value='add' id='button_action' class='button'>Registrar</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>'";
                //Finalmente se escribe o retorna lo que hemos almacenado en la variable $html
                echo $html;
            }else{
                $html.="
                <div class='alert alert_danger alert_sm' id='contenedor-alerta-reportes_venta' style='animation-delay: .2s;margin:0 auto;'>
                    <div class='alert--icon'>
                        <i class='fas fa-bell'></i>
                    </div>
                    <div class='alert--content'>
                        Ha ocurrudio un error. Por favor diríjase a la página anterior <a href='../'>Haciendo click aquí</a>
                    </div>
                </div>";
                echo $html;
            }
        break;

        case "updateCliente":
            $documento = $_GET['id'];
            $id_user = $_GET['user'];
            $consCVET->updateCliente($documento, $_POST['documento_cliente'], $_POST['nombre_cliente'], $_POST['apellido_cliente'], $_POST['telefono_cliente'], $id_user);
            
             return '';
            
        break;

        
        case "vehiculo":
            $html="";

            $datos = $consCVET->getVehiculo();
            
            //Creación de la respuesta a la vista.
            if(is_array($datos) and count($datos)>0){
                $html.="
                <div class='contenedor_resultado_consultas'>
                <div class='contenedor-main_barra-busqueda_cvet'>
                    <label class='contenedor-main_barra-busqueda__label-busqueda_usuario'><i class='fas fa-search'></i></label>
                    <input class='contenedor-main_barra-busqueda__search_texto' type='text' id='search_vehiculo' name='search_cliente' placeholder='Buscar un vehículo...'>
                </div>
                <div id='contenedor_tabla-general'>
                <div class='table-responsive'>
                    <table class='contenedor-table__table'>
                        <thead class='contenedor-table__thead'>
                            <tr class='contenedor-table__tr--principal'>
                                <th>PLACA</th>
                                <th>COLOR</th>
                                <th>MODELO</th>
                                <th>TAMAÑO</th>
                                <th>TIPO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody class='contenedor-table__tbody'>";
                
                foreach($datos as $row){
                    $html.="
                                    <tr>
                                        <td>$row[Placa]</td>
                                        <td>$row[Color_vehiculo]</td>
                                        <td>$row[Modelo_vehiculo]</td>
                                        <td>$row[Tamano_vehiculo]</td>
                                        <td>$row[Tipo_vehiculo]</td>
                                        <td>
                                            <a href='#' onclick='deleteVehiculo(\"$row[Placa]\")' id='$row[Placa]'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar Vehiculo'></i></a>
                                            <a href='#' onclick='updateVehiculo(\"$row[Placa]\")' id='$row[Placa]'><i id='edit' class='far fa-edit icon_tabla' title='Editar Vehiculo'></i></a>
                                        </td>
                                    </tr>";
                }
                
                $html.="
                    </tbody>
                    </table>
                    </div>
                    </div>
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
                        ¡Oops! Al parecer aún no hay registros de vehículos.
                    </div>
                </div>";
                echo $html;
            }
        break;

        case "consultaVehiculo":
            $search = $_GET['search'];
            $html="";

            $datos_cons = $consCVET->getVehiculoLike($search);
            
            //Creación de la respuesta a la vista.
            if(is_array($datos_cons) and count($datos_cons)>0){
                $html.="
                <div class='table-responsive'>
                    <table class='contenedor-table__table'>
                        <thead class='contenedor-table__thead'>
                            <tr class='contenedor-table__tr--principal'>
                                <th>PLACA</th>
                                <th>COLOR</th>
                                <th>MODELO</th>
                                <th>TAMAÑO</th>
                                <th>TIPO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody class='contenedor-table__tbody'>";
                
                foreach($datos_cons as $row){
                    $html.="
                                    <tr>
                                        <td>$row[Placa]</td>
                                        <td>$row[Color_vehiculo]</td>
                                        <td>$row[Modelo_vehiculo]</td>
                                        <td>$row[Tamano_vehiculo]</td>
                                        <td>$row[Tipo_vehiculo]</td>
                                        <td>
                                            <a href='#' onclick='deleteVehiculo(\"$row[Placa]\")' id='$row[Placa]'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar Vehiculo'></i></a>
                                            <a href='#' onclick='updateVehiculo(\"$row[Placa]\")' id='$row[Placa]'><i id='edit' class='far fa-edit icon_tabla' title='Editar Vehiculo'></i></a>
                                        </td>
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
                        Ningún vehículo coincide con &#39;<b>$search</b>&#39;&#46; Intente ingresar una búsqueda más acertada.
                    </div>
                </div>";
                echo $html;
            }
        break;

        case "deleteVehiculo":
            $placa = $_GET['placa'];
            $user_active = $_GET['user_active'];

            $consCVET->deleteVehiculo($placa, $user_active);
        break;

        case "showEditarVehiculo":
            $placa = $_GET['placa'];
            $html="";
            $datos = $consCVET->getVehiculo_x_id($placa);
            
            if(is_array($datos) and count($datos)>0){
                $html.="
                <div class='container_edit'>
                    <div class='content-form_edit'>
                        <form method='post' id='form_editar' class='formulario'>
                            <fieldset class='fieldset'><legend class='legend-principal'>Datos vehículo</legend>
                                <div class='contenido-cliente'>";
                
                foreach($datos as $row){
                    $html.="
                                    <div class='input-contenedor-edit'>
                                        <i class='fas fa-id-card icon_formularios_registro'></i>
                                        <input type='text' class='input_registrar' name='placa' id='placa' placeholder='Placa *' value='$row[Placa]' required>
                                    </div>
                                    <div class='input-contenedor-edit'>
                                        <i class='fas fa-palette icon_formularios_registro'></i>
                                        <input type='text' class='input_registrar' name='color_vehiculo' id='color_vehiculo' placeholder='Color' value='$row[Color_vehiculo]'>
                                    </div>
                                    <div class='input-contenedor-edit'>
                                        <i class='fas fa-car icon_formularios_registro'></i>
                                        <input type='text' class='input_registrar' name='modelo_vehiculo' id='modelo_vehiculo' placeholder='Modelo *' value='$row[Modelo_vehiculo]'>
                                    </div>
                                    <fieldset class='fieldset second'><legend>Tamaño vehículo</legend>
                                    <div class='input-contenedor contenedor_secundario'>
                                        <i class='fas fa-car-side icon_formularios_registro'></i>
                                        <select class='controls' name='tamano_vehiculo' id='tamano_vehiculo' required>
                                            <option value='$row[Tamano_vehiculo]' selected='true'>$row[Tamano_vehiculo]</option>";
                                            if($row['Tamano_vehiculo'] != 'Grande'):
                                                $html.="<option value='Grande'>Grande</option>";
                                            endif;
                                            if($row['Tamano_vehiculo'] != 'Mediano'):
                                                $html.="<option value='Mediano'>Mediano</option>";
                                            endif;
                                            if($row['Tamano_vehiculo'] != 'Pequeño'):
                                                $html.="<option value='Pequeño'>Pequeño</option>";
                                            endif;
                                $html.="</select>
                                    </div>
                                </fieldset >
                                <fieldset class='fieldset second'><legend>Tipo vehículo</legend>
                                    <div class='input-contenedor contenedor_secundario'>
                                        <i class='fas fa-car-side icon_formularios_registro'></i>
                                         <select class='controls' name='tipo_vehiculo' id='tipo_vehiculo' required>
                                            <option value='$row[Tipo_vehiculo]' selected='true'>$row[Tipo_vehiculo]</option>";
                                            if($row['Tipo_vehiculo'] != 'Bicicleta'):
                                                $html.="<option value='Bicicleta'>Bicicleta</option>";
                                            endif;
                                            if($row['Tipo_vehiculo'] != 'Moto'):
                                            $html.="<option value='Moto'>Moto</option>";
                                            endif;
                                            if($row['Tipo_vehiculo'] != 'Carro'):
                                            $html.="<option value='Carro'>Carro</option>";
                                            endif;
                            $html.="    </select>
                                    </div>
                                </fieldset>";
                }
                
                $html.="
                                    <div class='button-contenedor'>
                                        <input class='button reset' type='reset' name='btn-limpiar' value='Limpiar'>
                                        <button type='submit' name='action' value='add' id='button_action' class='button'>Registrar</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>'";
                //Finalmente se escribe o retorna lo que hemos almacenado en la variable $html
                echo $html;
            }else{
                $html.="
                <div class='alert alert_danger alert_sm' id='contenedor-alerta-reportes_venta' style='animation-delay: .2s;margin:0 auto;'>
                    <div class='alert--icon'>
                        <i class='fas fa-bell'></i>
                    </div>
                    <div class='alert--content'>
                        Ha ocurrudio un error. Por favor diríjase a la página anterior <a href='../'>Haciendo click aquí</a>
                    </div>
                </div>";
                echo $html;
            }
        break;

        case "updateVehiculo":
            $placa = $_GET['id'];
            $id_user = $_GET['user'];
            $consCVET->updateVehiculo($placa, $_POST['placa'], $_POST['color_vehiculo'], $_POST['modelo_vehiculo'], $_POST['tamano_vehiculo'], $_POST['tipo_vehiculo'], $id_user);
            
             return '';
            
        break;

        case "estacionamiento":
            $html="";

            $datos = $consCVET->getEstacionamiento();
            
            //Creación de la respuesta a la vista.
            if(is_array($datos) and count($datos)>0){
                $html.="
                <div class='contenedor_resultado_consultas'>
                    <div class='contenedor-main_barra-busqueda_cvet'>
                        <label class='contenedor-main_barra-busqueda__label-busqueda'>Búsqueda <i class='fas fa-search'></i></label>
                        <label class='contenedor-main_barra-busqueda__label' for='desde'> Desde:</label>
                        <input class='contenedor-main_barra-busqueda__search' type='date' id='desde'>
                        <label class='contenedor-main_barra-busqueda__label' for='hasta'>Hasta:</label>
                        <input class='contenedor-main_barra-busqueda__search' type='date' id='hasta'>
                        <input class='contenedor-main_barra-busqueda__button' type='submit' value='Consultar' id='consultar_estacionamientos'>
                    </div>
                    <div id='contenedor_tabla-general'>
                        <div class='table-responsive'>
                            <table class='contenedor-table__table'>
                                <thead class='contenedor-table__thead'>
                                    <tr class='contenedor-table__tr--principal'>
                                        <th>No.</th>
                                        <th>Placa</th>
                                        <th>Documento</th>
                                        <th>Nombres</th>
                                        <th>Estado</th>
                                        <th>Descripción</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class='contenedor-table__tbody'>";
                    
                foreach($datos as $row){
                    $html.="
                                    <tr>
                                        <td>$row[Num_estacionamiento]</td>
                                        <td>$row[id_vehiculo]</td>
                                        <td>$row[id_cliente]</td>
                                        <td>$row[Nombre]<br>$row[Apellido]</td>
                                        <td>$row[Estado_estacionamiento]</td>
                                        <td>$row[esta_descripcion]</td>
                                        <td>
                                            <a href='#' onclick='deleteEstacionamiento($row[id_estacionamiento])' id='$row[id_estacionamiento]'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar Estacionamiento'></i></a>
                                            <a href='#' onclick='updateEstacionamiento($row[id_estacionamiento])' id='$row[id_estacionamiento]'><i id='edit' class='far fa-edit icon_tabla' title='Editar Estacionamiento'></i></a>
                                        </td>
                                    </tr>";
                }
                
                $html.="
                    </tbody>
                    </table>
                    </div>
                    </div>
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
                        ¡Oops! Al parecer aún no hay registros de estacionamientos.
                    </div>
                </div>";
                echo $html;
            }
        break;

        case "consultaEstacionamiento":
            $desde = $_GET['desde'];
            $hasta = $_GET['hasta'];
            $html="";

            $datos_cons = $consCVET->getEstacionamientoLike($desde, $hasta);
            
            //Creación de la respuesta a la vista.
            if(is_array($datos_cons) and count($datos_cons)>0){
                $html.="
                <div class='alert alert_success alert_sm' id='contenedor-alerta-reportes_venta' style='animation-delay: .2s;margin:0 auto;margin-bottom:10px'>
                    <div class='alert--icon'>
                        <i class='fas fa-bell'></i>
                    </div>
                    <div class='alert--content'>
                        Mostrando registros desde <b>$desde</b> hasta <b>$hasta</b>
                    </div>
                </div>
                <div class='table-responsive'>
                    <table class='contenedor-table__table'>
                        <thead class='contenedor-table__thead'>
                            <tr class='contenedor-table__tr--principal'>
                                <th>No.</th>
                                <th>Placa</th>
                                <th>Documento</th>
                                <th>Nombres</th>
                                <th>Estado</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class='contenedor-table__tbody'>";
                
                foreach($datos_cons as $row){
                    $html.="
                                    <tr>
                                        <td>$row[Num_estacionamiento]</td>
                                        <td>$row[id_vehiculo]</td>
                                        <td>$row[id_cliente]</td>
                                        <td>$row[Nombre]<br>$row[Apellido]</td>
                                        <td>$row[Estado_estacionamiento]</td>
                                        <td>$row[esta_descripcion]</td>
                                        <td>
                                            <a href='#' onclick='deleteEstacionamiento($row[id_estacionamiento])' id='$row[id_estacionamiento]'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar Estacionamiento'></i></a>
                                            <a href='#' onclick='updateEstacionamiento($row[id_estacionamiento])' id='$row[id_estacionamiento]'><i id='edit' class='far fa-edit icon_tabla' title='Editar Estacionamiento'></i></a>
                                        </td>
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
                        Ningún estacionamiento coincide con su criterio de búsqueda.; Intente ingresar una <b>fecha</b> más acertada.
                    </div>
                </div>";
                echo $html;
            }
        break;

        case "deleteEstacionamiento":
            $id = $_GET['id'];
            $user_active = $_GET['user_active'];

            $consCVET->deleteEstacionamiento($id, $user_active);
        break;

        case "showEditarEstacionamiento":
            $id = $_GET['id'];
            $html="";
            // Traer clientes sin condiciones, para actualizar estacionamiento
            function getClientes($id){
                $cliente =  new ConsCVET();
                $clientes = $cliente->getClienteWhitoutLimit();
                $clientesHTML = '';
                foreach($clientes as $row){
                    if($row['Documento'] != $id){
                        $clientesHTML .= "<option value=$row[Documento]>$row[Documento]</option>";
                    }
                }

                return $clientesHTML;
            }

            // Traer vehículos sin condiciones, para actualizar estacionamiento
            function getVehiculos($placa){
                $vehiculo =  new ConsCVET();
                $vehiculos = $vehiculo->getVehiculoWhitoutLimit();
                $vehiculosHTML = '';
                foreach($vehiculos as $row){
                    if($row['Placa'] != $placa){
                        $vehiculosHTML .= "<option value=$row[Placa]>$row[Placa]</option>";
                    }
                }

                return $vehiculosHTML;
            }

            $datos = $consCVET->getEstacionamiento_x_id($id);
            
            if(is_array($datos) and count($datos)>0){
                $html.="
                <div class='container_edit'>
                    <div class='content-form_edit'>
                        <form method='post' id='form_editar' class='formulario' style='margin-bottom:350px'>
                            <fieldset class='fieldset'><legend class='legend-principal'>Datos estacionamiento</legend>
                                <div class='contenido-cliente'>";
                
                foreach($datos as $row){
                    $html.="
                                    <div class='input-contenedor-edit'>
                                        <i class='fas fa-id-card icon_formularios_registro'></i>
                                        <input type='text' title='Número de estacionamiento' class='input_registrar' name='Num_estacionamiento' id='Num_estacionamiento' placeholder='Num estacionamiento *' value='$row[Num_estacionamiento]' required>
                                    </div>
                                    <fieldset class='fieldset second'><legend>Vehículo</legend>
                                        <div class='input-contenedor contenedor_secundario'>
                                            <i class='fas fa-car-side icon_formularios_registro'></i>
                                            <select class='controls' name='placa' id='placa' required>
                                                <option value='$row[id_vehiculo]' selected='true'>$row[id_vehiculo]</option>";
                                                $html.=getVehiculos($row['id_vehiculo']);
                            $html.="        </select>
                                        </div>
                                    </fieldset >
                                    <fieldset class='fieldset second'><legend>Cliente</legend>
                                        <div class='input-contenedor contenedor_secundario'>
                                            <i class='fas fa-user icon_formularios_registro'></i>
                                            <select class='controls' name='cliente' id='cliente' required>
                                                <option value='$row[id_cliente]' selected='true'>$row[id_cliente]</option>";
                                                $html.=getClientes($row['id_cliente']);
                            $html.="        </select>
                                        </div>
                                    </fieldset >
                                    <fieldset class='fieldset second' style='width:100%'><legend>Estado</legend>
                                        <div class='input-contenedor contenedor_secundario'>
                                            <i class='fas fa-car-side icon_formularios_registro'></i>
                                            <select class='controls' name='Estado_estacionamiento' id='Estado_estacionamiento' required>
                                                <option value='$row[Estado_estacionamiento]' selected='true'>$row[Estado_estacionamiento]</option>";
                                                if($row['Estado_estacionamiento'] != 'Activo'):
                                                    $html.="<option value='Activo'>Activo</option>";
                                                endif;
                                                if($row['Estado_estacionamiento'] != 'Terminado'):
                                                    $html.="<option value='Terminado'>Terminado</option>";
                                                endif;
                            $html.="        </select>
                                        </div>
                                </fieldset >
                                <fieldset class='fieldset fieldset_textarea'><legend>Descripción/Detalles</legend>
                                    <div class='input-contenedor contenedor_textarea'>
                                        <textarea class='textarea_registro' name='descripcion_esta' id='descripcion_esta'>$row[esta_descripcion]</textarea>
                                    </div>
                                </fieldset>";
                }
                
                $html.="
                                    <div class='button-contenedor'>
                                        <input class='button reset' type='reset' name='btn-limpiar' value='Limpiar'>
                                        <button type='submit' name='action' value='add' id='button_action' class='button'>Actualizar</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>'";
                //Finalmente se escribe o retorna lo que hemos almacenado en la variable $html
                echo $html;
            }else{
                $html.="
                <div class='alert alert_danger alert_sm' id='contenedor-alerta-reportes_venta' style='animation-delay: .2s;margin:0 auto;'>
                    <div class='alert--icon'>
                        <i class='fas fa-bell'></i>
                    </div>
                    <div class='alert--content'>
                        Ha ocurrudio un error. Por favor diríjase a la página anterior <a href='../'>Haciendo click aquí</a>
                    </div>
                </div>";
                echo $html;
            }
        break;

        case "updateEstacionamiento":
            $id = $_GET['id'];
            $id_user = $_GET['user'];
            $consCVET->updateEstacionamiento($id, $_POST['Num_estacionamiento'], $_POST['placa'], $_POST['cliente'], $_POST['Estado_estacionamiento'], $_POST['descripcion_esta'], $id_user);
            
             return '';
            
        break;
        
        case "tarifa":
            $html="";

            $datos = $consCVET->getTarifa();
            
            //Creación de la respuesta a la vista.
            if(is_array($datos) and count($datos)>0){
                $html.="
                <div class='contenedor_resultado_consultas'>
                <div class='contenedor-main_barra-busqueda_cvet'>
                    <label class='contenedor-main_barra-busqueda__label-busqueda_usuario'><i class='fas fa-search'></i></label>
                    <input class='contenedor-main_barra-busqueda__search_texto' type='text' id='search_tarifa' name='search_cliente' placeholder='Buscar una tarifa...'>
                </div>
                <div id='contenedor_tabla-general'>
                <div class='table-responsive'>
                    <table class='contenedor-table__table'>
                        <thead class='contenedor-table__thead'>
                            <tr class='contenedor-table__tr--principal'>
                                <th>ID</th>
                                <th>TIPO</th>
                                <th>VALOR</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody class='contenedor-table__tbody'>";
                
                foreach($datos as $row){
                    $html.="
                                    <tr>
                                        <td>$row[id_tarifa]</td>
                                        <td>$row[Tipo_vehiculo]</td>
                                        <td>&#36;$row[Valor_tarifa]</td>
                                        <td>
                                            <a href='#' onclick='deleteTarifa($row[id_tarifa])' id='$row[id_tarifa]'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar Tarifa'></i></a>
                                            <a href='#' onclick='updateTarifa($row[id_tarifa])' id='$row[id_tarifa]'><i id='edit' class='far fa-edit icon_tabla' title='Editar Tarifa'></i></a>
                                        </td>
                                    </tr>";
                }
                
                $html.="
                    </tbody>
                    </table>
                    </div>
                    </div>
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
                        ¡Oops! Al parecer aún no hay registros de tarifas...
                    </div>
                </div>";
                echo $html;
            }
        break;

        case "consultaTarifa":
            $search = $_GET['search'];
            $html="";

            $datos_cons = $consCVET->getTarifaLike($search);
            
            //Creación de la respuesta a la vista.
            if(is_array($datos_cons) and count($datos_cons)>0){
                $html.="
                <div class='table-responsive'>
                    <table class='contenedor-table__table'>
                        <thead class='contenedor-table__thead'>
                            <tr class='contenedor-table__tr--principal'>
                                <th>ID</th>
                                <th>TIPO</th>
                                <th>VALOR</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody class='contenedor-table__tbody'>";
                
                foreach($datos_cons as $row){
                    $html.="
                                    <tr>
                                        <td>$row[id_tarifa]</td>
                                        <td>$row[Tipo_vehiculo]</td>
                                        <td>$row[Valor_tarifa]</td>
                                        <td>
                                            <a href='#' onclick='deleteTarifa($row[id_tarifa])' id='$row[id_tarifa]'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar Tarifa'></i></a>
                                            <a href='#' onclick='updateTarifa($row[id_tarifa])' id='$row[id_tarifa]'><i id='edit' class='far fa-edit icon_tabla' title='Editar Tarifa'></i></a>
                                        </td>
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
                        Ninguna tarifa coincide con &#39;<b>$search</b>&#39;&#46; Intente ingresar una búsqueda más acertada.
                    </div>
                </div>";
                echo $html;
            }
        break;

        case "deleteTarifa":
            $id = $_GET['id'];
            $user_active = $_GET['user_active'];

            $consCVET->deleteTarifa($id, $user_active);
        break;

        case "showEditarTarifa":
            $id = $_GET['id'];
            $html="";
            $datos = $consCVET->getTarifa_x_id($id);
            
            if(is_array($datos) and count($datos)>0){
                $html.="
                <div class='container_edit'>
                    <div class='content-form_edit'>
                        <form method='post' id='form_editar' class='formulario'>
                            <fieldset class='fieldset'><legend class='legend-principal'>Datos Tarifa</legend>
                                <div class='contenido-cliente'>";
                
                foreach($datos as $row){
                    $html.="        
                                    <div class='input-contenedor-edit'>
                                        <i class='fas fa-id-card icon_formularios_registro'></i>
                                        <input type='text' class='input_registrar' name='id_tarifa' id='id_tarifa' placeholder='Id tarifa *' value='$row[id_tarifa]' required readonly disabled>
                                    </div>
                                    <fieldset class='fieldset second' style='width:100%'><legend>Tipo vehículo</legend>
                                    <div class='input-contenedor contenedor_secundario'>
                                        <i class='fas fa-car-side icon_formularios_registro'></i>
                                        <select class='controls' name='tipo_vehiculo' id='tipo_vehiculo' required>
                                            <option value='$row[Tipo_vehiculo]' selected='true'>$row[Tipo_vehiculo]</option>";
                                            if($row['Tipo_vehiculo'] != 'Carro'):
                                                $html.="<option value='Carro'>Carro</option>";
                                            endif;
                                            if($row['Tipo_vehiculo'] != 'Bicicleta'):
                                                $html.="<option value='Bicicleta'>Bicicleta</option>";
                                            endif;
                                            if($row['Tipo_vehiculo'] != 'Moto'):
                                                $html.="<option value='Moto'>Moto</option>";
                                            endif;
                                $html.="</select>
                                    </div>
                                    </fieldset >
                                    <div class='input-contenedor-edit'>
                                        <i class='fas fa-hand-holding-usd icon_formularios_registro'></i>
                                        <input type='number' class='input_registrar' name='valor_tarifa' id='valor_tarifa' placeholder='Valor tarifa' value='$row[Valor_tarifa]'>
                                    </div>";
                }
                
                $html.="
                                    <div class='button-contenedor'>
                                        <input class='button reset' type='reset' name='btn-limpiar' value='Limpiar'>
                                        <button type='submit' name='action' value='add' id='button_action' class='button'>Registrar</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>'";
                //Finalmente se escribe o retorna lo que hemos almacenado en la variable $html
                echo $html;
            }else{
                $html.="
                <div class='alert alert_danger alert_sm' id='contenedor-alerta-reportes_venta' style='animation-delay: .2s;margin:0 auto;'>
                    <div class='alert--icon'>
                        <i class='fas fa-bell'></i>
                    </div>
                    <div class='alert--content'>
                        Ha ocurrudio un error. Por favor diríjase a la página anterior <a href='../'>Haciendo click aquí</a>
                    </div>
                </div>";
                echo $html;
            }
        break;

        case "updateTarifa":
            $id = $_GET['id'];
            $id_user = $_GET['user'];
            $consCVET->updateTarifa($id, $_POST['tipo_vehiculo'], $_POST['valor_tarifa'], $id_user);
            
             return '';
            
        break;

        //Peticiones con rol de cajero

        case "clienteCajero":
            $html="";

            $datos = $consCVET->getCliente();
            
            //Creación de la respuesta a la vista.
            if(is_array($datos) and count($datos)>0){
                $html.="
                <div class='contenedor_resultado_consultas'>
                <div id='contenedor_tabla-general'>
                <div class='table-responsive'>
                    <table class='contenedor-table__table'>
                        <thead class='contenedor-table__thead'>
                            <tr class='contenedor-table__tr--principal'>
                                <th>DOCUMENTO</th>
                                <th>NOMBRE</th>
                                <th>APELLIDO</th>
                                <th>TELEFONO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody class='contenedor-table__tbody'>";
                
                foreach($datos as $row){
                    $html.="
                                    <tr>
                                        <td>$row[Documento]</td>
                                        <td>$row[Nombre]</td>
                                        <td>$row[Apellido]</td>
                                        <td>$row[Telefono]</td>
                                        <td>
                                            <a href='#' onclick='deleteCliente($row[Documento])' id='$row[Documento]'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar cliente'></i></a>
                                            <a href='#' onclick='updateCliente($row[Documento])' id='$row[Documento]'><i id='edit' class='far fa-edit icon_tabla' title='Editar cliente'></i></a>
                                        </td>
                                    </tr>";
                }
                
                $html.="
                    </tbody>
                    </table>
                    </div>
                    </div>
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
                        ¡Oops! Al parecer aún no hay registros de clientes.
                    </div>
                </div>";
                echo $html;
            }
        break;

        case "vehiculoCajero":
                $html="";

                $datos = $consCVET->getVehiculo();
                
                //Creación de la respuesta a la vista.
                if(is_array($datos) and count($datos)>0){
                    $html.="
                    <div class='contenedor_resultado_consultas'>
                    <div id='contenedor_tabla-general'>
                    <div class='table-responsive'>
                        <table class='contenedor-table__table'>
                            <thead class='contenedor-table__thead'>
                                <tr class='contenedor-table__tr--principal'>
                                    <th>PLACA</th>
                                    <th>COLOR</th>
                                    <th>MODELO</th>
                                    <th>TAMAÑO</th>
                                    <th>TIPO</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody class='contenedor-table__tbody'>";
                    
                    foreach($datos as $row){
                        $html.="
                                        <tr>
                                            <td>$row[Placa]</td>
                                            <td>$row[Color_vehiculo]</td>
                                            <td>$row[Modelo_vehiculo]</td>
                                            <td>$row[Tamano_vehiculo]</td>
                                            <td>$row[Tipo_vehiculo]</td>
                                            <td>
                                                <a href='#' onclick='deleteVehiculo(\"$row[Placa]\")' id='$row[Placa]'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar Vehiculo'></i></a>
                                                <a href='#' onclick='updateVehiculo(\"$row[Placa]\")' id='$row[Placa]'><i id='edit' class='far fa-edit icon_tabla' title='Editar Vehiculo'></i></a>
                                            </td>
                                        </tr>";
                    }
                    
                    $html.="
                        </tbody>
                        </table>
                        </div>
                        </div>
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
                            ¡Oops! Al parecer aún no hay registros de vehículos.
                        </div>
                    </div>";
                    echo $html;
                }
        break;

        case "tarifaCajero":
            $html="";

            $datos = $consCVET->getTarifa();
            
            //Creación de la respuesta a la vista.
            if(is_array($datos) and count($datos)>0){
                $html.="
                <div class='alert alert_success alert_sm' id='contenedor-alerta-reportes_venta' style='animation-delay: .2s;margin:20px auto;'>
                    <div class='alert--icon'>
                        <i class='fas fa-bell'></i>
                    </div>
                    <div class='alert--content'>
                        Mostrando <b>tarifas</b> disponibles.
                    </div>
                </div>";

                $html.="
                <div class='contenedor_resultado_consultas'>
                <div id='contenedor_tabla-general'>
                <div class='table-responsive'>
                    <table class='contenedor-table__table'>
                        <thead class='contenedor-table__thead'>
                            <tr class='contenedor-table__tr--principal'>
                                <th>ID</th>
                                <th>TIPO</th>
                                <th>VALOR</th>
                            </tr>
                        </thead>
                        <tbody class='contenedor-table__tbody'>";
                
                foreach($datos as $row){
                    $html.="
                                    <tr>
                                        <td>$row[id_tarifa]</td>
                                        <td>$row[Tipo_vehiculo]</td>
                                        <td>&#36;$row[Valor_tarifa]</td>
                                    </tr>";
                }
                
                $html.="
                    </tbody>
                    </table>
                    </div>
                    </div>
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
                        ¡Oops! Al parecer aún no hay registros de tarifas...
                    </div>
                </div>";
                echo $html;
            }
        break;

        case "bahiasActivas":
            $html="";

            $datos = $consCVET->getBahiaActiva();
            
            //Creación de la respuesta a la vista.
            if(is_array($datos) and count($datos)>0){
                $html.="
                <div class='alert alert_success alert_sm' id='contenedor-alerta-reportes_venta' style='animation-delay: .2s;margin:20px auto;'>
                    <div class='alert--icon'>
                        <i class='fas fa-bell'></i>
                    </div>
                    <div class='alert--content'>
                        Mostrando <b>bahías</b> activas.
                    </div>
                </div>";

                $html.="
                <div class='contenedor_resultado_consultas'>
                <div id='contenedor_tabla-general'>
                <div class='table-responsive'>
                    <table class='contenedor-table__table'>
                        <thead class='contenedor-table__thead'>
                            <tr class='contenedor-table__tr--principal'>
                                <th style='width:50px;height:20px'>ID</th>
                                <th>No. BAHÍA</th>
                                <th>VEHÍCULO</th>
                                <th>CLIENTE</th>
                                <th>ESTADO</th>
                                <th>DESCRIPCION</th>
                                <th>ENTRADA</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class='contenedor-table__tbody'>";
                
                foreach($datos as $row){
                    $fecha = $row['fecha_creacion'];
                    $entradaFecha = date_create($fecha);
                    $entradaFecha = date_format($entradaFecha, 'd-M-Y');
                    $html.="
                                    <tr>
                                        <td>$row[id_estacionamiento]</td>
                                        <td>$row[Num_estacionamiento]</td>
                                        <td>$row[id_vehiculo]</td>
                                        <td>$row[id_cliente]</td>
                                        <td>$row[Estado_estacionamiento]</td>
                                        <td>$row[esta_descripcion]</td>
                                        <td>$entradaFecha <br> $row[hora_creacion]</td>
                                        <td>
                                            <a onclick='retirarBahia($row[id_estacionamiento], $row[Id_ticket_entrada])' href='#' id='retirarBahia'><i id='' class='fas fa-sign-in-alt icon_tabla' title='Retirar bahía'></i></a>
                                        </td>
                                    </tr>";
                }
                
                $html.="
                    </tbody>
                    </table>
                    </div>
                    </div>
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
                        ¡Oops! Al parecer aún no hay registros de tarifas...
                    </div>
                </div>";
                echo $html;
            }
        break;

        case "retirarBahia": 
            $id = $_GET['id'];
            $id_entrada = $_GET['id_entrada'];
            $user_active = $_GET['user_active']; //Usuario que realiza los movimientos
            
            //Retirar la bahía de los estacionamientos activos.
            $consCVET->retirarBahia($id, $id_entrada, $user_active);

            $ticket = new Ticket();
            $ticketSalida = $ticket->getTicketSalida_x_id($id_entrada);
            foreach($ticketSalida as $row){
                $id_ticket_salida = $row['Id_ticket'];
            }

            $terminarTicket = new Ticket();
            $terminarTicket->terminarTicketS($id_ticket_salida, $user_active);
            
        break;
    }
?>