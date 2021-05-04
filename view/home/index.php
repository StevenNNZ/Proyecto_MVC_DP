<?php 
	require_once("../../controlador/acceso.php");
	require_once("../../controlador/acceso_admin.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Dashboard Admin</title>
	<meta charset="UTF-8">

	<!-- Estilos del dashboard -->
	<link rel="stylesheet" href="../../assets/css/styles-dashboard.css">

	<!-- Tipografía lobster -->
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">

	<!-- Tipografía Open Sans  -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&display=swap" rel="stylesheet">

</head>

<body>
    <header class="header-dashboard">
        <nav class="header-dashboard__nav">
                <label class="logotipo_dparking">
                    <b class="header-dashboard__label--principal">Digital</b><br><b class="principal--sub">parking</b><br><img class="header-dashboard__label--img" src="../../assets/img/logdparking.webp" alt="Digital parking logo">
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
    </header>
    <main>
		<div class="contenedor_opciones admin">
			<ul>
				<li>
					<a href="../reporte_ventas.php">Reporte de<br> ventas</a>
				</li>
				<li>
					<a href="../consultar-usuarios.php">Gestionar<br>usuarios</a>
				</li>
				<li>
					<a href="../consultas_cvet.php">Consultas <br>CVET</a>
				</li>
			</ul>
		</div>
	</main> 
	<footer class="footer">
		<div class="footer-contenedor">
			<div class="footer-credits">
				<label>Parqueadero San Diego</label>
			</div>
			<div class="footer-credits">
				<label>Dparking&copy; 2020</label>
			</div>
		<div class="footer-credits">
			<label>Diseñado por: Dparking&copy; 2020</label>	
		</div>
	</div>
	<div class="line"></div>
    </footer> 

    <!-- Script fontawesome -->
    <script src="https://kit.fontawesome.com/2235ad2cfb.js" crossorigin="anonymous"></script>
	<!-- Script sweet alert -->
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Script alertas confirmación -->
    <script src="../../assets/js/confirm_window.js"></script>
</body>
</html>