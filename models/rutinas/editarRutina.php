<?php 
include('../../controllers/conexion_prueba.php');

    $id_rutina = $_POST['id_rutina'];
    $nombre = $_POST['nombre'];
    $rutina = $_POST['rutina'];

    $query = "UPDATE tb_rutinas SET nombre = '$nombre', rutina = '$rutina' WHERE id_rutina = '$id_rutina'";

    $result = mysqli_query($con,$query);
    if (!$result) {
        die('Consulta fallida');
    }

    echo $query;

    echo "Rutina editada"
    
?>