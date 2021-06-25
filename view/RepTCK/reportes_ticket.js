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
            $.post("../../controller/ticket.php?op=getReporteTickets&desde="+desde+"&hasta="+hasta+"&desdeH="+desdeH+"&hastaH="+hastaH+"",function(data, status){
                    $('#contenedor_resultado').html(data);
            });
        }
    });
});

function cargarTickets(){
    let desde = $('#desde').val(),
        desdeH = $('#desde_hora').val(),
        hasta = $('#hasta').val(),
        hastaH = $('#hasta_hora').val();
    $.post("../../controller/ticket.php?op=getReporteTickets&desde="+desde+"&hasta="+hasta+"&desdeH="+desdeH+"&hastaH="+hastaH+"",function(data, status){
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
            $.post("../../controller/ticket.php?op=deleteTicketSalida&id="+id+"&user_active="+user_active,function(data, status){
                Swal.fire('¡Campo eliminado!', '', 'error');
            })
            .done(function(){
                cargarTickets();
            });
            // return true;
        }
    });
}

function activarTicketSalida(id, user_active = $('#user-active').val()){
    Swal.fire({
        title: '¿Está seguro de activar este ticket?',
        showDenyButton: false,
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: `Activar`,
        cancelButtonText: `Cancelar`,
      }).then((result) => {
        // Read more about isConfirmed, isDenied below
        if (result.isConfirmed) {
            $.post("../../controller/ticket.php?op=activarTicketSalida&id="+id+"&user_active="+user_active,function(data, status){
                Swal.fire('¡Ticket activado!', '', 'success');
            })
            .done(function(){
                cargarTickets();
            });
            // return true;
        }
    });
}

//GENERAR TICKET DE SALIDA
function getTicketSalida(id_salida, user_active = $('#user-active').val()){
    $.post("../../controller/ticket.php?op=terminarTicketSalida&id="+id_salida+"&user_active="+user_active,function(data, status){
    })
    .done(function(){
        cargarTickets();
        Swal.fire('¡Ticket generado con éxito!', '', 'success');
        window.open(`../viewPDF/pdfTickSalida/?id_ticket_salida=${id_salida}`);
    });
}