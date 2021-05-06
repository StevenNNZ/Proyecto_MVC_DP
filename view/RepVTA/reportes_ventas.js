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