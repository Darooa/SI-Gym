// funcionesVentas.js
document.addEventListener("DOMContentLoaded", () => {

  // =====================================================
  // === FECHA AUTOMÁTICA EN FORMULARIO (si aplica) ===
  // =====================================================
  const inputFecha = document.getElementById("fecha_venta");
  if (inputFecha) inputFecha.value = new Date().toISOString().split("T")[0];


  // =====================================================
  // === ALERTAS DE STOCK BAJO ===
  // =====================================================
  let productosBajoStock = [];
  let alertaIndex = 0;
  let alertaInterval;

  function mostrarAlertaStock() {
    const alerta = document.getElementById("alertaStock");
    if (!alerta) return;

    if (!productosBajoStock.length) {
      alerta.textContent = "";
      alerta.classList.remove("alerta-visible");
      return;
    }

    const prod = productosBajoStock[alertaIndex];
    alerta.textContent = `⚠️ Stock bajo: ${prod.nombre_producto} (${prod.stock} piezas)`;
    alerta.classList.add("alerta-visible");

    alertaIndex = (alertaIndex + 1) % productosBajoStock.length;
    if (productosBajoStock.length > 1) {
      setTimeout(() => alerta.classList.remove("alerta-visible"), 3000);
    }
  }

function iniciarRotacionAlertas() {
  if (alertaInterval) clearInterval(alertaInterval);
  if (!productosBajoStock.length) return;
  mostrarAlertaStock();
  alertaInterval = setInterval(mostrarAlertaStock, 4000);
}

function cargarAlertasStock() {
  fetch("../models/ventas/productos_bajo_stock.php")
    .then(r => r.json())
    .then(data => {
      if (data.status === "ok") {
        productosBajoStock = data.productos || [];
        alertaIndex = 0;

        if (alertaInterval) clearInterval(alertaInterval);

        const alerta = document.getElementById("alertaStock");
        if (!productosBajoStock.length) {
          if (alerta) {
            alerta.textContent = "";
            alerta.classList.remove("alerta-visible");
          }
          return;
        }

        // Con 1 o más productos, inicia la rotación
        iniciarRotacionAlertas();
      }
    })
    .catch(err => console.error("Error al cargar alertas de stock:", err));
}


  // Llamada inicial de alertas
  cargarAlertasStock();


  // =====================================================
  // === ACTUALIZACIÓN AUTOMÁTICA DE CARDS ===
  // =====================================================
  const fechaActual = document.getElementById("fechaActual");
  const totalProductos = document.getElementById("totalProductos");
  const mensajeProductos = document.getElementById("mensajeProductos");
  const totalVentasHoy = document.getElementById("totalVentasHoy");
  const totalCaja = document.getElementById("totalCaja");

  const fecha = new Date();
  const opciones = { day: "2-digit", month: "long", year: "numeric" };
  if (fechaActual)if (fechaActual) {
  const meses = ["ENE","FEB","MAR","ABR","MAY","JUN","JUL","AGO","SEP","OCT","NOV","DIC"];
  const dia = String(fecha.getDate()).padStart(2, "0");
  const mes = meses[fecha.getMonth()];
  const año = fecha.getFullYear();
  fechaActual.textContent = `${dia} ${mes} ${año}`;
}

  function actualizarCards() {
    fetch("../models/ventas/obtenerResumenVentas.php")
      .then(res => res.json())
      .then(data => {
        if (data.status === "ok") {
          const d = data.data;

          const animar = (elemento) => {
            elemento.classList.add("actualizando");
            setTimeout(() => elemento.classList.remove("actualizando"), 400);
          };

          if (totalProductos) {
            totalProductos.textContent = d.totalProductos.toLocaleString();
            animar(totalProductos);

            if (mensajeProductos) {
              if (d.totalProductos === 0) {
                mensajeProductos.innerHTML = `<span class="text-danger text-sm font-weight-bolder">😟</span> Sin productos`;
              } else if (d.totalProductos < 50) {
                mensajeProductos.innerHTML = `<span class="text-warning text-sm font-weight-bolder">🧩</span> Limitado`;
              } else {
                mensajeProductos.innerHTML = `<span class="text-success text-sm font-weight-bolder">🔥</span> Catálogo`;
              }
            }
          }

          if (totalVentasHoy) {
            totalVentasHoy.textContent = d.totalVentasHoy.toLocaleString();
            animar(totalVentasHoy);
          }

          if (totalCaja) {
            totalCaja.textContent = `$${d.totalCaja.toLocaleString("es-MX", { minimumFractionDigits: 2 })}`;
            animar(totalCaja);
          }
        } else {
          console.warn("Error en datos de resumen:", data.message);
        }
      })
      .catch(err => console.error("Error al cargar datos:", err));
  }

  actualizarCards();
  setInterval(actualizarCards, 60000); // refrescar cada 1 min


  // =====================================================
  // === CONFIGURACIÓN DE TABLA DE PRODUCTOS (MODAL) ===
  // =====================================================
  const dtProductos = $('#tablaProductos').DataTable({
    responsive: true,
    serverSide: true,
    processing: true,
    paging: true,
    ordering: false,
    ajax: { url: '../models/ventas/obtenerProductos.php', type: 'POST' },
    language: {
      lengthMenu: "Mostrar _MENU_",
      zeroRecords: "Sin resultados",
      info: "_START_ al _END_ de _TOTAL_",
      infoEmpty: "0 al 0 de 0",
      infoFiltered: "(Total _MAX_)",
      sSearch: "Buscar:",
      oPaginate: { sFirst: "Primero", sLast: "Último", sNext: ">>", sPrevious: "<<" },
      sProcessing: "Procesando…"
    },
    rowCallback: function (row, data) {
      const stock = parseInt($(data[5]).text() || data.stock || 0, 10); // índice o campo stock
      const btn = $(row).find('.AddProducto');

      if (stock <= 0) {
        // Sin stock → desactivar botón e indicar visualmente
        btn.prop('disabled', true)
          .removeClass('btn-success')
          .addClass('btn-secondary')
          .html('<i class="fa-solid fa-ban"></i> Sin stock');

        $(row).css({
          opacity: '0.6',
          pointerEvents: 'none'
        });
      }
    }

  });


  // =====================================================
  // === CARRITO DE VENTA ===
  // =====================================================
  let carrito = [];

  $('#tablaProductos').on('click', '.AddProducto', function () {
    const row = $(this).closest('tr');
    const data = dtProductos.row(row).data();

    const id          = $(data[0]).text();
    const nombre      = $(data[1]).text();
    const descripcion = $(data[3]).text();
    const precio      = parseFloat($(data[4]).text().replace('$',''));

    const existente = carrito.find(p => p.id === id);
    if (existente) {
      existente.cantidad += 1;
    } else {
      carrito.push({ id, nombre, descripcion, precio, cantidad: 1 });
    }
    renderCarrito();
  });

  function renderCarrito() {
    const tbody = $('#tablaVenta tbody');
    tbody.empty();
    let total = 0;

    carrito.forEach((p, idx) => {
      const sub = p.precio * p.cantidad;
      total += sub;

      tbody.append(`
        <tr class="tr-animar">
          <td>${idx + 1}</td>
          <td>${p.nombre}</td>
          <td><input type="number" class="form-control form-control-sm cantItem" data-index="${idx}" min="1" value="${p.cantidad}"></td>
          <td>${p.descripcion ?? ''}</td>
          <td>$${p.precio.toFixed(2)}</td>
          <td class="subtotal">$${sub.toFixed(2)}</td>
          <td><i class="fa-solid fa-trash-can icon-delete delItem" title="Eliminar" data-index="${idx}"></i></td>
        </tr>
      `);
    });

    const totalVenta = $('#totalVenta');
    totalVenta.text(`$${total.toFixed(2)}`);
    totalVenta.addClass('actualizando');
    setTimeout(() => totalVenta.removeClass('actualizando'), 400);
  }


  // Editar cantidad
  $('#tablaVenta').on('input', '.cantItem', function () {
    const idx = $(this).data('index');
    const v = parseInt($(this).val(), 10);
    if (v > 0) {
      carrito[idx].cantidad = v;
      renderCarrito();
    }
  });


  // Eliminar con animación
  $('#tablaVenta').on('click', '.delItem', function () {
    const fila = $(this).closest('tr');
    const idx = $(this).data('index');

    fila.addClass('tr-eliminar');
    setTimeout(() => {
      carrito.splice(idx, 1);
      renderCarrito();
    }, 350);
  });


  // =====================================================
  // === GUARDAR VENTA ===
  // =====================================================
  $('#btnGuardarVenta').on('click', function () {
    const usuario = 1; 
    const fecha = inputFecha ? inputFecha.value : new Date().toISOString().split('T')[0];

    if (!carrito.length) {
      Swal.fire({
        icon: 'info',
        title: 'Carrito vacío',
        text: 'Agrega al menos un producto.',
        didClose: cleanupOverlays
      });
      return;
    }

    const total = parseFloat($('#totalVenta').text().replace('$', '')) || 0;
    if ($('#buscarProductos').hasClass('show')) $('#buscarProductos').modal('hide');

    Swal.fire({
      title: '¿Registrar venta?',
      text: `Total: $${total.toFixed(2)}`,
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#28a745',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, registrar',
      cancelButtonText: 'Cancelar',
      didClose: cleanupOverlays
    }).then(res => {
      if (!res.isConfirmed) return;

      const productos = carrito.map(p => ({
        id: parseInt(p.id, 10),
        cantidad: parseInt(p.cantidad, 10),
        precio: parseFloat(p.precio)
      }));

      fetch('../models/ventas/guardarVenta.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ usuario, fecha, productos })
      })
      .then(r => r.json())
      .then(data => {
        if (data.status === 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Venta registrada',
            html: `Folio: <b>${data.folio ?? ('V-' + String(data.id_venta).padStart(4,'0'))}</b><br>Total: <b>$${data.total}</b>`,
            timer: 2200,
            showConfirmButton: false,
            didClose: cleanupOverlays
          });

          carrito = [];
          renderCarrito();
          cargarAlertasStock(); // Refrescar alertas después de venta
          actualizarCards(); // Actualizar resumen
          dtProductos.ajax.reload(null, false); // recarga datos sin reiniciar paginación

        } else {
          Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'No se pudo registrar', didClose: cleanupOverlays });
        }
      })
      .catch(err => {
        console.error(err);
        Swal.fire({ icon: 'error', title: 'Error inesperado', text: 'Inténtalo de nuevo', didClose: cleanupOverlays });
      });
    });
  });


}); // Fin de DOMContentLoaded



document.addEventListener("DOMContentLoaded", () => {
  // 🎃 Solo activar entre el 15 de octubre y el 20 de noviembre
  const hoy = new Date();
  const inicio = new Date(hoy.getFullYear(), 9, 15);  // 15 de octubre
  const fin = new Date(hoy.getFullYear(), 10, 20);    // 20 de noviembre

  if (hoy >= inicio && hoy <= fin) {
    const emojis = ["💀", "🕯️", "🦇", "🎃"];

    setInterval(() => {
      const span = document.createElement("span");
      span.textContent = emojis[Math.floor(Math.random() * emojis.length)];
      span.style.position = "fixed";
      span.style.left = Math.random() * 100 + "vw";
      span.style.top = "-2em";
      span.style.fontSize = (Math.random() * 1.2 + 1) + "rem"; // tamaños aleatorios
      span.style.opacity = "0.8";
      span.style.zIndex = "9999";
      span.style.animation = "caer 10s linear";
      document.body.appendChild(span);
      setTimeout(() => span.remove(), 10000);
    }, 10000);
  } else {
    console.log("🎃 Animación desactivada (fuera de temporada Día de Muertos).");
  }
});

// Animación de caída
const style = document.createElement("style");
style.textContent = `
@keyframes caer {
  0% { transform: translateY(0) rotate(0deg); opacity: 1; }
  100% { transform: translateY(100vh) rotate(360deg); opacity: 0; }
}
`;
document.head.appendChild(style);







// =====================================================
// === UTILIDAD: LIMPIAR OVERLAYS SWEETALERT / MODAL ===
// =====================================================
function cleanupOverlays() {
  document.body.classList.remove('swal2-shown', 'swal2-height-auto', 'modal-open');
  document.body.style.overflow = '';
  document.body.style.paddingRight = '';
  document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
}
