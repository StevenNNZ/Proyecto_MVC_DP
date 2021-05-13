// Declaración de constantes para el login
const clickuno = document.querySelector('.close_registro_usuario')
const tarifa_click = document.querySelector('.tarifa_click')
const contenedorTarifa = document.querySelector('.registro_usuario-contenedor')


//Login
//Validación del target (click) al botón de cerrar el login
contenedorTarifa.addEventListener('click', (e)=>{
    if(e.target == clickuno){
        contenedorTarifa.classList.toggle('show_login')
         hamburguer1.style.opacity = '1'
         
    }
})
//Evento para hacer visible el formulario de login
tarifa_click.addEventListener('click', ()=>{
    contenedorTarifa.classList.toggle('show_login')
     hamburguer1.style.opacity = '0'
})

