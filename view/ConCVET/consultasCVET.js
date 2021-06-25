function cargarCliente(){
    $.post("../../controller/cliente.php?op=getClientes",function(data, status){
        $('#contenedor_resultado').html(data);
    })
}

function cargarVehiculo(){
    $.post("../../controller/vehiculo.php?op=getVehiculos",function(data, status){
        $('#contenedor_resultado').html(data);
    })
}

function cargarBahias(){
    $.post("../../controller/bahia.php?op=getBahias",function(data, status){
        $('#contenedor_resultado').html(data);
    })
}

function cargarTarifas(){
    $.post("../../controller/tarifa.php?op=getTarifas",function(data, status){
        $('#contenedor_resultado').html(data);
    })
}

$(document).ready(function() {
        $('#Consultar_cliente').on('click', function(){
            //Llamado al controlador de 
            
            $.post("../../controller/cliente.php?op=getClientes",function(data, status){
                $('#contenedor_resultado').html(data);
            })
            .done(function() {
                $('#search_cliente').on('keyup', function(){
                    const search = $('#search_cliente').val();
                    $.post("../../controller/cliente.php?op=consultaClientes&search="+search+"",function(data, status){
                        $('#contenedor_tabla-general').html(data);
                    });
                });
            });
        });

        $('#Consultar_vehiculo').on('click', function(){
            //Llamado al controlador de 
            $.post("../../controller/vehiculo.php?op=getVehiculos",function(data, status){
                $('#contenedor_resultado').html(data);
            })

            .done(function() {
                $('#search_vehiculo').on('keyup', function(){
                    let search = $('#search_vehiculo').val();
                    $.post("../../controller/vehiculo.php?op=consultaVehiculos&search="+search+"",function(data, status){
                        $('#contenedor_tabla-general').html(data);
                    });
                });
            });
        });

        $('#Consultar_estacionamiento').on('click', function(){
            //Llamado al controlador de 
            $.post("../../controller/bahia.php?op=getBahias",function(data, status){
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
                        $.post("../../controller/bahia.php?op=getBahiaBetween&desde="+desde+"&hasta="+hasta+"",function(data, status){
                                $('#contenedor_tabla-general').html(data);
                        });
                    }
                });
            });
        });

        $('#Consultar_tarifas').on('click', function(){
            //Llamado al controlador de 
            $.post("../../controller/tarifa.php?op=getTarifas",function(data, status){
                $('#contenedor_resultado').html(data);
            })

            .done(function() {
                $('#search_tarifa').on('keyup', function(){
                    let search = $('#search_tarifa').val();
                    $.post("../../controller/tarifa.php?op=consultaTarifas&search="+search+"",function(data, status){
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


//FUNCIONES

function deleteCliente(documento, user_active = $('#user-active').val()){
    Swal.fire({
        title: '¿Está seguro de eliminar este cliente?',
        showDenyButton: false,
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: `Eliminar`,
        cancelButtonText: `Cancelar`,
      }).then((result) => {
        // Read more about isConfirmed, isDenied below
        if (result.isConfirmed) {
            $.post("../../controller/cliente.php?op=deleteCliente&documento="+documento+"&user_active="+user_active,function(data, status){
                console.log(data);
                Swal.fire('¡Campo eliminado!', '', 'error');
            });
            cargarCliente();
            // return true;
        }
    });
}

function updateCliente(documento){
    Swal.fire({
        title: '¿Está seguro de editar este campo?',
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: `Editar`,
        cancelButtonText: `Cancelar`,
      }).then((result) => {
        // Read more about isConfirmed, isDenied below
        if (result.isConfirmed) {
            window.location.href="editarCliente/?id="+documento;
            // return true;
        }
    })
}

function deleteVehiculo(placa, user_active = $('#user-active').val()){
    Swal.fire({
        title: '¿Está seguro de eliminar este vehículo?',
        showDenyButton: false,
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: `Eliminar`,
        cancelButtonText: `Cancelar`,
      }).then((result) => {
        // Read more about isConfirmed, isDenied below
        if (result.isConfirmed) {
            $.post("../../controller/vehiculo.php?op=deleteVehiculo&placa="+placa+"&user_active="+user_active,function(data, status){
                console.log(data);
                Swal.fire('¡Campo eliminado!', '', 'error');
            });
            cargarVehiculo();
            // return true;
        }
    });
}

function updateVehiculo(placa){
    Swal.fire({
        title: '¿Está seguro de editar este campo?',
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: `Editar`,
        cancelButtonText: `Cancelar`,
      }).then((result) => {
        if (result.isConfirmed) {
            window.location.href="editarVehiculo/?id="+placa;
        }
    })
}

function deleteEstacionamiento(id, user_active = $('#user-active').val()){
    Swal.fire({
        title: '¿Está seguro de eliminar este registro?',
        showDenyButton: false,
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: `Eliminar`,
        cancelButtonText: `Cancelar`,
      }).then((result) => {
        // Read more about isConfirmed, isDenied below
        if (result.isConfirmed) {
            $.post("../../controller/bahia.php?op=deleteBahia&id="+id+"&user_active="+user_active,function(data, status){
                console.log(data);
                Swal.fire('¡Campo eliminado!', '', 'error');
            });
            cargarBahias();
            // return true;
        }
    });
}

function updateEstacionamiento(id){
    Swal.fire({
        title: '¿Está seguro de editar este campo?',
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: `Editar`,
        cancelButtonText: `Cancelar`,
      }).then((result) => {
        if (result.isConfirmed) {
            window.location.href="editarEstacionamiento/?id="+id;
        }
    })
}

function deleteTarifa(id, user_active = $('#user-active').val()){
    Swal.fire({
        title: '¿Está seguro de eliminar este registro?',
        showDenyButton: false,
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: `Eliminar`,
        cancelButtonText: `Cancelar`,
      }).then((result) => {
        // Read more about isConfirmed, isDenied below
        if (result.isConfirmed) {
            $.post("../../controller/tarifa.php?op=deleteTarifa&id="+id+"&user_active="+user_active,function(data, status){
                Swal.fire('¡Campo eliminado!', '', 'error');
            });
            cargarTarifas();
            // return true;
        }
    });
}

function updateTarifa(id){
    Swal.fire({
        title: '¿Está seguro de editar este campo?',
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: `Editar`,
        cancelButtonText: `Cancelar`,
      }).then((result) => {
        if (result.isConfirmed) {
            window.location.href="editarTarifa/?id="+id;
        }
    })
}