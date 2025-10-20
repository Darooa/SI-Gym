<?php
include('../../controllers/conexion_prueba.php');
header('Content-Type: application/json; charset=utf-8');

$data = json_decode(file_get_contents('php://input'), true);
$nombre = trim($data['nombre'] ?? '');

if ($nombre === '') {
    echo json_encode(['status' => 'error', 'message' => 'El nombre de la categoría es obligatorio.']);
    exit;
}

// Verificar duplicado
$check = $con->prepare("SELECT id_categoria FROM categorias WHERE nombre = ?");
$check->bind_param("s", $nombre);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'La categoría ya existe.']);
    exit;
}

$stmt = $con->prepare("INSERT INTO categorias (nombre, estado) VALUES (?, 1)");
$stmt->bind_param("s", $nombre);
$stmt->execute();

echo json_encode(['status' => 'success', 'message' => 'Categoría agregada correctamente.']);
