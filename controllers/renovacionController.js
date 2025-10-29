$(document).ready(function () {
    /*********** FECHA ACTUAL EN INPUT DATE PARA EL REGISTRO DE CLIENTE ***********/
    let hoy = new Date();
    // Convierte a fecha local según la zona horaria del usuario
    let dia = ("0" + hoy.getDate()).slice(-2);
    let mes = ("0" + (hoy.getMonth() + 1)).slice(-2);
    let año = hoy.getFullYear();
    let fechaLocal = `${año}-${mes}-${dia}`;
    $("#fechaInicio").val(fechaLocal);

    /************* MOSTRAR PRECIO EN INPUT AL SELECCIONAR UN TIPO DE MEMBRESÍA ************/
    $("#tipoMembresia").on("change", function () {
        let precio = $(this).find(":selected").data("precio");
        let dias = parseInt($(this).find(":selected").data("dias")) || 0;

        // Calcular fecha de término
        let hoy = new Date();
        hoy.setDate(hoy.getDate() + dias);

        let dia = ("0" + hoy.getDate()).slice(-2);
        let mes = ("0" + (hoy.getMonth() + 1)).slice(-2);
        let año = hoy.getFullYear();
        let fechaFin = `${año}-${mes}-${dia}`;

        $("#costo").val("$ " + precio);
        $("#fechaTermino").val(fechaFin);
    });
});
