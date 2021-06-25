$(document).ready(function() {
    $('#consultar_reportes').on('click', function(){
        let search = $('#search_movimiento').val();
        if(search==''){
            document.getElementById('contenedor_resultado').innerHTML = `
            <div class='alert alert_warning alert_sm' id='contenedor-alerta-reportes_venta' style='animation-delay: .2s;margin:0 auto;'>
                <div class='alert--icon'>
                    <i class='fas fa-bell'></i>
                </div>
                <div class='alert--content'>
                    Por favor ingrese el <b>documento</b> del usuario a consultar.
                </div>
            </div>`;
        }else{
            $.post("../../controller/usuario.php?op=ultimos_movimientos&search="+search+"",function(data, status){
                $('#contenedor_resultado').html(data);
            })
        }
    });
});