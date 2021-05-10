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
	<?php 
		if(isset($_SESSION['Cargo']) and $_SESSION['Cargo']=='Administrador'){
	?>
    <main>
		<div class="contenedor_opciones admin">
			<ul>
				<li>
					<a href="../RepVTA/">Reporte de<br> ventas</a>
				</li>
				<li>
					<a href="../GtUser/">Gestionar<br>usuarios</a>
				</li>
				<li>
					<a href="../conCVET/">Consultas <br>CVET</a>
				</li>
				<li>
					<a href="../intCajero/">Interfaz Cajero</a>
				</li>
				<li>
					<a href="../ultMov/">Últimos movimientos</a>
				</li>
				<li>
					<a href="../RepTCK/">Reporte de tickets</a>
				</li>
			</ul>
		</div>
	</main> 
	<?php 
		}else{
	?>
	<main>
		<div class="contenedor_opciones">
			<ul>
				<li>
					<a href="../Cliente/Registrar/" class="title">Ingresar Bahía</a>
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
	<?php 
		}
	?>
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