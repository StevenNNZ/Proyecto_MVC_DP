$(document).ready(function() {
            //Llamado al controlador de 
            $.post("../../controller/consCVET.php?op=bahiasActivas",function(data, status){
                $('#contenedor_resultado').html(data);
            })

});