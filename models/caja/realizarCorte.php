<?php
include('../../controllers/conexion_prueba.php');
header('Content-Type: application/json; charset=utf-8');

$usuario = 1; //  Cambiar según sesión
$sqlResumen = "
  SELECT 
    MIN(fecha) AS fecha_inicio,
    MAX(fecha) AS fecha_fin,
    SUM(CASE WHEN tipo='ingreso' THEN monto ELSE 0 END) AS total_ingresos,
    SUM(CASE WHEN tipo='egreso' THEN monto ELSE 0 END) AS total_egresos
  FROM caja
  WHERE estado = 1
";

$result = $con->query($sqlResumen);
$datos = $result->fetch_assoc();

if ($datos['fecha_inicio'] === null) {
    echo json_encode(['status'=>'empty','message'=>'No hay movimientos pendientes.']);
    exit;
}

// Insertar corte
$stmt = $con->prepare("
  INSERT INTO cortes_caja (fecha_inicio, fecha_fin, total_ingresos, total_egresos, usuario)
  VALUES (?, ?, ?, ?, ?)
");
$stmt->bind_param(
    "sssdi",
    $datos['fecha_inicio'],
    $datos['fecha_fin'],
    $datos['total_ingresos'],
    $datos['total_egresos'],
    $usuario
);
$stmt->execute();

// Actualizar movimientos
$con->query("UPDATE caja SET estado = 0 WHERE estado = 1");

echo json_encode(['status'=>'success','message'=>'Corte de caja realizado con éxito.']);
