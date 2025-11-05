<?php
header('Content-Type: application/json; charset=utf-8');
include('../../controllers/conexion_prueba.php'); // <- usa $con (mysqli)

try {
    $sql = "SELECT id_usuario, nombre FROM usuarios ORDER BY nombre ASC";
    $res = $con->query($sql);

    $usuarios = [];
    while ($row = $res->fetch_assoc()) {
        $usuarios[] = [
            "id_usuario" => $row["id_usuario"],
            "nombre"     => $row["nombre"]
        ];
    }

    echo json_encode([
        "status"   => "ok",
        "usuarios" => $usuarios
    ]);
} catch (Throwable $e) {
    echo json_encode([
        "status"  => "error",
        "message" => $e->getMessage()
    ]);
}
