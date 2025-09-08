<?php 
include('../../controllers/conexion_prueba.php');

    $id_membresia = $_POST['id_membresia'];
    $nombre = $_POST['nombre'];
    $duracion = $_POST['duracion'];
    $precio = $_POST['precio'];

    $query = "UPDATE tb_membresias SET membresia = '$nombre', duracion = '$duracion', precio = '$precio' WHERE id_membresia = '$id_membresia'";

    $result = mysqli_query($con,$query);
    if (!$result) {
        die('Query failed');
    }

    echo "Tarea editada"
    
?>