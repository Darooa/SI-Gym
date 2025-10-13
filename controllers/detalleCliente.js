$(document).ready(function() {
     /*************MOSTRAR PRECIO EN INPUT AL SELECCIONAR UN TIPO DE MEMBRESÍA EN FORMULARIO EDITAR************ */
    $("#edit_tipoMembresia").on("change", function () {
        let precio = $(this).find(":selected").data("precio");
        let dias = $(this).find(":selected").data("dias");
            let hoy = new Date();
            hoy.setDate(hoy.getDate() + dias);
            // Obtener fecha local del navegador
            let dia = ("0" + hoy.getDate()).slice(-2);
            let mes = ("0" + (hoy.getMonth() + 1)).slice(-2);
            let año = hoy.getFullYear();
            // Formato YYYY-MM-DD
            let fechaFin = `${año}-${mes}-${dia}`;
             $("#edit_costo").val("$ " + precio);
             $("#edit_fechaTermino").val(fechaFin);
    });


/*****************EDITAR CLIENTE ********************/
$(document).on('submit', '#editarCliente', function(e) {
   e.preventDefault();

   var edit_nombreCliente     = $('#edit_nombreCliente').val().trim();
   var edit_apellidosCliente  = $('#edit_apellidosCliente').val().trim();
   var edit_telefono          = $('#edit_telefono').val().trim();
   var edit_fecha_nac         = $('#edit_fecha_nac').val().trim();
   var edit_tipoMembresia     = $('#edit_tipoMembresia').val().trim();
   var edit_fechaInicio       = $('#edit_fechaInicio').val().trim();
   var edit_fechaTermino      = $('#edit_fechaTermino').val().trim();
   var id                     = $('#id').val().trim();

   if (edit_nombreCliente && edit_apellidosCliente && edit_telefono && edit_fecha_nac && edit_tipoMembresia && edit_fechaInicio && edit_fechaTermino) {
     $.ajax({
       url: "../models/actualizarCliente.php",
       type: "post",
       dataType: "json",
       data: {
          edit_nombreCliente,
          edit_apellidosCliente,
          edit_telefono,
          edit_fecha_nac,
          edit_tipoMembresia,
          edit_fechaInicio,
          edit_fechaTermino,
          id
       },
       success: function(json) {
          console.log(json);
          if (json.status === 'true') {
            $('#actualizarModal').modal('hide');
            $("#editarCliente")[0].reset();

            Swal.fire({
              position: 'top-center',
              icon: 'success',
              title: '¡ Registro exitoso !',
              showConfirmButton: false,
              timer: 1500,    
            }).then(() => {
                window.location.href = 'vistaClientes.php';
            });
          } else {
            Swal.fire({
              icon    : 'error',
              title   : 'Oops...',
              text    : 'No ingresaste todos los campos!',
            });
          }
       },
       error: function(xhr, status, error) {
         console.error("Error en AJAX:", error);
         console.error(xhr.responseText);
       }
     });
   } else {
     Swal.fire({
       icon: 'warning',
       title: 'Campos vacíos',
       text: 'Por favor llena todos los campos antes de enviar.'
     });
   }
});
});