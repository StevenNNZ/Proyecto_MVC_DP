$(document).ready(function() {
    id = $('#id_usuario').val();
        $.post("../../../controller/gest_user.php?op=editarUsuario&documento="+id,function(data, status){
            $('#contenedor_resultado').html(data);
        })

});