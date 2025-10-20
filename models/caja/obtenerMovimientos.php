<?php
include('../../controllers/conexion_prueba.php');
header('Content-Type: application/json; charset=utf-8');

// Obtener movimientos del día actual
$sql = "SELECT c.fecha, c.tipo, c.concepto, c.monto, c.referencia, u.nombre AS usuario
        FROM caja c
        LEFT JOIN usuarios u ON c.usuario = u.id_usuario
        WHERE DATE(c.fecha) = CURDATE()
        ORDER BY c.fecha ASC";

$result = $con->query($sql);

$movimientos = [];
$totalIngresos = 0;
$totalEgresos = 0;

while ($row = $result->fetch_assoc()) {
    $movimientos[] = $row;
    if ($row['tipo'] === 'ingreso') $totalIngresos += $row['monto'];
    else if ($row['tipo'] === 'egreso') $totalEgresos += $row['monto'];
}

echo json_encode([
    'status' => 'success',
    'movimientos' => $movimientos,
    'totalIngresos' => number_format($totalIngresos, 2, '.', ','),
    'totalEgresos' => number_format($totalEgresos, 2, '.', ','),
    'saldoFinal' => number_format(($totalIngresos - $totalEgresos), 2, '.', ',')
]);
