function cargarBahia(){
    const contenedor = $('#contenedor_resultado');
    contenedor.html(Spinner);

    setTimeout(() => {
        $.post("../../controller/bahia.php?op=getBahiasActivas",function(data, status){
            contenedor.html(data);
        })
    }, 1700);
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

            let id_salida;

            $.post(`../../controller/bahia.php?op=retirarBahia&id=${id}&id_entrada=${id_entrada}&user_active=${user_active}`,function(data, status){
                Swal.fire('¡Bahía retirada con éxito!', '', 'success');
                id_salida = data;
            })
            .done(function(){
                cargarBahia();
                window.open(`../viewPDF/pdfTickSalida/?id_ticket_salida=${id_salida}`);
            });
            
            // return true;
        }
    });
}