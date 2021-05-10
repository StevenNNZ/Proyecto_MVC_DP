function init(){
    $("#form_bahia").on("submit",function(e){
        guardaryeditar(e);
    });
}

// Se ejecuta este código cuando se haya cargado completamente nuestra página
$(document).ready(function(){
    console.log("funcionando...");
});

function guardaryeditar(e){
    e.preventDefault();
    var formData = new FormData($("#form_bahia")[0]);
    console.log( formData.get('documento_cliente') );
    console.log( formData.get('nombre_cliente') );
    console.log( formData.get('apellido_cliente') );
    console.log( formData.get('telefono_cliente') );
    console.log( formData.get('placa_vehiculo') );
    console.log( formData.get('color_vehiculo') );
    console.log( formData.get('modelo_vehiculo') );
    console.log( formData.get('tamano_vehiculo') );
    console.log( formData.get('tipo_vehiculo') );
    console.log( formData.get('num_estacionamiento') );
    console.log( formData.get('descripcion_esta') );
    console.log( formData.get('id_usuario') );
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
            Swal.fire({
                title: "¡Correcto!",
                text:"Registrado correctamente.",
                icon: 'success',
                confirmButtonText: 'Aceptar',
                
            });
        }
    });
}
init();
