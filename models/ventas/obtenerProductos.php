<?php
// models/ventas/obtenerProductos.php
include('../../controllers/conexion_prueba.php');

$output = array();
$sqlBase = "SELECT id_producto, nombre_producto, marca, contenido, p_venta FROM productos WHERE estado = 1";
$sql = $sqlBase;

// Búsqueda
if (isset($_POST['search']['value']) && $_POST['search']['value'] !== '') {
  $s = $con->real_escape_string($_POST['search']['value']);
  $sql .= " AND (nombre_producto LIKE '%$s%' OR marca LIKE '%$s%')";
}

// Orden
$columns = ['id_producto','nombre_producto','marca','contenido','p_venta'];
if (isset($_POST['order'])) {
  $col = (int)$_POST['order'][0]['column'];
  $dir = $_POST['order'][0]['dir'] === 'desc' ? 'DESC' : 'ASC';
  $sql .= " ORDER BY " . $columns[$col] . " " . $dir;
} else {
  $sql .= " ORDER BY id_producto ASC";
}

// Paginación
$start = isset($_POST['start']) ? (int)$_POST['start'] : 0;
$length = isset($_POST['length']) ? (int)$_POST['length'] : 10;
$sqlLimit = $sql . " LIMIT $start, $length";

$queryAll = $con->query($sqlBase);
$total_all_rows = $queryAll->num_rows;

$query = $con->query($sqlLimit);
$data = [];

while ($row = $query->fetch_assoc()) {
  $data[] = [
    '<p class="mb-0">'.$row['id_producto'].'</p>',
    '<p class="mb-0">'.$row['nombre_producto'].'</p>',
    '<span>'.$row['marca'].'</span>',
    '<span>'.$row['contenido'].'</span>',
    '<span>$'.number_format($row['p_venta'],2,'.',',').'</span>',
    '<button class="btn btn-sm btn-primary AddProducto" title="Agregar"><i class="bx bx-cart-add"></i></button>'
  ];
}

$output = [
  'draw' => isset($_POST['draw']) ? (int)$_POST['draw'] : 0,
  'recordsTotal' => $query->num_rows,
  'recordsFiltered' => $total_all_rows,
  'data' => $data
];

echo json_encode($output);
