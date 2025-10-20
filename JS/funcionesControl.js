$(document).ready(function () {

    const frases = [
        "Hoy le damos al fallo",
        "Que bien te ves hoy",
        "No cuentes los días, haz que los días cuenten.",
        "Ánimo que hoy es un gran día",
        "Con venir ya haz ganado."
    ];

    function obtenerFraseAleatoria() {
        const indiceAleatorio = Math.floor(Math.random() * frases.length);
        return frases[indiceAleatorio];
    }

    const fecha = new Date();
    const año = fecha.getFullYear(); // Devuelve el año
    const mes = fecha.getMonth() + 1; // Devuelve el mes (0-11)
    const dia = fecha.getDate(); // Devuelve el día del mes
    const hoy = año + '-' + mes + '-' + dia
    console.log(hoy)
    //Evento para controlar la entrada
    $('#control').submit(function (e) {
        event.preventDefault();
        const folio = $('#folio').val()
        $.post('../models/control/control.php', { folio }, function (response) {
            let cliente = JSON.parse(response);
            console.log(cliente)
            if (cliente.length === 0) {
                Swal.fire({
                    icon: "error",
                    title: "Usuario no encontrado",
                    text: "¿Desea inscribirse?",
                    showDenyButton: true,
                    confirmButtonText: "Si",
                    denyButtonText: `No`
                }).then((result) => {
                    if (result.isConfirmed) {
                        //Renovar membresía
                    } else if (result.isDenied) {
                        //Cancelar memebresia
                    }
                });
            } else {
                if (cliente.fecha_limite < hoy) {
                    Swal.fire({
                        icon: "error",
                        title: "Su membresía ha terminado",
                        text: "¿Acaso dejara de entrenar?",
                        showDenyButton: true,
                        confirmButtonText: "No",
                        denyButtonText: `Si`
                    }).then((result) => {
                        if (result.isConfirmed) {
                            //Renovar membresía
                        } else if (result.isDenied) {
                            //Cancelar memebresia
                        }
                    });
                } else {
                    const fechaLimite = new Date(cliente.fecha_limite);
                    const fechaHoy = new Date(hoy)
                    Swal.fire({
                        title: obtenerFraseAleatoria(),
                        html: "<span class='badge bg-gradient-primary'>Te restan: " + (fechaLimite - fechaHoy)/(1000 * 60 * 60 * 24) + " días</badge>",
                        icon: "success",
                    });
                }
            }
            $('#control').trigger('reset')
        })
    })

})