$(document).ready(function() {
    const id = $('#id_usuario').val();
    const user = $('#id_usuario_responsable').val();

    
        $.post("../../../controller/usuario.php?op=showEditarUsuario&documento="+id,function(data, status){
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
                    url: "../../../controller/usuario.php?op=updateUser&id="+id+"&user="+user,
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
                            console.log(datos);
                            console.log(typeof datos);
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


