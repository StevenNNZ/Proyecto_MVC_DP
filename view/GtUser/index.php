<?php 
    require_once("../../config/conexion.php"); 
    require_once("../../controller/validate_session.php");
    require_once("../../controller/validate_admin.php");
?>

<!DOCTYPE html>
<html lang="es">
    <?php require_once("../mainHead/head.php") ?>
    <title>Gestionar usuarios</title>
</head>
<body>
    <?php
        require_once("../mainHeader/header.php");    
    ?>
    </header>
    <main class="main_usuarios">
        <h1 class="Tittle-admin">
            <a href="../home/"><i class="fas fa-arrow-alt-circle-left"></i> Gestión usuarios</a>
        </h1>
        <div class="contenedor-main">
            <div class="contenedor-main_barra-busqueda_usuario">
                <label class="contenedor-main_barra-busqueda__label-busqueda_usuario"><i class="fas fa-search"></i></label>
                <input class="contenedor-main_barra-busqueda__search_texto" type="text" id="search_usuario" name="search_usuario" placeholder="Buscar un usuario...">
            </div>
            <div class="contenedor_table_principal">
                <div id="contenedor_resultado">
                    
                </div>
            </div>
        </div>
    </main>
    <?php
        require_once("../mainFooter/footer.php");
        require_once("../mainJS/js.php");    
    ?>
    <script src="gestionUsuarios.js"></script>
</body>
</html>



