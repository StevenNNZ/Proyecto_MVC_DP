$(document).ready(function() {
    const contenedor = $('#contenedor_resultado')

    contenedor.html(Spinner);

    setTimeout(() => {
        
        //Llamado al controlador de 
        $.post("../../controller/tarifa.php?op=getTarifas&crud=false",function(data, status){
            contenedor.html(data);
        })
        .done(function() {
            $('#search_tarifa').on('keyup', function(){
                let search = $('#search_tarifa').val();
                $('#contenedor_tabla-general').html(Spinner);
                
                $.post("../../controller/tarifa.php?op=consultaTarifas&search="+search+"",function(data, status){
                    $('#contenedor_tabla-general').html(data);
                });
            });
        });
    }, 1000);
});