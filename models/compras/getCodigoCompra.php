<?php
include('../../controllers/conexion_prueba.php');
$sql = "SELECT codigo FROM compras ORDER BY id_compra DESC LIMIT 1";
$result = $con->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    $ultimoCodigo = $row['codigo']; // Ejemplo: C-0001
    $numero = (int) substr($ultimoCodigo, 2); // Quita la "C-"
    $nuevoNumero = $numero + 1;
    $nuevoCodigo = "C-" . str_pad($nuevoNumero, 4, "0", STR_PAD_LEFT);
} else {
    // Si no hay registros en la tabla, empieza en C-0001
    $nuevoCodigo = "C-0001";
}

echo $nuevoCodigo;