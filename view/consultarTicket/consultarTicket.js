$(document).ready(function() {
        console.log('funciona...');
        $.post("../../controller/ticket.php?op=listar_ticket",function(data, status){
            // console.log(data);
            // document.getElementById('contenedor_resultado').innerHTML = data;
            $('#contenedor_resultado').html(data);
        });
        
});