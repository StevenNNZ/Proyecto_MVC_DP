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
    <main class="main_usuarios">
        <h1 class="Tittle-admin"><i class="fas fa-users"></i> Gestión usuarios</h1>
        <div class="contenedor-main">
            <div class="contenedor-main_barra-busqueda_usuario">
                <label class="contenedor-main_barra-busqueda__label-busqueda_usuario"><i class="fas fa-search"></i></label>
                <input class="contenedor-main_barra-busqueda__search_texto" type="text" id="search_usuario" placeholder="Buscar...">
            </div>
            <div class="contenedor_table_principal--reporte_venta">
                <div id="contenedor_resultado">
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
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </main>
    <?php
        require_once("../mainFooter/footer.php");
        require_once("../mainJS/js.php");    
    ?>
</body>
</html>



