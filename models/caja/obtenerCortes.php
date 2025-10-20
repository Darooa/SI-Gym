<?php
include('../../controllers/conexion_prueba.php');
header('Content-Type: application/json; charset=utf-8');

// Verificar si se reciben fechas
$fechaInicio = $_POST['fechaInicio'] ?? null;
$fechaFin    = $_POST['fechaFin'] ?? null;

// Consulta base
$sql = "SELECT c.id_corte, c.fecha_inicio, c.fecha_fin, c.total_ingresos, c.total_egresos, 
        c.saldo_final, u.nombre AS usuario
        FROM cortes_caja c
        LEFT JOIN usuarios u ON c.usuario = u.id_usuario";

if ($fechaInicio && $fechaFin) {
    $sql .= " WHERE DATE(c.fecha_inicio) >= ? AND DATE(c.fecha_fin) <= ?";
}

$sql .= " ORDER BY c.id_corte DESC";

$stmt = $con->prepare($sql);

if ($fechaInicio && $fechaFin) {
    $stmt->bind_param("ss", $fechaInicio, $fechaFin);
}

$stmt->execute();
$result = $stmt->get_result();
$cortes = [];

while ($row = $result->fetch_assoc()) {
  $cortes[] = $row;
}

echo json_encode([
  'status' => 'success',
  'cortes' => $cortes
]);
