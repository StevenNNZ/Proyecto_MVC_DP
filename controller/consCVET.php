<?php 
    require_once("../config/conexion.php");
    require_once("../models/ConsCVET.php");

    // Instancia clase Consultas CVET (Clientes, Vehiculos, Estacionamientos, Tarifas)
    $reportesVenta = new ConsCVET();

    switch($_GET["op"]){
        case "cliente":
            $html="";

            $datos = $reportesVenta->getCliente();
            
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
                                            <a href='#'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar cliente'></i></a>
                                            <a href='#'><i id='edit' class='far fa-edit icon_tabla' title='Editar cliente'></i></a>
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

        case "consultaCliente":
            $search = $_GET['search'];
            $html="";

            $datos_cons = $reportesVenta->getClienteLike($search);
            
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
                                            <a href='#'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar cliente'></i></a>
                                            <a href='#'><i id='edit' class='far fa-edit icon_tabla' title='Editar cliente'></i></a>
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
        
        case "vehiculo":
            $html="";

            $datos = $reportesVenta->getVehiculo();
            
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
                                            <a href='#'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar vehículo'></i></a>
                                            <a href='#'><i id='edit' class='far fa-edit icon_tabla' title='Editar vehículo'></i></a>
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

            $datos_cons = $reportesVenta->getVehiculoLike($search);
            
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
                                            <a href='#'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar Usuario'></i></a>
                                            <a href='#'><i id='edit' class='far fa-edit icon_tabla' title='Editar Usuario'></i></a>
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

        case "estacionamiento":
            $html="";

            $datos = $reportesVenta->getEstacionamiento();
            
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
                                            <a href='#'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar vehículo'></i></a>
                                            <a href='#'><i id='edit' class='far fa-edit icon_tabla' title='Editar vehículo'></i></a>
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

            $datos_cons = $reportesVenta->getEstacionamientoLike($desde, $hasta);
            
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
                                            <a href='#'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar Usuario'></i></a>
                                            <a href='#'><i id='edit' class='far fa-edit icon_tabla' title='Editar Usuario'></i></a>
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

        case "tarifa":
            $html="";

            $datos = $reportesVenta->getTarifa();
            
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
                                            <a href='#'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar cliente'></i></a>
                                            <a href='#'><i id='edit' class='far fa-edit icon_tabla' title='Editar cliente'></i></a>
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

            $datos_cons = $reportesVenta->getTarifaLike($search);
            
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
                                            <a href='#'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar Usuario'></i></a>
                                            <a href='#'><i id='edit' class='far fa-edit icon_tabla' title='Editar Usuario'></i></a>
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

        //Peticiones con rol de cajero

        case "clienteCajero":
            $html="";

            $datos = $reportesVenta->getCliente();
            
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
                                            <a href='#'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar cliente'></i></a>
                                            <a href='#'><i id='edit' class='far fa-edit icon_tabla' title='Editar cliente'></i></a>
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

                $datos = $reportesVenta->getVehiculo();
                
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
                                                <a href='#'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar vehículo'></i></a>
                                                <a href='#'><i id='edit' class='far fa-edit icon_tabla' title='Editar vehículo'></i></a>
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

            $datos = $reportesVenta->getTarifa();
            
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

            $datos = $reportesVenta->getBahiaActiva();
            
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
                    $html.="
                                    <tr>
                                        <td>$row[id_estacionamiento]</td>
                                        <td>$row[Num_estacionamiento]</td>
                                        <td>$row[id_vehiculo]</td>
                                        <td>$row[id_cliente]</td>
                                        <td>$row[Estado_estacionamiento]</td>
                                        <td>$row[esta_descripcion]</td>
                                        <td>$row[hora_creacion]</td>
                                        <td>
                                            <a href='#'><i id='delete' class='fas fa-sign-in-alt icon_tabla' title='Retirar bahía'></i></a>
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

    }
?>