$(document).ready(function() {
        $('#Consultar_ticketE').on('click', function(){
            //Llamado al controlador de 
            $.post("../../controller/ticket.php?op=listar_ticketE",function(data, status){
                $('#contenedor_resultado').html(data);
            })
        });
    
        $('#Consultar_ticketS').on('click', function(){
            //Llamado al controlador de 
            $.post("../../controller/ticket.php?op=listar_ticketS",function(data, status){
                $('#contenedor_resultado').html(data);
            })
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