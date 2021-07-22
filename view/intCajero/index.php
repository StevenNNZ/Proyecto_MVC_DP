<?php 
	require_once("../../config/conexion.php");
	require_once("../../controller/validate_session.php");
	require_once("../../controller/validate_admin.php");
?>

<!DOCTYPE html>
<html lang="es">
	<?php require_once("../mainHead/head.php") ?>
	<title>Dashboard</title>
</head>

<body>
	<?php require_once("../mainHeader/header.php") ?>
    </header>
	<!-- Content page -->
    <h1 class="Tittle-admin">
                <a href="../home/"><i class="fas fa-arrow-alt-circle-left"></i> Interfaz cajero</a>
        </h1>
	<main>
		<div class='alert alert_info alert_sm' id='contenedor-alerta-reportes_venta' style='animation-delay: .2s;margin:0 auto; width:60%'>
			<div class='alert--icon'>
				<i class='fas fa-bell'></i>
			</div>
			<div class='alert--content'>
				Actualmente se encuentra en la interfaz de cajero. Haga <a href="../home/" style="color:#3eb6ff"><b>click aquí</b></a> para regresar a la interfaz de Admin.
			</div>
		</div>
		<div class="contenedor_opciones">
			<ul>
				<li>
					<a href="../Cliente/Registrar/">Ingresar Bahía</a>
				</li>
				<li>
					<a href="../formularios/../Cliente/Consultar/">Consultar<br>cliente/vehículo</a>
				</li>
				<li>
					<a href="../Ticket/">Consultar<br>ticket</a>
				</li>
				<li>
					<a href="../Tarifa/">Consultar<br>tarifa</a>
				</li>
				<li>
					<a href="../Bahias/">Bahías<br>Activas</a>
				</li>
			</ul>
   		</div>
	</main> 
	<?php require_once("../mainFooter/footer.php") ?>
    </footer> 

    <?php require_once("../mainJS/js.php") ?>
</body>
</html>