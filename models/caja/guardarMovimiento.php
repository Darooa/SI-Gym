<?php
require_once('../../controllers/conexion_prueba.php');

$data = json_decode(file_get_contents("php://input"), true);

$tipo      = $data['tipo'];
$concepto  = $data['concepto'];
$monto     = floatval($data['monto']);
$nota      = $data['nota'];
$usuario   = intval($data['usuario']);

if(!$tipo || !$concepto || $monto <= 0){
  echo json_encode(["status" => "error", "message" => "Datos incompletos"]);
  exit;
}

$stmt = $con->prepare("INSERT INTO caja_movimientos (tipo, concepto, monto, nota, id_usuario, fecha) VALUES (?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("ssdsi", $tipo, $concepto, $monto, $nota, $usuario);

if($stmt->execute()){
  echo json_encode(["status" => "ok"]);
} else {
  echo json_encode(["status" => "error", "message" => $stmt->error]);
}
$stmt->close();
$con->close();
