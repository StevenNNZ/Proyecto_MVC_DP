<?php 
	require_once("../../config/conexion.php");
	if (isset($_SESSION['documento'])){
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
    <h1 class="Tittle-admin"><i class="fas fa-store"></i> Interfaz de cajero</h1>
	<main>
		<div class='alert alert_info alert_sm' id='contenedor-alerta-reportes_venta' style='animation-delay: .2s;margin:0 auto;'>
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
					<a href="../formularios/consultar-cliente.php">Consultar<br>cliente/vehículo</a>
				</li>
				<li>
					<a href="../formularios/consultar-ticket.php">Consultar<br>ticket</a>
				</li>
				<li>
					<a href="../formularios/consultar-tarifa.php">Consultar<br>tarifa</a>
				</li>
				<li>
					<a href="../formularios/estacionamiento-activo.php">Bahías<br>Activas</a>
				</li>
				<li>
					<a href="../formularios/consultar-estacionamiento.php">Consultar<br>Bahías</a>
				</li>
			</ul>
   		</div>
	</main> 
	<?php require_once("../mainFooter/footer.php") ?>
    </footer> 

    <?php require_once("../mainJS/js.php") ?>
</body>
</html>

<?php 
	}else{
		header("location:".Conectar::ruta()."index.php");
	}
?>