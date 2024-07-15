let paso = 1;

const citas = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
    
}

document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
    
})

function iniciarApp(){
    tabs(); //funcion para mostrar seccion.
    mostrarSeccion(); //muestra las secciones..
    botonesPaginador(); //quita o agrega botones de paginador.
    eventoBotones(); //agrega evento a botones
    serviciosAPI(); //consulta a una api los servicios..
    llenarNombreObjeto(); //Agrega nombre al objeto citas
    llenarFecha(); //Agrega fecha al ser escritas por el usuario.
    llenarHora(); //Agrega al objeto la hora input..
    llenarIdObjeto();
    
}


function eventoBotones(e){
    botonAnterior = document.querySelector('#anterior');
    botonSiguiente = document.querySelector('#siguiente');

    botonAnterior.addEventListener('click', function(){
    paso--;
    mostrarSeccion();
    botonesPaginador()
    });
    botonSiguiente.addEventListener('click', function(){
    paso++;
    mostrarSeccion();
    botonesPaginador();
    });
}

function botonesPaginador(){
    
    botonAnterior = document.querySelector('#anterior');
    botonSiguiente = document.querySelector('#siguiente');

    if(paso === 1){
        botonAnterior.classList.add('hidden');
    }
    if(paso !== 1){
        botonAnterior.classList.remove('hidden')
    }
    if(paso === 3){
        botonSiguiente.classList.add('hidden');
    }
    if(paso !== 3){
        botonSiguiente.classList.remove('hidden');
    }
    
}

function mostrarSeccion(boton){
    //quitar mostrar a seccion anterior
    let seccionAnterior = document.querySelector('.mostrar');
    let botonAnterior = document.querySelector('.actual');
    if(seccionAnterior){
        seccionAnterior.classList.remove('mostrar');
        botonAnterior.classList.remove('actual');
    }
    if(paso === 3 ){
        mostrarResumen();
    }
    //Agrega mostrar a seccion seleccionada.
    let seccion = document.querySelector(`#paso-${paso}`)
    seccion.classList.add('mostrar');

    //Resalto seccion actual.
    boton = document.querySelector(`[data-paso='${paso}']`);
    boton.classList.add('actual');
}

function tabs(){
    let botones = document.querySelectorAll('.tabs button')
    botones.forEach( (boton) => {
        boton.addEventListener('click', function(e){
            paso = parseInt(e.target.dataset.paso);
            mostrarSeccion();
            botonesPaginador();
            /* boton.classList.toggle('actual') */
        })
    })

}

async function serviciosAPI(){

    try {
        const url = `${location.origin}/api/servicios`;
        const resultado = await fetch(url);
        const json = await resultado.json();
        mostrarServicios(json);
        
    } catch (error) {
        console.log(error);
    }

}

function mostrarServicios(servicios){
    servicios.forEach( servicio => {
        const { id, nombre, precio} = servicio;
        
        //creo parrafo de nombre, precio y lo inserto en el html..

        let nombreServicio = document.createElement('P');
        nombreServicio.textContent = nombre;
        nombreServicio.classList.add('nombre-servicio')

        let precioServicio = document.createElement('P');
        precioServicio.textContent = precio;
        precioServicio.classList.add('precio-servicio')

        let divServicio = document.createElement('DIV');
        divServicio.classList.add('servicio')
        divServicio.dataset.idServicio = id;
        divServicio.onclick = function(){
            seleccionarServicio(servicio);
        };

        divServicio.appendChild(nombreServicio);
        divServicio.appendChild(precioServicio);

        document.querySelector('#servicios').appendChild(divServicio);

    })
}
function seleccionarServicio(servicio){
    const {id } = servicio;
    const { servicios } = citas;
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`)

    //comprobar si el servicio seleccionado ya esta guardado en el objeto en memoria...
    if(servicios.some( enMemoria => enMemoria.id === id)){
        //Eliminar servicio 
        divServicio.classList.remove('seleccionado');
        //crear un array con todos los servicios que sean diferentes al id del servicio que fue clickeado...
        citas.servicios = servicios.filter( agregado => agregado.id !== id)

    }else{
        //agregar servicio
        citas.servicios = [...servicios, servicio];
        divServicio.classList.add('seleccionado');
    }

}

function llenarNombreObjeto(){
    const nombre = document.getElementById('nombre').value;
    citas.nombre = nombre;
}
function llenarIdObjeto(){
    const id = document.getElementById('id').value;
    citas.id = id;
}
function llenarFecha(){
    const fecha = document.getElementById('fecha');
    fecha.addEventListener('input', (e)=>{
        const diasFestivos = [6, 0];
        const diaSeleccionado = new Date(e.target.value).getUTCDay()
        const contenedor = '.formulario';
        /* if(new Date(fecha.value).getUTCDay() === 6 || new Date(fecha.value).getUTCDay() === 0){ */
        if(diasFestivos.includes(diaSeleccionado)){
            e.target.value = '';
            mostrarAlerta('Domingos y festivos no permitidos...', 'error', contenedor)

        }else{
            citas.fecha = e.target.value;
        }
    })

    

}
function llenarHora(){

    const hora = document.getElementById('hora');
    hora.addEventListener('input', (e)=>{
        const horaCita = e.target.value;
        const hora = horaCita.split(":")[0];
        const horaMinima = 8;
        const horaMaxima = 16;
        const contenedor = '.formulario'
         if(hora < horaMinima || hora > horaMaxima){
            e.target.value = '';
            citas.hora = '';
            mostrarAlerta(`Las hora minima es: ${horaMaxima} y la hora maxima para atender es: ${horaMaxima} `, 'error', contenedor)

        }else{
            citas.hora = horaCita;
        }
    })
}
function mostrarAlerta(mensaje, tipo, contenedor, desaparece = true){
    const alertaPrevio = document.querySelector('.alerta');
    if(alertaPrevio) {
        alertaPrevio.remove();
    };
    const alerta = document.createElement('DIV')
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);
    const formulario = document.querySelector(contenedor)
    formulario.appendChild(alerta);

    if(desaparece){
        setTimeout(() => {
            alerta.remove();
        }, 3000);

    }

}

function mostrarResumen(){
    const values = Object.values(citas);
    const faltanDatos = values.includes('');
    const hayServicios = citas.servicios.length >= 1;
    const contenedor = '#paso-3';
    const resumen = document.querySelector('#paso-3')

    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild)
    }

    if(faltanDatos || !hayServicios){
        mostrarAlerta('Faltan datos...', 'error', contenedor, false)
        return
    }
        //Scripting
        const {nombre, fecha, hora, servicios} = citas;

        const nombreP = document.createElement('P');
        nombreP.innerHTML = `<span>Nombre: </span> ${nombre}`;

        const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'}
        const fechaFormato = new Date(fecha);
        const day = fechaFormato.getDate() +2;
        const month = fechaFormato.getMonth();
        const year = fechaFormato.getFullYear();
        const fechaUTC = new Date( Date.UTC(year, month, day))

        const fechaFormateada = fechaUTC.toLocaleDateString('es-MX', opciones);
        const fechaP = document.createElement('P');
        fechaP.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

        const horaP = document.createElement('P');
        horaP.innerHTML = `<span>Hora: </span> ${hora}`;


        const servicioDIV = document.createElement("DIV");
        servicioDIV.classList.add('serviciosDiv-resumen')
        const parrafo = document.createElement('P');
        parrafo.textContent = 'Servicios elegidos:'
        parrafo.classList.add('servicios-resumen-titulo')
        servicioDIV.appendChild(parrafo);
        servicios.forEach( servicio=> {
            const { id, nombre, precio} = servicio;
            const infoServicioDIV = document.createElement("DIV");
            infoServicioDIV.classList.add('servicios-resumen-info')

            const servicioNombre = document.createElement('P');
            servicioNombre.textContent = nombre;
            servicioNombre.classList.add('servicio-resumen-nombre')

            const servicioPrecio = document.createElement('P');
            servicioPrecio.innerHTML = `<span>Precio: </span> $${precio}`;
            infoServicioDIV.appendChild(servicioNombre);
            infoServicioDIV.appendChild(servicioPrecio);
            servicioDIV.appendChild(infoServicioDIV);
        })


        const DIV = document.querySelector('#paso-3')
        DIV.innerHTML = `
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la informacion sea correcta</p>
        `

        //boton para crear Cita:
        const botonReservar = document.createElement('BUTTON');
        botonReservar.textContent = 'Reservar la cita';
        botonReservar.classList.add('nombre')
        botonReservar.onclick = reservarCita;

        DIV.appendChild(nombreP);
        DIV.appendChild(fechaP);
        DIV.appendChild(horaP);
        DIV.appendChild(servicioDIV);
        DIV.appendChild(botonReservar);
    
    
}
//Funcion para enviar peticion al servidor:
async function reservarCita(){
    const {nombre, fecha, hora, servicios, id} = citas;

    const datos = new FormData();
    datos.append('usuariosId', id);
    datos.append('nombre', nombre);
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    
    const serviciosId = servicios.map(servicio=> servicio.id);
    datos.append('servicios', serviciosId);

// peticion a la api
try {
    const url = `${location.origin}/api/citas`;
    const options = {
        method : 'POST',
        body : datos
    }
    const respuesta = await fetch(url, options )
    const resultado = await respuesta.json();
    if(resultado.resultado){
        Swal.fire({
            icon: "success",
            title: "Cita creada",
            text: "La cita fue creada correctamente",
            button: 'OK'
          }).then(() =>{
            window.location.reload();       
          })
    }
    
} catch (error) {
    Swal.fire({
        icon: "error",
        title: "Ha habido un error",
        text: "La cita no se pudo crear.."
      });
}
    
    


}