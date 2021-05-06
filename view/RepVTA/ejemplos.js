// Se ejecuta este código cuando se haya cargado completamente nuestra página
$(document).ready(function() {
    $('#ticket_descrip').summernote({height:'200'});

    // Se llama el controlador categoría y se envia un elemento llamado "op" con el valor de "combo", este elemento lo recibo el controlador y hace lo que le corresponde. 
    $.post("../../controller/categoria.php?op=combo",function(data, status){
        // A la etiqueta con id='cata_id' se le envía un contenido. Este contenido viene desde el controlador 'categoria', y se recupera con la palabra 'data'
        $('#cata_id').html(data);
    });
});

$(document).ready(function(){
    $('#desde').focus();

    $('#consultar_reportes').on('click', function(){
        let desde = $('#desde').val();
        let hasta = $('#hasta').val();

        if(!isNaN(desde) || !isNaN(hasta)){
            document.getElementById('contenedor_resultado').innerHTML = `
            <div class='alert alert_warning alert_sm' id='contenedor-alerta-reportes_venta' style='animation-delay: .2s;margin:0 auto;'>
                <div class='alert--icon'>
                    <i class='fas fa-bell'></i>
                </div>
                <div class='alert--content'>
                    Por favor asegúrese de ingresar el rango <b>'Desde'</b> y <b>'Hasta'</b>
                </div>
                <div class='alert--close'>
                    <i class='far fa-times-circle'></i>
                </div>
            </div>`;
            
        }else{
            $.ajax({
                type: 'POST',
                url: '../modelo/busqueda_reportes.php',
                data: {'desde':desde, 'hasta':hasta},
                // data: {'hasta':hasta},

                beforeSend: function(){
                    $('#contenedor_resultado').html('<p class="cargando_resultado">Cargando...</P')
                }
            })

            .done(function(resultado){
                $('#contenedor_resultado').html(resultado);
            })

            .fail(function(){
                alert("Hubo un error :(");
            })
        }
    })
})