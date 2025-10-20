<?php
// models/compras/guardarCompra.php
header('Content-Type: application/json; charset=utf-8');

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
include "../../controllers/conexion_prueba.php"; // debe exponer $con (mysqli)

try {
    // 1) Leer JSON del fetch
    $data = json_decode(file_get_contents("php://input"), true);
    if (!$data) {
        echo json_encode(["status" => "error", "message" => "No se recibieron datos"]);
        exit;
    }

    // 2) Tomar variables
    $codigo      = trim($data['codigo'] ?? '');
    $fecha       = trim($data['fecha'] ?? '');
    $idUsuario   = (int)($data['usuario'] ?? 0);
    $idProveedor = (int)($data['proveedor_id'] ?? 0); // <-- OJO: usaremos proveedor_id
    $productos   = $data['productos'] ?? [];

    // 3) Validaciones mínimas
    if ($codigo === '' || $fecha === '' || $idUsuario <= 0 || $idProveedor <= 0) {
        echo json_encode(["status" => "error", "message" => "Datos incompletos (código/fecha/usuario/proveedor)."]);
        exit;
    }
    if (!is_array($productos) || count($productos) === 0) {
        echo json_encode(["status" => "error", "message" => "El carrito está vacío."]);
        exit;
    }

    // 4) Recalcular total en servidor (no confiar en el cliente)
    $total = 0.0;
    $carritoLimpio = []; // normalizamos por si vienen strings con $
    foreach ($productos as $p) {
        $id        = (int)($p['id'] ?? 0);
        $cantidad  = (int)($p['cantidad'] ?? 0);
        $precio    = (float)str_replace(['$', ','], '', ($p['precio'] ?? 0));
        if ($id <= 0 || $cantidad <= 0 || $precio < 0) {
            echo json_encode(["status" => "error", "message" => "Producto/cantidad/precio inválidos."]);
            exit;
        }
        $subtotal = $cantidad * $precio;
        $total   += $subtotal;
        $carritoLimpio[] = [
            'id'       => $id,
            'cantidad' => $cantidad,
            'precio'   => $precio,
            'subtotal' => $subtotal
        ];
    }

    // 5) Iniciar transacción
    $con->begin_transaction();

    // 6) Insertar en compras
    $sqlCompra = "INSERT INTO compras (codigo, fecha, monto, id_usuario, id_proveedor)
                  VALUES (?, ?, ?, ?, ?)";
    $stmtCompra = $con->prepare($sqlCompra);
    $stmtCompra->bind_param("ssdii", $codigo, $fecha, $total, $idUsuario, $idProveedor);
    $stmtCompra->execute();
    $idCompra = $stmtCompra->insert_id;

    // 7) Insertar detalles y actualizar stock
    $sqlDetalle = "INSERT INTO detalle_compras
                   (id_compra, id_producto, cantidad, precio_unitario, subtotal)
                   VALUES (?, ?, ?, ?, ?)";
    $stmtDetalle = $con->prepare($sqlDetalle);

    $sqlStock = "UPDATE productos SET stock = stock + ? WHERE id_producto = ?";
    $stmtStock = $con->prepare($sqlStock);

    foreach ($carritoLimpio as $item) {
        $stmtDetalle->bind_param("iiidd", $idCompra, $item['id'], $item['cantidad'], $item['precio'], $item['subtotal']);
        $stmtDetalle->execute();

        $stmtStock->bind_param("ii", $item['cantidad'], $item['id']);
        $stmtStock->execute();
    }

    // 8) Registrar movimiento en CAJA (egreso)
    $stmtCaja = $con->prepare("
        INSERT INTO caja (tipo, concepto, monto, referencia, usuario)
        VALUES ('EGRESO', 'Compra de productos', ?, ?, ?)
    ");
    $stmtCaja->bind_param("dsi", $total, $codigo, $idUsuario);
    $stmtCaja->execute();

    // 9) Confirmar transacción
    $con->commit();

    echo json_encode([
        "status"  => "success",
        "message" => "Compra registrada correctamente y registrada en caja.",
        "id_compra" => $idCompra,
        "total"   => number_format($total, 2, '.', '')
    ]);
} catch (Throwable $e) {
    if ($con && $con->errno === 0) {
        // Si la conexión existe, revertir si estaba en transacción
        $con->rollback();
    }
    echo json_encode(["status" => "error", "message" => "Error al registrar: " . $e->getMessage()]);
}
