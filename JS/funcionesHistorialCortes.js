$(document).ready(function() {

  // 🔹 Cargar lista de usuarios (para el filtro)
  fetch("../models/caja/obtenerUsuarios.php")
    .then(r => r.json())
    .then(data => {
      if (data.status === "ok") {
        data.usuarios.forEach(u => {
          $("#usuarioFiltro").append(`<option value="${u.id_usuario}">${u.nombre}</option>`);
        });
      }
    });

  // 🔹 Función principal
  function cargarCortes(fechaInicio = '', fechaFin = '', usuario = '') {
    const formData = new FormData();
    formData.append('fechaInicio', fechaInicio);
    formData.append('fechaFin', fechaFin);
    formData.append('usuario', usuario);

    fetch("../models/caja/obtenerCortes.php", {
      method: "POST",
      body: formData
    })
      .then(res => res.json())
      .then(data => {
        const tbody = $("#tablaCortes tbody");
        tbody.empty();

        if (data.status !== "success" || !data.cortes.length) {
          tbody.append('<tr><td colspan="7" class="text-center text-muted">No hay cortes en el rango seleccionado.</td></tr>');
          return;
        }

        data.cortes.forEach(c => {
          tbody.append(`
            <tr>
              <td>${c.id_corte}</td>
              <td>${c.fecha}</td>
              <td class="text-success">$${c.ingresos}</td>
              <td class="text-danger">$${c.egresos}</td>
              <td class="text-primary fw-bold">$${c.saldo}</td>
              <td>${c.usuario}</td>
            </tr>
          `);
        });
      })
      .catch(err => {
        console.error("Error al cargar cortes:", err);
        Swal.fire("Error", "No se pudieron cargar los cortes de caja.", "error");
      });
  }

  // 🔹 Filtrar por fechas o usuario
  $("#btnFiltrarCortes").click(() => {
    const inicio = $("#fechaInicio").val();
    const fin = $("#fechaFin").val();
    const usuario = $("#usuarioFiltro").val();
    cargarCortes(inicio, fin, usuario);
  });

  // 🔹 Exportar PDF
  $("#btnExportarPDF").click(() => {
    const inicio = $("#fechaInicio").val() || '';
    const fin = $("#fechaFin").val() || '';
    const usuario = $("#usuarioFiltro").val() || '';

    window.open(`../models/caja/exportarCortesPDF.php?inicio=${inicio}&fin=${fin}&usuario=${usuario}`, "_blank");
  });

  // Cargar por defecto (últimos 7 días)
  const hoy = new Date();
  const hace7 = new Date();
  hace7.setDate(hoy.getDate() - 7);
  $("#fechaInicio").val(hace7.toISOString().split("T")[0]);
  $("#fechaFin").val(hoy.toISOString().split("T")[0]);

  cargarCortes($("#fechaInicio").val(), $("#fechaFin").val());
});
