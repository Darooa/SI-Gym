<?php
header('Content-Type: application/json; charset=utf-8');
include('../../controllers/conexion_prueba.php'); // $con (mysqli)

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
  $id_usuario = 1; // TODO: reemplazar con el usuario real de sesión

  // =========================================================
  // 🧾 1️⃣ OBTENER TODAS LAS FECHAS PENDIENTES DE CORTE
  // =========================================================
  $sqlFechas = "
    SELECT DISTINCT DATE(fecha) AS fecha_base
    FROM caja_movimientos
    WHERE id_corte IS NULL
    ORDER BY fecha ASC
  ";
  $resFechas = $con->query($sqlFechas);
  if ($resFechas->num_rows === 0) {
    echo json_encode(["status" => "warning", "message" => "No hay movimientos pendientes de corte."]);
    exit;
  }

  $fechasPendientes = [];
  while ($f = $resFechas->fetch_assoc()) {
    $fechasPendientes[] = $f['fecha_base'];
  }

  $cortesRealizados = [];

  // =========================================================
  // 🔁 2️⃣ RECORRER CADA FECHA Y GENERAR CORTE
  // =========================================================
  foreach ($fechasPendientes as $fechaBase) {

    // 💰 Calcular totales del día
    $sqlTot = "
      SELECT
        IFNULL(SUM(CASE WHEN tipo='Ingreso' THEN monto END), 0) AS ingresos,
        IFNULL(SUM(CASE WHEN tipo='Egreso'  THEN monto END), 0) AS egresos
      FROM caja_movimientos
      WHERE id_corte IS NULL
        AND DATE(fecha) = ?
    ";
    $stmtTot = $con->prepare($sqlTot);
    $stmtTot->bind_param("s", $fechaBase);
    $stmtTot->execute();
    $tot = $stmtTot->get_result()->fetch_assoc();
    $stmtTot->close();

    $ingresos = (float)$tot['ingresos'];
    $egresos  = (float)$tot['egresos'];
    $saldo    = $ingresos - $egresos;

    // Si no hay nada que cortar ese día, saltamos
    if ($ingresos == 0 && $egresos == 0) continue;

    // 🚀 Iniciar transacción
    $con->begin_transaction();

    // 🧾 Insertar registro del corte
    $stmt = $con->prepare("
      INSERT INTO caja_cortes (fecha, total_ingresos, total_egresos, saldo_final, id_usuario)
      VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("sdddi", $fechaBase, $ingresos, $egresos, $saldo, $id_usuario);
    $stmt->execute();
    $id_corte = $stmt->insert_id;
    $stmt->close();

    // 🔁 Actualizar movimientos del día
    $stmtUp = $con->prepare("
      UPDATE caja_movimientos
      SET id_corte = ?
      WHERE id_corte IS NULL
        AND DATE(fecha) = ?
    ");
    $stmtUp->bind_param("is", $id_corte, $fechaBase);
    $stmtUp->execute();
    $filasAfectadas = $stmtUp->affected_rows;
    $stmtUp->close();

    // ✅ Confirmar transacción
    $con->commit();

    // 📦 Guardar resumen de este corte
    $cortesRealizados[] = [
      "fecha" => $fechaBase,
      "ingresos" => number_format($ingresos, 2, '.', ''),
      "egresos"  => number_format($egresos, 2, '.', ''),
      "saldo"    => number_format($saldo, 2, '.', ''),
      "movimientos" => $filasAfectadas,
      "id_corte" => $id_corte
    ];
  }

  // =========================================================
  // 🧠 3️⃣ RESULTADO FINAL
  // =========================================================
  if (count($cortesRealizados) > 0) {
    echo json_encode([
      "status" => "ok",
      "message" => "Corte(s) realizado(s) correctamente.",
      "total_cortes" => count($cortesRealizados),
      "cortes" => $cortesRealizados
    ]);
  } else {
    echo json_encode([
      "status" => "warning",
      "message" => "No se encontraron movimientos con montos pendientes para corte."
    ]);
  }

} catch (Throwable $e) {
  if ($con && $con->errno === 0) {
    $con->rollback();
  }
  echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
