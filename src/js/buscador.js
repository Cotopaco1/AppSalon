document.addEventListener('DOMContentLoaded', function(){

    iniciarApp();

})

function iniciarApp(){

    buscador();
}

function buscador(){

    document.getElementById('fecha').addEventListener('input', e=>{

        console.log(e.target.value);
        const fecha = e.target.value;

        window.location = `?fecha=${fecha}`;

    })
}