$(document).ready(function() {
        $('#Consultar_cliente').on('click', function(){
            //Llamado al controlador de 
            $.post("../../controller/consCVET.php?op=cliente",function(data, status){
                $('#contenedor_resultado').html(data);
            })

            .done(function() {
                $('#search_cliente').on('keyup', function(){
                    let search = $('#search_cliente').val();
                    $.post("../../controller/consCVET.php?op=consultaCliente&search="+search+"",function(data, status){
                        $('#contenedor_tabla-general').html(data);
                    });
                });
            });
        });

        $('#Consultar_vehiculo').on('click', function(){
            //Llamado al controlador de 
            $.post("../../controller/consCVET.php?op=vehiculo",function(data, status){
                $('#contenedor_resultado').html(data);
            })

            .done(function() {
                $('#search_vehiculo').on('keyup', function(){
                    let search = $('#search_vehiculo').val();
                    $.post("../../controller/consCVET.php?op=consultaVehiculo&search="+search+"",function(data, status){
                        $('#contenedor_tabla-general').html(data);
                    });
                });
            });
        });

        $('#Consultar_estacionamiento').on('click', function(){
            //Llamado al controlador de 
            $.post("../../controller/consCVET.php?op=estacionamiento",function(data, status){
                $('#contenedor_resultado').html(data);
            })

            .done(function() {
                $('#consultar_estacionamientos').on('click', function(){
                    let desde = $('#desde').val();
                    let hasta = $('#hasta').val();
                    if(!isNaN(desde) || !isNaN(hasta)){
                        document.getElementById('contenedor_tabla-general').innerHTML = `
                        <div class='alert alert_warning alert_sm' id='contenedor-alerta-reportes_venta' style='animation-delay: .2s;margin:0 auto;'>
                            <div class='alert--icon'>
                                <i class='fas fa-bell'></i>
                            </div>
                            <div class='alert--content'>
                                Por favor asegúrese de ingresar el rango <b>'Desde'</b> y <b>'Hasta'</b>
                            </div>
                        </div>`;
                    }else{
                        //Llamado al controlador de 
                        $.post("../../controller/consCVET.php?op=consultaEstacionamiento&desde="+desde+"&hasta="+hasta+"",function(data, status){
                                $('#contenedor_tabla-general').html(data);
                        });
                    }
                });
            });
        });

        $('#Consultar_tarifas').on('click', function(){
            //Llamado al controlador de 
            $.post("../../controller/consCVET.php?op=tarifa",function(data, status){
                $('#contenedor_resultado').html(data);
            })

            .done(function() {
                $('#search_tarifa').on('keyup', function(){
                    let search = $('#search_tarifa').val();
                    $.post("../../controller/consCVET.php?op=consultaTarifa&search="+search+"",function(data, status){
                        $('#contenedor_tabla-general').html(data);
                    });
                });
            });
        });

        function info(mensaje){
            Swal.fire({
                title: "¿Qué hace este botón?",
                html:"Realiza una consulta "+mensaje+"<br> que hay actualmente en la base de datos.",
                icon: 'info',
                confirmButtonText: 'Aceptar',
                toast: true,
                position: 'bottom-end',
            });
        }

        $('#info_tarifa').on('click', function(){
            info("sobre las tarifas");
        });

        $('#info_cliente').on('click', function(){
            info("sobre los clientes");
        });

        $('#info_vehiculo').on('click', function(){
            info("sobre los vehículos");
        });

        $('#info_estacionamiento').on('click', function(){
            info("sobre los estacionamientos");
        });

});