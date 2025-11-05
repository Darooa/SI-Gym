<?php
header('Content-Type: application/json');
require_once('../../controllers/conexion_prueba.php');

try {
    $response = [];

    // ======== TOTAL PRODUCTOS ========
    $sqlProductos = "SELECT COUNT(*) AS totalProductos FROM productos WHERE estado = 1";
    $resProd = $con->query($sqlProductos);
    $rowProd = $resProd->fetch_assoc();
    $response['totalProductos'] = (int)$rowProd['totalProductos'];

    // ======== TOTAL VENTAS DEL DÍA ========
    $sqlVentas = "SELECT COUNT(*) AS totalVentasHoy FROM ventas WHERE DATE(fecha) = CURDATE()";
    $resVentas = $con->query($sqlVentas);
    $rowVentas = $resVentas->fetch_assoc();
    $response['totalVentasHoy'] = (int)$rowVentas['totalVentasHoy'];

    // ======== TOTAL EN CAJA (saldo del día) ========
    $sqlCaja = "
        SELECT 
            IFNULL(SUM(CASE WHEN tipo = 'Ingreso' THEN monto ELSE 0 END), 0) -
            IFNULL(SUM(CASE WHEN tipo = 'Egreso' THEN monto ELSE 0 END), 0) AS saldo
        FROM caja_movimientos
        WHERE DATE(fecha) = CURDATE()
    ";
    $resCaja = $con->query($sqlCaja);
    $rowCaja = $resCaja->fetch_assoc();
    $response['totalCaja'] = (float)$rowCaja['saldo'];

    // ======== FECHA ACTUAL (desde el servidor) ========
    $response['fechaServidor'] = date("d/m/Y");

    echo json_encode(['status' => 'ok', 'data' => $response]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
