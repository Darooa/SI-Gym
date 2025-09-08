<?php 
include('../../controllers/conexion_prueba.php');

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = "DELETE FROM tb_membresias WHERE id_membresia =  $id";
    $result = mysqli_query($con,$query);
    if (!$result) {
        die('Consulta fallida.');
    }
    echo "Membresia eliminada";
}

?>
