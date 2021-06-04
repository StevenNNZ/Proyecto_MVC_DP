$(document).ready(function() {

    $('#consultar_reportes').on('click', function(){
        let desde = $('#desde').val(),
            desdeH = $('#desde_hora').val(),
            hasta = $('#hasta').val(),
            hastaH = $('#hasta_hora').val();
        if(!isNaN(desde) || !isNaN(hasta) || !isNaN(desdeH) || !isNaN(hastaH)){
            document.getElementById('contenedor_resultado').innerHTML = `
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
            $.post("../../controller/reporteTicket.php?op=combo&desde="+desde+"&hasta="+hasta+"&desdeH="+desdeH+"&hastaH="+hastaH+"",function(data, status){
                    $('#contenedor_resultado').html(data);
            });
        }
    });
});

function cargarTicket(){
    let desde = $('#desde').val(),
        desdeH = $('#desde_hora').val(),
        hasta = $('#hasta').val(),
        hastaH = $('#hasta_hora').val();
    $.post("../../controller/reporteTicket.php?op=combo&desde="+desde+"&hasta="+hasta+"&desdeH="+desdeH+"&hastaH="+hastaH+"",function(data, status){
        $('#contenedor_resultado').html(data);
    });
}


function deleteTicket(id, user_active = $('#user-active').val()){
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
            $.post("../../controller/reporteTicket.php?op=deleteTicket&id="+id+"&user_active="+user_active,function(data, status){
                Swal.fire('¡Campo eliminado!', '', 'error');
            })
            .done(function(){
                cargarTicket();
            });
            // return true;
        }
    });
}