$(document).ready(function() {
    $('#search_usuario').on('keyup', function(){
        let search = $('#search_usuario').val();
        //Llamado al controlador de 
            $.post("../../controller/gest_user.php?op=combo&search="+search+"",function(data, status){
                    $('#contenedor_resultado').html(data);
            });
    });
});