$(document).ready(function() {
    let id = $('#id_tarifa').val();
    let user = $('#id_usuario_responsable').val();

    
        $.post("../../../controller/tarifa.php?op=showEditarTarifa&id="+id,function(data, status){
            $('#contenedor_resultado').html(data);

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
                    url: "../../../controller/tarifa.php?op=updateTarifa&id="+id+"&user="+user,
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
                            setInterval(()=>location.href = '../', 1000);
                            
                        }
                    }
                });
            }
            init();

        })

});


