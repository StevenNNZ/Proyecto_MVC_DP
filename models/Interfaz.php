<?php 
    require_once 'Vehiculo.php';
    require_once 'Cliente.php';

    class Interfaz{
        //Crea el html de las alertas. Recibe el mensaje de error y la clase de la alerta.
        public function getAlert($mensaje, $type_alert){
            $alert = "
            <div class='alert $type_alert alert_sm' id='contenedor-alerta' style='animation-delay: .2s;margin:0 auto; margin-bottom:20px'>
                    <div class='alert--icon'>
                        <i class='fas fa-bell'></i>
                    </div>
                    <div class='alert--content'>
                        $mensaje
                    </div>
            </div>";

            return $alert;
        }

        //Crea el html de la cabecera de la tabla. Recibe un arreglo con los elementos que se agregarán a la cabecera.
        private function createTableHead($cabecera, $tipo){
            switch($tipo){
                case 'reporte_venta': 
                    $class = 'tabla_reporte-ventas';
                break;
                case 'usuarios':
                    $class = 'tabla_gestion-usuarios';
                    
                    break;
                default: 
                    $class = 'tabla_reporte-ventas';
            }
            
            $head="<thead class='contenedor-table__thead'> <tr class='contenedor-table__tr--principal $class'>";

            foreach($cabecera as $campo){
                $head.="<th>$campo</th>";
            }

            $head.="</tr></thead>";

            return $head;
        }

        //Crea el html del cuerpo de la tabla. Recibe un arreglo con los elementos que se agregarán al tbody, también recibe las llaves que se van a iterar dentro del arreglo. Y opcional, un arreglo de tipo de tabla para agregar cosas adicionales dependiendo del tipo de tabla ['tipo_tabla', 'adicional'];
        private function createTableBody($cuerpo, $keys, $tipo_tabla, $eliminar=true){
            $body='<tbody class="contenedor-table__tbody">';

            //Validar tipo de tabla
            switch ($tipo_tabla[0]){
                //Cuerpo de la tabla reporte de ventas
                case 'reporte_venta':

                    floatval($totalPagos = 0);

                    foreach($cuerpo as $campo){
                        $totalPagos+= $campo['Pago_total'];
                        $body.='<tr>';

                        foreach($keys as $key){
                            if($campo[$key] == $campo['Pago_total']){
                                //Formatear el campo de valor
                                $body .= "<td>$".number_format($campo['Pago_total'])."</td>";
                            }else{
                                $body .= "<td>$campo[$key]</td>";
                            }
                        }
    
                        $body.='</tr>';
                    }
                
                    $body.="<tr>
                                <td class='total_pagos' colspan='8'>Totales consulta</td>
                                <td class='sumatoria_total_pagos'>$".number_format($totalPagos)."</td>
                            </tr>";
                break;
                
                //Cuerpo de la tabla usuarios
                case 'usuarios':
                    foreach($cuerpo as $campo){
                        $body.='<tr>';

                        foreach($keys as $key){
                            $body .= "<td>$campo[$key]</td>";
                        }

                        $body .= $this->buttons($campo, $tipo_tabla[1]);
                        $body .='</tr>';
                    }
                   
                break;

                //Cuerpo de la tabla Clientes Vehículos Estacionamientos Tarifas
                case 'CVET': 
                    foreach($cuerpo as $campo){
                        $body.='<tr>';

                        foreach($keys as $key){
                            $body .= "<td>$campo[$key]</td>";
                        }
                        $body .= $this->buttons($campo, $tipo_tabla[1], $eliminar);
                        $body .='</tr>';
                    }
                break;

                //Cuerpo de la tabla ticket
                case 'ticket':
                    foreach($cuerpo as $campo){
                        $body.='<tr>';

                        foreach($keys as $key){
                            $body .= "<td>$campo[$key]</td>";
                        }

                        $body .= $this->buttons($campo, $tipo_tabla[1]);
                        $body .='</tr>';
                    }
                   
                break;

                case 'bahia-activa': 
                    foreach($cuerpo as $campo){
                        $body.='<tr>';

                        foreach($keys as $key){

                            if($campo[$key] == $campo['fecha_creacion']){
                                $body .= "<td>".$this->formatearFecha($campo[$key])." $campo[hora_creacion]</td>";
                            }else{
                                $body .= "<td>$campo[$key]</td>";
                            }

                        }
                        $body .= $this->buttons($campo, $tipo_tabla[1], $eliminar);
                        $body .='</tr>';
                    }
                    break;
                
                default:
                break;
            }

            $body .= '</tbody>';

            return $body;
        }

        //Crear la tabla completa
        public function createTable($cabecera, $cuerpo, $keys, $tipo_tabla = ['',''], $op1 ='', $eliminar=true){

            $table = "
            <div class='contenedor_resultado_consultas' style='text-align:right'>
                $op1
                <div id='contenedor_tabla-general'>
                    <div class='table-responsive'>
                        <table class='contenedor-table__table'>";
            $table.= $this->createTableHead($cabecera, $tipo_tabla[0]);
            $table.= $this->createTableBody($cuerpo, $keys, $tipo_tabla, $eliminar);

            $table.="
                        </table>
                    </div>
                </div>
            </div>";

            return $table;
        }

        public function createTableQuery($cabecera, $cuerpo, $keys, $tipo_tabla = ['',''], $op1 ='', $eliminar=true
        ){

            $table = "$op1
            <div id='contenedor_tabla-general'>
                <div class='table-responsive'>
                    <table class='contenedor-table__table'>";
            $table.= $this->createTableHead($cabecera, $tipo_tabla);
            $table.= $this->createTableBody($cuerpo, $keys, $tipo_tabla, $eliminar);

            $table.="
                    </table>
                </div>
            </div>";

            return $table;
        }

        //botones de eliminar, actualizar y desactivar/activar usuarios
        private function buttons($row, $tipo, $eliminar=true){
            switch($tipo){
                case 'users':
                    $html ="
                    <td>
                        <a href='#' onclick='deleteUser($row[documento])' id='$row[documento]'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar Usuario'></i></a>";

                        if( $row['estado_usuario'] == 'Activo' ){
                            $html.="<a href='#' onclick='desactivarUsuario($row[documento])' id='$row[documento]'><i id='bloquear' class='fas fa-user-alt-slash icon_tabla' title='Desactivar Usuario'></i></a>";
                        }else{
                            $html.="<a href='#' onclick='activarUsuario($row[documento])' id='$row[documento]'><i id='activar' class='fas fa-user-check icon_tabla' title='Activar usuario'></i></a>";
                        }

                        $html.="<a href='#' onclick='updateUser($row[documento], \"$row[estado_usuario]\")' id='$row[documento]'><i id='edit' class='far fa-edit icon_tabla' title='Editar Usuario'></i></a>
                    </td>";
                    break;
                case 'clients':
                    $html ="
                        <td>";
                    if ($eliminar):
                    $html .= "<a href='#' onclick='deleteCliente($row[Documento])' id='$row[Documento]'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar cliente'></i></a>";
                    endif;

                    $html .= "<a href='#' onclick='updateCliente($row[Documento])' id='$row[Documento]'><i id='edit' class='far fa-edit icon_tabla' title='Editar cliente'></i></a>
                        </td>";
                    break;
                case 'vehicle':
                    $html ="
                        <td>";
                            
                    if($eliminar):

                    $html .= "<a href='#' onclick='deleteVehiculo(\"$row[Placa]\")' id='$row[Placa]'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar Vehiculo'></i></a>";
                    endif;

                    $html.="<a href='#' onclick='updateVehiculo(\"$row[Placa]\")' id='$row[Placa]'><i id='edit' class='far fa-edit icon_tabla' title='Editar Vehiculo'></i></a>
                        </td>";
                    break;
                case 'tarifa': 
                    $html ="
                        <td>";
                            
                    if($eliminar):
                        $html .= "
                            <a href='#' onclick='deleteTarifa($row[id_tarifa])' id='$row[id_tarifa]'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar Tarifa'></i></a>
                            <a href='#' onclick='updateTarifa($row[id_tarifa])' id='$row[id_tarifa]'><i id='edit' class='far fa-edit icon_tabla' title='Editar Tarifa'></i></a>
                        </td>";
                    else: 
                        $html .= "<a class='view_button' title='Sólo lectura'><i class='fas fa-eye icon_cvet'></i></a>";
                    endif;

                    break;
                case 'bahia':
                    $html = "
                        <td>
                            <a href='#' onclick='deleteEstacionamiento($row[id_estacionamiento])' id='$row[id_estacionamiento]'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar Estacionamiento'></i></a>
                            <a href='#' onclick='updateEstacionamiento($row[id_estacionamiento])' id='$row[id_estacionamiento]'><i id='edit' class='far fa-edit icon_tabla' title='Editar Estacionamiento'></i></a>
                        </td>";
                    break;
                case 'bahia-activa': 
                    $html ="
                        <td>
                            <a onclick='retirarBahia($row[id_estacionamiento], $row[Id_ticket_entrada])' href='#' id='retirarBahia'><i id='' class='fas fa-sign-in-alt icon_tabla' title='Retirar bahía'></i></a>
                        </td>";
                    break;
                case 'tarifa':
                    $html = "
                        <td>
                            <a href='#' onclick='deleteTarifa($row[id_tarifa])' id='$row[id_tarifa]'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar Tarifa'></i></a>
                            <a href='#' onclick='updateTarifa($row[id_tarifa])' id='$row[id_tarifa]'><i id='edit' class='far fa-edit icon_tabla' title='Editar Tarifa'></i></a>
                        </td>";
                    break;
                case 'reporteTicket': 
                    $html="
                        <td>
                            <a href='#' onclick='deleteTicket($row[Id_ticket])' id='$row[Id_ticket]'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar ticket'></i></a>";

                            if($row['estado_salida'] == 'Terminado'):
                                $html.="
                                <a href='#' onclick='activarTicketSalida($row[Id_ticket])'><i id='btn-activar' class='fas fa-check-square icon_tabla' title='Activar ticket'></i></a>";
                            endif;

                            $html.="
                            <a href='#' onclick='getTicketSalida($row[Id_ticket])'><i id='btn-ticket' class='fas fa-eye icon_tabla' title='Visualizar ticket'></i></a>
                        </td>";
                    break;

                case 'ticket-entrada':
                    $html = "
                        <td>
                            <a target='_BLANK' href='../viewPDF/pdfTickEntrada?id=$row[Id_ticket_entrada]' onclick='terminarTicketEntrada($row[Id_ticket_entrada])'><i id='print' class='fas fa-print icon' title='Imprimir ticket ingreso'></i></a>
                        </td>";
                    break;
                case 'ticket-salida': 
                    $html = "
                        <td>
                            <a href='#' onclick='getTicketSalida($row[Id_ticket])'><i id='print' class='fas fa-print icon' title='Imprimir ticket salida'></i></a>
                        </td>";
                    break;
                default: 
                    $html = '';
                    break;
            }
    
            return $html;
        }

        //Crear el formulario para editar
        public function createUpdateForm($datos, $titulo, $tipo){
            $form ="<div class='container_edit'>
                        <div class='content-form_edit' style='margin-bottom:225px;'>
                            <form method='post' id='form_editar' class='formulario'>
                                <fieldset class='fieldset'><legend class='legend-principal'>$titulo</legend>
                                    <div class='contenido-$tipo'>";
                                        //Recorrer datos usuario a actualizar
                                        foreach($datos as $row){
                                            $form .= $this->innerForm($row, $tipo);
                                        }
                                        
                                        $form .="
                                        <div class='button-contenedor'>
                                            <input class='button reset' type='reset' name='btn-limpiar' value='Limpiar'>
                                            <button type='submit' name='action' value='add' id='button_action' class='button'>Actualizar</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>";

            return $form;
        }

        // Contenido del formulario (input, label, etc.)
        private function innerForm($row, $tipo){
            switch($tipo){
                case 'usuario':
                    $form ="
                        <div class='input-contenedor-edit'>
                            <i class='fas fa-id-card icon_formularios_registro'></i>
                            <input type='number' class='input_registrar' name='documento_usuario' id='documento_usuario' placeholder='Número documento *' value='$row[documento]' disabled readonly required>
                        </div>
                        <div class='input-contenedor-edit'>
                            <i class='fas fa-user icon_formularios_registro'></i>
                            <input type='text' class='input_registrar' name='nombre_usuario' id='nombre_usuario' placeholder='Nombre *' value='$row[nombre]' required>
                        </div>
                        <div class='input-contenedor-edit'>
                            <i class='far fa-user icon_formularios_registro'></i>
                            <input type='text' class='input_registrar' name='apellido_usuario' id='apellido_usuario' placeholder='Apellido *' value='$row[apellido]' required>
                        </div>
                        <div class='input-contenedor-edit'>
                            <i class='fas fa-envelope icon_formularios_registro'></i>
                            <input type='email' class='input_registrar' name='email_usuario' id='email_usuario' placeholder='E-mail *' value='$row[correo]' required>
                        </div>
                        <fieldset class='fieldset-user second_edit'><legend>Cargo</legend>
                            <div class='input_registro-contenedor'> 
                                <i class='fas fa-briefcase icon-form'></i>
                                <select name='cargo' id='cargo' class='controls_registro_edit' required>
                                    <option value='$row[Cargo]' selected='true'>$row[Cargo]</option>";
                                    if($row['Cargo'] == 'Administrador'){
                                        $form.="<option value='Cajero'>Cajero</option>";
                                    }else{
                                        $form.="<option value='Administrador'>Administrador</option>";
                                    }
                                    $form.="
                                </select>
                            </div>
                        </fieldset>
                        <div class='input-contenedor-edit'>
                            <i class='fas fa-key icon_formularios_registro'></i>
                            <input type='password' class='input_registrar' value='$row[contrasena]' name='contrasena_usuario' id='contrasena_usuario' placeholder='Contraseña  *' min-lenght='8' required>
                        </div>";
                        
                    break;

                case 'cliente': 
                    $form = 
                    "<div class='input-contenedor-edit'>
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
                    break;

                case 'vehiculo':
                    $form = "
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
                                    $form.="<option value='Grande'>Grande</option>";
                                endif;
                                if($row['Tamano_vehiculo'] != 'Mediano'):
                                    $form.="<option value='Mediano'>Mediano</option>";
                                endif;
                                if($row['Tamano_vehiculo'] != 'Pequeño'):
                                    $form.="<option value='Pequeño'>Pequeño</option>";
                                endif;
                    $form.="</select>
                        </div>
                    </fieldset >
                    <fieldset class='fieldset second'><legend>Tipo vehículo</legend>
                        <div class='input-contenedor contenedor_secundario'>
                            <i class='fas fa-car-side icon_formularios_registro'></i>
                            <select class='controls' name='tipo_vehiculo' id='tipo_vehiculo' required>
                                <option value='$row[Tipo_vehiculo]' selected='true'>$row[Tipo_vehiculo]</option>";
                                if($row['Tipo_vehiculo'] != 'Bicicleta'):
                                    $form.="<option value='Bicicleta'>Bicicleta</option>";
                                endif;
                                if($row['Tipo_vehiculo'] != 'Moto'):
                                $form.="<option value='Moto'>Moto</option>";
                                endif;
                                if($row['Tipo_vehiculo'] != 'Carro'):
                                $form.="<option value='Carro'>Carro</option>";
                                endif;
                    $form.="</select>
                        </div>
                    </fieldset>";
                    break;

                case 'bahia':
                    $form = "
                        <div class='input-contenedor-edit'>
                            <i class='fas fa-id-card icon_formularios_registro'></i>
                            <input type='text' title='Número de estacionamiento' class='input_registrar' name='Num_estacionamiento' id='Num_estacionamiento' placeholder='Num estacionamiento *' value='$row[Num_estacionamiento]' required>
                        </div>
                        <fieldset class='fieldset second'><legend>Vehículo</legend>
                            <div class='input-contenedor contenedor_secundario'>
                                <i class='fas fa-car-side icon_formularios_registro'></i>
                                <select class='controls' name='placa' id='placa' required>
                                    <option value='$row[id_vehiculo]' selected='true'>$row[id_vehiculo]</option>";
                                    $form.= $this->printOptionFormUpdate($row['id_vehiculo'], 'vehiculo');
                    $form.="    </select>
                            </div>
                        </fieldset >
                        <fieldset class='fieldset second'><legend>Cliente</legend>
                            <div class='input-contenedor contenedor_secundario'>
                                <i class='fas fa-user icon_formularios_registro'></i>
                                <select class='controls' name='cliente' id='cliente' required>
                                    <option value='$row[id_cliente]' selected='true'>$row[id_cliente]</option>";
                                    $form.=$this->printOptionFormUpdate($row['id_cliente'], 'cliente');
                    $form.="    </select>
                            </div>
                        </fieldset >
                        <fieldset class='fieldset second' style='width:100%'><legend>Estado</legend>
                            <div class='input-contenedor contenedor_secundario'>
                                <i class='fas fa-car-side icon_formularios_registro'></i>
                                <select class='controls' name='Estado_estacionamiento' id='Estado_estacionamiento' required>
                                    <option value='$row[Estado_estacionamiento]' selected='true'>$row[Estado_estacionamiento]</option>";
                                    if($row['Estado_estacionamiento'] != 'Activo'):
                                        $form.="<option value='Activo'>Activo</option>";
                                    endif;
                                    if($row['Estado_estacionamiento'] != 'Terminado'):
                                        $form.="<option value='Terminado'>Terminado</option>";
                                    endif;
                    $form.="    </select>
                            </div>
                        </fieldset >
                        <fieldset class='fieldset fieldset_textarea'><legend>Descripción/Detalles</legend>
                            <div class='input-contenedor contenedor_textarea'>
                                <textarea class='textarea_registro' name='descripcion_esta' id='descripcion_esta'>$row[esta_descripcion]</textarea>
                            </div>
                        </fieldset>";
                    break;
                case 'tarifa': 
                    $form = "
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
                                        $form.="<option value='Carro'>Carro</option>";
                                    endif;
                                    if($row['Tipo_vehiculo'] != 'Bicicleta'):
                                        $form.="<option value='Bicicleta'>Bicicleta</option>";
                                    endif;
                                    if($row['Tipo_vehiculo'] != 'Moto'):
                                        $form.="<option value='Moto'>Moto</option>";
                                    endif;
                    $form.="    </select>
                            </div>
                        </fieldset >
                        <div class='input-contenedor-edit'>
                            <i class='fas fa-hand-holding-usd icon_formularios_registro'></i>
                            <input type='number' class='input_registrar' name='valor_tarifa' id='valor_tarifa' placeholder='Valor tarifa' value='$row[Valor_tarifa]'>
                        </div>";
                    
                    break;
            }

            return $form;
        }

        //Barra de búsqueda CVET
        public function createBar($text='', $id='', $tipo=''){
            switch($tipo){
                case 'bahia':
                    $bar ="
                    <div class='contenedor-main_barra-busqueda_cvet'>
                        <label class='contenedor-main_barra-busqueda__label-busqueda'>Búsqueda <i class='fas fa-search'></i></label>
                        <label class='contenedor-main_barra-busqueda__label' for='desde'> Desde:</label>
                        <input class='contenedor-main_barra-busqueda__search' type='date' id='desde'>
                        <label class='contenedor-main_barra-busqueda__label' for='hasta'>Hasta:</label>
                        <input class='contenedor-main_barra-busqueda__search' type='date' id='hasta'>
                        <input class='contenedor-main_barra-busqueda__button' type='submit' value='Consultar' id='consultar_estacionamientos'>
                    </div>";
                    break;
                default: 
                    $bar = "
                    <div class='contenedor-main_barra-busqueda_cvet'>
                        <label class='contenedor-main_barra-busqueda__label-busqueda_usuario'><i class='fas fa-search'></i></label>
                        <input class='contenedor-main_barra-busqueda__search_texto' type='text' id='$id' name='$id' placeholder='$text'>
                    </div>";

            }
            

            return $bar;
        }

        //Imprimir las opciones para el formulario de actualizar bahía
        private function printOptionFormUpdate($campo, $tipoCampo){
            //Instancia clases
            $vehiculo = new Vehiculo();
            $cliente = new Cliente();
            $options = '';

            switch($tipoCampo){
                case 'vehiculo': 
                    $vehiculos = $vehiculo->getVehiculos();
                    foreach($vehiculos as $row){
                        if($row['Placa'] != $campo){
                            $options .= "<option value=$row[Placa]>$row[Placa]</option>";
                        }
                    }
                    break;
                case 'cliente': 
                    $clientes = $cliente->getClientes();
                    foreach($clientes as $row){
                        if($row['Documento'] != $campo){
                            $options .= "<option value=$row[Placa]>$row[Placa]</option>";
                        }
                    }
                    break;
            }

            return $options;
        }

        public function createTicket($tipo, $datos){

            $html = "
            <title>Ticket de $tipo</title>
            <div class='contenedorTicket'>
                <div class='header'>
                    <h1>Digital Parking</h1>
                    <p>Cra 50 # 26 - Paloquemao</p>
                    <p>Nit: 165856215441</span></p>
                    <p class='negrita'>Ticket de $tipo</p>
                </div>";

            if($tipo == 'salida'){
                $html .= "
                        <div class='info'>
                            <p>
                                <span class='negrita'>No. Ticket:</span><span class='content-info1'>$datos[0]</span>
                            </p>
                            <p><span class='negrita'>No. Estacionamiento:</span><span class='content-info2'>$datos[1]</span></p>
                            <p><span class='negrita'>Placa:</span><span class='content-info3'>$datos[2]</span></p>
                            <p><span class='negrita'>Tipo Vehículo:</span><span class='content-info5'>$datos[3]</span></p>
                            <p><span class='negrita'>Documento cliente:</span><span class='content-info4'>$datos[4]</span></p>
                            <p><span class='negrita'>Valor tarifa:</span><span class='content-info6'>$datos[5]</span></p>
                
                        </div>
                
                        <div class='detalles_tiempo'>
                            <h2>Fecha y hora de ingreso</h2>
                            <span id='fecha'>$datos[6]</span> <span id='hora'>$datos[7]</span>
                            
                            <h2>Fecha y hora de salida</h2>
                            <span id='fecha'>$datos[8]</span> <span id='hora'>$datos[9]</span>
                            
                            <h2>Tiempo transcurrido</h2>
                            <span id='fecha'>$datos[10]</span>
                        </div>
                
                        <div class='venta'>
                            <p>Valor venta: <span>$".number_format($datos[11])."</span></p>
                        </div>
                        
                        <div class='footerTicket'>
                            <h2>Atendido por: <span>$datos[12]</span></h2>
                            <h2 class='fecha'>Fecha: <span>$datos[13]</span></h2>
                        </div>
                    </div>";
            }elseif($tipo == 'entrada'){
                $html .= "
                        <div class='info'>
                            <p>
                                <span class='negrita'>No. Ticket:</span><span class='content-info1'>$datos[0]</span>
                            </p>
                            <p><span class='negrita'>No. Estacionamiento:</span><span class='content-info2'>$datos[1]</span></p>
                            <p><span class='negrita'>Placa:</span><span class='content-info3'>$datos[2]</span></p>
                            <p><span class='negrita'>Documento cliente:</span><span class='content-info4'>$datos[3]</span></p>
                        </div>

                        <div class='detalles_tiempo'>
                            <h2>Fecha y hora de ingreso</h2>
                            <span id='fecha'>$datos[4]</span> <span id='hora'>$datos[5]</span>
                        </div>
                        
                        <div class='footerTicket'>
                            <h2>Atendido por: <span>$datos[6]</span></h2>
                            <h2 class='fecha'>Fecha: <span>$datos[7]</span></h2>
                        </div>
                    </div>";
            }

            return $html;
        }

        //Formatear las fechas a un formato adecuado
        public function formatearFecha($fecha){
            $fecha = date_create($fecha); 
            $fecha = date_format($fecha,"d/M/Y");

            return $fecha;
        }
    }   
?>