<?php
include('../../controllers/conexion_prueba.php');
header('Content-Type: application/json; charset=utf-8');

$sql = "SELECT id_categoria, nombre, estado FROM categorias ORDER BY id_categoria DESC";
$result = $con->query($sql);

$categorias = [];
while ($row = $result->fetch_assoc()) {
    $categorias[] = $row;
}

echo json_encode([
    'status' => 'success',
    'categorias' => $categorias
]);
