<?php 
include('../../controllers/conexion_prueba.php');

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = "DELETE FROM tb_rutinas WHERE id_rutina =  $id";
    $result = mysqli_query($con,$query);
    if (!$result) {
        die('Consulta fallida.');
    }
    echo "Rutina eliminada";
}

?>
