$(document).ready(function() {
    $('#Consultar_cliente').on('click', function(){
        //Llamado al controlador de 
        $.post("../../../controller/consCVET.php?op=clienteCajero",function(data, status){
            $('#contenedor_resultado').html(data);
        })
    });

    $('#Consultar_vehiculo').on('click', function(){
        //Llamado al controlador de 
        $.post("../../../controller/consCVET.php?op=vehiculoCajero",function(data, status){
            $('#contenedor_resultado').html(data);
        })
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