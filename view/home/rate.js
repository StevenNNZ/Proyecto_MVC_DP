$('#add_rate').on('click', function(){
    tarifa('');
    function tarifa(mensaje){
        swal.fire({
            title: 'Registrar tarifa',
	        icon: 'info',
            html: 
            `${mensaje}
            <fieldset class="fieldset second" style="width:100%"><legend style="text-align:left">Tipo vehículo</legend>
                <div class="input-contenedor" style="width:100%"> 
                    <select name="tipo" id="tipo" class="controls" style="width:100%">
                        <option value="seleccionar">Seleccionar</option>
                        <option value="Carro">Carro</option>
                        <option value="Moto">Moto</option>
                        <option value="Bicicleta">Bicicleta</option>
                    </select>
                </div>
            </fieldset>
            <fieldset class="fieldset second" style="width:100%"><legend style="text-align:left">Valor tarifa</legend>
            <div class="input-contenedor" style="width:100%">
                <input type="number" style="width:100%" class="input_registrar" name="valor" id="valor" placeholder="Introducir..." required>
            </div>
            </fieldset>`,
            confirmButtonText:'Registrar',
            showCancelButton:true,
            preConfirm: () => {
                // function guardaryeditar(e){
                    let tipo = $('#tipo').val();
                    let valor = $('#valor').val();
                    if(tipo=='seleccionar' || valor==''){
                        tarifa(
                            `<div class='alert alert_danger alert_sm' id='contenedor-alerta-reportes_venta' style='animation-delay: .2s;margin:0 auto; width:100%; margin-bottom:10px'>
                                <div class='alert--icon'>
                                    <i class='fas fa-bell'></i>
                                </div>
                                <div class='alert--content'>
                                    Asegúrese de introducir ambos campos.
                                </div>
                            </div>`
                        );
                    }else{
                        $.post(`../../controller/tarifa.php?op=insert&tipo=${tipo}&valor=${valor}`,function(data, status){
                        })
            
                        .done(function() {
                                Swal.fire({
                                    title: "¡Enhorabuena!",
                                    text:"La tarifa se registró correctamente.",
                                    icon: 'success',
                                    confirmButtonText: 'Aceptar',
                                });
                        });
                    }
                    // $.ajax({
                    //     url: "../../controller/tarifa.php?op=insert",
                    //     type: "POST",
                    //     data: {'tipo':tipo, 'valor':valor},
                    //     contentType: false,
                    //     processData: false,
                    //     success: function(datos){
                    //         console.log(datos)
                    //         Swal.fire({
                    //             title: "¡Correcto!",
                    //             text:"Registrado correctamente.",
                    //             icon: 'success',
                    //             confirmButtonText: 'Aceptar',
                    //         });
                    //     }
                    // });
                // }
                }
            })
        }
});

// Swal.fire({
//     title: 'Submit your Github username',
//     input: 'text',
//     inputAttributes: {
//       autocapitalize: 'off'
//     },
//     showCancelButton: true,
//     confirmButtonText: 'Look up',
//     showLoaderOnConfirm: true,
//     preConfirm: (login) => {
//       return fetch(`//api.github.com/users/${login}`)
//         .then(response => {
//           if (!response.ok) {
//             throw new Error(response.statusText)
//           }
//           return response.json()
//         })
//         .catch(error => {
//           Swal.showValidationMessage(
//             `Request failed: ${error}`
//           )
//         })
//     },
//     allowOutsideClick: () => !Swal.isLoading()
//   }).then((result) => {
//     if (result.isConfirmed) {
//       Swal.fire({
//         title: `${result.value.login}'s avatar`,
//         imageUrl: result.value.avatar_url
//       })
//     }
//   }