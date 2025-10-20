<?php
include('../../controllers/conexion_prueba.php');
header('Content-Type: application/json; charset=utf-8');

$data = json_decode(file_get_contents('php://input'), true);
$id = (int)($data['id'] ?? 0);
$nombre = trim($data['nombre'] ?? '');

if ($id <= 0 || $nombre === '') {
    echo json_encode(['status' => 'error', 'message' => 'Datos inválidos.']);
    exit;
}

$stmt = $con->prepare("UPDATE categorias SET nombre = ? WHERE id_categoria = ?");
$stmt->bind_param("si", $nombre, $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(['status' => 'success', 'message' => 'Categoría actualizada correctamente.']);
} else {
    echo json_encode(['status' => 'warning', 'message' => 'No se realizaron cambios.']);
}

$stmt->close();
