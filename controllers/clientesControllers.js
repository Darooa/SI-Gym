$(document).ready(function() {
  var opcion;
   // *************************** OBTENER DATOS DEL PRODUCTO ***********************
   var dataTableProductos = $('#tablaClientes').DataTable({
     select:true,
     "fnCreatedRow": function(nRow, aData, iDataIndex) {
       $(nRow).attr('id', aData[0]);
     },
     'responsive'   : 'true',
     'serverSide'   : 'true',
     'processing'   : 'true',
     'paging'       : 'true',
     'order'        : [],
     
     'ajax'         : {
       'url'        : '../models/clientes/clientesModel.php',
       'type'       : 'POST',
     },
     "aoColumnDefs" : [{
         "bSortable": false,
         "aTargets" : [8]
       },
     ],
     "language": {
       "lengthMenu"  : "Mostrar _MENU_ registros",
       "zeroRecords" : "No se encontraron resultados",
       "info"        : "Registros del _START_ al _END_ de un total de _TOTAL_ registros.",
       "infoEmpty"   : "Registros del 0 al 0 de un total de 0 registros.",
       "infoFiltered": "(Filtrado de un total de _MAX_ registros.)",
       "sSearch"     : "Buscar:",
       "oPaginate"   : {
           "sFirst"  : "Primero",
           "sLast"   :"Último",
           "sNext"   :"Siguiente",
           "sPrevious": "Anterior"
        },
        "sProcessing":"Procesando...",
   }
   });

   /*************MOSTRAR PRECIO EN INPUT AL SELECCIONAR UN TIPO DE MEMBRESÍA ************ */
    $("#tipoMembresia").on("change", function () {
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
             $("#costo").val("$ " + precio);
             $("#fechaTermino").val(fechaFin);
    });

/**********************FUNCIÓN PARA REGISTRAR UN CLIENTE *************** */
$(document).on('submit', '#agregarCliente', function(e) {
	e.preventDefault();
	  var formData = new FormData(document.getElementById("agregarCliente"));
	  $.ajax({
		url: "../models/clientes/agregarClientes.php",
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
			$('#agregarCliente').modal('hide');
			$("#agregarCliente").trigger("reset");
			Swal.fire({
			  position: 'top-center',
			  icon: 'success',
			  title: '¡ Registro exitoso !',
			  showConfirmButton: false,
			  timer: 1500,    
			}).then(() => {
				var urlParams = new URLSearchParams(window.location.search);
                var newUrl = 'vistaClientes.php';
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

/******************MOSTRAR INFORMACIÓN DE UN CLIENTE EN MODAL **************** */
 $('#tablaClientes').on('click', '.btnEditarCliente', function(event) {
   var dataTableClientes = $('#tablaClientes').DataTable();
   var trid              = $(this).closest('tr').attr('id');
   var id                = $(this).data('id');
   $('#actualizarModal').modal('show');
 
   $.ajax({
     url: "../models/clientes/obtenerCliente.php",
     data: {
       id: id 
     },
     type: 'POST',
     success: function(data) {
       var json = JSON.parse(data);
       $('#edit_nombreCliente').val(json.nombre);
       $('#edit_apellidosCliente').val(json.apellidos);
       $('#edit_telefono').val(json.telefono);
       $('#edit_fecha_nac').val(json.fecha_nac);
       $('#edit_tipoMembresia').val(json.tipo_membresia);
       $('#edit_costo').val(json.costo);
       $('#edit_fechaInicio').val(json.fecha_inicio);
       $('#edit_fechaTermino').val(json.fecha_limite);
       $('#id').val(id);
      // $('#trid').val(trid); 
     }
   })
 });




/*************BAJA DE CLIENTE ******************* */
 $(document).on('click', '.btnDesactivarCliente', function(event) {
   var table = $('#tablaClientes').DataTable();
   event.preventDefault();
   var id = $(this).data('id');
   Swal.fire({
      title: '¿Eliminar este evento?',
      text: 'Esta acción no se puede deshacer',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '../models/clientes/bajaCliente.php',
          type: 'POST',
          data: { id: id},
          success: function (response) {
            if (response.status === 'success') {
              $('#calendar').fullCalendar('refetchEvents');
              $('#eventModal').modal('hide');
              Swal.fire('¡Eliminado!', 'El evento ha sido eliminado.', 'success').then(() => {
                var urlParams = new URLSearchParams(window.location.search);
                var id = urlParams.get('id');
                if (id === null) {
                  console.error('El parámetro "id" no se encuentra en la URL.');
                } else {
                  var newUrl = 'vistaClientes.php';
                  window.location.href = newUrl;
                }
                }); 

            } else {
              Swal.fire('Error', 'No se pudo eliminar el evento.', 'error');
            }
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
            console.error("Status: " + status);
            console.error("Error: " + error);
          }
        });
      }
    });
 })


});
