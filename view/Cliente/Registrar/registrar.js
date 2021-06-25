function init(){
    $("#form_bahia").on("submit",function(e){
        var boton = $('#button_action');
        boton.html('enviando...');
        boton.prop('disabled', true);
        console.log (boton)
        guardaryeditar(e);
    });
}

$(document).ready(function(){

});

function guardaryeditar(e){
    e.preventDefault();
    const documento = $('#documento_cliente').val();
    var formData = new FormData($("#form_bahia")[0]);
    $.ajax({
        url: "../../../controller/bahia.php?op=insert",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            var boton = $('#button_action');
            if(typeof datos == 'string' && datos != ''){
                console.log(datos);
                console.log(typeof datos);
                Swal.fire({
                    title: "¡Oops!",
                    text:"Algo ha salido mal, por favor inténtelo en unos minutos...",
                    icon: 'error',
                    confirmButtonText: 'Aceptar',
                    
                });
                boton.html('Registrar');
                boton.prop('disabled', false);
            }else{
                $('#documento_cliente').val('');
                $('#nombre_cliente').val('');
                $('#apellido_cliente').val('');
                $('#telefono_cliente').val('');
                $('#placa_vehiculo').val('');
                $('#color_vehiculo').val('');
                $('#modelo_vehiculo').val('');
                $('#tamano_vehiculo').val('');
                $('#tipo_vehiculo').val('');
                $('#num_estacionamiento').val('');
                $('#descripcion_esta').val('');
                boton.html('Registrar');
                boton.prop('disabled', false);
                Swal.fire({
                    title: "¡Correcto!",
                    text:"Registrado correctamente.",
                    icon: 'success',
                    confirmButtonText: 'Aceptar',
                    
                });
                document.getElementById('respuesta_registroBahia').innerHTML = `
                    <div class='alert alert_success alert_sm' id='contenedor-alerta-reportes_venta' style='animation-delay: .2s;margin:0 auto;'>
                        <div class='alert--icon'>
                            <i class='fas fa-bell'></i>
                            </div>
                            <div class='alert--content'>
                            Se ha generado un nuevo ticket. Haga <a href="../../Ticket/" style="color:#23ad5c;"><b>click aquí</b></a> para consultarlo.
                        </div>
                    </div>`;
                    
                    window.open(`../../viewPDF/pdfTickEntrada?doc=${documento}`);
            }
        }
    });
}
init();
