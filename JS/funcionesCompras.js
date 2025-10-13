// *************************** I N P U T  F E C H A  A U T O M A T I C A **********************
// ********************************************************************************************   
document.addEventListener("DOMContentLoaded", () => {
    const fechaInput = document.getElementById("fecha");
    const hoy = new Date();
    const fechaFormateada = hoy.toISOString().split("T")[0]; // YYYY-MM-DD
    fechaInput.value = fechaFormateada;
  });


// ************** I N P U T  N U M E R O  C O M P R A  A U T O M A T I C A *******************
document.addEventListener("DOMContentLoaded", () => {
  fetch("../models/compras/getCodigoCompra.php")
    .then(response => response.text())
    .then(data => {
      document.getElementById("no_compra").value = data;
    });
});



$(document).ready(function() {
  // *********************** T A B L A  P R O D U C T O S (B U S C A R) ************************
  // *******************************************************************************************
  var dataTableProductos = $('#tablaProductos').DataTable({
    'responsive': true,
    'serverSide': true,
    'processing': true,
    'paging': true,
    'order': [],
    'ajax': {
      'url': '../models/compras/obtenerProductos.php',
      'type': 'POST',
    },
    "language": {
      "lengthMenu": "Mostrar _MENU_ registros",
      "zeroRecords": "No se encontraron resultados",
      "info": " _START_ al _END_ de _TOTAL_ registros.",
      "infoEmpty": "Registros del 0 al 0 de un total de 0 registros.",
      "infoFiltered": "(Total _MAX_ registros.)",
      "sSearch": "Buscar:",
      "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": ">>",
        "sPrevious": "<<"
      },
      "sProcessing":"Procesando..."
    }
  });


  // ************************** I N P U T  P R O V E E D O R E S *******************************
  // *******************************************************************************************
  // para pulsaciones en un input
  $("#proveedor").keyup(function(){
        let query = $(this).val();
        if(query.length > 1){ // empieza a buscar desde 2 letras
            $.ajax({
                url: "../models/compras/buscarProveedor.php",
                method: "POST",
                data: {query:query},
                success:function(data){
                    $("#resultadosProveedor").html(data).show();
                }
            });
        } else {
            $("#resultadosProveedor").hide();
        }
    });

  document.addEventListener("click", function(e) {
    if (e.target.classList.contains("item-proveedor")) {
      e.preventDefault();
      let proveedorId = e.target.getAttribute("data-id");
      let proveedorNombre = e.target.textContent;
      console.log("Seleccionado:", proveedorId, proveedorNombre);
    }
  });

// Cuando el usuario hace clic en un resultado del buscador de proveedores
$(document).on("click", ".item-proveedor", function(e){
  e.preventDefault();
  
  const nombre = $(this).text();
  const id     = $(this).data("id"); // <-- recuperamos el data-id
  
  $("#proveedor").val(nombre);       // muestra el nombre en el input visible
  $("#proveedor_id").val(id);        // guarda el id en el input oculto
  
  $("#resultadosProveedor").hide();  // cierra la lista de resultados
});




  
  // Array para manejar productos agregados
  let carrito = [];

  // Agregar producto desde modal
  $('#tablaProductos').on('click', '.AddProducto', function() {
    let row = $(this).closest('tr');
    let data = dataTableProductos.row(row).data();

    let producto = {
      id: $(data[0]).text(),
      nombre: $(data[1]).text(),
      marca: $(data[2]).text(),
      // descripcion: $(data[3]).text(),
      contenido: $(data[3]).text(),
      precio: parseFloat($(data[4]).text()),
      cantidad: 1
    };

    // Si ya existe, solo aumentar cantidad
    let existente = carrito.find(p => p.id === producto.id);
    if (existente) {
      existente.cantidad += 1;
    } else {
      carrito.push(producto);
    }

    renderCarrito();
  });

  // Renderizar carrito
  function renderCarrito() {
    let tbody = $("#tablaCarrito tbody");
    tbody.empty();
    let total = 0;

    carrito.forEach((p, index) => {
      let subtotal = p.precio * p.cantidad;
      total += subtotal; //<td>${p.descripcion}</td>
      tbody.append(` 
        <tr>
          <td>${p.id}</td>
          <td>${p.nombre}</td>
          <td>${p.marca}</td>
          
          <td>${p.contenido}</td>
          <td>$${p.precio.toFixed(2)}</td>
          <td>
            <input type="number" min="1" class="form-control form-control-sm cantidadItem" 
              data-index="${index}" value="${p.cantidad}">
          </td>
          <td class="subtotal">$${subtotal.toFixed(2)}</td>
          <td><button class="btn btn-danger btn-sm removeItem" data-index="${index}">E</button></td>

        </tr>
      `);
    });

    $("#totalCarrito").text(`$${total.toFixed(2)}`);
  }

  // Cambiar cantidad
  $('#tablaCarrito').on('input', '.cantidadItem', function() {
    let index = $(this).data("index");
    let nuevaCantidad = parseInt($(this).val());
    if (nuevaCantidad > 0) {
      carrito[index].cantidad = nuevaCantidad;
      renderCarrito();
    }
  });

  // Quitar productos del carrito
  $('#tablaCarrito').on('click', '.removeItem', function() {
    let index = $(this).data("index");
    carrito.splice(index, 1);
    renderCarrito();
  });


  document.getElementById("btnGuardarCompra").addEventListener("click", function () {
  const codigo       = document.getElementById("no_compra").value;
  const fecha        = document.getElementById("fecha").value;
  const proveedor_id = parseInt(document.getElementById("proveedor_id").value, 10); // <-- usar ID
  const usuario      = 1;
  const total        = parseFloat(document.getElementById("totalCarrito").innerText.replace("$",""));

  // ... construir productos:
  let productos = [];
  document.querySelectorAll("#tablaCarrito tbody tr").forEach(fila => {
      const id       = parseInt(fila.children[0].innerText, 10);
      const cantidad = parseInt(fila.querySelector(".cantidadItem").value, 10);
      const precio   = parseFloat(fila.children[4].innerText.replace("$",""));
      const subtotal = parseFloat(fila.children[6].innerText.replace("$",""));
      productos.push({ id, cantidad, precio, subtotal });
  });

  // validaciones
  if (!proveedor_id) {
      Swal.fire({
          icon: "warning",
          title: "Proveedor no seleccionado",
          text: "Por favor selecciona un proveedor de la lista antes de guardar la compra.",
          confirmButtonColor: "#3085d6",
          didClose: cleanupOverlays

      });
    return;
  }

  if (!productos.length) {
    Swal.fire({ 
      icon:"info", 
      title:"Carrito vacío", 
      text:"Agrega al menos un producto." ,
      didClose: cleanupOverlays

    });
    return;
  }

  // Confirmación y envío…
  Swal.fire({
    title: "¿Deseas registrar esta compra?",
    text: `Total: $${total.toFixed(2)}`,
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#28a745",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, guardar",
    cancelButtonText: "Cancelar",
    didClose: cleanupOverlays

  }).then((result) => {
    if (result.isConfirmed) {
      fetch("../models/compras/guardarCompra.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          codigo,
          fecha,
          usuario,
          proveedor_id,
          total,
          productos
        })
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === "success") {
          Swal.fire({
            icon: "success",
            title: "Compra registrada",
            html: `Folio: <b>${codigo}</b><br>Total: <b>$${data.total}</b>`,
            timer: 2200,
            showConfirmButton: false
          });

          // Limpiar carrito / total / proveedor / nuevo folio
          document.querySelector("#tablaCarrito tbody").innerHTML = "";
          document.getElementById("totalCarrito").innerText = "0.00";
          document.getElementById("proveedor").value = "";
          document.getElementById("proveedor_id").value = "";

          fetch("../models/compras/getCodigoCompra.php")
            .then(res => res.text())
            .then(codigoNuevo => {
              document.getElementById("no_compra").value = codigoNuevo;
            });
        } else {
          Swal.fire({ icon: "error", title: "Error", text: data.message });
        }
      })
      .catch(err => {
        Swal.fire({ 
          icon: "error", 
          title: "Error inesperado", 
          text: "Ocurrió un problema al guardar.",
          didClose: cleanupOverlays
        });
        console.error(err);
      });
    }
  });
});






});

// Limpia cualquier overlay/clase que pueda dejar el fondo bloqueado
function cleanupOverlays() {
  // Clases que a veces quedan colgadas
  document.body.classList.remove('swal2-shown', 'swal2-height-auto', 'modal-open');
  // Restablecer scroll y padding
  document.body.style.overflow = '';
  document.body.style.paddingRight = '';

  // Remover backdrops si quedaron
  document.querySelectorAll('.swal2-container, .modal-backdrop').forEach(el => {
    // Solo eliminar si NO hay alerta activa
    if (!document.querySelector('.swal2-container')) {
      if (el.classList.contains('modal-backdrop')) el.remove();
    }
  });
}
