function cargarCliente(){
    $.post(`../../../controller/cliente.php?op=getClientes&eliminar=${true}`,function(data, status){
        $('#contenedor_resultado').html(data);
    })
    .done(function() {
        $('#search_cliente').on('keyup', function(){
            const search = $('#search_cliente').val();
            
            $.post(`../../../controller/cliente.php?op=consultaClientes&search=${search}&eliminar=${true}`,function(data, status){
                $('#contenedor_tabla-general').html(data);
            });
        });
    });
}

function cargarVehiculo(){
    $.post(`../../../controller/vehiculo.php?op=getVehiculos&eliminar=${true}`,function(data, status){
        $('#contenedor_resultado').html(data);
    })
    .done(function() {
        $('#search_vehiculo').on('keyup', function(){
            const search = $('#search_vehiculo').val();
            
            $.post(`../../../controller/vehiculo.php?op=consultaVehiculos&search=${search}&eliminar=${true}`,function(data, status){
                $('#contenedor_tabla-general').html(data);
            });
        });
    });
    
}

$(document).ready(function() {
    $('#Consultar_cliente').on('click', function(){
        //Llamado al controlador de cliente-cajero
        cargarCliente();
    });

    $('#Consultar_vehiculo').on('click', function(){
        //Llamado al controlador de vehículo
        cargarVehiculo();
    });

    $('#info_cliente').on('click', function(){
        info("clientes");
    });

    $('#info_vehiculo').on('click', function(){
        info("vehículos");
    });

});

//Mensaje de info
function info(mensaje){
    Swal.fire({
        title: "¿Qué hace este botón?",
        html:"Muestra los últimos <b>10</b> registros de <b>"+mensaje+"</b></br> que hay actualmente en la base de datos.",
        icon: 'info',
        confirmButtonText: 'Aceptar',
        toast: true,
        position: 'bottom-end',
    });
}

//Atualizar cliente
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
            window.location.href="../../conCVET/editarCliente/?id="+documento;
            // return true;
        }
    })
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
            window.location.href="../../ConCVET/editarVehiculo/?id="+placa;
        }
    })
}