$(document).ready(function () {

  // =========================================================
  // 🔹 MOSTRAR FECHA ACTUAL EN TÍTULO
  // =========================================================
  const tituloCaja = $("#tituloCaja");
  const hoy = new Date();
  const fechaFormateada = hoy.toLocaleDateString("es-MX", { day: "2-digit", month: "long", year: "numeric" }).toUpperCase();
  tituloCaja.text(`Movimientos de Caja (${fechaFormateada})`);




  // =========================================================
  // 🔹 VERIFICAR Y AGREGAR SALDO INICIAL DEL DÍA
  // =========================================================
  fetch("../models/caja/agregarSaldoInicial.php")
    .then(r => r.json())
    .then(data => {
      if (data.status === "ok" && data.monto) {
        // 💰 Mostrar notificación visual
        if (data.show_alert) {
          Swal.fire({
            title: "Saldo inicial del día",
            html: `<b>💰 $${parseFloat(data.monto).toFixed(2)}</b> agregados automáticamente.`,
            icon: "info",
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            toast: true,
            position: "top-end"
          });
        }
      }
    })
    .catch(err => console.error("Error al agregar saldo inicial:", err));

  // =========================================================
  // 🔹 CARGAR MOVIMIENTOS DE CAJA
  // =========================================================
  function cargarMovimientosCaja() {
    fetch("../models/caja/obtenerMovimientos.php")
      .then(res => res.json())
      .then(payload => {
        const movimientos = Array.isArray(payload.movimientos)
          ? payload.movimientos
          : (payload.data && Array.isArray(payload.data.movimientos)
              ? payload.data.movimientos
              : []);

        const tbody = $("#tablaCaja tbody");
        tbody.empty();

        let ingresos = 0;
        let egresos  = 0;

        const normTipo = (t) => {
          const v = String(t ?? "").trim().toLowerCase();
          if (["ingreso","i","1","true"].includes(v)) return "Ingreso";
          if (["egreso","e","0","false"].includes(v)) return "Egreso";
          return "Ingreso";
        };

        const toNumber = (m) => {
          const num = String(m ?? "").replace(/[^\d.\-]/g, "");
          const n = parseFloat(num);
          return isNaN(n) ? 0 : n;
        };

        movimientos.forEach((mov, idx) => {
          const tipo   = normTipo(mov.tipo);
          let montoN   = toNumber(mov.monto);

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

        $("#totalIngresos").text(`$${ingresos.toFixed(2)}`).addClass("actualizando");
        $("#totalEgresos").text(`$${egresos.toFixed(2)}`).addClass("actualizando");
        $("#saldoFinal").text(`$${saldo.toFixed(2)}`).addClass("actualizando");

        setTimeout(() => {
          $("#totalIngresos, #totalEgresos, #saldoFinal").removeClass("actualizando");
        }, 400);

        // 🔹 Si no hay movimientos, mostrar mensaje
        if (!movimientos.length) {
          tbody.append(`<tr><td colspan="6" class="text-center text-muted py-3">Sin movimientos registrados para hoy.</td></tr>`);
        }
      })
      .catch(err => console.error("Error cargando movimientos de caja:", err));
  }

  cargarMovimientosCaja();



 // =========================================================
// 🔹 BOTÓN REALIZAR CORTE DE CAJA (con resumen visual)
// =========================================================
$("#btnCorteCaja").on("click", () => {
  Swal.fire({
    title: "¿Realizar corte de caja?",
    text: "Esto finalizará los movimientos pendientes de uno o varios días.",
    icon: "question",
    showCancelButton: true,
    confirmButtonText: "Sí, realizar corte",
    cancelButtonText: "Cancelar",
    confirmButtonColor: "#28a745",
    cancelButtonColor: "#d33"
  }).then(res => {
    if (!res.isConfirmed) return;

    fetch("../models/caja/realizarCorte.php", { method: "POST" })
      .then(r => r.json())
      .then(data => {
        if (data.status === "ok") {

          // 🧾 Construir HTML con resumen de los cortes realizados
          let htmlResumen = `<div style='text-align:left'><b>Total de cortes:</b> ${data.total_cortes}<br><br>`;
          data.cortes.forEach(c => {
            htmlResumen += `
              <div style='margin-bottom:8px;'>
                <b>📅 ${c.fecha}</b><br>
                Ingresos: <span class='text-success'>$${c.ingresos}</span><br>
                Egresos: <span class='text-danger'>$${c.egresos}</span><br>
                Saldo final: <span class='text-primary fw-bold'>$${c.saldo}</span><br>
                Movimientos afectados: ${c.movimientos}
              </div><hr>
            `;
          });
          htmlResumen += "</div>";

          Swal.fire({
            title: "Corte(s) realizado(s)",
            html: htmlResumen,
            icon: "success",
            confirmButtonText: "Aceptar",
            confirmButtonColor: "#28a745",
            width: 600
          });

          // 🧹 Limpiar tabla visualmente
          $("#tablaCaja tbody").html(`<tr><td colspan="6" class="text-center text-muted py-3">Corte realizado. Sin movimientos pendientes.</td></tr>`);

          // 🔄 Reiniciar totales con animación
          ["#totalIngresos", "#totalEgresos", "#saldoFinal"].forEach(sel => {
            const el = document.querySelector(sel);
            if (el) {
              el.textContent = "$0.00";
              el.classList.add("actualizando");
              setTimeout(() => el.classList.remove("actualizando"), 500);
            }
          });

        } else if (data.status === "warning") {
          Swal.fire("Atención", data.message, "info");
        } else {
          Swal.fire("Error", data.message || "No se pudo realizar el corte.", "error");
        }
      })
      .catch(err => {
        console.error("Error en corte:", err);
        Swal.fire("Error", "Error inesperado al realizar el corte.", "error");
      });
  });
});




  // =========================================================
  // 🔹 REGISTRAR MOVIMIENTO MANUAL
  // =========================================================
  let enviandoMovimiento = false;

  $("#formMovimientoCaja").on("submit", function(e) {
    e.preventDefault();
    if (enviandoMovimiento) return;

    const tipo      = $("#tipoMovimiento").val();
    const concepto  = $("#conceptoMovimiento").val().trim();
    const monto     = parseFloat($("#montoMovimiento").val()) || 0;
    const nota      = $("#notaMovimiento").val().trim();
    const usuario   = 1; // TODO: reemplazar con usuario de sesión

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

      enviandoMovimiento = true;
      const btn = $(this).find('button[type="submit"]');
      btn.prop('disabled', true);

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
        })
        .finally(() => {
          enviandoMovimiento = false;
          btn.prop('disabled', false);
        });
    });
  });



  // =========================================================
  // 🔹 DETECTAR CORTE PENDIENTE AL INICIAR
  // =========================================================
  fetch("../models/caja/verificarCortePendiente.php")
    .then(r => r.json())
    .then(data => {
      if (data.status === "pendiente") {
        Swal.fire({
          title: "Corte de caja pendiente",
          text: "Aún no se ha realizado el corte de caja del día anterior. Debe hacerlo antes de continuar.",
          icon: "warning",
          confirmButtonText: "Realizar corte ahora",
          confirmButtonColor: "#28a745"
        }).then(() => {
          $("#btnCorteCaja").trigger("click");
        });
      }
    })
    .catch(err => console.error("Error al verificar corte pendiente:", err));



  // =========================================================
  // 🔹 AUTO-REFRESCO CADA 60s
  // =========================================================
  setInterval(cargarMovimientosCaja, 60000);

});
