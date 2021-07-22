$(document).ready(function() {
    const contenedor = $('#contenedor_resultado');

    $('#consultar_reportes').on('click', function(){
        const desde = $('#desde').val();
        const hasta = $('#hasta').val();

        if(!isNaN(desde) || !isNaN(hasta)){
            contenedor.html(`
            <div class='alert alert_warning alert_sm' id='contenedor-alerta' style='animation-delay: .2s;margin:0 auto;'>
                <div class='alert--icon'>
                    <i class='fas fa-bell'></i>
                </div>
                <div class='alert--content'>
                    Por favor asegúrese de ingresar el rango <b>'Desde'</b> y <b>'Hasta'</b>
                </div>
            </div>`);
            
        }else{
            contenedor.html(Spinner);

            setTimeout(() => {
                //Llamado al controlador de reportes venta
                $.post("../../controller/reporte_venta.php?op=reporteVenta&desde="+desde+"&hasta="+hasta+"",function(data, status){
                    contenedor.html(data);
                    
                });
            }, 1000);
        }
    });
});