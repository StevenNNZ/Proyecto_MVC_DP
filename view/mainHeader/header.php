<header class="header-dashboard">
        <nav class="header-dashboard__nav">
                <label class="logotipo_dparking">
                    <b class="header-dashboard__label--principal">Digital</b><br><b class="principal--sub">parking</b><br><img class="header-dashboard__label--img" src="../../public/img/logdparking.webp" alt="Digital parking logo">
                </label>
                <label class="label__datos_usuario">
                    <i class="fas fa-user-tie icon"></i>
                    <b class="header-dashboard__label"><?php echo $_SESSION['Cargo']?></b><br><i class="header-dashboard__label-sub">Bienvenido &#40;a&#41; <?php echo $_SESSION['nombre']?></i><br><i class="header-dashboard__label-sub2">&#218;LTIMO INGRESO: <?php echo $_SESSION['hora_ingreso']?></i>
                </label>
                <label class="header-dashboard__label--links">
                    <a href="#"><i class="fas fa-user-cog config" title="Configuración"></i></a>
                    <a onclick="return ConfirmLogOut()"><i class="fas fa-sign-out-alt log_out" title="Cerrar sesión"></i></a>
                </label>
        </nav>