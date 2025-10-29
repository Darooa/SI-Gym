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

    // ======== TOTAL EN CAJA ========
    $sqlCaja = "SELECT IFNULL(SUM(monto), 0) AS totalCaja FROM caja";
    $resCaja = $con->query($sqlCaja);
    $rowCaja = $resCaja->fetch_assoc();
    $response['totalCaja'] = (float)$rowCaja['totalCaja'];

    // ======== FECHA ACTUAL (por si quieres desde servidor) ========
    $response['fechaServidor'] = date("d/m/Y");

    echo json_encode(['status' => 'ok', 'data' => $response]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
