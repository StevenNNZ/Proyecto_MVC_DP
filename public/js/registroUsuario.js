$(document).ready(function() {
    function validarEmail(valor) {
        emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
        //Se muestra un texto a modo de ejemplo, luego va a ser un icono
        if (emailRegex.test(valor)) {
          return true;
        } else{
            return false;
        }
      }
    $('#registrarse').on('click', function(){
        usuario('');
        function usuario(mensaje, funcion){
            swal.fire({
                html: 
                `${mensaje}
                
                <div class="tittle">
                    <h1 class="tittle1">Registro </h1>
                    <h2 class="tittle2">usuario</h2>
                </div>
                <div class="sub">
                    <p class="sub-1">Digital</p>
                    <p class="sub-2">Parking</p>
                </div>      
                <fieldset class="fieldset-user"><legend class="legend-principal">Datos usuario</legend>
                        <div class="input_registro-contenedor required_row" id="contenedor_uno">
                            <i class="far fa-id-card icon-form"></i>
                            <input class="input_registro" type="number" name="documento_usuario" id="documento_usuario" placeholder="Número documento" required min="1000">
                        </div>
                        <div class="input_registro-contenedor required_row">
                            <i class="fas fa-user icon-form"></i>
                            <input type="text" class="input_registro" id="nombre_usuario"  name="nombre_usuario" placeholder="Nombre usuario" maxlength="50" required>
                        </div>
                        <div class="input_registro-contenedor">
                            <i class="far fa-user icon-form"></i>
                            <input class="input_registro" type="text" id="apellido_usuario" name="apellido_usuario" placeholder="Apellido usuario" maxlength="50" required>
                        </div>
                        <div class="input_registro-contenedor required_row" id="contenedor_email">
                            <i class="fas fa-envelope icon-form"></i>
                            <input class="input_registro" type="email" id="email_usuario" name="email_usuario" placeholder="Correo electrónico" required>
                        </div>
                        <fieldset class="fieldset-user second"><legend>Cargo</legend>
                            <div class="input_registro-contenedor required_row--active"> 
                                <i class="fas fa-briefcase icon-form"></i>
                                    <select name="cargo" id="cargo" class="controls_registro" required>
                                        <option value="seleccionar" selected="true"required>Seleccionar</option>
                                        <option value="Administrador">Administrador</option>
                                        <option value="Cajero">Cajero</option>
                                    </select>
                            </div>
                        </fieldset>
                        <div class="input_registro-contenedor required_row" id="contenedor_password">
                            <i class="fas fa-key icon-form"></i>
                            <input class="input_registro" type="password" id="contrasena" name="contrasena" placeholder="Contraseña" minlength="6" required >
                        </div>
                </fieldset>`,
                footer:`<i>Los campos marcados con <b style="color:rgb(251, 67, 67)">*</b> son obligatorios.</i>`,
                confirmButtonText:'Registrar',
                showCancelButton:true,
                allowOutsideClick: false,
                preConfirm: () => {
                        let documento = $('#documento_usuario').val();
                        let nombre = $('#nombre_usuario').val();
                        let apellido = $('#apellido_usuario').val();
                        let email = $('#email_usuario').val();
                        let cargo = $('#cargo').val();
                        let password = $('#contrasena').val();
                        if(documento=='' || nombre =='' || email == '' || cargo == 'seleccionar' || password == ''){
                            Swal.showValidationMessage(
                                `Por favor asegúrese de llenar los campos obligatorios.`
                              )
                        }else if(!validarEmail(email)){
                            Swal.showValidationMessage(
                                `Debe introducir un email válido.`,
                                document.getElementById('contenedor_email').classList.add('active'),
                                $('#email_usuario').on('click',()=>document.getElementById('contenedor_email').classList.remove('active'))
                              )
                        }else if(password.length < 8){
                            Swal.showValidationMessage(
                                `Su contraseña debe contener más de 8 caracteres.`,
                                document.getElementById('contenedor_password').classList.add('active'),
                                $('#contrasena').on('click',()=>document.getElementById('contenedor_password').classList.remove('active'))
                              )
                        }else{
                            let data = {
                                documento : documento,
                                nombre : nombre,
                                apellido : apellido,
                                email : email,
                                cargo : cargo,
                                password : password
                            };

                            $.ajax({
                                type: "POST",
                                url: "controller/usuario.php?op=insert",
                                data: data
                              })
                              .done(function(resultado){
                                if (resultado == 1){
                                    Swal.fire({
                                        title: "¡Enhorabuena!",
                                        text:"Se ha registrado correctamente. Por favor espere a que un administrador active su cuenta.",
                                        icon: 'success',
                                        confirmButtonText: 'Aceptar',
                                    });
                                }else if(resultado == 0){
                                    Swal.fire({
                                        title: "Algo salió mal...",
                                        text:"El documento y/o correo ya se encuentran registrados.",
                                        icon: 'error',
                                        confirmButtonText: 'Aceptar',
                                    });
                                }    
                            })
                        }
                    }
            })
        }
    });
});
    