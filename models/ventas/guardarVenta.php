<?php
// models/ventas/guardarVenta.php
header('Content-Type: application/json; charset=utf-8');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

include('../../controllers/conexion_prueba.php'); // $con (mysqli)

try {
  $data = json_decode(file_get_contents('php://input'), true);
  if (!$data) { echo json_encode(['status'=>'error','message'=>'Sin datos']); exit; }

  $id_usuario = (int)($data['usuario'] ?? 0);
  $fecha      = trim($data['fecha'] ?? date('Y-m-d'));
  $items      = $data['productos'] ?? [];

  if ($id_usuario <= 0 || !is_array($items) || !count($items)) {
    echo json_encode(['status'=>'error','message'=>'Datos inválidos']); exit;
  }

  // Recalcular total y validar stock
  $total = 0.0;
  $itemsLimpios = [];

  foreach ($items as $it) {
    $id       = (int)($it['id'] ?? 0);
    $cantidad = (int)($it['cantidad'] ?? 0);
    $precio   = (float)($it['precio'] ?? 0);

    if ($id <= 0 || $cantidad <= 0 || $precio < 0) {
      echo json_encode(['status'=>'error','message'=>'Producto/cantidad/precio inválidos']); exit;
    }

    // Verificar stock disponible
    $stmt = $con->prepare("SELECT stock FROM productos WHERE id_producto = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($stock);
    if ($stmt->fetch()) {
      if ($stock < $cantidad) {
        echo json_encode(['status'=>'error','message'=>"Stock insuficiente para producto ID $id (disponible $stock)"]);
        $stmt->close();
        exit;
      }
    } else {
      $stmt->close();
      echo json_encode(['status'=>'error','message'=>"Producto ID $id no existe"]); exit;
    }
    $stmt->close();

    $subtotal = $cantidad * $precio;
    $total += $subtotal;
    $itemsLimpios[] = ['id'=>$id,'cantidad'=>$cantidad,'precio'=>$precio,'subtotal'=>$subtotal];
  }

  // Transacción
  $con->begin_transaction();

  // Insert venta
  $stmt = $con->prepare("INSERT INTO ventas (fecha, monto, id_usuario) VALUES (?, ?, ?)");
  $stmt->bind_param("sdi", $fecha, $total, $id_usuario);
  $stmt->execute();
  $id_venta = $stmt->insert_id;
  $stmt->close();

  // Insert detalle y actualizar stock
  $stmtDet = $con->prepare("INSERT INTO detalle_ventas (id_venta, id_producto, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)");
  $stmtStk = $con->prepare("UPDATE productos SET stock = stock - ? WHERE id_producto = ?");

  foreach ($itemsLimpios as $it) {
    $stmtDet->bind_param("iiidd", $id_venta, $it['id'], $it['cantidad'], $it['precio'], $it['subtotal']);
    $stmtDet->execute();

    $stmtStk->bind_param("ii", $it['cantidad'], $it['id']);
    $stmtStk->execute();
  }

  // Registrar ingreso en caja
  // $stmtCaja = $con->prepare("
  //     INSERT INTO caja (tipo, concepto, monto, referencia, usuario)
  //     VALUES ('INGRESO', 'Venta de productos', ?, ?, ?)
  // ");
  // $stmtCaja->bind_param("dsi", $total, $id_venta, $id_usuario);
  // $stmtCaja->execute();

  // Registrar ingreso en caja_movimientos
    $tipo        = "Ingreso";
    $concepto    = "Venta #".$id_venta;
    $monto       = $total;
    $origen      = "Venta";
    $id_usuario  = $id_usuario;

   $stmtCajaMov = $con->prepare("
    INSERT INTO caja_movimientos (tipo, concepto, monto, id_usuario, origen, id_referencia, fecha)
    VALUES (?, ?, ?, ?, ?, ?, NOW()) 
    ");
    $stmtCajaMov->bind_param("ssdssi", $tipo, $concepto, $monto, $id_usuario, $origen, $id_venta);
    $stmtCajaMov->execute();
    $stmtCajaMov->close();

  // Confirmar todo
  $con->commit();

  echo json_encode([
    'status' => 'success',
    'message'=> 'Venta registrada correctamente y agregada a caja',
    'id_venta' => $id_venta,
    'total' => number_format($total, 2, '.', '')
  ]);

} catch (Throwable $e) {
  if ($con && $con->errno === 0) {
    $con->rollback();
  }
  echo json_encode(['status'=>'error', 'message'=>$e->getMessage()]);
}
