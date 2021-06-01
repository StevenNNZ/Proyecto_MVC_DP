<?php 
    require_once("../config/conexion.php");
    require_once("../models/Gest_user.php");

    $usuario = new Gest_user();

    switch($_GET["op"]){
        case "combo":
            $search = $_GET['search'];
            $html="";
            $datos = $usuario->getUser($search);
            
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
                                            <a href='#' onclick='deleteUser($row[documento])' id='$row[documento]'><i id='delete' class='far fa-trash-alt icon_tabla' title='Eliminar Usuario'></i></a>
                                            ";
                    if($row['estado_usuario']=='Activo'){
                        $prueba = 'hola';
                        $html.="<a href='#' onclick='desactivarUsuario($row[documento])' id='$row[documento]'><i id='bloquear' class='fas fa-user-alt-slash icon_tabla' title='Desactivar Usuario'></i></a>";
                    }else{
                        $html.="<a href='#' onclick='activarUsuario($row[documento])' id='$row[documento]'><i id='activar' class='fas fa-user-check icon_tabla' title='Activar usuario'></i></a>";
                    }
                    
                    $html.="<a href='#' onclick='updateUser($row[documento], \"$row[estado_usuario]\")' id='$row[documento]'><i id='edit' class='far fa-edit icon_tabla' title='Editar Usuario'></i></a>
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

        case "delete":
            $documento = $_GET['documento'];
            $user_active = $_GET['user_active'];

            $usuario->deleteUser($documento, $user_active);
        break;

        case "showEditarUsuario":
            $documento = $_GET['documento'];
            $html="";
            $datos = $usuario->getUser_x_id($documento);
            
            if(is_array($datos) and count($datos)>0){
                $html.="
                <div class='container_edit'>
                    <div class='content-form_edit'>
                        <form method='post' id='form_editar' class='formulario'>
                            <fieldset class='fieldset'><legend class='legend-principal'>Datos usuario</legend>
                                <div class='contenido-cliente'>";
                
                foreach($datos as $row){
                    $html.="
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
                                            $html.="<option value='Cajero'>Cajero</option>";
                                        }else{
                                            $html.="<option value='Administrador'>Administrador</option>";
                                        }
                                        $html.="
                                    </select>
                                </div>
                            </fieldset>
                            <div class='input-contenedor-edit'>
                                <i class='fas fa-key icon_formularios_registro'></i>
                                <input type='password' class='input_registrar' value='$row[contrasena]' name='contrasena_usuario' id='contrasena_usuario' placeholder='Contraseña  *' min-lenght='8' required>
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
                        No hemos encontrado ningún registro. Asegúrese de haber introducido la <b>información</b> correcta.
                    </div>
                </div>";
                echo $html;
            }
        break;
        
        case "activarUser":
            $documento = $_GET['documento'];
            $user_active = $_GET['user_active'];

            $usuario->activarUser($documento, $user_active);
        break;
        
        case "desactivarUser":
            $documento = $_GET['documento'];
            $user_active = $_GET['user_active'];

            $usuario->desactivarUser($documento, $user_active);
        break;

        case "updateUser":
            $id = $_GET['id'];
            $id_user = $_GET['user'];
            /*$nom = $_POST['nombre_usuario'];
            $nom1 = $_POST['apellido_usuario'];
            $nom2 = $_POST['cargo'];
            $nom3 = $_POST['contrasena_usuario'];
            $nom4 = $_POST['email_usuario']; */
            $usuario->updateUser($id, $_POST['nombre_usuario'], $_POST['apellido_usuario'], $_POST['email_usuario'], $_POST['cargo'], $_POST['contrasena_usuario'], $id_user);
            
             return '';
            
        break;
    }
?>