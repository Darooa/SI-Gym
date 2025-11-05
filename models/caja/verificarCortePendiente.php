<?php
header('Content-Type: application/json; charset=utf-8');
include('../../controllers/conexion_prueba.php');

try {
  // ¿Hay movimientos SIN corte de días ANTERIORES a hoy?
  $sql = "
    SELECT DATE(fecha) AS fecha
    FROM caja_movimientos
    WHERE id_corte IS NULL
      AND DATE(fecha) < CURDATE()
    ORDER BY fecha ASC
    LIMIT 1
  ";
  $res = $con->query($sql);
  $row = $res->fetch_assoc();

  if ($row) {
    echo json_encode([
      'status'  => 'pendiente',
      'fecha'   => $row['fecha'],
      'message' => 'Existe un día anterior sin corte de caja.'
    ]);
  } else {
    echo json_encode(['status' => 'ok']);
  }
} catch (Throwable $e) {
  echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
