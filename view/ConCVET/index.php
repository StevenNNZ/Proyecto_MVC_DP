<!DOCTYPE html>
<html lang="es">
    
	<?php 
        require_once("../../config/conexion.php"); 
        require_once("../mainHead/head.php") 
    ?>
    <title>Gestionar usuarios</title>
</head>
<body>
    <?php
        require_once("../mainHeader/header.php");    
    ?>
    </header>
    <main class="main_cvet">
        <h1 class="Tittle-admin"><i class="fab fa-elementor"></i> Consultas CVET</h1>
        <div class="contenedor__consultas">
            <div class="contenedor__consultas__cuerpo">
                <div class="contenedor__consultas--item">
                    <i class="fas fa-users icon_cvet"></i>
                    <span class="consultas_cantidad usuarios">5</span>
                    <br><br><a href="#" class="button_cvet">Consultar</a>
                </div>
                <div class="contenedor__consultas--item">
                    <i class="fas fa-car icon_cvet"></i>
                    <span class="consultas_cantidad vehiculos">5</span>
                    <br><br><a href="#" class="button_cvet">Consultar</a>
                </div>
                <div class="contenedor__consultas--item duo">
                    <i class="fas fa-car icon_cvet--duo"></i><i class="fas fa-building icon_cvet--duo"></i>
                    <span class="consultas_cantidad estacionamientos">+99</span>
                    <br><br><a href="#" class="button_cvet">Consultar</a>
                </div>
                <div class="contenedor__consultas--item">
                    <i class="fas fa-clipboard icon_cvet"></i>
                    <span class="consultas_cantidad tarifas">5</span>
                    <br><br><a href="#" class="button_cvet">Consultar</a>
                </div>
            </div>
        </div>
         <div class="contenedor_resultado_consultas">
            <div class="contenedor-main_barra-busqueda_cvet">
                <label class="contenedor-main_barra-busqueda__label-busqueda_usuario"><i class="fas fa-search"></i></label>
                <input class="contenedor-main_barra-busqueda__search_texto" type="text" id="search_usuario" placeholder="Buscar un cliente...">
            </div>
            
            <div id="contenedor_resultado" class="table-responsive">
                <table class="contenedor-table__table">
                    <thead class="contenedor-table__thead">
                        <tr class="contenedor-table__tr--principal">
                            <th>Documento</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Correo</th>
                            <th>Cargo</th>
                            <th>estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="contenedor-table__tbody">
                        <?php 
                            for($i=0; $i<3; $i++){
                        ?>
                                <tr>
                                    <td>50001212</td>
                                    <td>Steven</td>
                                    <td>Nuñez</td>
                                    <td>admin@admin</td>
                                    <td>Administrador</td>
                                    <td>Activo</td>
                                    <td>
                                        <a href="#"><i id="delete" class="far fa-trash-alt icon_tabla" title="Eliminar Usuario"></i></a>
                                        <a href="#"><i id="activar" class="fas fa-user-check icon_tabla" title="Activar usuario"></i></a>
                                        <a href="#"><i id="bloquear" class="fas fa-user-alt-slash icon_tabla" title="Desactivar Usuario"></i></a>
                                        <a href="#"><i id="edit" class="far fa-edit icon_tabla" title="Editar Usuario"></i></a>
                                    </td>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div> 
        <div class="div_de_prueba">
        </div>
    </main>
    <?php
        require_once("../mainFooter/footer.php");
        require_once("../mainJS/js.php");    
    ?>
</body>
</html>



