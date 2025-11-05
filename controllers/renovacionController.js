$(document).ready(function () {
    // 🔸 Fecha actual por defecto si está vacía
    let hoy = new Date();
    let dia = ("0" + hoy.getDate()).slice(-2);
    let mes = ("0" + (hoy.getMonth() + 1)).slice(-2);
    let año = hoy.getFullYear();
    let fechaLocal = `${año}-${mes}-${dia}`;
    if (!$("#fechaInicio").val()) {
        $("#fechaInicio").val(fechaLocal);
    }

    // 🔸 Función para actualizar los campos según la membresía
    function actualizarCampos() {
        let selected = $("#tipoMembresia").find(":selected");
        let precio = parseFloat(selected.data("precio")) || 0;
        let dias = parseInt(selected.data("dias")) || 0;

        if (!precio) return; // Si no hay selección válida, no hace nada

        // 🔹 Calcular fecha de término
        let fechaInicio = new Date($("#fechaInicio").val());
        fechaInicio.setDate(fechaInicio.getDate() + dias);

        let dia = ("0" + fechaInicio.getDate()).slice(-2);
        let mes = ("0" + (fechaInicio.getMonth() + 1)).slice(-2);
        let año = fechaInicio.getFullYear();
        let fechaFin = `${año}-${mes}-${dia}`;

        // 🔹 Formato moneda MXN
        let precioFormateado = precio.toLocaleString("es-MX", {
            style: "currency",
            currency: "MXN",
            minimumFractionDigits: 2
        });

        // 🔹 Actualizar campos
        $("#costo").val(precioFormateado);
        $("#fechaTermino").val(fechaFin);
    }

    // Ejecutar una vez al cargar (por si ya hay membresía seleccionada)
    actualizarCampos();

    // Al cambiar la membresía
    $("#tipoMembresia").on("change", actualizarCampos);

    // Si cambian la fecha de inicio, recalcular término
    $("#fechaInicio").on("change", actualizarCampos);


    /**********************FUNCIÓN PARA REGISTRAR RENOVACIÓN  *************** */
$(document).on('submit', '#renovarMembresia', function(e) {
	e.preventDefault();
	  var formData = new FormData(document.getElementById("renovarMembresia"));
	  $.ajax({
		url: "../models/clientes/registrarRenovacion.php",
		type: "post",
		dataType: "html",
		data: formData,
		cache: false,
		contentType: false,
		processData: false,
		success: function(data) {
		  console.log(data);
		  var json = JSON.parse(data);
		  var status = json.status;
		  if (status == 'true') {
			$("#renovarMembresia").trigger("reset");
			Swal.fire({
			  position: 'top-center',
			  icon: 'success',
			  title: '¡ Registro exitoso !',
			  showConfirmButton: false,
			  timer: 1500,    
			}).then(() => {
				var urlParams = new URLSearchParams(window.location.search);
                var newUrl = 'control.php';
					window.location.href = newUrl;
			  });
		   }
		},
		error: function(xhr, status, error) {
		  console.error(xhr.responseText);
		  console.error("Status: " + status);
		  console.error("Error: " + error);
		}
	  });
});
});
