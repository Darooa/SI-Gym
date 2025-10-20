$(document).ready(function() {

  function cargarMovimientos() {
    fetch("../models/caja/obtenerMovimientos.php")
      .then(res => res.json())
      .then(data => {
        if (data.status === "success") {
          let tbody = $("#tablaCaja tbody");
          tbody.empty();

          data.movimientos.forEach(m => {
            const color = m.tipo === 'ingreso' ? 'text-success' : 'text-danger';
            tbody.append(`
              <tr>
                <td>${m.fecha}</td>
                <td class="${color}">${m.tipo}</td>
                <td>${m.concepto}</td>
                <td>$${parseFloat(m.monto).toFixed(2)}</td>
                <td>${m.referencia}</td>
                <td>${m.usuario || ''}</td>
              </tr>
            `);
          });

          $("#totalIngresos").text(`$${data.totalIngresos}`);
          $("#totalEgresos").text(`$${data.totalEgresos}`);
          $("#saldoFinal").text(`$${data.saldoFinal}`);
        }
      });
  }

  // Cargar al iniciar
  cargarMovimientos();

  // Realizar corte
  $("#btnCorteCaja").click(function() {
    Swal.fire({
      title: "¿Deseas realizar el corte de caja?",
      text: "Esto cerrará los movimientos del día.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Sí, realizar corte",
      cancelButtonText: "Cancelar"
    }).then(result => {
      if (result.isConfirmed) {
        fetch("../models/caja/realizarCorte.php")
          .then(res => res.json())
          .then(data => {
            if (data.status === "success") {
              Swal.fire({
                icon: "success",
                title: "Corte realizado",
                text: data.message,
                timer: 2500,
                showConfirmButton: false
              });
              cargarMovimientos(); // recargar tabla
            } else {
              Swal.fire("Aviso", data.message, "info");
            }
          });
      }
    });
  });
});
