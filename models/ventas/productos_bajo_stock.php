<?php
// require_once '../conexion.php';
require_once('../../controllers/conexion_prueba.php');


$sql = "SELECT nombre_producto, stock FROM productos WHERE stock <= 5 ORDER BY stock ASC";
$result = $con->query($sql);

$productos = [];
while ($row = $result->fetch_assoc()) {
  $productos[] = $row;
}

echo json_encode([
  "status" => "ok",
  "productos" => $productos
]);
?>
