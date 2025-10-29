$(document).ready(function() {
  cargarMovimientosCaja();

function cargarMovimientosCaja() {
  fetch("../models/caja/obtenerMovimientos.php")
    .then(res => res.json())
    .then(payload => {
      // Soportar {movimientos:[...]} o {status:'ok', data:{movimientos:[...]}}
      const movimientos = Array.isArray(payload.movimientos)
        ? payload.movimientos
        : (payload.data && Array.isArray(payload.data.movimientos) ? payload.data.movimientos : []);

      const tbody = $("#tablaCaja tbody");
      tbody.empty();

      let ingresos = 0;
      let egresos  = 0;

      // Helpers
      const normTipo = (t) => {
        const v = String(t ?? "").trim().toLowerCase();
        if (v === "ingreso" || v === "i" || v === "1" || v === "true") return "Ingreso";
        if (v === "egreso"  || v === "e" || v === "0" || v === "false") return "Egreso";
        // fallback: si no coincide, asumimos ingreso
        return "Ingreso";
      };

      const toNumber = (m) => {
        // quita todo excepto dígitos, punto y signo
        const num = String(m ?? "").replace(/[^\d.\-]/g, "");
        const n = parseFloat(num);
        return isNaN(n) ? 0 : n;
      };

      movimientos.forEach((mov, idx) => {
        const tipo   = normTipo(mov.tipo);
        let   montoN = toNumber(mov.monto);

        // Si es egreso y ya viene negativo, lo ponemos en positivo para acumular egresos
        if (tipo === "Egreso") montoN = Math.abs(montoN);

        if (tipo === "Ingreso") ingresos += montoN;
        else egresos += montoN;

        const signo     = (tipo === "Ingreso") ? "+" : "−";
        const colorTipo = (tipo === "Ingreso") ? "text-success" : "text-danger";

        tbody.append(`
          <tr>
            <td>${idx + 1}</td>
            <td>${mov.fecha ?? ""}</td>
            <td class="${colorTipo} fw-bold">${tipo}</td>
            <td>${mov.concepto ?? ""}</td>
            <td class="${colorTipo} fw-bold text-end">${signo} $${montoN.toFixed(2)}</td>
            <td>${mov.usuario ?? ""}</td>
          </tr>
        `);
      });

      const saldo = ingresos - egresos;

      // Actualiza totales (sin signos)
      $("#totalIngresos").text(`$${ingresos.toFixed(2)}`).addClass("actualizando");
      $("#totalEgresos").text(`$${egresos.toFixed(2)}`).addClass("actualizando");
      $("#saldoFinal").text(`$${saldo.toFixed(2)}`).addClass("actualizando");

      setTimeout(() => {
        $("#totalIngresos, #totalEgresos, #saldoFinal").removeClass("actualizando");
      }, 400);
    })
    .catch(err => console.error("Error cargando movimientos de caja:", err));
}


  // Corte de caja
  $("#btnCorteCaja").on("click", () => {
    Swal.fire({
      title: "¿Realizar corte de caja?",
      text: "Se generará un nuevo registro de balance del día.",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí, realizar corte"
    }).then(res => {
      if (!res.isConfirmed) return;
      fetch("../models/caja/realizarCorte.php", { method: "POST" })
        .then(r => r.json())
        .then(data => {
          if (data.status === "ok") {
            Swal.fire("Corte realizado", "Los datos de caja se han reiniciado correctamente.", "success");
            cargarMovimientosCaja();
          } else {
            Swal.fire("Error", data.message || "No se pudo realizar el corte.", "error");
          }
        });
    });
  });


  // =============================
  // REGISTRAR MOVIMIENTO MANUAL
  // =============================
  $("#formMovimientoCaja").on("submit", function(e) {
    e.preventDefault();

    const tipo      = $("#tipoMovimiento").val();
    const concepto  = $("#conceptoMovimiento").val().trim();
    const monto     = parseFloat($("#montoMovimiento").val()) || 0;
    const nota      = $("#notaMovimiento").val().trim();
    const usuario   = 1; // Cambia según tu sesión

    if (!tipo || !concepto || monto <= 0) {
      Swal.fire("Campos incompletos", "Por favor, rellena los datos correctamente.", "warning");
      return;
    }

    Swal.fire({
      title: "¿Registrar movimiento?",
      text: `${tipo} por $${monto.toFixed(2)} (${concepto})`,
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Sí, guardar",
      cancelButtonText: "Cancelar",
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#d33"
    }).then(res => {
      if (!res.isConfirmed) return;

      fetch("../models/caja/guardarMovimiento.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ tipo, concepto, monto, nota, usuario })
      })
      .then(r => r.json())
      .then(data => {
        if (data.status === "ok") {
          Swal.fire("Éxito", "Movimiento registrado correctamente.", "success");
          $("#modalMovimientoCaja").modal("hide");
          $("#formMovimientoCaja")[0].reset();
          cargarMovimientosCaja();
        } else {
          Swal.fire("Error", data.message || "No se pudo registrar el movimiento.", "error");
        }
      })
      .catch(err => {
        console.error("Error al guardar movimiento:", err);
        Swal.fire("Error", "Error inesperado, intenta de nuevo.", "error");
      });
    });
  });

});
