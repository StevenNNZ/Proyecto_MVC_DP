$(document).ready(function() {
    //Llamado al controlador de 
    $.post("../../controller/tarifa.php?op=getTarifas&crud=false",function(data, status){
        $('#contenedor_resultado').html(data);
    })
    .done(function() {
        $('#search_tarifa').on('keyup', function(){
            let search = $('#search_tarifa').val();
            $.post("../../controller/tarifa.php?op=consultaTarifas&search="+search+"",function(data, status){
                $('#contenedor_tabla-general').html(data);
            });
        });
    });
});