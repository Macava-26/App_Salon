let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;


const cita = {
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

document.addEventListener('DOMContentLoaded', function () {
    iniciarApp();

});

function iniciarApp() {
    mostrarSeccion();
    tabs(); //Cambiar la seccion al presionar los Tabs
    botonesPaginador(); //Agregar y/o quitar botones
    paginaAnterior();
    paginaSiguiente();

    consultarAPI(); //Consulta la API en el backend

    nombreCliente(); //Añada el nombre al arreglo de la cita
    seleccionarFecha(); //Añada la fecha al objeto
    seleccionarHora(); //Añade la hora al objeto

    mostrarResumen(); //Resumen de los datos de cita


}

function mostrarSeccion() {

    //Ocultar Seccion

    const seccionAnterior = document.querySelector('.mostrar');
    if (seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }

    const pasoSelector = `#paso-${paso}`;  //Llamar por ID
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');

    //Quitar clase "ACTUAL" de tabs
    const tabAnterior = document.querySelector('.actual');
    if (tabAnterior) {
        tabAnterior.classList.remove('actual');
    }

    //Agregar clase "Actual" A tabs
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');

}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach(boton => {
        boton.addEventListener('click', function (e) {


            paso = parseInt(e.target.dataset.paso);

            mostrarSeccion();
            botonesPaginador();
        });
    });
}

function botonesPaginador() {
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');


    if (paso === 1) {
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    } else if (paso === 2) {
        paginaAnterior.classList.remove('ocultar');
        paginaAnterior.classList.remove('ocultar');
    } else if (paso === 3) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');

        mostrarResumen();
    }

    mostrarSeccion();
}

function paginaAnterior() {
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function () {
        if (paso <= pasoInicial) return;
        paso--;

        botonesPaginador();

    });
}

function paginaSiguiente() {
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function () {
        if (paso >= pasoFinal) return;
        paso++;

        botonesPaginador();

    });
}

async function consultarAPI() {

    try {
        const url = 'http://localhost:3000/api/servicios';
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);
    } catch (error) {
        console.log(error);
    }
}


function mostrarServicios(servicios) {
    servicios.forEach(servicio => {
        const { id, nombre, precio } = servicio;


        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$${precio}`;


        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicios');
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = function () {
            seleccionarServicio(servicio);
        }

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        document.querySelector('#servicios').appendChild(servicioDiv);
    });
}

function seleccionarServicio(servicio) {
    const { id } = servicio;
    const { servicios } = cita;

    //identifica el elemento seleccionado
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);


    if (servicios.some(agregado => agregado.id === id)) {
        cita.servicios = servicios.filter(agregado => agregado.id !== id);
        divServicio.classList.remove('seleccionado');
    } else {
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add('seleccionado');
    }
}

function nombreCliente() {
    cita.nombre = document.querySelector('#nombre').value;
}

function seleccionarFecha() {
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function (e) {

        const dia = new Date(e.target.value).getUTCDay();

        if ([0].includes(dia)) {
            e.target.value = '';
            mostrarAlerta('Los Domingos no abrimos, disculpa las molestias', 'error', '.formulario');
        } else {
            cita.fecha = e.target.value;
        }
    });
}

function seleccionarHora() {
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function(e) {
        const horaCita = e.target.value;
        const hora =horaCita.split(":");
        if(hora < '09:00' || hora > '20:00') {
            e.target.value = '';
        mostrarAlerta('Nuestro horario es de 10 am a 9 pm', 'error','.formulario');
        } else {
            cita.hora = e.target.value;

            console.log(cita);
        }
    })
}

function mostrarResumen() {
    const resumen = document.querySelector(".contenido-resumen");

    if(Object.values(cita).includes('') || cita.servicios.length === 0) {
        mostrarAlerta('Asegurate que todos los campos o servicios esten correctos','error', '.contenido-resumen');
    } else {
        console.log('Todo bien');
    }
}

function mostrarAlerta(mensaje, tipo, elemento) {
    //Preveer el duplicado de la alerta
    const alertaPrevia = document.querySelector('.alerta');
    if (alertaPrevia) return;

    //Scriptin de alerta
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const formulario = document.querySelector(elemento);
    formulario.appendChild(alerta);

    //Eliminar alerta
    setTimeout(() => {
        alerta.remove();
    }, 3000);
}

