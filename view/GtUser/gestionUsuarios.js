function cargarUser(search){
    //Llamado al controlador de 
        $.post("../../controller/gest_user.php?op=combo&search="+search+"",function(data, status){
                $('#contenedor_resultado').html(data);
        });
}

$(document).ready(function() {
    $('#search_usuario').on('keyup', function(){
        let search = $('#search_usuario').val();
        cargarUser(search);
    });

    
});

function deleteUser(documento){
    Swal.fire({
        title: '¿Realmente desea eliminar este campo?',
        showDenyButton: false,
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: `Eliminar`,
        cancelButtonText: `Cancelar`,
      }).then((result) => {
        // Read more about isConfirmed, isDenied below
        if (result.isConfirmed) {
            $.post("../../controller/gest_user.php?op=delete&documento="+documento+"",function(data, status){
                console.log(data);
                Swal.fire('¡Campo eliminado!', '', 'success');
                let search = '';
                cargarUser($(search));
            });
            // return true;
        }
    })
}

function estadoUser($documento){
    
}

function updateUser(documento){
    Swal.fire({
        title: '¿Está seguro de editar este campo?',
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: `Editar`,
        cancelButtonText: `Cancelar`,
      }).then((result) => {
        // Read more about isConfirmed, isDenied below
        if (result.isConfirmed) {
            window.location.href="editarUsuario/?id="+documento;
            // return true;
        }
    })
}