<?php
require_once('../../controllers/conexion_prueba.php');
header('Content-Type: application/json; charset=utf-8');

try {
  $data = json_decode(file_get_contents("php://input"), true);

  $tipo     = ucfirst(strtolower(trim($data['tipo'] ?? ''))); // Ingreso/Egreso
  $concepto = trim($data['concepto'] ?? '');
  $monto    = (float)($data['monto'] ?? 0);
  $nota     = trim($data['nota'] ?? '');
  $usuario  = (int)($data['usuario'] ?? 0);

  if (!in_array($tipo, ['Ingreso','Egreso'], true) || $concepto === '' || $monto <= 0 || $usuario <= 0) {
    echo json_encode(["status"=>"error","message"=>"Datos incompletos"]);
    exit;
  }

  $stmt = $con->prepare("
    INSERT INTO caja_movimientos (tipo, concepto, monto, nota, id_usuario, origen, fecha)
    VALUES (?, ?, ?, ?, ?, 'Manual', NOW())
  ");
  $stmt->bind_param("ssdsi", $tipo, $concepto, $monto, $nota, $usuario);
  $stmt->execute();
  $stmt->close();

  echo json_encode(["status"=>"ok"]);
} catch (Throwable $e) {
  echo json_encode(["status"=>"error","message"=>$e->getMessage()]);
}
