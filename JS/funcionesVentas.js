// funcionesVentas.js
document.addEventListener("DOMContentLoaded", () => {
  // Fecha automática (input con id="fecha_venta" si lo usas)
  const inputFecha = document.getElementById("fecha_venta");
  if (inputFecha) inputFecha.value = new Date().toISOString().split("T")[0];
});

$(document).ready(function () {
  // =========================
  // DataTable: Buscar productos (modal)
  // =========================
  const dtProductos = $('#tablaProductos').DataTable({
    responsive: true,
    serverSide: true,
    processing: true,
    paging: true,
    order: [],
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
    }
  });

  // =========================
  // Carrito en DOM
  // =========================
  let carrito = []; // {id, nombre, descripcion, precio, cantidad}

  // Agregar desde modal
  $('#tablaProductos').on('click', '.AddProducto', function () {
    const row = $(this).closest('tr');
    const data = dtProductos.row(row).data();
    // Ajusta índices según tu obtenerProductos.php
    const id          = $(data[0]).text();            // ID
    const nombre      = $(data[1]).text();            // Producto
    const descripcion = $(data[3]).text();            // Contenido/desc
    const precio      = parseFloat($(data[4]).text().replace('$','')); // P. venta

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
        <tr>
          <td>${idx + 1}</td>
          <td>${p.nombre}</td>
          <td>
            <input type="number" class="form-control form-control-sm cantItem" data-index="${idx}" min="1" value="${p.cantidad}">
          </td>
          <td>${p.descripcion ?? ''}</td>
          <td>$${p.precio.toFixed(2)}</td>
          <td class="subtotal">$${sub.toFixed(2)}</td>
          <td><button class="btn btn-sm btn-danger delItem" data-index="${idx}"><i class="bx bx-trash"></i></button></td>
        </tr>
      `);
    });

    $('#totalVenta').text(`$${total.toFixed(2)}`);
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

  // Eliminar del carrito
  $('#tablaVenta').on('click', '.delItem', function () {
    const idx = $(this).data('index');
    carrito.splice(idx, 1);
    renderCarrito();
  });

  // =========================
  // Guardar venta
  // =========================
  $('#btnGuardarVenta').on('click', function () {
    const usuario = 1; // TODO: toma de la sesión
    const fecha   = document.getElementById("fecha_venta") ? document.getElementById("fecha_venta").value : new Date().toISOString().split('T')[0];

    // Validaciones
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
    // const total = parseFloat(document.getElementById("totalVenta").innerText.replace(/[^\d.]/g, "")) || 0;
    // const total        = parseFloat(document.getElementById("totalVenta").innerText.replace("$",""));

    // Si el modal está abierto, ciérralo antes del Swal (evita fondo bloqueado)
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

      // Preparar payload
      const productos = carrito.map(p => ({
        id: parseInt(p.id, 10),
        cantidad: parseInt(p.cantidad, 10),
        precio: parseFloat(p.precio)  // precio de venta
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
          // Limpiar carrito
          carrito = [];
          renderCarrito();
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

}); // ready

// Utilidad: limpiar overlays SweetAlert/Bootstrap (fondo negro)
function cleanupOverlays() {
  document.body.classList.remove('swal2-shown', 'swal2-height-auto', 'modal-open');
  document.body.style.overflow = '';
  document.body.style.paddingRight = '';
  document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
}
