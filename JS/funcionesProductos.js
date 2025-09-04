$(document).ready(function() {
  var opcion;
   // *************************** OBTENER DATOS DEL PRODUCTO ***********************
   var dataTableProductos = $('#Productos').DataTable({
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
       'url'        : '../models/obtenerProductos.php',
       'type'       : 'POST',
     },
     "aoColumnDefs" : [{
         "bSortable": false,
         "aTargets" : [2]
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
  
 // ***************************** AGREGAR PRODUCTO **********************************
 $(document).on('submit', '#agregarProducto', function(e) {
   e.preventDefault();
   var TGYM_nombre      = $('#TGYM_nombre').val();
   var TGYM_marca       = $('#TGYM_marca').val();
   var TGYM_contenido   = $('#TGYM_contenido').val();
   var TGYM_categoria   = $('#TGYM_categoria').val();

  var TGYM_stockinicial = $('#TGYM_stockinicial').val();
  var TGYM_descripcion  = $('#TGYM_descripcion').val();
  var TGYM_preciocompra = $('#TGYM_preciocompra').val();
  var TGYM_precioventa  = $('#TGYM_precioventa').val();

  if (TGYM_nombre === '' || TGYM_marca === ''|| TGYM_contenido == '' || TGYM_categoria ==='' || TGYM_stockinicial=='' || TGYM_descripcion == '' || TGYM_preciocompra =='' || TGYM_precioventa == '') {
       Swal.fire({
         icon    : 'error',
         title   : 'Oops...', 
         text    : 'No ingresaste todos los campos!',
       });
   } else { 
     $.ajax({
       url: "../Models/agregarProducto.php",
       type: "post",
       data: {
          TGYM_nombre       : TGYM_nombre,
          TGYM_marca        : TGYM_marca,
          TGYM_contenido    : TGYM_contenido,
          TGYM_categoria    : TGYM_categoria,
          TGYM_stockinicial : TGYM_stockinicial,
          TGYM_descripcion  : TGYM_descripcion,
          TGYM_preciocompra : TGYM_preciocompra,
          TGYM_precioventa  : TGYM_precioventa,
          
       },
       success: function(data) {
         dataTableProductos.ajax.reload(null, false);
         var json      = JSON.parse(data);
         var status    = json.status;
         if (status    == 'true') {
           $('#AgregarProducto').modal('hide');
           $("#agregarProducto").trigger("reset");
           Swal.fire({
             position: 'top-center',
             icon: 'success',
             title: 'Producto agregado',
             showConfirmButton: false,
             timer: 1500,    
           })	
         } else {
         }
       }
     });
   }
 });
 
 // ********************************** EDITAR PRODUCTO *****************************
 $(document).on('submit', '#EDTProducto', function(e) {
   e.preventDefault();
   //var tr = $(this).closest('tr');
   var EDT_nombre      = $('#EDT_nombre').val();
   var EDT_descripcion = $('#EDT_descripcion').val();
   var EDT_categoria   = $('#EDT_categoria').val();
   var EDT_marca       = $('#EDT_marca').val();
   var EDT_contenido   = $('#EDT_contenido').val();
   var EDT_stock       = $('#EDT_stock').val();
   var EDT_pcompra     = $('#EDT_pcompra').val();
   var EDT_pventa      = $('#EDT_pventa').val();
  //  var EDT_agregado    = $('#EDT_agregado').val();
  //  var EDT_estado      = $('#EDT_estado').val();

   var trid            = $('#trid').val();
   var id              = $('#id').val();
 
   if (EDT_nombre != '' && EDT_descripcion != '' && EDT_categoria != ''&& EDT_marca != '' && EDT_contenido != ''  && EDT_stock != ''  && EDT_pcompra != ''  && EDT_pventa != '') {
     $.ajax({
       url: "../Models/actualizarProducto.php",
       type: "post",
       data: {
          EDT_nombre        : EDT_nombre, 
          EDT_descripcion   : EDT_descripcion,
          EDT_categoria     : EDT_categoria,
          EDT_marca         : EDT_marca,
          EDT_contenido     : EDT_contenido,
          EDT_stock         : EDT_stock,
          EDT_pcompra       : EDT_pcompra,
          EDT_pventa        : EDT_pventa,
          // EDT_agregado      : EDT_agregado,
          // EDT_estado        : EDT_estado,
          id                 : id
       },
       success: function(data) {
         dataTableProductos.ajax.reload(null, false);
         
       }
     });
      $('#EDTProducto').modal('hide');		
      $("#EDTProducto").trigger("reset");
     Swal.fire({
         position          : 'top-center',
         icon              : 'success',
         title             : 'Datos del producto actualizados!',
         showConfirmButton : false,
         timer             : 1500,
       })
   } else {
     Swal.fire({
       icon    : 'error',
       title   : 'Oops...',
       text    : 'No ingresaste todos los campos!',
     });
   }
 });
 
 // ************************* CLICK AL BOTON EDITAR TABLA USUARIOS *****************
 $('#Productos').on('click', '.EDTProducto ', function(event) {
   var dataTableClientes = $('#Productos').DataTable();
   var trid              = $(this).closest('tr').attr('id');
   var id                = $(this).data('id');
   $('#EDTProducto').modal('show');
 
   $.ajax({
     url: "../Models/obtenerProducto.php",
     data: {
       id: id 
     },
     type: 'POST',
     success: function(data) {
       var json = JSON.parse(data);
       $('#EDT_nombre').val(json.nombre_producto);
       $('#EDT_descripcion').val(json.descripcion);
       $('#EDT_categoria').val(json.categoria);
       $('#EDT_marca').val(json.marca);
       $('#EDT_contenido').val(json.contenido);
       $('#EDT_stock').val(json.stock);
       $('#EDT_pcompra').val(json.p_compra);
       $('#EDT_pventa').val(json.p_venta);
       $('#EDT_agregado').val(json.agregado);
       $('#EDT_estado').val(json.estado);

       $('#id').val(id);
       $('#trid').val(trid); 
     }
   })
 })
 
 // ******************************* DESACTIVAR PRODUCTO ***********************
 $(document).on('click', '.desactivarClienteBtn', function(event) {
   var table = $('#Productos').DataTable();
   event.preventDefault();
   var id = $(this).data('id');
 
 
   const swalWithBootstrapButtons = Swal.mixin({
     customClass: {
       confirmButton : 'btn btn-success', 
       cancelButton  : 'btn btn-danger'
     },
     buttonsStyling: false
   })
   
   Swal.fire({
     title             : '¿Estás seguro de desactivar el Producto?',
     text              : "Una vez desactivado no podrá aparecer en productos en venta.",
     icon              : 'warning',
     showCancelButton  : true,
     confirmButtonColor: '#3085d6',
     confirmButtonText : 'Sí',
     cancelButtonColor: '#d33',
     cancelButtonText  : 'Cancelar',
     reverseButtons    : true
   }).then((result) => {
     if (result.isConfirmed) {
         $.ajax({
             url       : "../Models/desactivarProducto.php", 
             type      : "POST",
             datatype  : "json",    
             data:  { id     :id,
                      opcion :opcion},    
             success: function(data) {
               dataTableProductos.ajax.reload(null, false);
             }
           });	
       swalWithBootstrapButtons.fire(
         'Producto desactivado',
         'El registro del Producto se ha desactivado correctamente.',
         'success'
       )
     } else if (
       result.dismiss === Swal.DismissReason.cancel
     ) {
       swalWithBootstrapButtons.fire(
         'Cancelar',
         'El Producto no ha sido desactivado.',
         'error'
       )
     }
   })
 })
 
 // ******************************* ACTIVAR PRODUCTO ***********************
 $(document).on('click', '.activarClienteBtn', function(event) {
  var table = $('#Productos').DataTable();
  event.preventDefault();
  var id = $(this).data('id');


  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton : 'btn btn-success', 
      cancelButton  : 'btn btn-danger'
    },
    buttonsStyling: false
  })
  
  Swal.fire({
    title             : '¿Estás seguro de activar los datos?',
    text              : "Una vez activado se podrá visualizar en el listado de productos.",
    icon              : 'warning',
    showCancelButton  : true,
    confirmButtonColor: '#3085d6',
    confirmButtonText : 'Sí',
    cancelButtonColor: '#d33',
    cancelButtonText  : 'Cancelar',
    reverseButtons    : true
  }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url       : "../Models/activarProducto.php", 
            type      : "POST",
            datatype  : "json",    
            data:  { id     :id,
                     opcion :opcion},    
            success: function(data) {
              dataTableProductos.ajax.reload(null, false);
            }
          });	
      swalWithBootstrapButtons.fire(
        'Producto activado',
        'Los datos se han activado correctamente.',
        'success'
      )
    } else if (
      result.dismiss === Swal.DismissReason.cancel
    ) {
      swalWithBootstrapButtons.fire(
        'Cancelar',
        'El registro no se ha activado.',
        'error'
      )
    }
  })
})

 });