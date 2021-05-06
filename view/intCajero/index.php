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
		<div class="contenedor_opciones">
			<ul>
				<li>
					<a href="../formularios/registrar_cliente.php" class="title">Ingresar Bahía</a>
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