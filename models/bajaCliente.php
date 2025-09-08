<?php
include('../controllers/conection.php');
header('Content-Type: application/json');

if (isset($_POST['id'])) {
    $id          = $_POST['id'];
    $estado = 0;
    $stmt = $con->prepare("UPDATE clientes 
                       SET estado = ?
                       WHERE id_cliente = ?");
    $stmt->bind_param("ii", $estado, $id);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'failed', 'error' => $stmt->error]);
    }
    $stmt->close();
    $con->close();
} else {
    echo json_encode(['status' => 'failed', 'error' => 'ID no recibido']);
}