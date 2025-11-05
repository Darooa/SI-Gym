<?php
// models/caja/obtenerMovimientos.php
header('Content-Type: application/json; charset=utf-8');
include('../../controllers/conexion_prueba.php');

try {
  date_default_timezone_set('America/Mexico_City');
  $hoy = date('Y-m-d');

  // Solo movimientos del día sin corte asignado (pantalla Caja = operación del día)
  $sql = "SELECT
            id_movimiento,
            DATE_FORMAT(fecha, '%d/%m/%Y %H:%i') AS fecha,
            tipo,              -- 'Ingreso' / 'Egreso'
            concepto,
            monto,             -- siempre positivo (el signo lo da 'tipo')
            COALESCE(nota,'') AS nota,
            id_usuario,
            COALESCE(origen,'Manual') AS origen
          FROM caja_movimientos
          WHERE DATE(fecha) = ? AND id_corte IS NULL
          ORDER BY fecha DESC, id_movimiento DESC";

  $stmt = $con->prepare($sql);
  $stmt->bind_param("s", $hoy);
  $stmt->execute();
  $res = $stmt->get_result();

  $movs = [];
  while ($row = $res->fetch_assoc()) {
    $usuario = 'Usuario #'.$row['id_usuario']; // Ajusta si tienes tabla usuarios
    $movs[] = [
      'fecha'    => $row['fecha'],
      'tipo'     => $row['tipo'],
      'concepto' => $row['concepto'],
      'monto'    => $row['monto'],
      'usuario'  => $usuario,
      'origen'   => $row['origen'],
    ];
  }

  echo json_encode(['status'=>'ok','movimientos'=>$movs]);
} catch (Throwable $e) {
  echo json_encode(['status'=>'error','message'=>$e->getMessage()]);
}
