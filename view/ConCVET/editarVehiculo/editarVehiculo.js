$(document).ready(function() {
    let id = $('#id_vehiculo').val();
    let user = $('#id_usuario_responsable').val();
    let rol = $('#cargo_user').val();
    const contenedor = $('#contenedor_resultado');

    contenedor.html(Spinner);
    
    $.post("../../../controller/vehiculo.php?op=showEditarVehiculo&placa="+id,function(data, status){
        contenedor.html(data);

        function init(){
            $("#form_editar").on("submit",function(e){
                var boton = $('#button_action');
                boton.html('enviando...');
                boton.prop('disabled', true);
                guardaryeditar(e);
            });
        }

        function guardaryeditar(e){
            e.preventDefault();
            var formData = new FormData($("#form_editar")[0]);
            $.ajax({
                url: "../../../controller/vehiculo.php?op=updateVehiculo&id="+id+"&user="+user,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(datos){
                    console.log(datos);
                    var boton = $('#button_action');
                    if(typeof datos == 'string' && datos != ''){
                        Swal.fire({
                            title: "¡Oops!",
                            text:"Algo ha salido mal, por favor inténtelo en unos minutos...",
                            icon: 'error',
                            confirmButtonText: 'Aceptar',
                            
                        });
                        boton.html('Registrar');
                        boton.prop('disabled', false);
                    }else{
                        boton.html('Registrar');
                        boton.prop('disabled', false);
                        Swal.fire({
                            title: "¡Correcto!",
                            text:"Actualizado correctamente.",
                            icon: 'success',
                            confirmButtonText: 'Aceptar',
                            
                        });
                        setInterval(()=>{
                            if(rol == 'Administrador'){
                                location.href = '../'
                            }else if(rol == 'Cajero'){
                                location.href = '../../Cliente/Consultar/'
                            }
                        
                        }, 1000);
                        
                    }
                }
            });
        }
        init();
    })
});


