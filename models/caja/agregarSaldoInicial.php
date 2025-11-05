<?php
header('Content-Type: application/json; charset=utf-8');
include('../../controllers/conexion_prueba.php');
date_default_timezone_set('America/Mexico_City');

try {
  $hoy = date('Y-m-d');
  $id_usuario = 1; // TODO: sustituir por sesión real

  // 1️⃣ Verificar si ya hay saldo inicial hoy
  $sqlCheck = "SELECT COUNT(*) FROM caja_movimientos 
               WHERE DATE(fecha) = ? AND concepto = 'Saldo inicial del día'";
  $stmt = $con->prepare($sqlCheck);
  $stmt->bind_param("s", $hoy);
  $stmt->execute();
  $stmt->bind_result($existe);
  $stmt->fetch();
  $stmt->close();

  if ($existe > 0) {
    echo json_encode(["status"=>"ok","message"=>"Saldo inicial ya registrado."]);
    exit;
  }

  // 2️⃣ Obtener el último corte realizado
  $sql = "SELECT saldo_final, fecha 
          FROM caja_cortes 
          ORDER BY fecha DESC LIMIT 1";
  $res = $con->query($sql);
  $ultimo = $res->fetch_assoc();

  if (!$ultimo) {
    echo json_encode(["status"=>"ok","message"=>"Aún no existen cortes previos."]);
    exit;
  }

  $fechaUltimoCorte = $ultimo['fecha'];
  $saldoFinal = floatval($ultimo['saldo_final']);

  // Si no hay saldo o el corte fue de hoy, no registrar saldo inicial
  if ($saldoFinal <= 0 || $fechaUltimoCorte === $hoy) {
    echo json_encode(["status"=>"ok","message"=>"Sin saldo pendiente a trasladar."]);
    exit;
  }

  // 3️⃣ Insertar el saldo inicial como ingreso
  $stmt = $con->prepare("
    INSERT INTO caja_movimientos (tipo, concepto, monto, id_usuario, origen, fecha)
    VALUES ('Ingreso', 'Saldo inicial del día', ?, ?, 'Automático', NOW())
  ");
  $stmt->bind_param("di", $saldoFinal, $id_usuario);
  $stmt->execute();
  $stmt->close();

  echo json_encode([
    "status" => "ok",
    "message" => "Saldo inicial agregado exitosamente.",
    "monto" => $saldoFinal,
    "show_alert" => true
  ]);
} catch (Throwable $e) {
  echo json_encode(["status"=>"error","message"=>$e->getMessage()]);
}
