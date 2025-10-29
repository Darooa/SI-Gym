<?php
header('Content-Type: application/json; charset=utf-8');
include('../../controllers/conexion_prueba.php'); // $con (mysqli)

try {
  $qry = "
    SELECT 
      id_movimiento,
      DATE_FORMAT(fecha, '%d/%m/%Y %H:%i') AS fecha,
      tipo,
      concepto,
      monto,
      COALESCE(nota, '') AS nota,
      id_usuario,
      origen,
      id_referencia
    FROM caja_movimientos
    ORDER BY fecha DESC
  ";

  $res = $con->query($qry);
  $movimientos = [];

  while ($row = $res->fetch_assoc()) {
    // Obtener nombre de usuario (si existe tabla usuarios)
    $usuario = 'Usuario #' . $row['id_usuario'];

    // Si más adelante tienes tabla usuarios:
    // $u = $con->query("SELECT nombre FROM usuarios WHERE id_usuario = ".$row['id_usuario']." LIMIT 1");
    // if ($u && $ur = $u->fetch_assoc()) $usuario = $ur['nombre'];

    $movimientos[] = [
      'fecha'       => $row['fecha'],
      'tipo'        => $row['tipo'],
      'concepto'    => $row['concepto'],
      'monto'       => $row['monto'],
      'nota'        => $row['nota'],
      'usuario'     => $usuario,
      'origen'      => $row['origen'],
      'referencia'  => $row['id_referencia']
    ];
  }

  echo json_encode([
    'status' => 'ok',
    'movimientos' => $movimientos
  ]);
} catch (Throwable $e) {
  echo json_encode(['status'=>'error', 'message'=>$e->getMessage()]);
}
