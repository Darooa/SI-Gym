$(document).ready(function() {

  function cargarCortes(fechaInicio = '', fechaFin = '') {
    const formData = new FormData();
    formData.append('fechaInicio', fechaInicio);
    formData.append('fechaFin', fechaFin);

    fetch("../models/caja/obtenerCortes.php", {
      method: "POST",
      body: formData
    })
      .then(res => res.json())
      .then(data => {
        if (data.status === "success") {
          let tbody = $("#tablaCortes tbody");
          tbody.empty();

          if (data.cortes.length === 0) {
            tbody.append('<tr><td colspan="7" class="text-center text-muted">No hay cortes en el rango seleccionado.</td></tr>');
            return;
          }

          data.cortes.forEach(c => {
            tbody.append(`
              <tr>
                <td>${c.id_corte}</td>
                <td>${c.fecha_inicio}</td>
                <td>${c.fecha_fin}</td>
                <td class="text-success">$${parseFloat(c.total_ingresos).toFixed(2)}</td>
                <td class="text-danger">$${parseFloat(c.total_egresos).toFixed(2)}</td>
                <td class="text-primary fw-bold">$${parseFloat(c.saldo_final).toFixed(2)}</td>
                <td>${c.usuario || ''}</td>
              </tr>
            `);
          });
        }
      })
      .catch(err => {
        console.error("Error al cargar cortes:", err);
        Swal.fire("Error", "No se pudieron cargar los cortes de caja.", "error");
      });
  }

  // Cargar al iniciar
  cargarCortes();

  // Botón de filtro
  $("#btnFiltrarCortes").click(function() {
    const inicio = $("#fechaInicio").val();
    const fin = $("#fechaFin").val();

    if (!inicio || !fin) {
      Swal.fire("Atención", "Selecciona ambas fechas para filtrar.", "info");
      return;
    }

    if (inicio > fin) {
      Swal.fire("Atención", "La fecha inicial no puede ser mayor que la final.", "warning");
      return;
    }

    cargarCortes(inicio, fin);
  });
});
