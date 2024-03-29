function cargarUserBusqueda(search){
    const contenedor = $('#contenedor_resultado');
    contenedor.html(Spinner);
    
    //Llamado al controlador de 
    $.post("../../controller/usuario.php?op=getUsuariosBusqueda&search="+search+"",function(data, status){
        contenedor.html(data);
    });
}

const cargarAllUsers = ()=>{
    const contenedor = $('#contenedor_resultado');
    contenedor.html(Spinner);

    setTimeout(() => {
        $.post("../../controller/usuario.php?op=getAllUsuarios",function(data, status){
            contenedor.html(data);
        });
    }, 1000);
}

$(document).ready(function() {
    cargarAllUsers();

    $('#search_usuario').on('keyup', function(){
        let search = $('#search_usuario').val();
        cargarUserBusqueda(search);
    });
});

function deleteUser(documento, user_active = $('#user-active').val()){
    Swal.fire({
        title: '¿Realmente desea eliminar este campo?',
        showDenyButton: false,
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: `Eliminar`,
        cancelButtonText: `Cancelar`,
      }).then((result) => {
        if (result.isConfirmed) {
            $.post("../../controller/usuario.php?op=delete&documento="+documento+"&user_active="+user_active,function(data, status){
                console.log(data);
                Swal.fire('¡Campo eliminado!', '', 'error');
                let search = '';
                cargarUser(search);
            });
            // return true;
        }
    });
}

function activarUsuario(documento, user_active = $('#user-active').val()){
    Swal.fire({
        title: '¿Realmente desea activar este usuario?',
        showDenyButton: false,
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: `Activar`,
        cancelButtonText: `Cancelar`,
      }).then((result) => {
        // Read more about isConfirmed, isDenied below
        if (result.isConfirmed) {
            $.post("../../controller/usuario.php?op=activarUser&documento="+documento+"&user_active="+user_active,function(data, status){
                console.log(data);
                Swal.fire('¡Usuario activado!', '', 'success');
                let search = ' ';
                cargarUser(search);
            });
            // return true;
        }
    });
}

function desactivarUsuario(documento, user_active = $('#user-active').val()){
    Swal.fire({
        title: '¿Realmente desea desactivar este usuario?',
        showDenyButton: false,
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: `Desactivar`,
        cancelButtonText: `Cancelar`,
      }).then((result) => {
        // Read more about isConfirmed, isDenied below
        if (result.isConfirmed) {
            $.post("../../controller/usuario.php?op=desactivarUser&documento="+documento+"&user_active="+user_active,function(data, status){
                console.log(data);
                Swal.fire('¡Usuario desactivado!', '', 'success');
                let search = ' ';
                cargarUser(search);
            });
            // return true;
        }
    });
}

function updateUser(documento, estado){
    Swal.fire({
        title: '¿Está seguro de editar este campo?',
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: `Editar`,
        cancelButtonText: `Cancelar`,
      }).then((result) => {
        if (result.isConfirmed) {
            window.location.href="editarUsuario/?id="+documento+"&estado="+estado;
            // return true;
        }
    })
}