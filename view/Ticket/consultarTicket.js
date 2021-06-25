function cargarTicketEntrada(){
    $.post("../../controller/ticket.php?op=listar_ticketE",function(data, status){
        $('#contenedor_resultado').html(data);
    })
}

function cargarTicketSalida(){
    $.post("../../controller/ticket.php?op=listar_ticketS",function(data, status){
        $('#contenedor_resultado').html(data);
    })
}

$(document).ready(function() {
        $('#Consultar_ticketE').on('click', function(){
            //Llamado al controlador de 
            cargarTicketEntrada();
        });
    
        $('#Consultar_ticketS').on('click', function(){
            //Llamado al controlador de 
            cargarTicketSalida();
        });
    
        function info(mensaje){
            Swal.fire({
                title: "¿Qué hace este botón?",
                html:"Muestra los <b>"+mensaje+"</b> que se encuentran <br>activos en este momento.",
                icon: 'info',
                confirmButtonText: 'Aceptar',
                toast: true,
                position: 'bottom-end',
            });
        }
    
        $('#info_ticketE').on('click', function(){
            info("tickets de entrada");
        });
    
        $('#info_ticketS').on('click', function(){
            info("tickets de salida");
        });
    
});

function terminarTicketEntrada(id, user_active = $('#user-active').val()){
    console.log(id);
    $.post("../../controller/ticket.php?op=terminarTicketE&id="+id+"&user_active="+user_active,function(data, status){
        Swal.fire('¡Ticket generado con éxito!', '', 'success');
    });
    cargarTicketEntrada();
        
}


//GENERAR TICKET DE SALIDA
function getTicketSalida(id_salida, user_active = $('#user-active').val()){

    $.post("../../controller/ticket.php?op=terminarTicketSalida&id="+id_salida+"&user_active="+user_active,function(data, status){
    })
    .done(function(){
        cargarTicketSalida();
        Swal.fire('¡Ticket generado con éxito!', '', 'success');
        window.open(`../viewPDF/pdfTickSalida/?id_ticket_salida=${id_salida}`);
    });
}

