$(function () {

    inicializarEventos();

    $(document).ready(function () {
        $(".inputBuscador").each(function () {
            const input = this;
            const inputId = input.id;
            const sugerenciasId = input.getAttribute("data-sugerencias");
            const hiddenId = input.getAttribute("data-hidden-id");

            if (sugerenciasId && hiddenId) {
                inicializarBuscadorSucursal(inputId, sugerenciasId, hiddenId);
            }
        });
    });

});

let esMovil = window.innerWidth <= 1300;

function ajustarMenuEnResize() {
    const actualEsMovil = window.innerWidth <= 1300;

    if (esMovil !== actualEsMovil) {
        if (actualEsMovil) {
            $('#menuNavegacion').removeClass('mostrar');
            $('body').css('overflow', '');
        }
    }

    esMovil = actualEsMovil;
}

$(window).on('resize', ajustarMenuEnResize);
$(document).ready(ajustarMenuEnResize);


function inicializarEventos() {

    $(function () {
        const $menu = $('#menuNavegacion');
        const $body = $('body');

        $('#menuHamburguesa').on('click', function () {
            $('#menuNavegacion').toggleClass('mostrar');
            $(this).toggleClass('activo');

            $('body').css('overflow', function (index, value) {
                return value == 'hidden' ? '' : 'hidden';
            });
        });


        $(window).on('resize', function () {
            if (window.innerWidth > 1300) {
                $menu.removeClass('activo');
                $body.css('overflow', '');
            }
        }).trigger('resize');
    });

    $("#lightSlider").lightSlider({
        item: 1,
        speed: 2000,
        auto: true,
        loop: true,
        pause: 4000
    });


    $(window).on('resize', function () {
        const rutaActual = window.location.pathname + window.location.search;

        const rutasPermitidas = [
            "index.php?vista=detallesAlquiler"
        ];

        if (window.innerWidth > 1300 && rutasPermitidas.includes(rutaActual)) {
            window.location.href = "index.php?vista=inicio";
        }
    });


}


document.addEventListener("DOMContentLoaded", function () {

    flatpickr("#flatpickrCalendar", {
        mode: "range",
        enableTime: false,
        dateFormat: "Y-m-d",
        minDate: "today",
        locale: "es",
        onChange: function (selectedDates) {
            if (selectedDates.length === 2) {
                const [start, end] = selectedDates;

                const fechaRecogida = start.toLocaleDateString('sv-SE');
                const fechaDevolucion = end.toLocaleDateString('sv-SE');


                const textoRecogida = start.toLocaleDateString('es-ES');
                const textoDevolucion = end.toLocaleDateString('es-ES');

                // Guardar en inputs ocultos
                document.getElementById('fechaRecogida').value = fechaRecogida;
                document.getElementById('fechaDevolucion').value = fechaDevolucion;

                // Mostrar fechas por separado en la interfaz
                document.getElementById('recogidaFechaTexto').textContent = textoRecogida;
                document.getElementById('devolucionFechaTexto').textContent = textoDevolucion;
            }
        }
    });

    const form = document.getElementById("formFechas");
    if (form) {
        form.addEventListener("submit", function (event) {
            const horaRec = document.getElementById("horaRecogidaInput").value;
            const horaDev = document.getElementById("horaDevolucionInput").value;

            document.getElementById("horaRecogida").value = horaRec;
            document.getElementById("horaDevolucion").value = horaDev;
        });
    }

});

function abrirCalendario(cuadro) {
    const input = document.getElementById('flatpickrCalendar');
    const target = document.getElementById(cuadro); // "recogidaCuadro" o "devolucionCuadro"

    // Coloca el input sobre el cuadro clicado
    const rect = target.getBoundingClientRect();

    input.style.top = `${window.scrollY + rect.bottom}px`;
    input.style.left = `${window.scrollX + rect.left}px`;
    input.style.opacity = 1;
    input.style.pointerEvents = "auto";

    input._flatpickr.open();
}

function inicializarBuscadorSucursal(inputId, sugerenciasId, hiddenId) {
    const inputSucursal = document.getElementById(inputId);
    const sugerenciasDiv = document.getElementById(sugerenciasId);
    const hiddenInput = document.getElementById(hiddenId);

    if (!inputSucursal || !sugerenciasDiv || !hiddenInput) return;

    // Mostrar todas las sedes al hacer focus
    inputSucursal.addEventListener("focus", () => {
        obtenerSedesCache().then(sedes => {
            sugerenciasDiv.innerHTML = "";
            sedes.forEach(item => {
                const sugerencia = document.createElement("div");
                sugerencia.textContent = item.nombre_sede;
                sugerencia.classList.add("sugerenciasSucursal");
                sugerencia.onclick = () => {
                    inputSucursal.value = item.nombre_sede;
                    hiddenInput.value = item.id_sede; // Guardamos el ID
                    sugerenciasDiv.innerHTML = "";
                };
                sugerenciasDiv.appendChild(sugerencia);
            });
        });
    });

    // Filtrar al escribir
    inputSucursal.addEventListener("input", () => {
        const entrada = inputSucursal.value.trim().toLowerCase();
        sugerenciasDiv.innerHTML = "";
        hiddenInput.value = ""; // Limpiar ID hasta que se seleccione una sugerencia válida

        if (entrada.length < 2) return;

        obtenerSedesCache().then(sedes => {
            sedes.forEach(item => {
                if (item.nombre_sede.toLowerCase().includes(entrada)) {
                    const sugerencia = document.createElement("div");
                    sugerencia.textContent = item.nombre_sede;
                    sugerencia.classList.add("sugerenciasSucursal");
                    sugerencia.onclick = () => {
                        inputSucursal.value = item.nombre_sede;
                        hiddenInput.value = item.id_sede;
                        sugerenciasDiv.innerHTML = "";
                    };
                    sugerenciasDiv.appendChild(sugerencia);
                }
            });
        });
    });

    // Cerrar sugerencias si clic fuera
    document.addEventListener("click", (e) => {
        if (!sugerenciasDiv.contains(e.target) && e.target !== inputSucursal) {
            sugerenciasDiv.innerHTML = "";
        }
    });
}



window.addEventListener("load", () => {
    localStorage.removeItem('sedesCache');
});

let sedesCache = null;

function obtenerSedesCache() {
    if (sedesCache) {
        return Promise.resolve(sedesCache);
    }

    const sedesGuardadas = localStorage.getItem('sedesCache');
    if (sedesGuardadas) {
        sedesCache = JSON.parse(sedesGuardadas);
        return Promise.resolve(sedesCache);
    }

    return fetch('https://yellow-wren-221467.hostingersite.com/API_journey/obtenerSedes')
        .then(response => response.json())
        .then(data => {
            if (!data.sedes || !Array.isArray(data.sedes)) return [];
            sedesCache = data.sedes;
            localStorage.setItem('sedesCache', JSON.stringify(sedesCache));
            return sedesCache;
        })
        .catch(err => {
            console.error("Error obteniendo sedes:", err);
            return [];
        });
}


function actualizarHref() {
    const enlace = document.getElementById("editarReserva");
    if (!enlace) return;

    if (window.innerWidth > 1300) {
        enlace.href = "index.php?vista=inicio";
    } else {
        enlace.href = "index.php?vista=detallesAlquiler";
    }
}

// Ejecutar al cargar la página
window.addEventListener("load", actualizarHref);

// Ejecutar al redimensionar la ventana
window.addEventListener("resize", actualizarHref);