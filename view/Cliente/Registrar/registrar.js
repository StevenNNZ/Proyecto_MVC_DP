function init(){
    $("#form_bahia").on("submit",function(e){
        guardaryeditar(e);
    });
}

$(document).ready(function(){
});

function guardaryeditar(e){
    e.preventDefault();
    var formData = new FormData($("#form_bahia")[0]);
    $.ajax({
        url: "../../../controller/bahia.php?op=insert",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
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
            // console.log(datos);
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

            location.href = '#respuesta_registroBahia';
        }
    });
}
init();
