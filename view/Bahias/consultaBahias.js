function cargarBahia(){
    $.post("../../controller/consCVET.php?op=bahiasActivas",function(data, status){
        $('#contenedor_resultado').html(data);
    })
}

$(document).ready(function() {
    cargarBahia();
            
});


function retirarBahia(id, id_entrada, user_active = $('#user-active').val()){
    Swal.fire({
        title: '¿Está seguro de retirar esta bahía?',
        showDenyButton: false,
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: `Retirar`,
        cancelButtonText: `Cancelar`,
      }).then((result) => {
        // Read more about isConfirmed, isDenied below
        if (result.isConfirmed) {
            $.post("../../controller/consCVET.php?op=retirarBahia&id="+id+"&id_entrada="+id_entrada+"&user_active="+user_active,function(data, status){
                // Swal.fire('¡Campo eliminado!', '', 'error');
            })
            .done(function(){
                cargarBahia();
                window.open(`../pdfTickSalida/?id=${id}&id_entrada=${id_entrada}`);
            });
            
            // return true;
        }
    });
}