function cargarCliente(){
    $.post("../../../controller/consCVET.php?op=clienteCajero",function(data, status){
        $('#contenedor_resultado').html(data);
    })
}

function cargarVehiculo(){
    $.post("../../../controller/consCVET.php?op=vehiculoCajero",function(data, status){
        $('#contenedor_resultado').html(data);
    })
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

    $('#info_cliente').on('click', function(){
        info("clientes");
    });

    $('#info_vehiculo').on('click', function(){
        info("vehículos");
    });

});

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
            $.post("../../../controller/consCVET.php?op=deleteCliente&documento="+documento+"&user_active="+user_active,function(data, status){
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
            window.location.href="../../conCVET/editarCliente/?id="+documento;
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
            $.post("../../../controller/consCVET.php?op=deleteVehiculo&placa="+placa+"&user_active="+user_active,function(data, status){
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
            window.location.href="../../ConCVET/editarVehiculo/?id="+placa;
        }
    })
}