<?php
header('Content-Type: application/json; charset=utf-8');
include('../../controllers/conexion_prueba.php');

try {
  $fechaInicio = $_POST['fechaInicio'] ?? '';
  $fechaFin    = $_POST['fechaFin'] ?? '';
  $usuario     = $_POST['usuario'] ?? '';

  $sql = "
    SELECT c.id_corte, c.fecha, c.total_ingresos, c.total_egresos, c.saldo_final, 
           u.nombre AS usuario
    FROM caja_cortes c
    LEFT JOIN usuarios u ON c.id_usuario = u.id_usuario
    WHERE 1
  ";

  $params = [];
  $types = "";

  if ($fechaInicio && $fechaFin) {
    $sql .= " AND c.fecha BETWEEN ? AND ?";
    $params[] = $fechaInicio;
    $params[] = $fechaFin;
    $types .= "ss";
  }

  if ($usuario !== "") {
    $sql .= " AND c.id_usuario = ?";
    $params[] = $usuario;
    $types .= "i";
  }

  $sql .= " ORDER BY c.fecha DESC";

  $stmt = $con->prepare($sql);
  if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
  }

  $stmt->execute();
  $res = $stmt->get_result();

  $cortes = [];
  while ($row = $res->fetch_assoc()) {
    $cortes[] = [
      'id_corte' => $row['id_corte'],
      'fecha' => $row['fecha'],
      'ingresos' => number_format($row['total_ingresos'], 2),
      'egresos' => number_format($row['total_egresos'], 2),
      'saldo' => number_format($row['saldo_final'], 2),
      'usuario' => $row['usuario'] ?? '—'
    ];
  }

  echo json_encode(['status' => 'success', 'cortes' => $cortes]);
} catch (Throwable $e) {
  echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
