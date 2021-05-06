$(document).ready(function() {

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
            </div>`;
            
        }else{
            //Llamado al controlador de 
            $.post("../../controller/reporte_venta.php?op=combo&desde="+desde+"&hasta="+hasta+"",function(data, status){
                    $('#contenedor_resultado').html(data);
            
    
            });
        }
    });
});