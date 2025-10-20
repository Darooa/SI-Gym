<?php
include('../../controllers/conexion_prueba.php');
header('Content-Type: application/json; charset=utf-8');

$data = json_decode(file_get_contents('php://input'), true);
$id = (int)($data['id'] ?? 0);

if ($id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'ID inválido.']);
    exit;
}

// Solo cambia el estado a 0 (inactivo)
$stmt = $con->prepare("UPDATE categorias SET estado = 0 WHERE id_categoria = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

echo json_encode(['status' => 'success', 'message' => 'Categoría desactivada correctamente.']);
