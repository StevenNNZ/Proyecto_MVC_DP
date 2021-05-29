<?php 
    require_once("config/conexion.php");
    if(isset($_POST["enviar"]) and $_POST["enviar"]=="si"){
        require_once("models/Usuario.php");
        $usuario = new Usuario();
        $usuario->login();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital parking</title>

    <!-- Estilos de la página principal y del login -->
    <link rel="stylesheet" href="public/css/styles.css">
    
    <!-- Estilos formulario registro de usuario. -->
    <link rel="stylesheet" href="public/css/style-registro-usuario.css">

    <!-- Tipografía lobster -->
	<link href="public/css/fonts/Lobster.css" rel="stylesheet">

    <!-- Tipografía Open Sans  -->
    <link href="public/css/fonts/Open-Sans.css" rel="stylesheet">

    <!-- Fuente Heebo -->
    <link href="public/css/fonts/Heebo.css" rel="stylesheet">

    <!-- Estilos de alertas avisos emergentes. -->
    <link rel="stylesheet" href="public/css/alerts-css.min.css">

    <!-- Estilos fontawesome. -->
    <!-- <script src="public/js/lib/fontawesome/2235ad2cfb.js" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="public/css/lib/fontawesome/all.min.css">
    
</head>
<body>
    <main>
    <div class="login_signup">
        <div class="container">
            <div class="row justify-content-between">
                <div class="content-left">
                    <h1>Digital</h1><h2>Parking</h2>
                    <img class="container__logo_principal" src="public/img/logdparking.webp" alt="Logo digital parking">
                </div>


                <div class="content-right">
                    <div class="login_contenedor">
                        <!-- Respuesta notificación javascript -->
                        <div id="dato_faltante">
                            <?php 
                                if(isset($_GET["m"])){
                                    switch($_GET["m"]){
                                        case "1";
                                        ?>
                                            <div class='alert alert_warning alert_sm' style='animation-delay: .2s;margin:0 auto;'>
                                                <div class='alert--icon'>
                                                    <i class='fas fa-bell'></i>
                                                </div>
                                                <div class='alert--content'>
                                                    El <b>usuario</b> y/o <b>contraseña</b> son incorrectos.
                                                </div>
                                                <div class='alert--close'>
                                                    <i class='far fa-times-circle'></i>
                                                </div>
                                            </div>
                                        <?php
                                        break;

                                        case "2";
                                        ?>
                                            <div class='alert alert_warning alert_sm' style='animation-delay: .2s;margin:0 auto;'>
                                                <div class='alert--icon'>
                                                    <i class='fas fa-bell'></i>
                                                </div>
                                                <div class='alert--content'>
                                                    Los campos están vacios.
                                                </div>
                                                <div class='alert--close'>
                                                    <i class='far fa-times-circle'></i>
                                                </div>
                                            </div>
                                        <?php
                                        break;

                                        case "3";
                                        ?>
                                            <div class='alert alert_warning alert_sm' style='animation-delay: .2s;margin:0 auto;'>
                                                <div class='alert--icon'>
                                                    <i class='fas fa-bell'></i>
                                                </div>
                                                <div class='alert--content'>
                                                    Su usuario no se encuentra activado. Por favor comuníquese con un administrador.
                                                </div>
                                                <div class='alert--close'>
                                                    <i class='far fa-times-circle'></i>
                                                </div>
                                            </div>
                                        <?php


                                    }
                                }
                            ?>
                        </div>

                        <form class="formulario" action="" method="POST" id="login_form">
                            <div class="contenedorform">
                                <div class="input-contenedor">
                                    <i class="fas fa-id-card icon_login"></i>
                                    <input class="input_index" id="documento" name="documento" type="number" placeholder="Número documento" required>
                                </div>
                                <div class="input-contenedor">
                                    <i class="fas fa-key icon_login"></i>
                                    <input class="input_index" id="password" name="password" type="password" placeholder="Contraseña" required>
                                </div>
                                    <!-- <input type="submit" value="Iniciar sesión" id="iniciar_sesion_boton" class="button-index"> -->
                                    <input type="hidden" name="enviar" class="form-control" value="si">
                                    <button type="submit" class="button-index">Iniciar sesión</button>
                                    <div class="forgot">
                                        <!-- <a href="">Recuperar contraseña</a> -->
                                    </div>
                                <div class="line"></div>
                                <p class="new_account">¿Aún no tienes una cuenta? <a id="registrarse" class="link tarifa_click">Regístrate</a></p>
                            </div>
                        </form>
                        <p class="tyc">Al iniciar sesión, aceptas las condiciones de uso y políticas de privacidad.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
    <footer class="footer_index">
        <p>Dparking 2020©</p>
    </footer>

    <!-- <script src="assets/js/registro_usuario.js"></script> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> -->
    <!-- Script sweet alert -->
	<!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script> -->
    <!-- <script type="text/javascript" src="controlador/iniciar_sesion.js"></script> -->
    <script src="public/js/lib/jquery/jquery.min.js"></script>

	<script src="public/js/lib/sweetalert/sweetalert2.all.min.js"></script>
    <script src="public/js/alerts.min.js"></script>
    <script src="public/js/registroUsuario.js"></script>
</body>
</html>