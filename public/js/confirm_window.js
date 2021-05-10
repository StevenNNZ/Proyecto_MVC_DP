function ConfirmDelete(){
    var respuesta = confirm("¿Realmente desea eliminar este campo?");
    
    if(respuesta==true){
        return true;
    }else{
        return false;
    }
}

function ConfirmUpdate(){
    var respuesta = confirm("¿Realmente desea actualizar este registro?");
    
    if(respuesta==true){
        return true;
    }else{
        return false;
    }
}

function ConfirmLeft(){
    var respuesta = confirm("¿Realmente desea retirar esta bahía?");
    
    if(respuesta==true){
        return true;
    }else{
        return false;
    }
}

function ConfirmLogOut(){
    Swal.fire({
        title: '¿Desea cerrar la sesión?',
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: `Cerrar sesión`,
        cancelButtonText: `Cancelar`,
      }).then((result) => {
        // Read more about isConfirmed, isDenied below
        if (result.isConfirmed) {
              Swal.fire('¡Sesión finalizada!', '', 'success');
            setTimeout(()=>{window.location.href="../Logout/logout.php"}, 1500);
            // return true;
        }
    })
}

function ConfirmLogOutSub(){
    Swal.fire({
        title: '¿Desea cerrar la sesión?',
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: `Cerrar sesión`,
        cancelButtonText: `Cancelar`,
      }).then((result) => {
        // Read more about isConfirmed, isDenied below
        if (result.isConfirmed) {
              Swal.fire('¡Sesión finalizada!', '', 'success');
            setTimeout(()=>{window.location.href="../../Logout/logout.php"}, 1500);
            // return true;
        }
    })
}