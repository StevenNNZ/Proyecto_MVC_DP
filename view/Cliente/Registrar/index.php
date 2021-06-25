<!DOCTYPE html>
<html lang="es">
    <?php 
	    require_once("../../../config/conexion.php");
        require_once("../../mainHead/headSub.php");
    ?>
    <title>Ingresar Bahía</title>
</head>
<body>
    <?php require_once("../../mainHeader/headerSub.php") ?>
    </header>
    <main>  
        <h1 class="Tittle-admin">
            <a href="../../home/"><i class="fas fa-arrow-alt-circle-left"></i> Registro de bahía</a>
        </h1>
        <div id="respuesta_registroBahia"></div>
        <div class="container">
            <div class="content-form">
                <form method="post" id="form_bahia" class="formulario">
                    <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION['documento']?>">
                    <div class="tittle">
                        <h2 class="tittle1">Registrar </h2>
                        <h2 class="tittle2">Bahía</h2>
                    </div>
                    <div class="sub">
                        <p class="sub-1">Digital</p>
                        <p class="sub-2">Parking</p>
                    </div>
                        <fieldset class="fieldset"><legend class="legend-principal">Datos de cliente</legend>
                            <div class="contenido-cliente">
                                <div class="input-contenedor">
                                <i class="fas fa-id-card icon_formularios_registro"></i>
                                <input type="number" class="input_registrar" name="documento_cliente" id="documento_cliente" placeholder="Número documento *" required pattern="[0-9]+">
                            </div>
                            <div class="input-contenedor">
                                <i class="fas fa-user icon_formularios_registro"></i>
                                <input type="text" class="input_registrar" name="nombre_cliente" id="nombre_cliente" placeholder="Nombre *" required pattern="[a-zA-záéíóúÁÉÍÓÚÑñ ]+">
                            </div>
                            <div class="input-contenedor">
                                <i class="far fa-user icon_formularios_registro"></i>
                                <input type="text" class="input_registrar" name="apellido_cliente" id="apellido_cliente" placeholder="Apellido *" pattern="[a-zA-záéíóúÁÉÍÓÚÑñ ]+" required>
                            </div>
                            <div class="input-contenedor">
                                <i class="fas fa-phone icon_formularios_registro"></i>
                                <input type="number" class="input_registrar" name="telefono_cliente" id="telefono_cliente" placeholder="Teléfono *" required>
                            </div>
                        </div>
                        </fieldset>
                        <fieldset class="fieldset"><legend class="legend-principal">Datos Vehículo</legend>
                            <div class="contenido-vehiculo">
                                <div class="input-contenedor">
                                    <i class="fas fa-id-card-alt icon_formularios_registro"></i>
                                    <input type="text" class="input_registrar" name="placa_vehiculo" id="placa_vehiculo" placeholder="Placa vehículo *" required>
                                </div>
                                <div class="input-contenedor">
                                    <i class="fas fa-car icon_formularios_registro"></i>
                                    <input type="text" class="input_registrar" name="color_vehiculo" id="color_vehiculo" placeholder="Color vehículo">
                                </div>
                                <div class="input-contenedor">
                                    <i class="fas fa-car icon_formularios_registro"></i>
                                    <input type="text" class="input_registrar" name="modelo_vehiculo" id="modelo_vehiculo" placeholder="Modelo vehículo">
                                </div>
                                <fieldset class="fieldset second"><legend>Tamaño vehículo</legend>
                                    <div class="input-contenedor contenedor_secundario">
                                        <i class="fas fa-car-side icon_formularios_registro"></i>
                                        <select class="controls" name="tamano_vehiculo" id="tamano_vehiculo" required>
                                            <option value="" selected="true" disabled="disabled">Seleccionar *</option>
                                            <option value="Grande">Grande</option>
                                            <option value="Mediano">Mediano</option>
                                            <option value="Pequeño">Pequeño</option>
                                        </select>
                                    </div>
                                </fieldset >
                                <fieldset class="fieldset second"><legend>Tipo vehículo</legend>
                                    <div class="input-contenedor contenedor_secundario">
                                        <i class="fas fa-car-side icon_formularios_registro"></i>
                                         <select class="controls" name="tipo_vehiculo" id="tipo_vehiculo" required>
                                            <option value="" selected="true" disabled="disabled">Seleccionar *</option>
                                            <option value="Bicicleta">Bicicleta</option>
                                            <option value="Moto">Moto</option>
                                            <option value="Carro">Carro</option>
                                         </select>
                                    </div>
                                </fieldset>
                            </div>
                        </fieldset>
                        <fieldset class="fieldset"><legend class="legend-principal">Datos Estacionamiento</legend>
                            <div class="input-contenedor-edit">
                                <i class="fas fa-map-marker-alt icon_formularios_registro"></i>
                                <input type="number" class="input_registrar-full" name="num_estacionamiento" id="num_estacionamiento" placeholder="Número estacionamiento *" required>
                            </div><br>
                            <fieldset class="fieldset fieldset_textarea"><legend>Descripción/Detalles</legend>
                                <div class="input-contenedor contenedor_textarea">
                                    <textarea class="textarea_registro" name="descripcion_esta" id="descripcion_esta"></textarea>
                                </div>
                            </fieldset >
                        </fieldset>
                <div class="button-contenedor">
                    <input class="button reset" type="reset" name="btn-limpiar" value="Limpiar">
                    <!-- <input class="button" type="submit" name="btn-registrar" id="btn-registrar" value="Registrar"> -->
                    <button type="submit" name="button_action" id='button_action' value="add" class="button">Registrar</button>
                </div>
                </form>
            </div>
        </div>
    </main>

    <?php require_once("../../mainFooter/footer.php");?>
    <?php require_once("../../mainJS/jsSub.php");?>
    <script src="registrar.js"></script>
</body>
</html>



