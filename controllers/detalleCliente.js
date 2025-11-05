$(document).ready(function() {
     /*************MOSTRAR PRECIO EN INPUT AL SELECCIONAR UN TIPO DE MEMBRESÍA EN FORMULARIO EDITAR************ */
  // Escuchar el cambio en el select
  // document.getElementById('edit_tipoMembresia').addEventListener('change', function() {
  //   // Obtener la opción seleccionada
  //   const selectedOption = this.options[this.selectedIndex];
  //   // Leer los atributos data-precio y data-dias
  //   const precio = selectedOption.getAttribute('data-precio');
  //   const dias = selectedOption.getAttribute('data-dias');
  //   // Asignar los valores a los inputs
  //   document.getElementById('precio').value = precio ? precio : '';
  //   document.getElementById('duracion').value = dias ? dias : '';
  // });

function formatearFecha(fechaInput) {
  if (!fechaInput) return ''; // evita errores si viene vacío
  // Detectar si viene con "/" o "-"
  let partes = fechaInput.includes('/') ? fechaInput.split('/') : fechaInput.split('-');
  // Si el primer valor es mayor a 12 → claramente es un DÍA (DD/MM/YYYY)
  if (parseInt(partes[0]) > 12) {
    // Formato DD/MM/YYYY → YYYY-MM-DD
    return `${partes[2]}-${partes[1]}-${partes[0]}`;
  } else {
    // Ya está correcto o es YYYY-MM-DD
    return fechaInput;
  }
}

/*****************EDITAR CLIENTE ********************/
$(document).on('submit', '#actualizarClientes', function(e) {
   e.preventDefault();

   var edit_nombreCliente     = $('#nombreCliente').val().trim();
   var edit_apellidosCliente  = $('#apellidosCliente').val().trim();
   var edit_telefono          = $('#telefonoCliente').val().trim();
   var edit_fecha_nac         = $('#fechaCliente').val().trim();
   var id                     = $('#clienteId').val().trim();
   // edit_fecha_nac = formatearFecha(edit_fecha_nac);
   if (edit_nombreCliente && edit_apellidosCliente && edit_telefono && edit_fecha_nac) {
     $.ajax({
       url: "../models/clientes/actualizarCliente.php",
       type: "post",
       dataType: "json",
       data: {
          edit_nombreCliente,
          edit_apellidosCliente,
          edit_telefono,
          edit_fecha_nac,
          id
       },
       success: function(json) {
          console.log(json);
          if (json.status === 'true') {
            Swal.fire({
              position: 'top-center',
              icon: 'success',
              title: '¡ Registro exitoso !',
              showConfirmButton: false,
              timer: 1500,    
            }).then(() => {
              //  window.location.href = 'detalleCliente.php';
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